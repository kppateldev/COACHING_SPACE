<?php
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Coach;
use DateTime as DateTime;
use Illuminate\Support\Str;
use PHPMailer\PHPMailer\PHPMailer, Carbon\Carbon, Carbon\CarbonPeriod;
use App\Models\EmailTemplate as EmailTemplateModel;
use App\Models\Settings as SettingsModel;

function _getDepartmentTitle($id)
{
    $result = App\Models\Departments::where('id',$id)->first();
    if($result){
        return $result->title;
    }
    else{
        return "N/A";
    }
}

function createOutLookEvent($to_name,$to_address,$location,$startTime,$endTime)
{
    $subject = "Coaching Space Session!";
    $description = "Coaching Space Session!";    
    $location = $location;
    $from_name  = 'CoachingSpace';
    $from_address  = 'kanu.nyusoft@gmail.com';    
    $domain = 'coachingspace.nyusoft.in/';
    $mail = new PHPMailer();
    $mail->isSMTP();
    $mail->SMTPDebug = 0;
    $mail->Host = 'smtp.gmail.com';
    $mail->Username = 'kanu.nyusoft@gmail.com';
    $mail->Password = 'xubkrttjtxuuktdr';
    $mail->Port = 587;
    $mail->SMTPAuth = true;
    $mail->SMTPSecure = 'tls';
    $mail->IsHTML(true);
    $mail->setFrom($from_address, $from_name);
    $mail->addReplyTo($from_address, $from_name);
    $mail->addAddress($to_address, $to_name);
    $mail->ContentType = 'text/calendar; charset="utf-8"; method=REQUEST';
    $mail->Subject = $subject;
    //Event setting
    $ical = 'BEGIN:VCALENDAR' . "\r\n" .
    'PRODID:-//Microsoft Corporation//Outlook 10.0 MIMEDIR//EN' . "\r\n" .
    'VERSION:2.0' . "\r\n" .
    'METHOD:REQUEST' . "\r\n" .
    'BEGIN:VTIMEZONE' . "\r\n" .
    'TZID:Eastern Time' . "\r\n" .
    'BEGIN:STANDARD' . "\r\n" .
    'DTSTART:20091101T020000' . "\r\n" .
    'RRULE:FREQ=YEARLY;INTERVAL=1;BYDAY=1SU;BYMONTH=11' . "\r\n" .
    'TZOFFSETFROM:-0400' . "\r\n" .
    'TZOFFSETTO:-0500' . "\r\n" .
    'TZNAME:EST' . "\r\n" .
    'END:STANDARD' . "\r\n" .
    'BEGIN:DAYLIGHT' . "\r\n" .
    'DTSTART:20090301T020000' . "\r\n" .
    'RRULE:FREQ=YEARLY;INTERVAL=1;BYDAY=2SU;BYMONTH=3' . "\r\n" .
    'TZOFFSETFROM:-0500' . "\r\n" .
    'TZOFFSETTO:-0400' . "\r\n" .
    'TZNAME:EDST' . "\r\n" .
    'END:DAYLIGHT' . "\r\n" .
    'END:VTIMEZONE' . "\r\n" .  
    'BEGIN:VEVENT' . "\r\n" .
    'ORGANIZER;CN="'.$from_name.'":MAILTO:'.$from_address. "\r\n" .
    'ATTENDEE;CN="'.$to_name.'";ROLE=REQ-PARTICIPANT;RSVP=TRUE:MAILTO:'.$to_address. "\r\n" .
    'LAST-MODIFIED:' . date("Ymd\TGis") . "\r\n" .
    'UID:'.date("Ymd\TGis", strtotime($startTime)).rand()."@".$domain."\r\n" .
    'DTSTAMP:'.date("Ymd\TGis"). "\r\n" .
    'DTSTART;TZID="Asia/Kolkata":'.date("Ymd\THis", strtotime($startTime)). "\r\n" .
    'DTEND;TZID="Asia/Kolkata":'.date("Ymd\THis", strtotime($endTime)). "\r\n" .
    'TRANSP:OPAQUE'. "\r\n" .
    'SEQUENCE:1'. "\r\n" .
    'SUMMARY:' . $subject . "\r\n" .
    'LOCATION:' . $location . "\r\n" .
    'CLASS:PUBLIC'. "\r\n" .
    'PRIORITY:5'. "\r\n" .
    'BEGIN:VALARM' . "\r\n" .
    'TRIGGER:-PT15M' . "\r\n" .
    'ACTION:DISPLAY' . "\r\n" .
    'DESCRIPTION:Reminder' . "\r\n" .
    'END:VALARM' . "\r\n" .
    'END:VEVENT'. "\r\n" .
    'END:VCALENDAR'. "\r\n";
    $mail->Body = $ical;
    //send the message, check for errors
    if(!$mail->send()) {
        echo "Mailer Error: " . $mail->ErrorInfo;
        return false;
    } else {
        echo "Message sent!";
        return true;
    }
}

