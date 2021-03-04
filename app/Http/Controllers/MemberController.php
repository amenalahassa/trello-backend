<?php

namespace App\Http\Controllers;

use App\Models\Team;
use App\Models\User;
use App\Models\Notifications;
use App\Notifications\AddMemberNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MemberController extends Controller
{

// Todo use this to insert or remove user after updating a team by admin https://laravel.com/docs/8.x/eloquent-relationships#toggling-associations
// Todo use FirstOrCreate when no admin user add a new member to a team

    private function save (Request $request)
    {

//         Todo remove required rule
        $this->validateRequest($request->all(), [
            'team_id' => ['required', 'integer'],
            "members"    => ['required', "array"],
            "members.*"  => ['required', "email", "distinct"],
        ]);

        $team = Team::find($request->team_id);

        $team->user()->attach(Auth::id(), ['user_email' => Auth::user()->email, 'admin' => true]);

        foreach ($request->members as $member)
        {
            $ifExistUser = User::where('email', $member)->get();
            if (count($ifExistUser) > 0)
            {
//                $team->user()->attach($ifExistUser[0]->id, ['user_email' => $member]);
                $ifExistUser[0]->notify(new AddMemberNotification(Notifications::create([
                    'type' => 'invitation_team',
                    'for' => $team->id,
                    'to' => $ifExistUser[0]->id,
                    'from'=> Auth::id(),
                    'content' => Auth::user()->name . " invite you to join " . $team->name . " team",
                ])));
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

    public function saveFirstMembersOfFirstTeam(Request $request)
    {
        $this->save($request);
        return response()->json([], 204);
    }

    public function saveMembersOfOthersTeams(Request $request)
    {
        $this->save($request);
        return redirect()->route('dashboard.show');
    }


}
