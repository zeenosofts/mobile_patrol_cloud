<?php

namespace App\Http\Controllers;

use App\Http\Traits\FormTrait;
use App\Http\Traits\ResponseTrait;
use App\Models\Client;
use Illuminate\Http\Request;

class FormController extends Controller
{
    use FormTrait,ResponseTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $clients=Client::all();
        return view('manager.form.index')->with('title','Create form');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function save_form(Request $request)
    {
    try{
        $form_element_array = array();
        for ($i=0;$i<count($request->form_element);$i++){
            $decode_data=json_decode($request->form_element[$i]);
            array_push($form_element_array,$decode_data);
        }
        this

        return $this->returnApiResponse(200, 'success', array('response' => 'Shifts Created Successfully'));
            }catch (\Exception $e){
    return $this->returnApiResponse(404, 'error', array());
    }


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
