<?php

namespace App\Http\Controllers;

use App\Models\Invitations;
use App\Models\MemberTeam;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MemberController extends Controller
{
    private function save (Request $request)
    {

//         Todo remove required rule
        $this->validateRequest($request->all(), [
            'team_id' => ['required', 'integer'],
            "members"    => ['required', "array"],
            "members.*"  => ['required', "email", "distinct"],
        ]);

        $user = new MemberTeam;
        $user->fill(['team_id' => $request->team_id, 'user_email' => Auth::user()->email, 'admin' => true]);
        $user->save();

        foreach ($request->members as $member)
        {
            $ifExistUser = User::where('email', $member)->get();
            if (count($ifExistUser) > 0)
            {
                $new = new MemberTeam;
                $new->fill([
                        'team_id' => $request->team_id,
                        'user_email' => $member]
                );
                $new->save();
            }
            else
            {
                $new = new Invitations;
                $new->fill([
                    'team_id' => $request->team_id,
                    'user_id' => Auth::id(),
                    'to_email' => $member,
                ]);
                $new->save();
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
