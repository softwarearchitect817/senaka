<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Rules\RackNumber;
use App\Models\Stock;

class LocationInformationController extends Controller
{
    public function index()
    {
        return view("location_information.index")->with([
            "users" =>[],
            "menu" => "location_information"
        ]);
    }

    public function getLocationInformation(Request $request)
    {
        $rule = [
            'rack_number' => ['required', new RackNumber]
        ];
        $validator = Validator::make($request->all(), $rule);
        if ($validator->fails()) {
            return response([
                'status' => 0,
                'message' => 'Invalid Rack Number'
            ]);
        }

        $items = Stock::where('rack_number',$request->rack_number)
        ->get();

        if(!count($items)){
            return response([
                'status' => 0,
                'message' => 'There is no information available for this Rack/Gate Number.'
            ]);
        }

        return response([
            'status' => 1,
            'message' => 'Information available for this Rack/Gate Number.',
            'items' => $items
        ]);


    }
}
