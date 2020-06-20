<?php

namespace App\Http\Controllers;

use App\UrlModel;
use Illuminate\Http\Request;
use Validator;

class UrlController extends Controller
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function user_store(Request $request)
    {   

        $messages = array(
            'required'  => ':attribute Tidak boleh kosong sahabat!',
            'judul.min' => 'Panjang data minimal untuk <b>:attribute</b> Form adalah 5',
            'judul.max' => 'Panjang data maximum untuk <b>:attribute</b> Form adalah 25',
            'link.min'  => 'Panjang data minimal untuk <b>:attribute</b> Form adalah 7'
        );

        $rules = array(
            'judul' => 'required|min:5|max:25',
            'link'  => 'required|min:7',
            'desc'  => 'required|max:100',
            'is_public' => 'required'
        );


        $valid = Validator::make($request->post(), $rules, $messages);
        if($valid->fails()){
            $msg = $valid->errors()->first();
            return redirect()->route('user_add_link')->with('error', $msg);
        }else{
        
            $url = $request->link;
            if (filter_var($url, FILTER_VALIDATE_URL)){ //validate url input

                //if valid
                

            }else{

                //if not valid

            }

        }
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\UrlModel  $urlModel
     * @return \Illuminate\Http\Response
     */
    public function show(UrlModel $urlModel)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\UrlModel  $urlModel
     * @return \Illuminate\Http\Response
     */
    public function edit(UrlModel $urlModel)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\UrlModel  $urlModel
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, UrlModel $urlModel)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\UrlModel  $urlModel
     * @return \Illuminate\Http\Response
     */
    public function destroy(UrlModel $urlModel)
    {
        //
    }
}
