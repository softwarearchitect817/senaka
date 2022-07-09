<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Capacity;
use App\Rules\RackNumber;
use Illuminate\Support\Facades\Validator;

class CapacityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('capacity.add')->with([
            "menu" => "capacity"
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rule = [
            'rack_number' => ['required', new RackNumber],
            'capacity' => 'required|in:0,25,50,75,100',
        ];
        $validator = Validator::make($request->all(), $rule);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput()->with('error_message', 'Make sure all validation rule');
        }
         Capacity::updateOrCreate(
             ["rack_number" => $request->rack_number],
             [ "capacity" => $request->capacity]
            );

        $request->session()->flash("info_message","Capacity has been added/Updated successfully.");
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function getCurrentCapacity(Request $request) {

        $rule = [
            'rack_number' => ['required', new RackNumber]
        ];
        $validator = Validator::make($request->all(), $rule);
        if ($validator->fails()) {
            return response([
                'status' => 201,
                'message' => 'Invalid rack number'
            ]);
        }
        $data = Capacity::where('rack_number',$request->rack_number)->first();

        if($data){
            return response([
                'status' => 200,
                'message' => 'Capacity Available',
                'capacity' => $data->capacity,
            ]);
        }

        return response([
            'status' => 203,
            'message' => 'Capacity Not Available'
        ]);
    }
}
