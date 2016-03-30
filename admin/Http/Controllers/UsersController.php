<?php

namespace Admin\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Admin\Contracts\OwnerInterface;
use Admin\Contracts\CityInterface;
use Admin\Contracts\RegionInterface;
use Admin\Contracts\UsStateInterface;
use Admin\Contracts\CountryInterface;
use Admin\Http\Requests\OwnerRequest;
use Admin\Http\Requests\UserRequest;
use Admin\Contracts\UserInterface;



class UsersController extends Controller
{
    /**
     * Create a new home controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, OwnerInterface $ownerService, UserInterface $userService)
    {
        //dd('asdefewrtfresd');
       /* if(auth()->user()->isSuperAdmin()) {
            return redirect('/reports');
        }
        else {
            dd('asd');
            return redirect('/staffs');
        }*/
        //dd(  );
        return view('admin.users.index');
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
    public function store(UserRequest $request, UserInterface $userService)
    {
        if(null != $userService->createUser($request->all())) {
            dd($userService->createUser($request->all()));
            //return
        }
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
     * @param  \Illuminate\Http\OwnerRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($id)
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
