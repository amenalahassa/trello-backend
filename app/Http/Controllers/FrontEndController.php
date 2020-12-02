<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FrontEndController extends Controller
{
    public  function  getAllCategoryList()
    {
        return response()->json(array_map('getObjectFromArray', array_keys(\App\Models\Team::Category) ,  array_values(\App\Models\Team::Category)), 200);
    }
}
