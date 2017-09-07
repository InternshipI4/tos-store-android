<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Illuminate\Http\Response;
use Illuminate\Routing\UrlGenerator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return json_encode(url('/'));
    }

    public function getUsers(){
        $data = DB::select("select * from users");
        return json_encode($data);
    }

    public function login(Request $request){
        $phone_number = $request->input('phone');
        $password = $request->input('password');
        $data = DB::select("select * from users where phone=$phone_number and password=$password");
        if ($data != null)
            $status = true;
        else
            $status = false;
        return json_encode(array('status'=>$status));
    }

    public function signup(Request $request){
        $name = $request->input('name');
        $phone_number = $request->input('phone');
        $password = $request->input('password');
        if (DB::table('users')->insert([
            'name' => $name,
            'phone' => $phone_number,
            'password' => $password,
            ])){
            return json_encode(array('status'=>true));
        } else{
            return json_encode(array('status'=>false));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
class Status {
    private $status;
    private $msg;

    /**
     * status constructor.
     * @param $status
     * @param $msg
     */
    public function __construct($status, $msg)
    {
        $this->status = $status;
        $this->msg = $msg;
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @return mixed
     */
    public function getMsg()
    {
        return $this->msg;
    }

}
