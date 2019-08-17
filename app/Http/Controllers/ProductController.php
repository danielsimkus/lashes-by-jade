<?php

namespace App\Http\Controllers;

use App\Appointment;
use App\User;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    protected $validationRules = [
        'name' => 'required|max:75',
        'description' => 'required|max:255'
    ];
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
        $this->authorize('create', Appointment::class);
        $params = $request->validate($this->validationRules);

         $params['user_id'] = auth()->user()->id;
        return redirect(tap(new Appointment($params))->save()->path());
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Appointment  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Appointment $product)
    {
        return view('product.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Appointment  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Appointment $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Appointment  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Appointment $product)
    {
        $this->authorize('update', $product);
        $product->update($request->validate($this->validationRules));
        return redirect($product->path());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Appointment  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Appointment $product)
    {
        //
    }
}
