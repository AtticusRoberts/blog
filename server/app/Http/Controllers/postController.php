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

  }
  public function make(Request $request) {
    $user = DB::select('SELECT username FROM creds WHERE cookie =\''.$request['cookie'].'\'');
    if (!empty($user)) {
      $user = $user[0]->username;
      date_default_timezone_set("America/New_York");
      $time=date("Y-m-d h:i:s")." EST";
      $title=$request['title'];
      $content=$request['content'];
      DB::insert('INSERT INTO posts (username,time,title,content) VALUES (\''.$user.'\',\''.$time.'\',\''.$title.'\',\''.$content.'\')');
      return "success";
    }
    else {
      return "false";
    }
  }
}
