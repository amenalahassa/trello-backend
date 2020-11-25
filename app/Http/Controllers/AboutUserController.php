<?php

namespace App\Http\Controllers;

use App\Models\MemberTeam;
use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AboutUserController extends Controller
{

    public function saveTeam (Request $request)
    {

        $this->validateRequest($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'secteur' => ['required', 'string', 'max:255'],
        ]);

        $team = new Team;
        $team->fill($request->only(['name', 'secteur']));
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

        $user = new MemberTeam;
        $user->fill(['team_id' => $request->team_id, 'user_email' => Auth::user()->email, 'admin' => true]);
        $user->save();

//        Todo : Find a solution for members don't have a account

        foreach ($request->members as $member)
        {
            $new = new MemberTeam;
            $new->fill(['team_id' => $request->team_id, 'user_email' => $member]);
            $new->save();
        }

        return response()->json([], 204);
    }

    public function show(Request $request)
    {
        $user = Auth::user();
        return response()->json([
            'user' => collect($user)->except(['created_at', 'email_verified_at', 'updated_at']),
        ], 200);
    }
}
