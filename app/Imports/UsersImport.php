<?php

namespace App\Imports;

use App\Models\User;
use App\Models\Organization;
use App\Models\Departments;
use Str;
use Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithCustomCsvSettings;

class UsersImport implements ToModel, WithStartRow, WithValidation, WithCustomCsvSettings
{
    public function startRow(): int
    {
        return 2;
    }

    public function getCsvSettings(): array
    {
        return [
            'delimiter' => ','
        ];
    }
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        if(!empty($row[0]) && !empty($row[1]) && !empty($row[2]) && !empty($row[3]) && !empty($row[4])){
            $name = $row[2]." ".$row[3];
            $email = $row[4];
            $email_count =  User::where('email', $email)->count();
            $organization =  Organization::where('company_name','like', "%{$row[0]}%")->first();
            $department =  Departments::where('title','like', "%{$row[1]}%")->first();
            if($email_count > 0):
                return;
            endif;
            $slug = Str::slug($name);
            $input['organization_id'] = $organization['id'] ?? '0';
            $input['department_id'] = $department['id'] ?? '0';
            $input['first_name'] = $row[2];
            $input['last_name'] = $row[3];
            $input['name'] = $name;
            $input['slug'] = $slug;
            $input['email'] = $row[4];
            $input['is_active'] = 1;
            $generatePassword = $this->get_password();
            $input['password'] = Hash::make($generatePassword); 
            $data = User::create($input);
            if(isset($data) && !empty($data)){
                // Mail send start
                $name = $name;
                $email = $email;
                $subject = "Account created!";
                $mailData['SUBJECT'] = $subject;
                $mailData['EMAIL'] = $email;
                $mailData['NAME']= $name;
                $mailData['LINK'] = url('/');
                $mailData['PASSWORD'] = $generatePassword;
                $mailData['MESSAGE'] = 'Your account has been created by an administrator! ';

                $mailData['NAME'] = $name;
                $new_email_data = _email_template_content("44",$mailData);
                $new_subject = isset( $new_email_data[0] ) ? $new_email_data[0] : '';
                $new_content = $new_email_data[1];
                $new_fromdata = ['email' => $email,'name' => $name];
                $new_mailids = [$email => $name];
                _mail_send_general( $new_fromdata, $new_subject , $new_content , $new_mailids );

                //Verify Email start
                $encrypted = Crypt::encryptString($email);
                $link=url("verification").'/'.$encrypted;
                $new_mail_data['NAME'] = $name;
                $new_mail_data['LINK'] = $link;
                $new_email_data = _email_template_content("1",$new_mail_data);
                $new_subject = isset( $new_email_data[0] ) ? $new_email_data[0] : '';
                $new_content = $new_email_data[1];
                $new_fromdata = ['email' => $email,'name' => $name];
                $new_mailids = [$email => $name];
                _mail_send_general( $new_fromdata, $new_subject , $new_content , $new_mailids );
                return;
            }
        }
    }

    public function rules():array   
    {
        # code...
        return [
            '*.4' => ['unique:users,email']
        ];
    }

    public function customValidationMessages()
    {
        return [
            '4.unique' => 'Duplicate value found in Email Address. Please add a different value.',
        ];
    }

    function get_password($upper = 1, $lower = 5, $numeric = 2, $other = 1) { 
        $pass_order = Array(); 
        $passWord = ''; 
        //Create contents of the password 
        for ($i = 0; $i < $upper; $i++) { 
            $pass_order[] = chr(rand(65, 90)); 
        } 
        for ($i = 0; $i < $lower; $i++) { 
            $pass_order[] = chr(rand(97, 122)); 
        } 
        for ($i = 0; $i < $numeric; $i++) { 
            $pass_order[] = chr(rand(48, 57)); 
        } 
        for ($i = 0; $i < $other; $i++) { 
            $pass_order[] = chr(rand(33, 47)); 
        } 
        //using shuffle() to shuffle the order
        shuffle($pass_order); 
        //Final password string 
        foreach ($pass_order as $char) { 
            $passWord .= $char; 
        } 
        return $passWord;  
    }
} 