if (! function_exists('get_coach_by_id')) {
    function get_coach_by_id($id)
    {
       $reslut = App\Models\Coach::where(['is_active'=>1,'id'=>$id])->first();
       return $reslut['name'] ?? '';
   }
}
function getTwoMonthDates($day){
    $currDate = date("Y-m-d",strtotime("- 1 day"));
    $twoMonthDate = date("Y-m-d", strtotime("+ 60 day"));
    $dateFrom = new \DateTime($currDate);
    $dateTo = new \DateTime($twoMonthDate);
    $dates = [];
    if ($dateFrom > $dateTo) {
        return $dates;
    }
    if (1 != $dateFrom->format('N')) {
        $dateFrom->modify('next '.$day);
    }
    while ($dateFrom <= $dateTo) {
        $dates[] = $dateFrom->format('Y-m-d');
        $dateFrom->modify('+1 week');
    }
    return $dates;
}

function getBetweenDates($startDate, $endDate)
{
    $rangArray = [];   
    $startDate = strtotime($startDate);
    $endDate = strtotime($endDate);
    for ($currentDate = $startDate; $currentDate <= $endDate; 
        $currentDate += (86400)) {

        $date = date('Y-m-d', $currentDate);
        $rangArray[] = $date;
    }
    return $rangArray;
}

function _get_setting( $name ) {
    if( isset($name) && $name ):
        return SettingsModel::where('field',trim($name))->value('value');
    endif;
    return false;
}

function character_limit($x, $length){
    return Str::limit($x, $length);
}

function _email_template_content($id,$user_data) {
    // Logo
    $user_data['BASE_URL']  =   url('/');   
    //$user_data['LOGO']  =   url('public/uploads/settings/'._get_setting('logo'));
    $user_data['LOGO']  =  url('front_assets/images/logo_final.png');
    // Social medial icon
    $user_data['BACK_URL']  =  url('/');
    // COPYRIGHT
    $user_data['COPYRIGHT'] =  "&copy; ".date('Y')." Coaching Space. All Rights Reserved.";
    $content_array = array();
    $emailTemplate = EmailTemplateModel::where('id', $id)->where('status', '1')->first();
    $string="";
    $subject=$emailTemplate->subject;
    $only_string = '';
    if(isset($emailTemplate)):
        $keys = [
            '{FIRST_NAME}',
            '{LAST_NAME}',
            '{LINK}',
            '{LINK_1}',
            '{NAME}',
            '{EMAIL}',
            '{PASSWORD}',
            '{PHONE}',
            '{COUNTRY}',
            '{SUBJECT}',
            '{MESSAGE}',
            '{DATE}',
            '{TIME}',
            '{USERNAME}',
            '{PLAN}',
            '{ADDRESS}',
            '{PHONE}',
            '{ICON}',
            '{LOGO}',
            '{COPYRIGHT}',
            '{BASE_URL}',
            '{ROLE}',
            '{REMARK}',
            '{TITLE}',
            '{BACK_URL}',
            '{DATE_TIME}',
            '{SESSION_ID}',
            '{COACH_NAME}',
            '{OVERALL_EXPERIENCE}',
            '{ATTENTIVENESS}',
            '{COMMUNICATION}',
            '{ACTIVE_LISTING_QUESTIONING}',
            '{REVIEW}',
            '{SESSION_REPORT}',
            '{DISCUSSION}',

        ];
        $keys2 = [
            '{ACTION_URL}',
        ];
        $only_string = $emailTemplate->body;
        $string = $emailTemplate->hasTemplateHeader->description;
        $string .= $emailTemplate->body;
        $string .= $emailTemplate->hasTemplateFooter->description;
        foreach ($keys as $v):
            $k = str_replace("{","",$v);
            $k = str_replace("}","",$k);
            if(isset($user_data[$k])):
                $string = str_replace( $v, $user_data[$k], $string);
                $only_string = str_replace( $v, $user_data[$k], $only_string);
                $subject = str_replace( $v, $user_data[$k], $subject);
            endif;
        endforeach;
        foreach ($keys2 as $v):
            $k = str_replace("{","",$v);
            $k = str_replace("}","",$k);
            if(isset($user_data[$k])):
                $string = str_replace( $v, $user_data[$k], $string);
                $only_string = str_replace( $v, $user_data[$k], $only_string);
                $subject = str_replace( $v, $user_data[$k], $subject);
            endif;
        endforeach;
    endif;
    //echo $string; exit;
    $content_array = array($subject,$string,$only_string);
    //print_r($content_array); die;
    return $content_array;
}

