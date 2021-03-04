<?php

namespace App\Http\Controllers;

use App\Models\MemberTeam;
use App\Models\Notifications;
use App\Models\Team;
use App\Models\User;
use App\Notifications\AddMemberNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TeamController extends Controller
{
    public function save (Request $request)
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

    public function show (Request $request)
    {
        $this->validateRequest($request->all(), [
            'id' => ['required', 'integer'],
        ]);

        $team = Team::with('user', 'invited')->without('boards')->find($request->id);

        return response()->json(['team' => $team], 200);
    }

    public function update(Request $request)
    {

        $this->validateRequest($request->all(), [
            'id' => ['required', 'integer'],
            'name' => ['sometimes', 'required', 'string', 'max:255'],
            'secteur' => ['sometimes', 'required', 'string', 'max:255'],
            "members.*"  => ['sometimes', 'required', "email", "distinct"],
        ]);

        $team = Team::find($request->id);

        if ($request->name !== null)
        {
           $team->name = $request->name;
        }

        if ($request->secteur !== null)
        {
            $team->secteur = $request->secteur;
        }

        if ($request->members !== null)
        {
            foreach ($request->members as $member)
            {
                $ifExistUser = User::where('email', $member)->get();

                if (count($ifExistUser) > 0)
                {
                    $users =  $team->user()->where('email', $member)->get();

                    if (count($users) > 0)
                    {
                        MemberTeam::where('user_email', $users[0]->email)->where('team_id', $team->id)->delete();
                    }
                    else {
//                        $team->user()->attach($ifExistUser[0]->id, ['user_email' => $member]);
                        $ifExistUser[0]->notify(new AddMemberNotification(Notifications::create([
                            'type' => 'invitation_team',
                            'for' => $team->id,
                            'to' => $ifExistUser[0]->id,
                            'from'=> Auth::id(),
                            'content' => Auth::user()->name . " invite you to join " . $team->name . " team",
                        ])));
                    }
                }
                else
                {
                    $invited = $team->invited()->where('to_email', $member)->get();

                    if (count($invited) > 0)
                    {
                       $invited[0]->delete();
                    }
                    else
                    {
                        $team->invited()->create([
                            'user_id' => Auth::id(),
                            'to_email' => $member,
                        ]);
                    }
                }
            }
        }
        $team->save();
        return redirect()->route('dashboard.show');
    }

    public function delete(Request $request)
    {
        $this->validateRequest($request->all(), [
            'id' => ['required', 'integer'],
        ]);

        Team::find($request->id)->delete();

        return redirect()->route('dashboard.show');
    }
}
