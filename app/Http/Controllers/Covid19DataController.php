<?php

namespace App\Http\Controllers;

use App\Http\Requests\Covid19DataAddForm;
use App\Http\Requests\GetCovidData;
use App\Models\Covid19Data;
use App\User;
use Illuminate\Http\Request;

use App\Exports\UserExport;
use Maatwebsite\Excel\Facades\Excel;

use App\Models\Department;

class Covid19DataController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $departments = Department::all();
        return view('covid-19-data.index')->with([
            'menu' => 'covid_19_data',
            'departments' => $departments,
        ]);
    }

    private function getPercentage($arr)
    {

        // $sum = array_sum($arr);
        // if($sum == 0){
        //     return $arr;
        // } 
        // foreach ($arr as $key => $value) {
        //     $arr[$key] = ($value/$sum) * 100;
        // }
        return $arr;
    }

    public function getData(GetCovidData $request)
    {
        $date = ($request->date);

        $agency = [
            "category" => "Agency",
            "sign_in" => Covid19Data::whereDate('created_at', $date)->whereHas('user', function ($query) {
                $query->where('affiliated_to', 'agency');
            })->groupBy('user_id')->get()->count(),
            "registered" => User::where('affiliated_to', 'agency')->count(),
        ];
        $vinyl_pro = [
            "category" => "Vinyl-pro",
            "sign_in" => Covid19Data::whereDate('created_at', $date)->whereHas('user', function ($query) {
                $query->where('affiliated_to', 'vinyl-pro');
            })->groupBy('user_id')->get()->count(),
            "registered" => User::where('affiliated_to', 'vinyl-pro')->count(),
        ];
        $vinyl_pro_office = [
            "category" => "Vinyl-pro Office",
            "sign_in" => Covid19Data::whereDate('created_at', $date)->whereHas('user', function ($query) {
                $query->where('affiliated_to', 'vinyl-pro office');
            })->groupBy('user_id')->get()->count(),
            "registered" => User::where('affiliated_to', 'vinyl-pro office')->count(),
        ];


        $data = [
            "pie_chart_data" => $this->getPercentage([
                $agency["sign_in"],
                $vinyl_pro["sign_in"],
                $vinyl_pro_office["sign_in"]
            ]),
            "total_employees" => [
                $agency,
                $vinyl_pro,
                $vinyl_pro_office,
                [
                    "category" => "Production", // agency + vinyl-pro
                    "sign_in" => $agency["sign_in"] +  $vinyl_pro["sign_in"],
                    "registered" => $agency["registered"] +  $vinyl_pro["registered"],
                ],
            ],
            "users" => User::with(['covid_form_submission' => function ($query) use($date){
                $query->whereDate('created_at', $date);
            }])->get()
        ];

        return response()->json([
            "success" => true,
            "message" => "Success",
            "data" => $data,
        ], 200);
    }

    public function export(Request $request) 
    {
        $date = $request->date;
        $category = $request->category;
        $department = $request->department;
        return Excel::download(new UserExport( $date, $category, $department ),  $date . '.xlsx');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("covid-19-data.add")->with([
            "menu" => "covid_19_questions",
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Covid19DataAddForm $request)
    {
        Covid19Data::create($request->getData());
        $request->session()->flash("info_message", "Data has been saved successfully.");
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

  

    
}
