<?php

namespace App\Http\Controllers;

use App\UrlModel;
use Illuminate\Http\Request;
use Validator;
use Auth;
use DB;

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
    public function user_store(Request $request){   

        $messages = array(
            'required'  => ':attribute Tidak boleh kosong sahabat!',
            'judul.min' => 'Panjang data minimal untuk <b>:attribute</b> Form adalah 5',
            'judul.max' => 'Panjang data maximum untuk <b>:attribute</b> Form adalah 25',
            'link.min'  => 'Panjang data minimal untuk <b>:attribute</b> Form adalah 7',
            'link.*.min' => 'Panjang setiap form Link harus 7 data'
        );

        $rules = array(
            'judul' => 'required|min:5|max:25',
            'link'  => 'required|array',
            'link.*'  => 'required|min:7',
            'desc'  => 'required|max:100',
        );

        

        $valid = Validator::make($request->post(), $rules, $messages);
        if($valid->fails()){
            $msg = $valid->errors()->first();
            return redirect()->route('user_add_link')->with('error', $msg);
        }else{
            $is_url = True;
            
            foreach($request->link as $uri){

                if (!filter_var($uri, FILTER_VALIDATE_URL)){ //validate url input
                    $is_url = False;
                }

            }

            if($is_url){

                $uid   = Auth::user()->id;
                $judul = $request->judul;
                $link  = json_encode($request->link);
                $desc  = $request->desc;
                $is_public = $request->is_public === 'on' ? 1 : 0;


                $insert = UrlModel::create([
                    'uid' => $uid,
                    'name' => $judul,
                    'desc' => $desc,
                    'url'  => $link,
                    'public' => $is_public
                ]);

                // dd($insert);

                if($insert){

                    return redirect()->route('user_add_link')->with('success', $judul." Berhasil ditambahkan di Database!");

                }else{

                    return redirect()->route('user_add_link')->with('error', $judul." Tidak berhasil ditambahkan, sepertinya ada masalah pada Sistim kami :(");

                }

            }else{

                return redirect()->route('user_add_link')->with('error', 'Salah satu form dideteksi bukan URL valid.<br>Hubungi kami jika ini sebuah kesalahan!');

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

    public function return_url_total(Request $request){
        $uid   = Auth::user()->id;
        $query = "SELECT count(`id`) as `total` FROM `urls` WHERE `uid` = :uid and `deleted_at` IS NULL;";
        $exec  = DB::select($query, ['uid'=>$uid]);
        return view('users.view_link', ['total' => $exec[0]->total]);

    }

    public function return_url_public(Request $request){

        $query = "SELECT (SELECT count(`id`) FROM `users` WHERE `active`= 1) as total_user , (SELECT count(`id`) FROM `urls` WHERE `deleted_at` is NULL and `public` = 1) as total_url";
        $exec = DB::select($query);
        // dd($exec);
        return view('users.pub_view_link', ['data' => $exec[0]]);

    }

    public function get_edit_url(Request $request, $id){
        $uid   = Auth::user()->id;

        //check the uid has the requests 
        $check_has = "SELECT `uid` FROM `urls` WHERE `id` = :id1";

        $check_exec = DB::select($check_has, ['id1' => $id]);

        if(count($check_exec) === 1){
            $uid_url = $check_exec[0]->uid;

            if($uid === $uid_url){
                //sama
                $data  = UrlModel::find($id);
                return view('users.edit_link', ['data' => $data]);
            }else{

                //seems IDOR

            }

        }else{
            dd('Tidak ada');
        }

    }

    public function action_edit_url(Request $request, $id){

        $uid   = Auth::user()->id;
        //check the uid has the requests 
        $check_has = "SELECT `uid` FROM `urls` WHERE `id` = :id1";
        $check_exec = DB::select($check_has, ['id1' => $id]);
        if(count($check_exec) === 1){
            $uid_url = $check_exec[0]->uid;

            if($uid === $uid_url){
                //valid is the asset of user
                
                $messages = array(
                    'required'  => ':attribute Tidak boleh kosong sahabat!',
                    'judul.min' => 'Panjang data minimal untuk <b>:attribute</b> Form adalah 5',
                    'judul.max' => 'Panjang data maximum untuk <b>:attribute</b> Form adalah 25',
                    'link.min'  => 'Panjang data minimal untuk <b>:attribute</b> Form adalah 7',
                    'link.*.min' => 'Panjang setiap form Link harus 7 data'
                );

                $rules = array(
                    'judul' => 'required|min:5|max:25',
                    'link'  => 'required|array',
                    'link.*'  => 'required|min:7',
                    'desc'  => 'required|max:100',
                );

                $valid = Validator::make($request->post(), $rules, $messages);
                if($valid->fails()){
                    $msg = $valid->errors()->first();
                    return redirect()->route('edit_url_get', ['id' => $id])->with('error', $msg);
                }else{
                    $is_url = True;
                    
                    foreach($request->link as $uri){

                        if (!filter_var($uri, FILTER_VALIDATE_URL)){ //validate url input
                            $is_url = False;
                        }

                    }

                    if($is_url){

                        $uid   = Auth::user()->id;
                        $judul = $request->judul;
                        $link  = json_encode($request->link);
                        $desc  = $request->desc;
                        $is_public = $request->is_public === 'on' ? 1 : 0;


                        $insert = UrlModel::where('id', $id)->update([
                            'uid' => $uid,
                            'name' => $judul,
                            'desc' => $desc,
                            'url'  => $link,
                            'public' => $is_public
                        ]);

                        // dd($insert);

                        if($insert){
                            return redirect()->route('edit_url_get', ['id' => $id])->with('success', $judul." Berhasil dirubah di Database!");
                        }else{
                            return redirect()->route('edit_url_get', ['id' => $id])->with('error', $judul." Tidak berhasil dirubah, sepertinya ada masalah pada Sistim kami :(");
                        }
                    }else{
                        return redirect()->route('edit_url_get', ['id' => $id])->with('error', 'Salah satu form dideteksi bukan URL valid.<br>Hubungi kami jika ini sebuah kesalahan!');
                    }


                //end no error
                }
        


            }else{

                //seems IDOR

            }

        }else{
            dd('Tidak ada');
        }
    }

    public function action_delete_url(Request $request, $id){

        $uid   = Auth::user()->id;

        //check the uid has the requests 
        $check_has = "SELECT `uid` FROM `urls` WHERE `id` = :id1";

        $check_exec = DB::select($check_has, ['id1' => $id]);

        if(count($check_exec) === 1){
            $uid_url = $check_exec[0]->uid;

            if($uid === $uid_url){
                //sama
                $data  = UrlModel::find($id);
                $data->destroy($id);
                return redirect()->route('user_my_view_link')->with('success', 'Delete berhasil!');
            }else{

                //seems IDOR

            }

        }else{
            dd('Tidak ada');
        }
    }


}
