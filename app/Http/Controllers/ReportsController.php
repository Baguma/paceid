<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportsController extends Controller
{

    function view(){

        return view('pages.support_team.reports.view');
    }

    function anaylsisdata(){
        $resultdetails = array();

        $beneficiaries = DB::table('users as u')
            ->select('u.name as name', 'u.dob as dob', 'u.gender as gender', 'u.phone as phone', 'ms.name as marital_status',
                'o.name as occupation', 'el.name as educationlevels', 'd.name as districtresidence', 'sc.name as subcountyresidence',
                'p.name as parishresidence', 'v.name as villageresidence', 'dh.name as districthome', 'sch.name as subcountyhome',
                'ph.name as parishhome', 'vh.name as villagehome')
            ->leftJoin('student_records as sr', 'sr.user_id', '=', 'u.id')
            ->leftJoin('marital_statuses as ms', 'sr.marital_status', '=', 'ms.id')
            ->leftJoin('occupations as o', 'sr.occupation', '=', 'o.id')
            ->leftJoin('education_levels as el', 'sr.education_level', '=', 'el.id')
            ->leftJoin('districts as d', 'sr.district_residence', '=', 'd.id')
            ->leftJoin('sub_counties as sc', 'sr.subcounty_residence', '=', 'sc.id')
            ->leftJoin('parishes as p', 'sr.parish_residence', '=', 'p.id')
            ->leftJoin('villages as v', 'sr.village_residence', '=', 'v.id')

            ->leftJoin('districts as dh', 'sr.district_home', '=', 'dh.id')
            ->leftJoin('sub_counties as sch', 'sr.subcounty_home', '=', 'sch.id')
            ->leftJoin('parishes as ph', 'sr.parish_home', '=', 'ph.id')
            ->leftJoin('villages as vh', 'sr.village_home', '=', 'vh.id')

            ->where('u.user_type', '=', 'student')
            ->get();
        foreach ($beneficiaries as $key => $beneficiary){
            $resultdetails[$key]['Beneficiary Name'] = $beneficiary->name;
            $resultdetails[$key]['Date of Birth'] = $beneficiary->dob;
            $resultdetails[$key]['Age'] = $beneficiary->name;
            $resultdetails[$key]['Gender'] = $beneficiary->gender;
            $resultdetails[$key]['Phone'] = $beneficiary->phone;

            $resultdetails[$key]['Marital Status'] = $beneficiary->marital_status;
            $resultdetails[$key]['Occupation'] = $beneficiary->occupation;
            $resultdetails[$key]['Education Levels'] = $beneficiary->educationlevels;

            $resultdetails[$key]['District of Residence'] = $beneficiary->districtresidence;
            $resultdetails[$key]['Sub-County of Residence'] = $beneficiary->subcountyresidence;
            $resultdetails[$key]['Parish of Residence'] = $beneficiary->parishresidence;
            $resultdetails[$key]['Village of Residence'] = $beneficiary->villageresidence;

            $resultdetails[$key]['District of Origin'] = $beneficiary->districthome;
            $resultdetails[$key]['Sub-County of Origin'] = $beneficiary->subcountyhome;
            $resultdetails[$key]['Parish of Origin'] = $beneficiary->parishhome;
            $resultdetails[$key]['Village of Origin'] = $beneficiary->villagehome;
            $key++;
        }

        return json_encode($resultdetails);
    }
}
