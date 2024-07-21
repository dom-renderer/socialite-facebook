<?php

namespace App\Http\Controllers;

use Laravel\Socialite\Facades\Socialite;
use Illuminate\Http\Request;
use App\Models\Facebook;
use App\Models\User;

class FacebookController extends Controller
{
    public function auth() {
        return Socialite::driver('facebook')
        ->redirect();
    }

    public function callback() {
        $user = Socialite::driver('facebook')->user();
        $accessToken = $user->token;

        $response = \Http::get("https://graph.facebook.com/v20.0/me?fields=age_range%2Cbirthday%2Ceducation%2Cemail%2Cfirst_name%2Cgender%2Chometown%2Cid%2Clanguages%2Clink%2Clast_name%2Clocation%2Cmiddle_name%2Cname%2Cname_format%2Crelationship_status%2Cshort_name%2Csignificant_other%2Cavatars.limit(10)%2Cfriends%7Blocation%2Cname%7D%2Cvideos.limit(10)%2Cposts%7Bplace%2Ccaption%2Ccreated_time%2Cfull_picture%2Cid%2Cname%2Cpermalink_url%2Ccomments%2Cmessage%2Cprivacy%2Ctype%2Creactions%7Bname%2Cid%7D%2Cattachments%7D%2Cphotos%7Bcreated_time%2Cpicture%7D&access_token=$accessToken")->json();

        dd($response);

        Facebook::create([
            'avatar' => $user->avatar,
            'nickname' => $user->nickname,
            'gender' => $user->user['gender'] ?? '',
            'full_name' => $user->name,
            'email' => $user->email,
            'facebook_id' => $user->id
        ]);

        return redirect('/home');
    }

    public function privacyPolicy() {
        
    }
}

//https://developers.facebook.com/tools/explorer/
//me?fields=id,name
//me?fields=id,name,education,gender,birthday,relationship_status,posts.limit(10),email,age_range,friends{accounts{id,general_info},id},link,hometown,location,name_format,middle_name

//https://developers.facebook.com/docs/facebook-login/guides/access-tokens/
//https://developers.facebook.com/docs/permissions

// curl -i -X GET \
//  "https://graph.facebook.com/v20.0/me?fields=id%2Cname%2Ceducation%2Cgender%2Cbirthday%2Crelationship_status%2Cposts.limit(10)%2Cemail%2Cage_range%2Cfriends%7Baccounts%7Bid%2Cgeneral_info%7D%2Cid%7D%2Clink%2Chometown%2Clocation%2Cname_format%2Cmiddle_name%2Cabout%2Cprofile_pic&access_token=EAAExtnWP4xQBOzIXOMAsJVpJR6ARXRlsTzLfR6fuXKGVVHCcxF2vX8MB2BTfxXy1ZC4qqAf0AKgVBfZCJeSu70azhhTkIjEaM5Ok4ycuhYZAWsVLOUNQQyCoZAZCD6QSG33HZB0FgzS9q1EZCq94WIErCcnZAUV5w5xpGf0EdbCF4ZB8UOEebnDYztegbFi8SZBoKjaYZAvFxaKh7r8vER6iJLCsskrapMZAVUFs3MGsSu7zfRuD638o11wJ"

