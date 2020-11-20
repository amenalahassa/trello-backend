<?php

namespace App\Http\Controllers;

use App\Models\MemberTeam;
use App\Models\Team;
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

    public function saveTeam (Request $request)
    {

        $this->validateRequest($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'secteur' => ['required', 'string', 'max:255'],
        ]);

        $team = new Team;
        $team->fill($request->only(['name', 'secteur']));
        $team->access = false;
        $team->user_id = Auth::id();
        $team->save();

        return response()->json(['team_id' => $team->id], 200);
    }

    public function saveMember (Request $request)
    {

        $this->validateRequest($request->all(), [
            'team_id' => ['required', 'integer'],
            "members"    => ["required" , "array"],
            "members.*"  => ["required", "email", "distinct"],
        ]);

        foreach ($request->members as $member)
        {
            $new = new MemberTeam;
            $new->fill(['team_id' => $request->team_id, 'email' => $member]);
            $new->save();
        }

        return response()->json([], 204);
    }
}
