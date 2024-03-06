<?php
namespace App\Http\Controllers\Front;

use Request, Redirect, DB, Session, Hash;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Organization;
use App\Models\Coach;
use App\Models\Review as ReviewModel;
use App\Models\Session as SessionModel;
//use App\Http\Requests\Request;
use Illuminate\Http\Request as Request2;
use Carbon\Carbon;
use Illuminate\Support\Facades\Crypt;

class CronController extends Controller {
	
	protected $viewPath;
	protected $actionURL;

	public function __construct()
	{

	}

	public function oneORthreeDaysBeforeEmail()
	{
		$currDate = Carbon::now();
		$oneHourBeforeSessions = SessionModel::whereDate('date', $currDate)->where('status','upcoming')->where('1day_before_email',0)->get();
		if(isset($oneHourBeforeSessions) && $oneHourBeforeSessions->count() > 0){
			// Cron Start Log
			\Log::info("oneHourBeforeSession Email Cron Started At - ". Carbon::now()->format('d-m-Y H:i:s'));
			echo 'The User/Coach receives a reminder notification of the scheduled session 1 Hour before by email.! Email sent to below emails:';
			foreach($oneHourBeforeSessions as $key => $oneHourBeforeSession)
			{
				$currentTime = Carbon::parse(Carbon::now()->toDateTimeString());
				$currentDateTime = Carbon::parse($oneHourBeforeSession->session_start_time);
				$diffMinutes = $currentDateTime->diffInMinutes($currentTime, true);
				if ($diffMinutes == 60) {
					$logMsg = "[CLASS_STATUS_SEND_MAIL_PROCESS]:: ";
	        		\Log::info($logMsg."START WITH => COACH(".$oneHourBeforeSession->CoachData->email.") AND USER (".$oneHourBeforeSession->UserData->email.')');
					$link=url("my-sessions-details/".$oneHourBeforeSession->id);
					$coachEmail = $oneHourBeforeSession->CoachData->email;
					$coachName = $oneHourBeforeSession->CoachData->name;
					$userEmail = $oneHourBeforeSession->UserData->email;
					$userName = $oneHourBeforeSession->UserData->name;
					$new_email_data['LINK'] = $link;
					$new_email_data['LINK_1'] = $oneHourBeforeSession->ms_join_web_url;
					$new_email_data['MESSAGE'] = 'Your session start after 1 Hour.';
					$new_email_data['SESSION_ID'] = $oneHourBeforeSession->id;
					$new_email_data['DATE_TIME'] = date("d M, Y",strtotime($oneHourBeforeSession->date)).' '.$oneHourBeforeSession->time;
					$new_email_data['COACH_NAME'] = character_limit($oneHourBeforeSession->CoachData->name,30);
					$new_email_data['USERNAME'] = character_limit($oneHourBeforeSession->UserData->name,30);

					$new_email_data['NAME'] = character_limit($coachName,25);
					$new_email_data = _email_template_content("38",$new_email_data);
					$new_subject = 'Your session start after 1 Hour!';
					$new_content = $new_email_data[1];
					$new_fromdata = ['email' => $coachEmail,'name' => $coachName];
					$new_mailids = [$coachEmail => $coachName];
					echo "<br>(Coach): ".$coachEmail;
					_mail_send_general( $new_fromdata, $new_subject , $new_content , $new_mailids );
					
					$new_email_data['MESSAGE'] = 'Your session start after 1 Hour.';
					$new_email_data['SESSION_ID'] = $oneHourBeforeSession->id;
					$new_email_data['DATE_TIME'] = date("d M, Y",strtotime($oneHourBeforeSession->date)).' '.$oneHourBeforeSession->time;
					$new_email_data['COACH_NAME'] = character_limit($oneHourBeforeSession->CoachData->name,30);
					$new_email_data['USERNAME'] = character_limit($oneHourBeforeSession->UserData->name,30);
					$new_email_data['NAME'] = character_limit($userName,25);
					$new_email_data = _email_template_content("38",$new_email_data);
					$new_subject = 'Your session start after 1 Hour!';
					$new_content = $new_email_data[1];
					$new_fromdata = ['email' => $userEmail,'name' => $userName];
					$new_mailids = [$userEmail => $userName];
					echo "<br>(User): ".$userEmail;
					_mail_send_general( $new_fromdata, $new_subject , $new_content , $new_mailids );
					try {
						SessionModel::where('id', $oneHourBeforeSession->id)->update(array('1day_before_email' => 1));
					} catch (\Exception $e) {
						$logMsg = "[CLASS_STATUS_SEND_MAIL_PROCESS]:: ";
						\Log::info($logMsg." ERROR ON SessionModel->id = ".$oneHourBeforeSession->id);
						\Log::info($e->getMessage());	
					}
					$logMsg = "[CLASS_STATUS_SEND_MAIL_PROCESS]:: ";
					\Log::info($logMsg."END");
				}
			}
			\Log::info("oneHourBeforeSession Email Ended (with ".$oneHourBeforeSessions->count()." users) At - ". Carbon::now()->format('d-m-Y H:i:s'));
			// cron end log
		}
		//Email before one day start
		/*$oneDayBeforeDate = Carbon::now()->addDays(1);
		$oneDayBeforeSessions = SessionModel::whereDate('date', $oneDayBeforeDate)->where('status','upcoming')->where('1day_before_email',0)->get();
		if(isset($oneDayBeforeSessions) && $oneDayBeforeSessions->count() > 0)
		{
			// Cron Start Log
			\Log::info("oneDayBeforeSession Email Cron Started At - ". Carbon::now()->format('d-m-Y H:i:s'));
			echo 'The User/Coach receives a reminder notification of the scheduled session 1 day before by email.! Email sent to below emails:';
			foreach($oneDayBeforeSessions as $key => $oneDayBeforeSession)
			{
				$logMsg = "[CLASS_STATUS_SEND_MAIL_PROCESS]:: ";
        		\Log::info($logMsg."START WITH => COACH(".$oneDayBeforeSession->CoachData->email.") AND USER (".$oneDayBeforeSession->UserData->email.')');
				
				$link=url("my-sessions-details/".$oneDayBeforeSession->id);
				$coachEmail = $oneDayBeforeSession->CoachData->email;
				$coachName = $oneDayBeforeSession->CoachData->name;
				$userEmail = $oneDayBeforeSession->UserData->email;
				$userName = $oneDayBeforeSession->UserData->name;
				$new_email_data['LINK'] = $link;
				$new_email_data['LINK_1'] = $oneDayBeforeSession->ms_join_web_url;
				/*$linkHTML = '<a href="'.$link.'" target="_blank"  style="display: inline-block;text-decoration: none; font-size: 14px; font-weight: bold; "><span class="link" style="display: table;text-align: center; padding: 10px 25px; color: #ffffff; background-color: #3498db; border: solid 1px #3498db; border-radius: 5px; box-sizing: border-box; cursor: pointer; text-transform: capitalize; border-color: #3498db;">View Session</span></a>';*/

				/*$new_email_data['MESSAGE'] = 'You have a session tomorrow!';
				$new_email_data['SESSION_ID'] = $oneDayBeforeSession->id;
				$new_email_data['DATE_TIME'] = date("d M, Y",strtotime($oneDayBeforeSession->date)).' '.$oneDayBeforeSession->time;
				$new_email_data['COACH_NAME'] = character_limit($oneDayBeforeSession->CoachData->name,30);
				$new_email_data['USERNAME'] = character_limit($oneDayBeforeSession->UserData->name,30);

				$new_email_data['NAME'] = character_limit($coachName,25);
				$new_email_data = _email_template_content("38",$new_email_data);
				$new_subject = 'You have a session tomorrow!';
				$new_content = $new_email_data[1];
				$new_fromdata = ['email' => $coachEmail,'name' => $coachName];
				$new_mailids = [$coachEmail => $coachName];
				echo "<br>(Coach): ".$coachEmail;
				_mail_send_general( $new_fromdata, $new_subject , $new_content , $new_mailids );
				
				$new_email_data['MESSAGE'] = 'You have a session tomorrow!';
				$new_email_data['SESSION_ID'] = $oneDayBeforeSession->id;
				$new_email_data['DATE_TIME'] = date("d M, Y",strtotime($oneDayBeforeSession->date)).' '.$oneDayBeforeSession->time;
				$new_email_data['COACH_NAME'] = character_limit($oneDayBeforeSession->CoachData->name,30);
				$new_email_data['USERNAME'] = character_limit($oneDayBeforeSession->UserData->name,30);
				$new_email_data['NAME'] = character_limit($userName,25);
				$new_email_data = _email_template_content("38",$new_email_data);
				$new_subject = 'You have a session tomorrow!';
				$new_content = $new_email_data[1];
				$new_fromdata = ['email' => $userEmail,'name' => $userName];
				$new_mailids = [$userEmail => $userName];
				echo "<br>(User): ".$userEmail;
				_mail_send_general( $new_fromdata, $new_subject , $new_content , $new_mailids );
				try {
					SessionModel::where('id', $oneDayBeforeSession->id)->update(array('1day_before_email' => 1));
				} catch (\Exception $e) {
					$logMsg = "[CLASS_STATUS_SEND_MAIL_PROCESS]:: ";
					\Log::info($logMsg." ERROR ON SessionModel->id = ".$oneDayBeforeSession->id);
					\Log::info($e->getMessage());	
				}
				$logMsg = "[CLASS_STATUS_SEND_MAIL_PROCESS]:: ";
				\Log::info($logMsg."END");
			}
			\Log::info("oneDayBeforeSession Email Ended (with ".$oneDayBeforeSessions->count()." users) At - ". Carbon::now()->format('d-m-Y H:i:s'));*/
			// cron end log
		/*}*/
		//Email before one day end
		//Email before three days start
		$threeDaysBeforeDate = Carbon::now()->addDays(3);
		$threeDaysBeforeSessions = SessionModel::whereDate('date', $threeDaysBeforeDate)->where('status','upcoming')->where('3days_before_email',0)->get();
		if(isset($threeDaysBeforeSessions) && $threeDaysBeforeSessions->count() > 0)
		{
			// Cron Start Log
			\Log::info("threeDaysBeforeSession Email Cron Started At - ". Carbon::now()->format('d-m-Y H:i:s'));
			echo 'The User/Coach receives a reminder notification of the scheduled session 3 days before by email.! Email sent to below emails:';
			foreach($threeDaysBeforeSessions as $threeDaysBeforeSession)
			{
				$logMsg = "[CLASS_STATUS_SEND_MAIL_PROCESS]:: ";
        		\Log::info($logMsg."START WITH => COACH(".$threeDaysBeforeSession->CoachData->email.") AND USER (".$threeDaysBeforeSession->UserData->email.')');

				$link=url("my-sessions-details/".$threeDaysBeforeSession->id);
				$coachEmail = $threeDaysBeforeSession->CoachData->email;
				$coachName = $threeDaysBeforeSession->CoachData->name;
				$userEmail = $threeDaysBeforeSession->UserData->email;
				$userName = $threeDaysBeforeSession->UserData->name;
				$new_email_data['LINK'] = $link;
				$new_email_data['LINK_1'] = $threeDaysBeforeSession->ms_join_web_url;
				//$linkHTML = '<a href="'.$link.'" target="_blank"  style="display: inline-block;text-decoration: none; font-size: 14px; font-weight: bold; "><span class="link" style="display: table;text-align: center; padding: 10px 25px; color: #ffffff; background-color: #3498db; border: solid 1px #3498db; border-radius: 5px; box-sizing: border-box; cursor: pointer; text-transform: capitalize; border-color: #3498db;">View Session</span></a>';
				$new_email_data['MESSAGE'] = 'Your upcoming session is after 3 days!';
				$new_email_data['SESSION_ID'] = $threeDaysBeforeSession->id;
				$new_email_data['DATE_TIME'] = date("d M, Y",strtotime($threeDaysBeforeSession->date)).' '.$threeDaysBeforeSession->time;
				$new_email_data['COACH_NAME'] = character_limit($threeDaysBeforeSession->CoachData->name,30);
				$new_email_data['USERNAME'] = character_limit($threeDaysBeforeSession->UserData->name,30);

				$new_email_data['NAME'] = character_limit($coachName,25);
				$new_email_data = _email_template_content("38",$new_email_data);

				$new_subject = 'Your upcoming session is after 3 days!';
				$new_content = $new_email_data[1];
				
				$new_fromdata = ['email' => $coachEmail,'name' => $coachName];
				$new_mailids = [$coachEmail => $coachName];
				echo '<br>(Coach): '.$coachEmail;
				_mail_send_general( $new_fromdata, $new_subject , $new_content , $new_mailids );

				$new_email_data['MESSAGE'] = 'Your upcoming session is after 3 days!';
				$new_email_data['SESSION_ID'] = $threeDaysBeforeSession->id;
				$new_email_data['DATE_TIME'] = date("d M, Y",strtotime($threeDaysBeforeSession->date)).' '.$threeDaysBeforeSession->time;
				$new_email_data['COACH_NAME'] = character_limit($threeDaysBeforeSession->CoachData->name,30);
				$new_email_data['USERNAME'] = character_limit($threeDaysBeforeSession->UserData->name,30);
				$new_email_data['NAME'] = character_limit($userName,25);
				$new_email_data = _email_template_content("38",$new_email_data);
				$new_subject = 'Your upcoming session is after 3 days!';
				$new_content = $new_email_data[1];
				$new_fromdata = ['email' => $userEmail,'name' => $userName];
				$new_mailids = [$userEmail => $userName];
				echo '<br>(User): '.$userEmail;
				_mail_send_general( $new_fromdata, $new_subject , $new_content , $new_mailids );

				try {
					SessionModel::where('id', $threeDaysBeforeSession->id)->update(array('3days_before_email' => 1));
				} catch (\Exception $e) {
					$logMsg = "[CLASS_STATUS_SEND_MAIL_PROCESS]:: ";
					\Log::info($logMsg." ERROR ON SessionModel->id = ".$threeDaysBeforeSession->id);
					\Log::info($e->getMessage());	
				}
				$logMsg = "[CLASS_STATUS_SEND_MAIL_PROCESS]:: ";
				\Log::info($logMsg."END");
			}
			\Log::info("threeDaysBeforeSession Email Ended (with ".$threeDaysBeforeSessions->count()." users) At - ". Carbon::now()->format('d-m-Y H:i:s'));
		}
		//Email before three days end
	}

