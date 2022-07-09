<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\User;
use App\Models\Page;
use App\Models\Department;
use Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user()->load(["pagesAccess"]);
         $users = User::with(['pagesAccess','landing'])->get();
        return view('users.index')->with([
            'menu' => 'users',
            'users' => $users,
            'user' => $user
        ]);
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
    public function edit($id)
    {
        $user = Auth::user()->load(["pagesAccess"]);
        $edit = User::with('pagesAccess')->whereId($id)->first();
        $pages = Page::all();
        $departments = Department::all();
        $access = array();
        foreach ($edit->pagesAccess as $page) {
            array_push($access, $page->id);
        }

        return view('users.edit')->with([
            'menu' => 'users',
            'edit' => $edit,
            'access' => $access,
            'user' => $user,
            'pages' => $pages,
            'departments' => $departments,
        ]);
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
        $rule = [
            "password" => "nullable|confirmed",
            "access" => "required|array",
            "first_name" => "required|string",
            "last_name" => "required|string",
            "username" => "required|string|unique:users,username,".$id,
            "landing_page" => "required|numeric",
            
            "phone" => "nullable|string",
            "email" => "nullable|email|unique:users,email,".$id,
            "emp_id" => "nullable|string",
            "mailing_address" => "nullable|string",
            "affiliated_to" => "nullable|in:vinyl-pro,agency,vinyl-pro office",
            "department" => "nullable|numeric|exists:departments,id",
        ];
        $validator = Validator::make($request->all(), $rule);
        if ($validator->fails())
            return back()->withErrors($validator)->withInput()->with('error_message', $validator->errors()->first());
        $user = User::find($id);

        if(!empty($request->password)){
            if($request->password != $request->password_confirmation){
                return back()->withErrors()->withInput()->with('error_message', 'Password confirmation filed is required.');
            }
            $user->password = Hash::make($request->password);
        }

        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->username = $request->username;
        $user->landing_page = $request->landing_page;

        if($request->has("phone") && !empty($request->phone) ){
            $user->phone = $request->phone;
        }
        if($request->has("email") && !empty($request->email)){
            $user->email = $request->email;
        }
        if($request->has("emp_id") && !empty($request->emp_id) ){
            $user->emp_id = $request->emp_id;
        }
        if($request->has("mailing_address") && !empty($request->mailing_address)){
            $user->mailing_address = $request->mailing_address;
        }
        if($request->has("affiliated_to") && !empty($request->affiliated_to) ){
            $user->affiliated_to = $request->affiliated_to;
        }
        if($request->has("department") && !empty($request->department)){
            $user->department_id = $request->department;
        }
        $user->save();

        $user->pagesAccess()->sync($request->access);
        $request->session()->flash("info_message","User has been Edited successfully.");
        return redirect()->route('user.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        User::find($id)->delete();
        return redirect()->back();
    }
}
