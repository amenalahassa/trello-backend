<?php

namespace App\Http\Controllers;

use Unsplash\HttpClient as UnsplashClient;
use Unsplash\Photo as UnsplashPhoto;

class FrontEndController extends Controller
{
    public  function  getAllCategoryList()
    {
        return response()->json(array_map('getObjectFromArray', array_keys(\App\Models\Team::Category) ,  array_values(\App\Models\Team::Category)), 200);
    }

    public function getBoardBackgroundImages ()
    {
        return response()->json(['images' =>  $this->initUnsplach()], 200);
    }

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
