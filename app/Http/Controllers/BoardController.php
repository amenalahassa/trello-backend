<?php

namespace App\Http\Controllers;

use App\Http\Requests\GetBoardRequest;
use App\Models\Boards;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\Boards as BoardRessource;

class BoardController extends Controller
{
    public function save(Request $request)
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
        return redirect()->route('dashboard.show');
    }

    public function updateName (Request $request)
    {
        $this->validateRequest($request->all(), [
            'id' => ['required', 'integer'],
            'name' => ['required', 'string', 'max:255'],
        ]);

        $board = Boards::find($request->id);
        $board->name = $request->name;
        $board->save();

        return redirect()->route('dashboard.show');
    }

    public function view (GetBoardRequest $request)
    {
        $board = new BoardRessource(Boards::findOrFail($request->id));
        return response()->json(['board'=> $board], 200);
    }

    public function updateOwner (Request $request)
    {
        $this->validateRequest($request->all(), [
            "owner"    => ["required" , "integer"],
            "id"    => ["required" , "integer"],
        ]);

        $board = Boards::find($request->id);
        $board->ownable_type = "App\Models\Team";
        $board->ownable_id = $request->owner;
        $board->save();

        return redirect()->route('dashboard.show');

    }
}
