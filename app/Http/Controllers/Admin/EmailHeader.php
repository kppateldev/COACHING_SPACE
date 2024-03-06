<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Request, Lang, Str;
use App\Models\User as UserModel;
use App\Models\EmailTemplateHeader as EmailTemplateHeaderModel;
// use Illuminate\Http\Request;

class EmailHeader extends Controller
{
    protected $section;
    protected $singleSection;
    protected $viewPath;
    protected $actionURL;

    public function __construct(){
        $this->section = 'Email Header';
        $this->singleSection = 'Email Header';
        $this->viewPath = 'admin/email';
        $this->actionURL = 'admin/email_header_template';
    }

    public function index(){

        $headers = EmailTemplateHeaderModel::where('status','1')->orderBy('id','DESC')->paginate(10);
        $_data=array(
            'section'=>$this->section,
            'singleSection'=>$this->singleSection,
            'actionURL'=>$this->actionURL,
            'view'=>"list",
            'headers'=>$headers,
        );
        return view($this->viewPath.'/email-header', $_data);
    }

    public function Add(){
       
        $_data=array(
            'section'=>$this->section,
            'singleSection'=>$this->singleSection,
            'actionURL'=>$this->actionURL,
            'view'=>"add"
        );
        return view($this->viewPath.'/create-email-header', $_data);
    }

    public function Edit($id="") {
        $data = EmailTemplateHeaderModel::where("id", $id)->first();
        if(isset($data) && !empty($data)):
            $_data=array(
                'section'=>$this->section,
                'singleSection'=>$this->singleSection,
                'actionURL'=>$this->actionURL,
                'view'=>"edit",
                'data'=>$data
            );
            return view($this->viewPath.'/create-email-header', $_data);
        else:
            return redirect($this->actionURL)->with('error', 'No data found.');
        endif;
    }

    public function Action($action="",$id="") {
        $data = Request::all();
        unset($data['_token']);
        // dd($data);
        if($action=="add"):
            EmailTemplateHeaderModel::create($data);
            return redirect($this->actionURL)->with( 'success', Lang::get('message.detailAdded', [ 'section' => $this->singleSection ])); 
        elseif($action=="edit"):
            EmailTemplateHeaderModel::where("id", $id)->update($data);
            return redirect($this->actionURL)->with( 'success', Lang::get('message.detailUpdated', [ 'section' => $this->singleSection ]));
        elseif($action=="delete"):
        endif; 
    }
}