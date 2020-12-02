<?php

namespace App\Http\Controllers;

use App\Models\Boards;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
}
