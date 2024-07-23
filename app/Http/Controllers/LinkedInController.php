<?php

namespace App\Http\Controllers;

use Laravel\Socialite\Facades\Socialite;
use Illuminate\Http\Request;

class LinkedInController extends Controller
{
    public function auth() {
        return Socialite::driver('linkedin-openid')
        ->redirect();
    }

    public function callback() {
        $user = Socialite::driver('linkedin-openid')->user();
        $accessToken = $user->token;
        
        $client = new \GuzzleHttp\Client();
        $response = $client->get('https://api.linkedin.com/v2/shares', [
            'headers' => [
                'Authorization' => 'Bearer ' . $accessToken,
            ],
            'query' => [
                'q' => 'owners',
                'owners' => 'urn:li:person:' . $user->id,
            ],
        ]);



        // $posts = json_decode($response->getBody(), true);

        // dd($posts);
    }
}
