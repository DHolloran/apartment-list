<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Apartment;

class ApartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Apartment::all();
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
        $this->formValidate( $request );
        $apartment = Apartment::create($request->all());
        return $apartment;
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
        $this->formValidate( $request );
        $apartment = Apartment::findOrFail($id)->update($request->all());

        return $id;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return Apartment::destroy($id);
    }

    /**
     * Handles form validation.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return  Boolean True if successful.
     */
    public function formValidate(Request $request) {
        $validation = $this->validate($request, [
            'name'         => 'required',
            'addressLine1' => 'required',
            'city'         => 'required',
            'state'        => 'required',
            'zip'          => 'required',
            'price'        => 'required|numeric',
            'parkingPrice' => 'required|numeric',
            'deposit'      => 'required|numeric',
        ]);

        return true;
    }
}
