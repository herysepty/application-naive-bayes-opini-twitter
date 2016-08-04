<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use DB;
use Session;
use Abraham\TwitterOAuth\TwitterOAuth; 


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