	public function ReminderForBooksession()
	{
		$users = User::where('is_active',1)->get();
		\Log::info("2 Months Before Email Cron Started At - ". Carbon::now()->format('d-m-Y H:i:s'));
			echo '2 Months Before Email sent to below email IDs:';
		foreach ($users as $key => $user) {
			$sessions = SessionModel::where('user_id',$user->id)->whereIn('status',['upcoming','completed','canceled'])->latest()->first();
			if(isset($sessions) && !empty($sessions)){
				$twoMonthsbeforeDate = Carbon::now()->subDays(60);
				if($sessions->date < $twoMonthsbeforeDate && $user->twomonths_before_email == 0){
					$link=url("dashboard");
					$userEmail = $user->email;
					$userName = $user->name;
					$new_email_data['NAME'] = character_limit($userName,25);
					$new_email_data['LINK'] = $link;
					$new_email_data['MESSAGE'] = 'Please connect with the coach and book a session from <a href='.$link.' target="_blank">here</a>';
					$new_email_data = _email_template_content("47",$new_email_data);
					$new_subject = 'Reminder Email For Booksession!';
					$new_content = $new_email_data[1];
					$new_fromdata = ['email' => $userEmail,'name' => $userName];
					$new_mailids = [$userEmail => $userName];
					_mail_send_general( $new_fromdata, $new_subject , $new_content , $new_mailids );
					echo "<br>(User): ".$userEmail;
					try {
						User::where('id', $user->id)->update(['twomonths_before_email'=>1]);
					} catch (\Exception $e) {
						$logMsg = "[CLASS_STATUS_SEND_MAIL_PROCESS]:: ";
						\Log::info($logMsg." ERROR ON User->id = ".$user->id);
						\Log::info($e->getMessage());	
					}
					$logMsg = "[CLASS_STATUS_SEND_MAIL_PROCESS]:: ";
					\Log::info($logMsg."END");
				}else{
					User::where('id', $user->id)->update(['twomonths_before_email'=>0]);
				}
			}
		}
		\Log::info("2 Months Before Email Ended (with ".$users->count()." users) At - ". Carbon::now()->format('d-m-Y H:i:s'));
	}

