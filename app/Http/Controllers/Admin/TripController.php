<?php


namespace App\Http\Controllers\Admin;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Trip;
use Yajra\Datatables\Facades\Datatables;

class TripController extends Controller
{
    public function index(Trip $trip,Request $request)
    {
        if(Request()->ajax()) {
            return $datatables = datatables()->of($trip->select('*'))
            ->addColumn('image', function($row) {
                return '<img src="'.asset($row->hasOneUser->avatarImage()).'" width="60" height="60" class="img-circle" >';
            })
            ->addColumn('status', function($row) {
                if($row->disable == 1){
                    return '<span class="badge badge-pill badge-danger">Disable</span>';
                }
                    return '<span class="badge badge-pill badge-info">Enable</span>';
                
            })
            ->rawColumns(['image','status'])
            ->make(true);
        }
        return view('admin.trip.index',['trips' => $trip->paginate(5)]);
    }
    public function create()
    {
        return view('admin.trip.create');
    }
    public function detail($id)
    {
        $trip = Trip::find($id);

        return view('admin.trip.detail', compact('trip'));
    }
}
