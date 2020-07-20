<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Auth;
use DB;
use DataTables;
class ApiActionURL extends Controller
{
    
	function get_my_link_api(Request $request){
		$uid   = Auth::user()->id;;
		$query = "SELECT `id`,`name` FROM `urls` WHERE `uid` = :uid and `deleted_at` IS NULL";
		$exec  = DB::select($query, ['uid' => $uid]);
		return datatables()->of($exec)
		->addColumn('edit', function($data){
			return $data->id;
		})
		->addIndexColumn()
		->make(true);

	}

	function public_link(Request $request){

		$query = "SELECT `id`,`name` FROM `urls` WHERE `public` = 1 and `deleted_at` IS NULL;";
		$exec = DB::select($query);
		return datatables()->of($exec)
			->addIndexColumn()
			->make(true);

	}


	function get_detail_link(Request $request, $id){

		// return $id;
		$query = "SELECT * FROM `urls` WHERE `id` = :id";
		$exec  = DB::select($query, ['id' => $id]);
		if(count($exec) != 1){
			return 'Something Wrong, Or your data requested was Gone.';
		}else{
			#return 200;
			$uidpost = $exec[0]->uid;
			$uiduser = Auth::user()->id;
			if($uidpost == $uiduser or $exec[0]->public == 1){

				$detail = $exec[0];
				
				$ret =  array(
					'judul' => $detail->name,
					'deskripsi' => $detail->desc,
					// 'recordsTotal' => count(json_decode($detail->url)),
					// 'recordsFiltered' => count(json_decode($detail->url)),
					'data' => [

					]
				);

				foreach(json_decode($detail->url) as $uri){
					array_push($ret['data'], ['url' => $uri]);
				}

				// return datatables()->of($ret)->make(true);
				return $ret;

			}else{
				return 'No IDOR!';
			}
		}

	}

}



