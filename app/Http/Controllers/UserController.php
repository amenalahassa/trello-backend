<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Unsplash\HttpClient as UnsplashClient;
use Unsplash\Photo as UnsplashPhoto;

class UserController extends Controller
{
    public function show(Request $request)
    {
//        Todo : Add invitation people in the team member count field

        $user = Auth::user();
        return response()->json([
            'user' => collect($user)->except(['created_at', 'email_verified_at', 'updated_at']),
            'board_background' => $this->initUnsplach(),
            'team_category' => array_map('getObjectFromArray', array_keys(\App\Models\Team::Category) ,  array_values(\App\Models\Team::Category)),
        ], 200);
    }

    //    Private function

    private function initUnsplach()
    {

        $accesKey = env('UNSPLASH_ACCESS_KEY');
        $appKey = env('UNSPLASH_APP_KEY');

        UnsplashClient::init([
            'applicationId'	=> $accesKey,
            'secret'	=> $appKey,
            'callbackUrl'	=> 'https://petitrello.com/oauth/callback',
            'utmSource' => 'trello'
        ]);

        $filters = [
            'collections' => 1053842,
            'orientation'    => 'landscape',
            'count'        => 6,
        ];
        $images = UnsplashPhoto::random($filters);

        return $images->toArray();
    }

}
