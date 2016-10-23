<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\lib\NBC;
use App\Http\Controllers\lib\FileDataSource;
use App\Http\Controllers\preprocessing\Preprocessing;  
use Storage;
use DB;
use Session;

class KlasifikasiController extends Controller
{
	public function  __construct()
	{
		ini_set('max_execution_time', 3000);
	}
    public function klasifikasi(Request $request)
    {
    	$nbc = new NBC();
    	$nbc->train(new FileDataSource(storage_path('app\public\positif.txt')), 'positif');
		$nbc->train(new FileDataSource(storage_path('app\public\negatif.txt')), 'negatif');
		$nbc->train(new FileDataSource(storage_path('app\public\netral.txt')), 'netral');

		$tweets = DB::table('tweet_preprocessing')->get();
		$positif  = array();
		$negatif = array();
		$netral = array();
		$array_tweet = array();
		foreach ($tweets as $key => $value) {
			$classify =  $nbc->classify($value->preprocessing);
			if($classify=='positif'){
				$tweet = DB::table('tweets')->where('id',$value->id_tweet)->first();
				$positif['positif'][] = $tweet->tweet;
			}
			else if($classify=='negatif'){
				$tweet = DB::table('tweets')->where('id',$value->id_tweet)->first();
				$negatif['negatif'][] = $tweet->tweet;
			}
			else{
				$tweet = DB::table('tweets')->where('id',$value->id_tweet)->first();
				$netral['netral'][] = $tweet->tweet;
			}
		}
		$array_tweet = array_merge($positif,$netral,$negatif);
		$analisis = array(count($positif['positif']),count($negatif['negatif']),count($netral['netral']));
		Session::flash('message','<div class="alert alert-success">
                                    Berhasil klasifikasi
                                </div>');
		return view('contents.hasil_klasifikasi')->with('tweets',$array_tweet)->with('count_analisis',$analisis);
    }
    public function preprocessing(Request $request)
    {
		$post = $request->all();
    	$p = new Preprocessing();
		
    	db::table('tweet_preprocessing')->delete();
    	// $terms = $p->preprocesing($post['date_tweet'],$post['start_time_tweet'],$post['end_time_tweet']);
    	$terms = $p->preprocesing(date('Y-m-d',strtotime($post['date'])),$post['start_time_tweet'],$post['end_time_tweet']);
		$total_tweet    = DB::table('tweets')->where('date_tweet','LIKE',date('D M d%Y',strtotime($post['date'])))->count();

		if($total_tweet==0)
		{
			Session::flash('message','<div class="alert alert-danger">
                                    Tidak ada tweet di tanggal '.$post['date'].'
                                </div>');
    		return redirect()->back();
		}
		else
		{

			Session::flash('message','<div class="alert alert-success">
                                    Berhasil preprocessing
                                </div>');
    		return redirect('tweet/preprocessing');
		}
    }
}
