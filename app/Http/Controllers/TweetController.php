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
      
    	return view('contents.daftar_tweet')->with('tweets',DB::table('tweets')->orderBy('id','desc')->groupBy('tweet')->paginate(10))->with('tweets_training',$this->checkTweetTraining());
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

        $keywords = array('Ahok','Djarot','Agus Yudhoyono','Sylviana murni','Sandiaga Uno','Anies Baswedan','PilkadaDKI2017');
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

    public function showTraining()
    {
       $netral = Storage::get('public/netral.txt');
       $tweets_netral = explode("\n", $netral);
       array_shift($tweets_netral);

       $negatif = Storage::get('public/negatif.txt');
       $tweets_negatif = explode("\n", $negatif);
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
            Session::flash('message','<div class="alert alert-success">
                                    Berhasil disimpan
                                </div>');
            return redirect('/training');
          }
          elseif($p['tipetraining']=='p')
          {
              $positif = Storage::get('public/positif.txt');
              Storage::put('public/positif.txt',$positif."\n".$p['tweet']);
              Session::flash('message','<div class="alert alert-success">
                                    Berhasil disimpan
                                </div>');
              return redirect('/training');
          }
          else
          {
              $negatif = Storage::get('public/negatif.txt');
              Storage::put('public/negatif.txt',$negatif."\n".$p['tweet']);
              Session::flash('message','<div class="alert alert-success">
                                    Berhasil disimpan
                                </div>');
              return redirect('/training');
          }
        }
    }
    public function storeTrainingOne($id,$type)
    {
          $tweet = DB::table('tweets')->where('id',$id)->first();
          if($type=='netral')
          {
            $netral = Storage::get('public/netral.txt');
            Storage::put('public/netral.txt',$netral."\n".$tweet->tweet);
            Session::flash('message','<div class="alert alert-success">
                                    Tweet training Berhasil ditambah, klik <a href="'.URL('/training#netral').'">disini</a> untuk melihat tweet training.
                                </div>');
            return redirect()->back();
          }
          elseif($type=='positif')
          {
              $positif = Storage::get('public/positif.txt');
              Storage::put('public/positif.txt',$positif."\n".$tweet->tweet);
              Session::flash('message','<div class="alert alert-success">
                                    Tweet training Berhasil ditambah, klik <a href="'.URL('/training#positif').'">disini</a> untuk melihat tweet training.
                                </div>');
              return redirect()->back();
          }
          else
          {
              $negatif = Storage::get('public/negatif.txt');
              Storage::put('public/negatif.txt',$negatif."\n".$tweet->tweet);
              Session::flash('message','<div class="alert alert-success">
                                    Tweet training Berhasil ditambah, klik <a href="'.URL('/training#negatif').'">disini</a> untuk melihat tweet training.
                                </div>');
              return redirect()->back();
          }
    }
    public function checkTweetTraining()
    {
      $tweets = [];
      $netral = Storage::get('public/netral.txt');
      $tweets_netral= explode("\n", $netral);
      array_shift($tweets_netral);

      $positif = Storage::get('public/positif.txt');
      $tweets_positif = explode("\n", $positif);
      array_shift($tweets_positif);

      $negatif = Storage::get('public/negatif.txt');
      $tweets_negatif = explode("\n", $negatif);
      array_shift($tweets_negatif);

      $tweets = array_merge($tweets_positif,$tweets_netral);
      $tweets = array_merge($tweets,$tweets_negatif);

      return $tweets;
    }
    public function clear($type)
    {
        if($type == 'netral') {
            Storage::put('public/netral.txt',"");
        }
        else if($type == 'negatif')
        {
            Storage::put('public/negatif.txt',"");
        }
        else
        {
            Storage::put('public/positif.txt',"");
        }

    }
}
