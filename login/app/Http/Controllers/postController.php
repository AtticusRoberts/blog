<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class postController extends Controller
{
  public function get(Request $request) {
    return DB::select('SELECT username,time,title,content FROM posts');
    // return [["username" => "Luke Roberts",
    //         "time" => "2019-02-03 04:09:55 UTC",
    //         "title" => "My trip to Paris",
    //         "content" => "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque vulputate mauris sit amet turpis lobortis, sit amet pellentesque lectus tincidunt. Suspendisse vitae maximus lorem. Nam semper ac lorem ut blandit. Proin molestie lacus id nulla pretium ultricies vitae id risus. Morbi id felis nec justo iaculis rutrum. Sed velit dolor, tristique in hendrerit at, accumsan at ligula. Nam tincidunt vehicula varius. Fusce tempus arcu pretium nunc fermentum mattis. "
    //       ]];
  }
  public function make(Request $request) {
    $cookie = $request->cookie('login-auth');
    $user = json_decode(json_encode(DB::select('SELECT username FROM creds WHERE cookie = \''.$cookie.'\'')),true)[0]['username'];
    date_default_timezone_set("America/New_York");
    $time=date("Y-m-d h:i:s")." EST";
    $title=$request['title'];
    $content=$request['content'];
    DB::insert('INSERT INTO posts (username,time,title,content) VALUES (\''.$user.'\',\''.$time.'\',\''.$title.'\',\''.$content.'\')');
    return $request;
  }
}
