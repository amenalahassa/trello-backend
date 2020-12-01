<?php

namespace App\Http\Controllers;

use App\Models\Boards;
use App\Models\Invitations;
use App\Models\MemberTeam;
use App\Models\Team;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Unsplash\HttpClient  as UnsplashClient;
use Unsplash\Photo  as UnsplashPhoto;

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

        return response()->json([], 204);
    }

    public function show(Request $request)
    {
//        Todo : Add invitation people in the team member count field

        $user = Auth::user();
        return response()->json([
            'user' => collect($user)->except(['created_at', 'email_verified_at', 'updated_at']),
            'board_background' => $this->initUnsplach(),
        ], 200);
    }

    public function saveBoard(Request $request)
    {
        $this->validateRequest($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'backgroundImage' => ['required', 'string'],
            "owner"    => ["required" , "integer"],
        ]);

        if ($request->owner === 0)
        {
            $ownable_type = "App\Models\User";
            $ownable_id = Auth::id();
        }
        else
        {
            $ownable_type = "App\Models\Team";
            $ownable_id = $request->owner;
        }

        $board = new Boards;
        $board->fill([
            'name' => $request->name,
            'image' => $request->backgroundImage,
            'ownable_type' => $ownable_type,
            'ownable_id' => $ownable_id,
        ]);
        $board->save();
        return redirect()->route('about.dashboard');
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