	public function askingforUserReview()
	{
		$currentTime = Carbon::now();
		$completedSessions = SessionModel::where('session_end_time','<', $currentTime)->where('status','upcoming')->where('is_user_reviewed',0)->get();
		if(isset($completedSessions) && $completedSessions->count() > 0)
		{
			\Log::info("askingforUserReview Email Cron Started At - ". Carbon::now()->format('d-m-Y H:i:s'));
			echo 'Give a review for the session! Email sent to below email IDs:';
			foreach($completedSessions as $completedSession)
			{				
				$logMsg = "[CLASS_STATUS_SEND_MAIL_PROCESS]:: ";
        		\Log::info($logMsg."START WITH => USER (".$completedSession->UserData->email.')');
				//Email send to user for Review
				//$link=url("give-review/".Crypt::encryptString($completedSession->id));
				$link=url("my-sessions-details/".$completedSession->id);
				$userEmail = $completedSession->UserData->email;
				$userName = $completedSession->UserData->name;
				$new_email_data['NAME'] = character_limit($userName,25);
				$new_email_data['LINK'] = $link;
				$new_email_data['MESSAGE'] = 'We hope you found your coaching session useful!';
				$new_email_data['SESSION_ID'] = $completedSession->id;
				$new_email_data['DATE_TIME'] = date("d M, Y",strtotime($completedSession->date)).' '.$completedSession->time;
				$new_email_data['COACH_NAME'] = character_limit($completedSession->CoachData->name,30);

				$new_email_data = _email_template_content("39",$new_email_data);

				$new_subject = 'Give a review for the session!';
				$new_content = $new_email_data[1];
				$new_fromdata = ['email' => $userEmail,'name' => $userName];
				$new_mailids = [$userEmail => $userName];
				_mail_send_general( $new_fromdata, $new_subject , $new_content , $new_mailids );
				echo "<br>(User): ".$userEmail;

				//Email to coach asking for a session report - Start 05122022
				$link=url("add-session-report/".Crypt::encryptString($completedSession->id));
				$coachEmail = $completedSession->CoachData->email;
				$coachName = $completedSession->CoachData->name;
				$new_email_data['NAME'] = character_limit($coachName,25);
				$new_email_data['LINK'] = $link;
				$new_email_data['USERNAME'] = $completedSession->UserData->name;
				$new_email_data['SESSION_ID'] = $completedSession->id;
				$new_email_data['DATE_TIME'] = date("d M, Y",strtotime($completedSession->date)).' '.$completedSession->time;
				$new_email_data = _email_template_content("42",$new_email_data);
				$new_subject = 'Give a report for the session!';
				$new_content = $new_email_data[1];
				$new_fromdata = ['email' => $coachEmail,'name' => $coachName];
				$new_mailids = [$coachEmail => $coachName];
				_mail_send_general( $new_fromdata, $new_subject , $new_content , $new_mailids );
				//Email to coach asking for a session report - End 05122022

				try {
					SessionModel::where('id', $completedSession->id)->update(array('is_user_reviewed' => 1,'status' => 'completed'));
				} catch (\Exception $e) {
					$logMsg = "[CLASS_STATUS_SEND_MAIL_PROCESS]:: ";
					\Log::info($logMsg." ERROR ON SessionModel->id = ".$completedSession->id);
					\Log::info($e->getMessage());	
				}
				$logMsg = "[CLASS_STATUS_SEND_MAIL_PROCESS]:: ";
				\Log::info($logMsg."END");
			}
			\Log::info("askingforUserReview Email Ended (with ".$completedSessions->count()." users) At - ". Carbon::now()->format('d-m-Y H:i:s'));

		}
	}

