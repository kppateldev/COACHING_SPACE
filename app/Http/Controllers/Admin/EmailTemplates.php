<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Request, Lang, Str;
use App\Models\User as UserModel;
use App\Models\EmailTemplate as EmailTemplateModel;
use App\Models\EmailTemplateHeader as EmailTemplateHeaderModel;
use App\Models\EmailTemplateFooter as EmailTemplateFooterModel;
// use Illuminate\Http\Request;

class EmailTemplates extends Controller
{
    protected $section;
    protected $singleSection;
    protected $viewPath;
    protected $actionURL;

    public function __construct(){
        $this->section = 'Email Template';
        $this->singleSection = 'Email Template';
        $this->viewPath = 'admin/email';
        $this->actionURL = 'admin/email_templates';
    }

    public function index(){

        $templatebody = EmailTemplateModel::where('status','1')->orderBy('id','DESC')->paginate(10);
        $_data=array(
            'section'=>$this->section,
            'singleSection'=>$this->singleSection,
            'actionURL'=>$this->actionURL,
            'view'=>"list",
            'templatebody'=>$templatebody,
        );
        return view($this->viewPath.'/email-body', $_data);
    }

    public function Add(){
        $headers = EmailTemplateHeaderModel::where('status','1')->get();
        $footers = EmailTemplateFooterModel::where('status','1')->get();
        if(isset($headers) && !empty($headers) && isset($footers) && !empty($footers)):
            $_data=array(
                'section'=>$this->section,
                'singleSection'=>$this->singleSection,
                'actionURL'=>$this->actionURL,
                'view'=>"add",
                'headers'=>$headers,
                'footers'=>$footers,
            );
            return view($this->viewPath.'/create-email-body', $_data);
        else:
            return redirect($this->actionURL)->with('error','Something went wrong.');
        endif;
    }

    public function Edit($id="") {
        $data = EmailTemplateModel::where("id", $id)->first();
        $headers = EmailTemplateHeaderModel::where('status','1')->get();
        $footers = EmailTemplateFooterModel::where('status','1')->get();
        if(isset($data) && !empty($data) && isset($headers) && !empty($headers) && isset($footers) && !empty($footers)):
            $_data=array(
                'section'=>$this->section,
                'singleSection'=>$this->singleSection,
                'actionURL'=>$this->actionURL,
                'view'=>"edit",
                'headers'=>$headers,
                'footers'=>$footers,
                'data'=>$data
            );
            return view($this->viewPath.'/create-email-body', $_data);
        else:
            return redirect($this->actionURL)->with('error', 'No data found.');
        endif;
    }

    public function Action($action="",$id="") {
        $data = Request::all();
        unset($data['_token']);
        // dd($data);
        if($action=="add"):
            EmailTemplateModel::create($data);
            return redirect($this->actionURL)->with( 'success', Lang::get('message.detailAdded', [ 'section' => $this->singleSection ])); 
        elseif($action=="edit"):
            EmailTemplateModel::where("id", $id)->update($data);
            return redirect($this->actionURL)->with( 'success', Lang::get('message.detailUpdated', [ 'section' => $this->singleSection ]));
        elseif($action=="delete"):
        endif; 
    }
}