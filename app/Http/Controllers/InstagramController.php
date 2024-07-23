<?php

namespace App\Http\Controllers;

use Laravel\Socialite\Facades\Socialite;
use Illuminate\Http\Request;
use App\Models\Instagram;
use GuzzleHttp\Client;
use App\Models\User;

class InstagramController extends Controller
{
    //https://stackoverflow.com/questions/59142407/laravel-integrate-with-instagram-api-after-october-2019
    public function auth()
    {
        $appId = config('services.instagram.app_id');
        $redirectUri = urlencode(config('services.instagram.redirect'));

        $url = "https://api.instagram.com/oauth/authorize?client_id=" . env('INSTA_CLIENT_ID') . "&redirect_uri=" . env('INSTA_REDIRECT') . "&scope=user_profile,user_media&response_type=code";
        
        //https://justinstolpe.com/blog_code/instagram_graph_api/get_users_info_and_posts.php
        //https://github.com/jstolpe/blog_code/blob/master/instagram_graph_api/get_users_info_and_posts.php
        //Endpoint: https://graph.facebook.com/v12.0/{ig-user-id}?fields=business_discovery.username({ig-username}){username,website,name,ig_id,id,profile_picture_url,biography,follows_count,followers_count,media_count,media{id,caption,like_count,comments_count,timestamp,username,media_product_type,media_type,owner,permalink,media_url,children{media_url}}}&access_token={access-token}


        return redirect()->to($url);

        // return redirect()->to("https://api.instagram.com/oauth/authorize?redirect_uri={$redirectUri}&app_id={$appId}&scope=user_profile,user_media&response_type=code");
    }
    
    public function callback(Request $request)
    {
        $code = $request->code;
        if (empty($code)) return redirect()->route('home')->with('error', 'Failed to login with Instagram.');
    
        $appId = config('services.instagram.client_id');
        $secret = config('services.instagram.client_secret');
        $redirectUri = config('services.instagram.redirect');
    
        $client = new Client();
    
        // Get access token
        $response = $client->request('POST', 'https://api.instagram.com/oauth/access_token', [
            'form_params' => [
                'app_id' => $appId,
                'app_secret' => $secret,
                'grant_type' => 'authorization_code',
                'redirect_uri' => $redirectUri,
                'code' => $code,
            ]
        ]);
    
        if ($response->getStatusCode() != 200) {
            return redirect()->route('home')->with('error', 'Unauthorized login to Instagram.');
        }
    
        $content = $response->getBody()->getContents();
        $content = json_decode($content);
    
        $accessToken = $content->access_token;
        $userId = $content->user_id;
    
        // Get user info
        $response = $client->request('GET', "https://graph.instagram.com/me?fields=id,username,account_type&access_token={$accessToken}");
    
        $content = $response->getBody()->getContents();
        $oAuth = json_decode($content);
    
        // Get instagram user name 
        $username = $oAuth->username;
    
        // do your code here
    }
}
