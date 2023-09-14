<?php

namespace App\Http\Controllers;

use App\Models\Parish;
use App\Models\SubCounty;
use App\Models\Village;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class DropdownController extends Controller
{
    public function findSubcounty(Request $request){
        $subcounty = SubCounty::select('id','name')->where('districts_id', $request->id)->get();

        return Response::json($subcounty);
    }

    public function findParish(Request $request){
        $parish = Parish::select('id','name')->where('sub_counties_id', $request->id)->get();

        return Response::json($parish);
    }

    public function findVillage(Request $request){
        $village = Village::select('id','name')->where('parishes_id', $request->id)->get();

        return Response::json($village);
    }
}