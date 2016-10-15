<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use DB;
use Session;
use Abraham\TwitterOAuth\TwitterOAuth; 
use Storage;
use Validator;


class TweetController extends Controller
{
	public function  __construct()
	{
		ini_set('max_execution_time', 3000);
	}
    public function index()
    {	
    	return view('contents.daftar_tweet')->with('tweets',DB::table('tweets')->paginate(10));
    }
    public function preprocessing()
    {   
        return view('contents.daftar_preprocessing')->with('tweets',DB::table('tweet_preprocessing')->paginate(10));
    }
    public function showTraining()
    {
       $netral = Storage::get('public/netral.txt');
       $tweets_netral = explode("\n", $netral);
       array_shift($tweets_netral);

       $negatif = Storage::get('public/negatif.txt');
       $tweets_negatif = explode("\n", $netral);
       array_shift($tweets_negatif);
       
       $positif = Storage::get('public/positif.txt');
       $tweets_positif = explode("\n", $positif);
       array_shift($tweets_positif);
        return view('contents.training')->with('tweets_netral',$tweets_netral)->with('tweets_negatif',$tweets_negatif)->with('tweets_positif',$tweets_positif);
    }
    public function storeTraining(Request $request)
    {
        $p = $request->all();
        $v = Validator::make($p,[
              'tweet' => 'required',
              'tipetraining' => 'required'

          ]);
        if($v->fails())
        {
            return redirect()->back()->withErrors($v->errors())->withInput();
        }
        else
        {
          if($p['tipetraining']=='n')
          {
            $netral = Storage::get('public/netral.txt');
            Storage::put('public/netral.txt',$netral."\n".$p['tweet']);
            return redirect('/training');
          }
          elseif($p['tipetraining']=='p')
          {
              $positif = Storage::get('public/positif.txt');
              Storage::put('public/positif.txt',$positif."\n".$p['tweet']);
              return redirect('/training');
          }
          else
          {
              $negatif = Storage::get('public/negatif.txt');
              Storage::put('public/negatif.txt',$negatif."\n".$p['tweet']);
              return redirect('/training');
          }
        }
    }
    public function unduh(Request $request)
    {
    	$post                = $request->all();
        // $date                = date('Y-m-d',strtotime($post['date']) + 86400);
       // $date                = date('Y-m-d',strtotime($post['date']));

       $consumer_key        = "YyiX1I2pgTKaMAI4UbKxkFCJ0";
        $consumer_secret     = "Kxw9IrUjFHz5IcVFhiBPUmjr1FxAvwSt3zveo2oPKqro1PMUni";
        $access_token        = "715720484491399169-BRLVVh1oqYsy7Hq3bf1pRkWTfqCIHLc";
        $access_token_secret = "66q4RVaIq8NPHcc01mEaXXJXqPmLvqUfdtcbjuUvnBTHx";
        $twitter             = new TwitterOAuth($consumer_key,$consumer_secret,$access_token,$access_token_secret);
        $twitter->setTimeouts(10, 360000);

        $keywords = array('ahok','pilkadadki2017','yusril','sandiago uno','risma','temanahok');
        foreach ($keywords as $value_keyword)
        {
            $tweets = $twitter->get("search/tweets", ["q" => $value_keyword,"count"=>100,"result_type"=>"recent"]);
            if(!empty($tweets->statuses))
            {
                foreach ($tweets->statuses as $tweet)
                {

                    $check_tweet = DB::table('tweets')->where('id_tweet' , $tweet->id_str)->count();
                    if($check_tweet == 0)
                    {
                        DB::table('tweets')->insert(['id_tweet' => $tweet->id_str,'username' => $tweet->user->screen_name,'tweet' => $tweet->text,'date_tweet' => $tweet->created_at]);
                    }
                }
            }
        }
        Session::flash('message','<div class="alert alert-success">
                                    Berhasil unduh
                                </div>');
        return redirect('tweet');
}
}
