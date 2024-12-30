<?php

namespace App\Http\Controllers\ADMIN;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

// use DB;
class MailController extends Controller
{

   /*  common function for sending mail to the requested email */
   public function send_mail(request $request){

         $setting =(object) DB::table('settings')->pluck('short_value','key')->toArray();

         if($setting->is_checked_smtp == 1){ //if user have set smtp credentails
         $website_link = route('frontend.home',app()->getLocale());
      
         if($request->type == 'registration_test'){
            $template = $setting->registration_template;
            $link_text = '<a href="'.$website_link.'">'.$setting->reg_link_text.'</a>';
            $subject = trans('msg.subject_email_verification_test');
         }
         elseif($request->type == 'forget_password_test'){
            $template = $setting->forget_password_template;
            $link_text = '<a href="'.$website_link.'">'.$setting->forget_pass_link_text.'</a>';
            $subject = trans('msg.subject_forget_password_test');
         }
         elseif($request->type == 'new_user_temp_test'){
            $template = $setting->new_user_template;
            $link_text = '<a href="'.route('frontend.sign-in',app()->getLocale()).'">click here</a>';
            $subject = trans('msg.subject_new_user_test');
         }
         elseif($request->type == 'new_user_temp'){  //if the admin creates a new user and sends mail to a user
            $template = $setting->new_user_template;
            $link_text = '<a href="'.route('frontend.sign-in',app()->getLocale()).'">click here</a>';
            $subject = trans('msg.subject_new_user');
         }
         $final_template = "";
       
         if($setting->is_checked_logo_on_mail)
         {
            $final_template .=  '<img src="'.\Storage::url(getSettingShortValue('my_logo')).'" alt="logo" width="200px" height="50px" /> </br> </br>'."\r\n";
         }
         $new_template = str_replace('[username]',$request->full_name ?? 'username',$template);
         $new_template = str_replace('[break]','</br>',$new_template);
         $new_template = str_replace('[linktext]',@$link_text,$new_template);
         $new_template = str_replace('[website_link]',$link_text,$new_template);
         $new_template = str_replace('[email]',$request->email ?? 'email',$new_template);
         $new_template = str_replace('[password]',$request->password ?? 'password',$new_template);

         $final_template .= $new_template;

   
         $obj = (object)[];
         $obj->receiver_email = $request->email;
         $obj->template = $final_template;
         $obj->subject = $subject;
         $check = sendUserEmailMandrill($obj);   //custom helper function for sending mail
         if ($check) {
            return json_response(['status' => true, 'msg' => trans('msg.text_email_send_succ')], 200);
         } else {
            return json_response(['status' => false, 'msg' => trans('msg.failed_password_reset_send_mail')], 400);
         }
      }
      return json_response(['status' => false, 'msg' => trans('msg.fill_smtp_credentails')], 400);
   }

    /*  function for sending mail to new user */
   public function send_mail2($request){

         $setting = (object) DB::table('settings')->whereNull('long_value')->pluck('short_value','key')->toArray();
         $setting2 =(object) DB::table('settings')->whereNull('short_value')->pluck('long_value','key')->toArray();


         if($setting->is_checked_smtp == 1){ //if user have set smtp credentails
         $website_link = route('frontend.home',app()->getLocale());
      
         if($request->type == 'new_user_temp'){  //if the admin creates a new user and sends mail to a user
            $template = $setting2->new_user_template;
            $link_text = '<a href="'.route('frontend.sign-in',app()->getLocale()).'">click here</a>';
            $subject = trans('msg.subject_new_user');
         }
         $final_template = "";
       
         if($setting->is_checked_logo_on_mail)
         {
            $final_template .=  '<img src="'.\Storage::url(getSettingShortValue('my_logo')).'" alt="logo" width="200px" height="50px" /> </br> </br>'."\r\n";
         }
         $new_template = str_replace('[username]',@$request->full_name ?? 'username',$template);
         $new_template = str_replace('[break]','</br>',$new_template);
         $new_template = str_replace('[linktext]',@$link_text,$new_template);
         $new_template = str_replace('[website_link]',$link_text,$new_template);
         $new_template = str_replace('[email]',$request->email ?? 'email',$new_template);
         $new_template = str_replace('[password]',$request->password ?? 'password',$new_template);

         $final_template .= $new_template;

   
         $obj = (object)[];
         $obj->receiver_email = $request->email;
         $obj->template = $final_template;
         $obj->from_email_address =   $setting->from_email_address;
         $obj->from_name =   $setting->from_name;
         $obj->subject = $subject;

         $check = sendUserEmailMandrill($obj);  //custom helper function for sending mail
         if ($check) {
            return json_response(['status' => true, 'msg' => trans('msg.text_email_send_succ')], 200);
         } else {
            return json_response(['status' => false, 'msg' => trans('msg.failed_password_reset_send_mail')], 400);
         }
      }
      return json_response(['status' => false, 'msg' => trans('msg.fill_smtp_credentails')], 400);
   }
   
}
