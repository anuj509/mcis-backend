<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Manufacturer;
use App\MModel;
use Validator;
use Illuminate\Support\Facades\Input;

class ModelController extends Controller
{
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
        $rules = array(
            'name'               => 'required',
            'manufacturer'       => 'required',
            'color'              => 'required',
            'year'               => 'required',
            'registration_number'=> 'required',
            'note'               => 'required',
            'count'              => 'required',
            'image1'             => 'required',
            'image2'             => 'required'
        );
        $validator = Validator::make(Input::all(), $rules);
        if ($validator->fails()) {
            $errors = $validator->errors();
            return Response()->json(["status"=>"error","message"=>$errors->toJson()]);//"Please provide all required fields"
        } else {
            if($request->hasfile('image1') && $request->hasfile('image2') ) 
            {
            //    return Response()->json(["status"=>"error","message"=>'has images']); 
            $file_image1 = $request->file('image1');
            $file_image2 = $request->file('image2');
            $extension_image1 = $file_image1->getClientOriginalExtension(); // getting image extension
            $extension_image2 = $file_image2->getClientOriginalExtension(); // getting image extension            
            $filename_image1 =time().'.'.$extension_image1;
            $filename_image2 =time().'.'.$extension_image2;            
            $file_image1->move('uploads/', $filename_image1);
            $file_image2->move('uploads/', $filename_image2);
            }
            $model = new MModel([
            'name'               => $request->name,
            'manufacturer_id'       => $request->manufacturer,
            'color'              => $request->color,
            'year'               => $request->year,
            'registration_number'=> $request->registration_number,
            'note'               => $request->note,
            'count'              => $request->count,
            'image_url_1'        => 'uploads/'.$filename_image1,
            'image_url_2'        => 'uploads/'.$filename_image2
            ]);
            $model->save();
            return Response()->json(["status"=>"success","message"=>"Model added successfully"]);
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