function _mail_send_general( $replyData = array() ,$subject="" , $message="" , $mailids = array() , $attachments = array() ) {
    $fromData = $fromdata=array(
        'host'=>env('SMTP_HOST'),
        'port'=>env('SMTP_PORT'),
        'username'=>env('SMTP_USERNAME'),
        'password'=>env('SMTP_PASSWORD'),
        'from_name'=>env('SMTP_FROM_NAME'),
        'from_email'=>env('SMTP_FROM_EMAIL'),
    );
    $replyToMail = $fromData['username'];
    $replyToName = 'Coaching Space';
    if( isset($replyData['email']) && $replyData['email'] != '' ) $replyToMail = $replyData['email'];
    if( isset($replyData['name']) && $replyData['name'] != '' ) $replyToName = $replyData['name'];

    $mail = new PHPMailer;
    $IS_SMTP = 1;
    if($IS_SMTP):
        //$mail->SMTPDebug = 2; //Alternative to above constant
        $mail->isSMTP(); // commented to send the mail
        $mail->CharSet = "utf-8";
        $mail->Host = $fromData['host'];
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = '';
        $mail->Port = $fromData['port'];
        $mail->SMTPOptions = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            )
        );
    endif;
    $mail->Username = $fromData['username'];
    $mail->Password = $fromData['password'];
    $mail->setFrom( $fromData['from_email'] , $fromData['from_name'] );
    if( $replyToMail != '' ):
        $mail->AddReplyTo( $replyToMail , $replyToName );
    endif;
    //  Add Attachments >>
    if( isset( $attachments ) && count( $attachments ) ):
        foreach ( $attachments as $key => $value ):
            $mail->AddAttachment( $value );
        endforeach;
    endif;
    //  << Add Attachments
    $mail->Subject = $subject;
    $mail->MsgHTML($message);
    if(count($mailids)):
        foreach ($mailids as $key => $value):
            $mail->addAddress($key,$value);
        endforeach;
    endif;
    $mail->isHTML(true);
    //print_r($mail); die;
    $a = $mail->send();
    //print_r($a); die;
    return $a;
}

// Get settings by field name for all site
if (! function_exists('get_settings')) {
    function get_settings($field)
    {
        $result =  SettingsModel::where('field',$field)->first();

        if($result){
            return $result->value;
        }else{
            return null;
        }

    }
}

// Get user Name
if (! function_exists('get_user_name')) {
    function get_user_name($user_id)
    {
        $result =  User::where('id',$user_id)->first();

        if($result){

            if($result->name != ''){
                return $result->name;
            }
            elseif($result->first_name != ''){
                return $result->first_name.' '.$result->last_name;
            }
            else{
                return 'N/A';
            }

        }else{
            return 'N/A';
        }

    }
}

