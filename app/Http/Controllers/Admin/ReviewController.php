<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Models\Review;
use App\Models\User;
use Redirect;
use Storage;
use DataTables;
use Str;
use View;

class ReviewController extends Controller
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


    ///////////////// Review ////////////////
    public function index(Request $request)
    {

      return view('admin.reviews.list');

    }

    public function fetchReviewsData(Request $request){

        $data = Review::select('reviews.*','u1.name as review_for_name','u2.name as review_by_name')
                ->join('users AS u1','u1.id','reviews.review_for')
                ->join('users AS u2','u2.id','reviews.review_by');
                // ->orderBy('id','DESC');

        return DataTables::of($data)
        ->filter(function ($query) use ($request, $data) {
            if ($request->has('rating') && !empty($request->rating)) {
                // $query->where('services', 'like', '%"'.$request->get('service').'"%');
                $query->orderBy('overall_rating',$request->get('rating'));
            }else{
                $query->orderBy('id','DESC');
            }
        })
        ->addColumn('overall_rating', function ($data) {
            $overall_rating = '<div class="rateYo ps-0" data-rateyo-read-only="true" data-rateyo-rating="'.$data->overall_rating.'" data-rateyo-star-width="18px" data-rateyo-spacing="1px"></div>';
            return $overall_rating;
        })
        ->addColumn('active_status', function ($data) {

            if($data->status == "1"){
                $active_status = 'checked';
            }else{
                $active_status = '';
            }

            return '<label class="switch">
                <input class="change_status" data-url="'.route('admin.reviews.change_status',$data->id).'" type="checkbox" '.$active_status.'>
                <span class="slider round"></span>
            </label>';

        })
        ->addColumn('action', function ($data) {

            return '<button data-url="'.route('admin.reviews.view_review',$data->id).'" data-toggle="modal" data-target="#viewModal"
                class="btn btn-info" title="View">
                <i class="fa fa-eye"></i>
            </button>
            <button data-url="'.route('admin.reviews.delete',$data->id).'" data-toggle="modal"
                data-target="#deleteModal" class="btn btn-danger" title="Delete">
                <i class="fa fa-trash"></i>
            </button>';

        })
        ->rawColumns(['action','active_status','overall_rating'])
        ->make(true);
    }

    public function view_review($id)
    {
        $data = Review::select('reviews.*','u1.name as review_for_name','u2.name as review_by_name')
                ->join('users AS u1','u1.id','reviews.review_for')
                ->join('users AS u2','u2.id','reviews.review_by')
                ->where('reviews.id',$id)
                ->first();

        if($data){
            $view = View::make('admin.reviews.view_review_modal',compact('data'));
            $html = $view->render();

            return $view;
        }
        else {
            abort(404);
        }
    }

    public function delete($id)
    {
      $detail = Review::select('*')->where('id',$id)->firstOrFail();

      if($detail)
      {
        $detail->delete();

        $notification = array(
            'message' => 'Success! Review deleted successfully.',
            'alert-type' => 'success'
        );
      }
      else{
        $notification = array(
            'message' => 'Oops! Something went wrong.',
            'alert-type' => 'error'
        );
      }

      return Redirect::route('admin.reviews')->with($notification);
    }

    public function change_status($id)
    {
      $detail = Review::select('*')->where('id',$id)->first();
      if($detail)
      {
        if($detail->status == 0){

            Review::where('id',$id)->update(['status' => 1]);
            //Update average rating and rating count in user table
            $r_user_id = $detail->review_for;
            $r_review = Review::where('review_for',$r_user_id)->where('status',1)->get();
            $r_review_avg = $r_review->avg('overall_rating');
            $r_review_count = $r_review->count();
            $r_user = User::findOrFail($r_user_id);
            $r_user->rating_count = $r_review_count;
            $r_user->avg_rating = $r_review_avg;
            $r_user->update();
        }
        else
        {
            Review::where('id',$id)->update(['status' => 0]);
            //Update average rating and rating count in user table
            $r_user_id = $detail->review_for;
            $r_review = Review::where('review_for',$r_user_id)->where('status',1)->get();
            $r_review_avg = $r_review->avg('overall_rating');
            $r_review_count = $r_review->count();
            $r_user = User::findOrFail($r_user_id);
            $r_user->rating_count = $r_review_count;
            $r_user->avg_rating = $r_review_avg;
            $r_user->update();
        }

        $output['msg']			= "Review status updated successfully.";
        $output['msgHead']	    = "Success! ";
        $output['msgType']	    = "success";

        return response()->json($output);
      }
      else {
        $output['msg']			    = "Something went wrong.";
        $output['msgHead']	    = "Oops! ";
        $output['msgType']	    = "error";

        return response()->json($output);
      }
    }

}