	public function addSessionReport($token)
	{
		//Session::flush();
		if($token):
			$session = SessionModel::where('id',Crypt::decryptString($token))->first();
			if(!$session):
				return redirect('thanks')->with('error','Session not found.');
			endif;
		endif;

		if(isset($session->session_report) && !empty($session->session_report))
		{
			return redirect('thanks')->with('error','Session report already added.');
		}

		$_meta_title = 'Give Report';
		$_meta_keyword = 'Give Report';
		$_meta_desc = 'Give Report';
		$pass_array = array(
			'_meta_title' => $_meta_title,
			'_meta_keyword' => $_meta_keyword,
			'_meta_desc' => $_meta_desc,
			'token' => $token,
			'sessionData' => $session
		);
		return view('front/session-report-form', $pass_array);
	}

	public function addSessionReportSubmit($id,Request2 $request)
	{
		$sessionData = SessionModel::where('id',$id)->first();
		$sessionData->session_report = $request->session_report;
		$sessionData->update();

		//Results of the session report emailed to admin - start
		$adminEmail = get_settings('admin_email');
		$adminName = 'Admin';
		$link=url("admin/sessions/");
		$new_email_data['NAME'] = character_limit($adminName,25);
		$new_email_data['LINK'] = $link;

		$new_email_data['MESSAGE'] = 'Coach has added the report in the below session.';
		$new_email_data['SESSION_ID'] = $sessionData->id;
		$new_email_data['DATE_TIME'] = date("d M, Y",strtotime($sessionData->date)).' '.$sessionData->time;
		$new_email_data['USERNAME'] = character_limit($sessionData->UserData->name,30);
		$new_email_data['COACH_NAME'] = character_limit($sessionData->CoachData->name,30);
		$new_email_data['SESSION_REPORT'] = $request->session_report;

		$new_email_data = _email_template_content("43",$new_email_data);
		$new_subject = 'Coach has reported on session!';
		$new_content = $new_email_data[1];
		$new_fromdata = ['email' => $adminEmail,'name' => $adminName];
		$new_mailids = [$adminEmail => $adminName];
		_mail_send_general( $new_fromdata, $new_subject , $new_content , $new_mailids );
		//Results of the session report emailed to admin - end

		return redirect('thanks')->with('success','Thank you, Session report has been added successfully.');
	}

