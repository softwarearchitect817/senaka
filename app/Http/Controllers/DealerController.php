<?php

namespace App\Http\Controllers;

use App\Http\Requests\Covid19DataAddForm;
use App\Http\Requests\GetCovidData;
use App\Models\Covid19Data;
use App\Models\DealerInfo;
use App\Models\CustomerOrderReceive;
use App\Models\WorkOrder;
use App\Models\Page;
use App\Models\OrderSummary;
use App\Models\WindowShipping;
use App\Models\GlassReport;
use App\Models\FramesCutting;
use App\Models\WindowsAssembly;
use App\Models\Stock;
use App\User;
use Illuminate\Http\Request;

use App\Exports\UserExport;
use Maatwebsite\Excel\Facades\Excel;

use App\Models\Department;

class DealerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dealer_name = WorkOrder::groupBy('DEALER')->pluck('DEALER');
        $page = Page::pluck('page');
        $departments = Department::all();
        return view('dealer.index')->with([
            'menu' => 'dealer_registration',
            'departments' => $departments,
            'dealer_name' => $dealer_name,
            'page' => $page
        ]);
    }

    public function postDealerRegister(Request $request)
    {
        $dealerInfo = new DealerInfo();
        $dealerInfo['dealer_name'] = $request['dealer_name'];
        $dealerInfo['dealer_address'] = $request['dealer_address'];
        $dealerInfo['company_phone'] = $request['company_phone'];
        $dealerInfo['cell_phone'] = $request['cell_phone'];
        $dealerInfo['dealer_email'] = $request['dealer_email'];
        $dealerInfo['dealer_username'] = $request['dealer_username'];
        $dealerInfo['dealer_password'] = $request['dealer_password'];
        $dealerInfo['landing_page'] = $request['landing_page'];
        $dealerInfo['page_access'] = $request['page_access'];

        $date = explode("/", $request['show_record_date']);
        $dealerInfo['show_record_date'] = $date[2].$date[0].$date[1];
        $dealerInfo->save();    
        
        return back()->with('info_message', 'Successfully saved');
    }

    public function dealer_login()
    {
        $departments = Department::all();
        return view('dealer.login')->with([
            'menu' => 'dealer',
            'departments' => $departments,
        ]);
    }

    public function postDealerLogin(Request $request)
    {
        $user = DealerInfo::where('dealer_username', '=', $request['username'])->first();
        if ($user === null) {
            return back()->with('error_message', 'Dealer user not exist');
        }
        if ($user->dealer_password !== $request['password']) {
            return back()->with('error_message', 'Dealer user password not correct');
        }
        $dealer_info['dealer_name'] = $user->dealer_name;
        $dealer_info['show_record_date'] = $user->show_record_date;
        $departments = Department::all();
        return redirect()->route('dealer.info', [
            'menu' => 'dealer_info',
            'departments' => json_encode($departments),
            'dealer' => json_encode($dealer_info)
        ]);
    }

    public function dealer_info(Request $request)
    {
        $dealer = json_decode($request['dealer']);
        $dealer_infos = OrderSummary::where('COMPANY', '=', $dealer->dealer_name)->where('ORDER DATE', '>=', $dealer->show_record_date)->paginate(10);
        // dd($dealer_infos);

        foreach ($dealer_infos as $row){
            $row['processing'] = false;
            $windowshipping = WindowShipping::where('Order', '=', $row['ORDER#'])->first();
            if ($windowshipping === null) {
                $row['processing'] = true;
            }
            else {
                $row['batch_number'] = $windowshipping['Reference'];
            }
        }

        foreach ($dealer_infos as $row){
            $row['in_production'] = true;
            $glassreport = GlassReport::where('order', '=', $row['ORDER#'])->first();
            $framescutting =  FramesCutting::where('J', '=', $row['ORDER#'])->first();
            if ($glassreport === null && $framescutting === null) {
                $row['in_production'] = false;
            }
        }

        foreach ($dealer_infos as $row){
            $row['assemble_start'] = true;
            $windowsassembly = WindowsAssembly::where('Line_number', 'like', $row['ORDER#'].'-%')->first();
            if ($windowsassembly === null) {
                $row['assemble_start'] = false;
            }
        }

        foreach ($dealer_infos as $row){
            $qty = WorkOrder::where('ORDER #', '=', $row['ORDER#'])->get();
            $total_qty = 0;
            foreach ($qty as $qty_row){
                $total_qty += $qty_row['QTY'];
            }
            $row['total_qty'] = $total_qty;
        }

        foreach ($dealer_infos as $row){
            $count = Stock::where('item_number', 'like', $row['ORDER#'].'-%')->count();
            $row['ready_qty'] = $count;
        }

        foreach ($dealer_infos as $row){
            $count = WorkOrder::where('ORDER #', '=', $row['ORDER#'])->count();
            $su_count = WorkOrder::where('ORDER #', '=', $row['ORDER#'])->where('WINDOW DESCRIPTION', '=', 'SU#')->where('WINDOW DESCRIPTION', '=', 'SUSHP#')->count();
            $row['windows_total'] = $count;
            $row['SU'] = $su_count;
        }

        $dealer_infos_shipped = OrderSummary::where('COMPANY', '=', $dealer->dealer_name)->where('ORDER DATE', '>=', $dealer->show_record_date)->pluck('ORDER#');
        $shipped = WindowShipping::whereIn('Order', $dealer_infos_shipped)->select('Order')->distinct()->get();

        $departments = Department::all();
        return view('dealer.dealer_info')->with([
            'menu' => 'dealer_info',
            'departments' => $departments,
            'dealer' => $dealer->dealer_name,
            'dealer_infos' => $dealer_infos,
            'shipped' => $shipped
        ]);
    }

    public function postReceiveOrder(Request $request)
    {
        $receiveOrder = new CustomerOrderReceive();
        $receiveOrder['item_number'] = $request['data_input'];
        $receiveOrder['location'] = $request['location'];
        $receiveOrder['name'] = $request['name'];
        $receiveOrder['date'] = date('Y-m-d');
        $receiveOrder['time'] = date('H:i:s');
        $receiveOrder->save();    
        
        return back()->with([
            'info_message' => 'Successfully saved',
            'location' => $request['location'],
            'name' => $request['name']
        ]);
    }

    // private function getPercentage($arr)
    // {

    //     // $sum = array_sum($arr);
    //     // if($sum == 0){
    //     //     return $arr;
    //     // } 
    //     // foreach ($arr as $key => $value) {
    //     //     $arr[$key] = ($value/$sum) * 100;
    //     // }
    //     return $arr;
    // }

    // public function getData(GetCovidData $request)
    // {
    //     $date = ($request->date);

    //     $agency = [
    //         "category" => "Agency",
    //         "sign_in" => Covid19Data::whereDate('created_at', $date)->whereHas('user', function ($query) {
    //             $query->where('affiliated_to', 'agency');
    //         })->groupBy('user_id')->get()->count(),
    //         "registered" => User::where('affiliated_to', 'agency')->count(),
    //     ];
    //     $vinyl_pro = [
    //         "category" => "Vinyl-pro",
    //         "sign_in" => Covid19Data::whereDate('created_at', $date)->whereHas('user', function ($query) {
    //             $query->where('affiliated_to', 'vinyl-pro');
    //         })->groupBy('user_id')->get()->count(),
    //         "registered" => User::where('affiliated_to', 'vinyl-pro')->count(),
    //     ];
    //     $vinyl_pro_office = [
    //         "category" => "Vinyl-pro Office",
    //         "sign_in" => Covid19Data::whereDate('created_at', $date)->whereHas('user', function ($query) {
    //             $query->where('affiliated_to', 'vinyl-pro office');
    //         })->groupBy('user_id')->get()->count(),
    //         "registered" => User::where('affiliated_to', 'vinyl-pro office')->count(),
    //     ];


    //     $data = [
    //         "pie_chart_data" => $this->getPercentage([
    //             $agency["sign_in"],
    //             $vinyl_pro["sign_in"],
    //             $vinyl_pro_office["sign_in"]
    //         ]),
    //         "total_employees" => [
    //             $agency,
    //             $vinyl_pro,
    //             $vinyl_pro_office,
    //             [
    //                 "category" => "Production", // agency + vinyl-pro
    //                 "sign_in" => $agency["sign_in"] +  $vinyl_pro["sign_in"],
    //                 "registered" => $agency["registered"] +  $vinyl_pro["registered"],
    //             ],
    //         ],
    //         "users" => User::with(['covid_form_submission' => function ($query) use($date){
    //             $query->whereDate('created_at', $date);
    //         }])->get()
    //     ];

    //     return response()->json([
    //         "success" => true,
    //         "message" => "Success",
    //         "data" => $data,
    //     ], 200);
    // }

    // public function export(Request $request) 
    // {
    //     $date = $request->date;
    //     $category = $request->category;
    //     $department = $request->department;
    //     return Excel::download(new UserExport( $date, $category, $department ),  $date . '.xlsx');
    // }

    // /**
    //  * Show the form for creating a new resource.
    //  *
    //  * @return \Illuminate\Http\Response
    //  */
    // public function create()
    // {
    //     return view("covid-19-data.add")->with([
    //         "menu" => "covid_19_questions",
    //     ]);
    // }

    // /**
    //  * Store a newly created resource in storage.
    //  *
    //  * @param  \Illuminate\Http\Request  $request
    //  * @return \Illuminate\Http\Response
    //  */
    // public function store(Covid19DataAddForm $request)
    // {
    //     Covid19Data::create($request->getData());
    //     $request->session()->flash("info_message", "Data has been saved successfully.");
    //     return redirect()->back();
    // }

    // /**
    //  * Display the specified resource.
    //  *
    //  * @param  int  $id
    //  * @return \Illuminate\Http\Response
    //  */
    // public function show($id)
    // {
    //     //
    // }

    // /**
    //  * Show the form for editing the specified resource.
    //  *
    //  * @param  int  $id
    //  * @return \Illuminate\Http\Response
    //  */
    // public function edit($id)
    // {
    //     //
    // }

    // /**
    //  * Update the specified resource in storage.
    //  *
    //  * @param  \Illuminate\Http\Request  $request
    //  * @param  int  $id
    //  * @return \Illuminate\Http\Response
    //  */
    // public function update(Request $request, $id)
    // {
    //     //
    // }

    // /**
    //  * Remove the specified resource from storage.
    //  *
    //  * @param  int  $id
    //  * @return \Illuminate\Http\Response
    //  */
    // public function destroy($id)
    // {
    //     //
    // }
  
}