// Get user type
if (! function_exists('get_user_type')) {
    function get_user_type($user_id)
    {
        $result =  User::where('id',$user_id)->first();

        if($result){

            if($result->user_type != ''){
                return $result->user_type;
            }
            else{
                return 'N/A';
            }

        }else{
            return 'N/A';
        }

    }
}

// Nice datetime format
if (! function_exists('nice_date_time')) {
    function nice_date_time($bad_date = ''){
        if(empty($bad_date)):
            $bad_date = date('Y-m-d');
        endif;
        $format = 'h:i A, d M Y';
        return Carbon::parse($bad_date)->format($format);
    }
}

// Nice date format
if (! function_exists('nice_date')) {
    function nice_date($bad_date = ''){
        if(empty($bad_date)):
            $bad_date = date('Y-m-d');
        endif;
        $format = 'd M, Y';
        return Carbon::parse($bad_date)->format($format);
    }
}

// Nice date format for reviews
if (! function_exists('nice_date_for_review')) {
    function nice_date_for_review($bad_date = ''){
        if(empty($bad_date)):
            $bad_date = date('Y-m-d');
        endif;
        $format = 'M d, Y';
        return Carbon\Carbon::parse($bad_date)->format($format);
    }
}

// Get user Image
if (! function_exists('get_user_image')) {
    function get_user_image($user_id)
    {
        $result =  User::where('id',$user_id)->first();

        if($result){

            if($result->profile_image != ''){
                return asset('uploads/'.$result->profile_image);
            }
            else{
                return asset('assets/images/default_profile.png');
            }

        }else{
            return asset('assets/images/default_profile.png');
        }

    }
}

// Get coach Image
if (! function_exists('get_coach_image')) {
    function get_coach_image($coach_id)
    {
        $result =  Coach::where('id',$coach_id)->first();

        if($result){

            if($result->profile_image != ''){
                return asset('uploads/coach/'.$result->profile_image);
            }
            else{
                return asset('assets/images/default_profile.png');
            }

        }else{
            return asset('assets/images/default_profile.png');
        }

    }
}


if (! function_exists('get_custom_slot')) {

    function get_custom_slot($min='45'){
        $interval = '15';
        $start_time = strtotime('2022-03-04 08:00:00');
        $end_time = strtotime('2022-03-04 17:45:00');
        $slot = strtotime(date('Y-m-d H:i:s',$start_time) . ' +'.$min.' minutes');
        $data = [];
        for ($i=0; $slot <= $end_time; $i++) {
            $data[$i] = date('H:i', $start_time).' - '.date('H:i', $slot);
            //$start_time = $slot;
            $start_time = strtotime(date('Y-m-d H:i:s',$slot) . ' +'.$interval.' minutes');
            $slot = strtotime(date('Y-m-d H:i:s',$start_time) . ' +'.$min.' minutes');
        }
        return $data;
    }
}
if (! function_exists('reviewImages')) {

    function reviewImages($reviewCount){
        if($reviewCount == 5)
        {
            $url = url('public/front_assets/images/star5.png');
            $overallRateImage = '<img style="height: 14px;" src="'.$url.'"/>';
        }
        else if($reviewCount == 4)
        {
            $url = url('public/front_assets/images/star4.png');
            $overallRateImage = '<img style="height: 14px;" src="'.$url.'"/>';
        }
        else if($reviewCount == 3)
        {
            $url = url('public/front_assets/images/star3.png');
            $overallRateImage = '<img style="height: 14px;" src="'.$url.'"/>';
        }
        else if($reviewCount == 2)
        {
            $url = url('public/front_assets/images/star2.png');
            $overallRateImage = '<img style="height: 14px;" src="'.$url.'"/>';
        }
        else if($reviewCount == 1)
        {
            $url = url('public/front_assets/images/star1.png');
            $overallRateImage = '<img style="height: 14px;" src="'.$url.'"/>';
        }
        if(!isset($overallRateImage) || empty($overallRateImage))
        {
            $overallRateImage = '---';
        }
        return $overallRateImage;
    }
}