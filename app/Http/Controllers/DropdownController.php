<?php

namespace App\Http\Controllers;

use App\Models\DigitalUsage;
use App\Models\FinanceType;
use App\Models\Parish;
use App\Models\RefugeeCamp;
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

    public function findCamps(Request $request){
        $camps = RefugeeCamp::select('id','name')->get();

        return Response::json($camps);
    }

    function findFinanceTypes(Request $request){
        $fintyps = FinanceType::select('id','name')->get();

        return Response::json($fintyps);
    }

    function findDigitalUsages(Request $request){
        $digusage = DigitalUsage::select('id','name')->get();

        return Response::json($digusage);
    }
}