	public function giveReviewPost(Request2 $request)
	{
		try {
			$sessionData = SessionModel::where('id',$request->sessionID)->first();
			if(!isset($sessionData))
			{
				return redirect('login')->with('error','Something went wrong..Session not found.');
			}
			$reviewAlready = reviewModel::where('session_id',$sessionData->id)->count();
			if(isset($reviewAlready) && $reviewAlready > 0)
			{
				return redirect('login')->with('error','You have already reviewed coach for this session.');
			}
			$reviewModel = new ReviewModel();
			$reviewModel->session_id = $sessionData->id;
			$reviewModel->review_by = $sessionData->user_id;
			$reviewModel->review_for = $sessionData->coach_id;
			$reviewModel->overall_rating = $request->overall_rating_val;
			$reviewModel->attentiveness = $request->attentiveness_val;
			$reviewModel->communication = $request->communication_val;
			$reviewModel->active_listening = $request->active_listening_val;
			$reviewModel->review = strip_tags($request->review);
			$reviewModel->status = 1;
			$reviewModel->save();

			//Update coach table
			$count = ReviewModel::where('status',1)->where('review_for',$sessionData->coach_id)->count();
			$avg_rating = ReviewModel::where('status',1)->where('review_for',$sessionData->coach_id)->avg('overall_rating');
			$coach = Coach::find($sessionData->coach_id);
			$coach->rating_count = $count;
			$coach->avg_rating = $avg_rating;
			$coach->save();

            //User reviewed : Email to coach start
			/*$coachEmail = $sessionData->CoachData->email;
			$coachName = $sessionData->CoachData->name;
			$new_email_data['NAME'] = character_limit($coachName,25);
			//$new_email_data['LINK'] = $link;
			$new_email_data['MESSAGE'] = 'User has reviewed your session.';
			$new_email_data['SESSION_ID'] = $sessionData->id;
			$new_email_data['DATE_TIME'] = date("d M, Y",strtotime($sessionData->date)).' '.$sessionData->time;
			$new_email_data['USERNAME'] = character_limit($sessionData->UserData->name,30);
			$new_email_data['OVERALL_EXPERIENCE'] = reviewImages($reviewModel->overall_rating);
			$new_email_data['ATTENTIVENESS'] = reviewImages($reviewModel->attentiveness);
			$new_email_data['COMMUNICATION'] = reviewImages($reviewModel->communication);
			$new_email_data['ACTIVE_LISTING_QUESTIONING'] = reviewImages($reviewModel->active_listening);
			$new_email_data['REVIEW'] = $reviewModel->review; 

			$new_email_data = _email_template_content("40",$new_email_data);
			$new_subject = 'User has reviewed on session - #'.$sessionData->id;
			$new_content = $new_email_data[1];
			$new_fromdata = ['email' => $coachEmail,'name' => $coachName];
			$new_mailids = [$coachEmail => $coachName];
			_mail_send_general( $new_fromdata, $new_subject , $new_content , $new_mailids );*/
            //User reviewed : Email to coach end

			//User reviewed : Email to admin start
			$adminEmail = get_settings('admin_email');
			$adminName = 'Admin';
			$link=url("admin/sessions/");
			$new_email_data['NAME'] = character_limit($adminName,25);
			$new_email_data['LINK'] = $link;
			$new_email_data['MESSAGE'] = 'User has reviewed on below session.';
			$new_email_data['SESSION_ID'] = $sessionData->id;
			$new_email_data['DATE_TIME'] = date("d M, Y",strtotime($sessionData->date)).' '.$sessionData->time;
			$new_email_data['USERNAME'] = character_limit($sessionData->UserData->name,30);
			$new_email_data['COACH_NAME'] = character_limit($sessionData->CoachData->name,30);
			$new_email_data['OVERALL_EXPERIENCE'] = reviewImages($reviewModel->overall_rating);
			$new_email_data['ATTENTIVENESS'] = reviewImages($reviewModel->attentiveness);
			$new_email_data['COMMUNICATION'] = reviewImages($reviewModel->communication);
			$new_email_data['ACTIVE_LISTING_QUESTIONING'] = reviewImages($reviewModel->active_listening);
			$new_email_data['REVIEW'] = $reviewModel->review; 

			$new_email_data = _email_template_content("41",$new_email_data);
			$new_subject = 'User has reviewed on session - #'.$sessionData->id;
			$new_content = $new_email_data[1];
			$new_fromdata = ['email' => $adminEmail,'name' => $adminName];
			$new_mailids = [$adminEmail => $adminName];
			_mail_send_general( $new_fromdata, $new_subject , $new_content , $new_mailids );
			//User reviewed : Email to admin end

			//Email to coach asking for a session report - Start
			/*$link=url("add-session-report/".Crypt::encryptString($sessionData->id));
			$coachEmail = $sessionData->CoachData->email;
			$coachName = $sessionData->CoachData->name;
			$new_email_data['NAME'] = character_limit($coachName,25);
			$new_email_data['LINK'] = $link;
			$new_email_data['USERNAME'] = $sessionData->UserData->name;
			$new_email_data['SESSION_ID'] = $sessionData->id;
			$new_email_data['DATE_TIME'] = date("d M, Y",strtotime($sessionData->date)).' '.$sessionData->time;
			$new_email_data = _email_template_content("42",$new_email_data);
			$new_subject = 'Give a report for the session!';
			$new_content = $new_email_data[1];
			$new_fromdata = ['email' => $coachEmail,'name' => $coachName];
			$new_mailids = [$coachEmail => $coachName];
			_mail_send_general( $new_fromdata, $new_subject , $new_content , $new_mailids );*/
			//Email to coach asking for a session report - End
			return back()->with('success','Your review has been submitted successfully.');
		}
		catch (Exception $e) {
			$errMsg = $e->getMessage();
			return redirect('login')->with('error',$errMsg);
		}
	}

	public function thanks()
	{
		$_meta_title = 'Login';
		$_meta_keyword = 'Login';
		$_meta_desc = 'Login';
		$pass_array = array(
			'_meta_title' => $_meta_title,
			'_meta_keyword' => $_meta_keyword,
			'_meta_desc' => $_meta_desc,
		);
		return view( 'front/thanks', $pass_array );
	}


}