// curl -i -X GET \
//  "https://graph.facebook.com/v20.0/me?fields=age_range%2Cbirthday%2Ceducation%2Cemail%2Cfirst_name%2Cgender%2Chometown%2Cid%2Clanguages%2Clink%2Clast_name%2Clocation%2Cmiddle_name%2Cname%2Cname_format%2Crelationship_status%2Cshort_name%2Csignificant_other%2Cavatars.limit(10)%2Cfriends%7Blocation%2Cname%7D%2Cvideos.limit(10)%2Cposts%7Bplace%2Ccaption%2Ccreated_time%2Cfull_picture%2Cid%2Cname%2Cpermalink_url%2Ccomments%2Cmessage%2Cprivacy%2Ctype%2Creactions%7Bname%2Cid%7D%2Cattachments%7D%2Cphotos%7Bcreated_time%2Cpicture%7D&access_token=EAAExtnWP4xQBO74CL4PUS05skjBHxKZAnGZAue7TyEEXgwtRXAT1gZB8SdYHzKsCkcPmHJNUJ9iR7lq1NnbjbM0MMpXZBnniJZCCcoLuSnebSBGHbj8jpQwL1V5QwDdNSeLPnDJGXkFKZAOj2E2soNs2Xz2ZAWXR70FAv6HXgk1ZB7oh0BZCWIKKyoOfAAZB9zIFABwrLEYPNnDLlrRzccyPZB9MaXpXkJ3NiAZBpoq2d8cMB8QYJZBSlb2ZCh"



// curl -i -X GET \
//  "https://graph.facebook.com/v20.0/me?fields=age_range%2Cbirthday%2Ceducation%2Cemail%2Cfirst_name%2Cgender%2Chometown%2Cid%2Clanguages%2Clink%2Clast_name%2Clocation%2Cmiddle_name%2Cname%2Cname_format%2Crelationship_status%2Cshort_name%2Csignificant_other%2Cavatars.limit(10)%2Cfriends%7Blocation%2Cname%2Cabout%2Cage_range%2Cbirthday%2Ceducation%2Cemail%2Cid%2Clanguages%2Clast_name%7D%2Cvideos.limit(10)%2Cposts%7Bplace%2Ccaption%2Ccreated_time%2Cfull_picture%2Cid%2Cname%2Cpermalink_url%2Ccomments%2Cmessage%2Cprivacy%2Ctype%2Creactions%7Bname%2Cid%7D%2Cattachments%7D%2Cphotos%7Bcreated_time%2Cpicture%7D%2Clikes%7Bcover%7D%2Cpicture%2Cgroups%7Bid%2Cname%2Cprivacy%2Copted_in_members%7Bid%2Cfirst_name%2Clast_name%7D%7D%2Cwebsite&access_token=EAAExtnWP4xQBO69PJUL9mVd3R0JDZBIe3TxeJSO6LLmCvT9LmcZCBYHW3UEDeWEcf8wLDKGjM9uZAUfCGeUFcOxkf8Vwla5BbdZA5lkoJje0eZCgCRGk76r6L9CGYX3PZCCKhYGJTT4xOlezyKjeclhyJGgTdoE8WkWOcEvD5MCVxFNKfDqlkipwPy1u1pIn04KwJZAmO9A6NgyxHiJexPpUeULzZCwV5Fo1FGgqaG5sNRNL5oyUloRN"

// https://developers.facebook.com/tools/explorer/?method=GET&path=me%3Ffields%3Dage_range%2Cbirthday%2Ceducation%2Cemail%2Cfirst_name%2Cgender%2Chometown%2Cid%2Clanguages%2Clink%2Clast_name%2Clocation%2Cmiddle_name%2Cname%2Cname_format%2Crelationship_status%2Cshort_name%2Csignificant_other%2Cavatars.limit(10)%2Cfriends%7Blocation%2Cname%2Cabout%2Cage_range%2Cbirthday%2Ceducation%2Cemail%2Cid%2Clanguages%2Clast_name%7D%2Cvideos.limit(10)%2Cposts%7Bplace%2Ccaption%2Ccreated_time%2Cfull_picture%2Cid%2Cname%2Cpermalink_url%2Ccomments%2Cmessage%2Cprivacy%2Ctype%2Creactions%7Bname%2Cid%7D%2Cattachments%7D%2Cphotos%7Bcreated_time%2Cpicture%7D%2Clikes%7Bcover%7D%2Cpicture%2Cgroups%7Bid%2Cname%2Cprivacy%2Copted_in_members%7Bid%2Cfirst_name%2Clast_name%7D%7D%2Cwebsite&version=v20.0