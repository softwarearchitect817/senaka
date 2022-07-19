<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\User;
use App\Models\DealerInfo;
use App\Models\WorkOrder;
use App\Models\Page;
use App\Models\Department;
use Hash;
use Illuminate\Support\Facades\Validator;

class DealersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user()->load(["pagesAccess"]);
        $dealers = DealerInfo::all();
        return view('dealers.index')->with([
            'menu' => 'dealers',
            'dealers' => $dealers,
            'user' => $user
        ]);
    }

    public function edit($id)
    {
        $user = Auth::user()->load(["pagesAccess"]);
        $edit = DealerInfo::whereId($id)->first();
        $dealer_name = WorkOrder::groupBy('DEALER')->pluck('DEALER');
        $page = Page::pluck('page');
        $pages = Page::all();
        $departments = Department::all();
        $access = array();
        // foreach ($edit->pagesAccess as $page) {
        //     array_push($access, $page->id);
        // }
        // dd($edit);
        return view('dealers.edit')->with([
            'menu' => 'dealers',
            'edit' => $edit,
            'dealer_name' => $dealer_name,
            'page' => $page,
            'access' => $access,
            'user' => $user,
            'pages' => $pages,
            'departments' => $departments,
        ]);
    }

    public function update(Request $request, $id)
    {
        // $rule = [
        //     "password" => "nullable|confirmed",
        //     "access" => "required|array",
        //     "first_name" => "required|string",
        //     "last_name" => "required|string",
        //     "username" => "required|string|unique:users,username,".$id,
        //     "landing_page" => "required|numeric",
            
        //     "phone" => "nullable|string",
        //     "email" => "nullable|email|unique:users,email,".$id,
        //     "emp_id" => "nullable|string",
        //     "mailing_address" => "nullable|string",
        //     "affiliated_to" => "nullable|in:vinyl-pro,agency,vinyl-pro office",
        //     "department" => "nullable|numeric|exists:departments,id",
        // ];
        // $validator = Validator::make($request->all(), $rule);
        // if ($validator->fails())
        //     return back()->withErrors($validator)->withInput()->with('error_message', $validator->errors()->first());
        $dealerInfo = DealerInfo::find($id);

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
        
        $request->session()->flash("info_message", "Dealer information has been Edited successfully.");
        return redirect()->route('dealers.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = Auth::user()->load(["pagesAccess"]);
        $pages = Page::all();
        $departments = Department::all();
        return view('users.add')->with([
            'menu' => 'users',
            'user' => $user,
            'pages' => $pages,
            'departments' => $departments,
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
            "password" => "required|confirmed",
            "access" => "required|array",
            "first_name" => "required|string",
            "last_name" => "required|string",
            "username" => "required|string|unique:users,username",
            "landing_page" => "required|numeric",
            
            "phone" => "nullable|string",
            "email" => "nullable|email|unique:users,email",
            "emp_id" => "nullable|string",
            "mailing_address" => "nullable|string",
            "affiliated_to" => "nullable|in:vinyl-pro,agency,vinyl-pro office",
            "department" => "nullable|numeric|exists:departments,id",

        ];
        $validator = Validator::make($request->all(), $rule);
        if ($validator->fails())
            return back()->withErrors($validator)->withInput()->with('error_message', $validator->errors()->first());
        $user = User::create([
            "first_name" => $request->first_name,
            "last_name" => $request->last_name,
            "username" => $request->username,
            "landing_page" => $request->landing_page,
            "password" => Hash::make($request->password),
            "phone" => $request->has("phone")?$request->phone:NULL,
            "email" => $request->has("email")?$request->email:NULL,
            "emp_id" => $request->has("emp_id")?$request->emp_id:NULL,
            "mailing_address" => $request->has("mailing_address")?$request->mailing_address:NULL,
            "affiliated_to" => $request->has("affiliated_to")?$request->affiliated_to:NULL,
            "department_id" => $request->has("department")?$request->department:NULL,
        ]);

        $user->pagesAccess()->sync($request->access);
        $request->session()->flash("info_message","User has been added successfully.");
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
    

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Dealerinfo::find($id)->delete();
        return redirect()->back();
    }
}
