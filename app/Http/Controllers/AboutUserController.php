<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AboutUserController extends Controller
{
    public function ifUerHasTeam ()
    {
        $teams = Auth::user()->teams;
        $hasteam = false;
        if (count($teams) > 0)
        {
            $hasteam = true;
        }
        return response()->json(['userHasTeam' => $hasteam], 200);
    }
}
