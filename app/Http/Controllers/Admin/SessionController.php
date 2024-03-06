<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Models\Session as SessionModel;
use App\Models\User;
use App\Models\Coach;
use App\Models\Organization;
use Storage;
use Redirect;
use Str;
use DataTables;
use View;
use Mail;
use App\Mail\SendMarkdownMail;
use Illuminate\Support\Facades\Hash;

class SessionController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function index()
    {
        $count = SessionModel::select('*')->withTrashed()->orderBy('id','DESC')->count();
        return view('admin.sessions.list',compact('count'));
    }

    public function fetchSessionData(Request $request){
        
        $data = SessionModel::select('*')->withTrashed()->orderBy('id','DESC');

        return DataTables::of($data)
        ->filter(function ($query) use ($request, $data) {
            if(($request->has('session_start_date') && !empty($request->session_start_date)) || ($request->has('session_end_date') && !empty($request->session_end_date)))
            {
                if(($request->has('session_start_date') && !empty($request->session_start_date)) && !isset($request->session_end_date))
                {
                    $query->where(function($q) use ($request, $data) {
                        $sessionSearchDate = date('Y-m-d',strtotime($request->get('session_start_date')));
                        $q->whereDate('date', '>=', $sessionSearchDate);
                    });
                }
                else if(($request->has('session_end_date') && !empty($request->session_end_date)) && !isset($request->session_start_date))
                {
                    $query->where(function($q) use ($request, $data) {
                        $sessionSearchDate = date('Y-m-d',strtotime($request->get('session_end_date')));
                        $q->whereDate('date', '<=', $sessionSearchDate);
                    });
                }
                else
                {
                    $query->where(function($q) use ($request, $data) {
                        $from = date('Y-m-d',strtotime($request->get('session_start_date')));
                        $to = date('Y-m-d',strtotime($request->get('session_end_date')));
                        $q->whereBetween('date', [$from, $to]);
                    });
                }
            }
            if($request->has('session_status') && !empty($request->session_status)) {
                $session_status = $request->session_status;
                $query->where('status',$session_status);
            }

        })
        ->addColumn('user_name', function ($data) {
            return $data->UserData->name ?? '--';
        })
        ->addColumn('coach_name', function ($data) {
            return $data->CoachData->name ?? '--';
        })
        ->addColumn('dateTime', function ($data) {
            return date("d-M-Y",strtotime($data->date))." ".$data->time;
        })
        ->addColumn('statusHTML', function ($data) {
            return ucwords($data->status);
        })
        ->addColumn('action', function ($data) {
            $action = '<button data-url="'.route('admin.sessions.view_session',$data->id).'" data-toggle="modal" data-target="#viewModal" class="btn btn-info" title="View"><i class="fa fa-eye"></i></button>';
            return $action;
        })
        ->rawColumns(['action','user_name','coach_name','statusHTML'])
        ->make(true);
    }

    public function view_session($id)
    {
        $data = SessionModel::select('sessions.*')
        ->where('sessions.id',$id)
        ->withTrashed()
        ->first();

        if($data){
            $view = View::make('admin.sessions.view_session_modal',compact('data'));
            $html = $view->render();

            return $view;
        }
        else {
            abort(404);
        }
    }

}
