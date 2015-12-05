<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Apartment;
use App\User;
use Auth;
use Parsedown;

class ApartmentController extends Controller
{
    protected $parsedown;

    /**
     * Class constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->parsedown = new Parsedown();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = Auth::user();

        $apartments = $user->apartments->toArray();

        if ($request->ajax()) {

            $apartments = array_map(function($a){
                $a['notes'] = $this->parsedown->text($a['notes']);
                return $a;
            }, $apartments);

            return $apartments;
        }

        return view('apartments/index', compact('apartments'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('apartments/create');
    }

    /**
     * Display the specified resource.
     *
     * @param  Apartment  $apartment
     * @return \Illuminate\Http\Response
     */
    public function show(Apartment $apartment)
    {
        return view('apartments/show', compact('apartment'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Apartment  $apartment
     * @return \Illuminate\Http\Response
     */
    public function edit(Apartment $apartment)
    {
        return view('apartments/edit', compact('apartment'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->formValidate($request);

        $apartment = Auth::user()->apartments()->create($request->all());

        if ($request->ajax()) {
            return $apartment;
        }

        return redirect()->action('ApartmentController@index');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Apartment $apartment)
    {
        $this->formValidate($request);

        $apartment->update($request->all());

        if ($request->ajax()) {
            return $apartment;
        }

        return redirect()->action('ApartmentController@index');
    }

    /**
     * Update the apartment sort order.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updateOrder(Request $request)
    {
        $apartments = [];
        foreach ($request->all() as $value) {
            $id = (isset($value['id'])) ? $value['id'] : '';
            $order = (isset($value['order'])) ? $value['order'] : '';

            if ('' === $id or '' === $order) {
                return [];
            }

            $apartment = Apartment::findOrFail($id);
            $apartment->order = $order;
            $apartment->save();

            $apartments[] = $apartment;
        }

        return $apartments;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Apartment $apartment
     * @param  Request $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Apartment $apartment, Request $request)
    {
        $destroy = $apartment->destroy($apartment->id);

        if ($request->ajax()) {
            return $destroy;
        }

        return redirect()->action('ApartmentController@index');
    }

    /**
     * Handle form validation.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return  Boolean True if successful.
     */
    protected function formValidate(Request $request)
    {
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
