<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
class cookieController extends Controller
{
  public function setCookie(Request $request){
   $users = DB::select('SELECT username FROM creds');
   $pass = DB::select('SELECT password FROM creds');
   for ($i = 0; $i < count($users); $i++) {
     if ($request['username'] == $users[$i]->username && $request['password'] == $pass[$i]->password) {
       $cookie = (string)hash('sha256',(string)rand(0,1000000000000));
       DB::update('update creds set cookie=\''.$cookie.'\' where username = \''.$request['username'].'\'');
       $minutes = 60;
       $response = new \Illuminate\Http\Response('Success');
       $response->withCookie(cookie('login-auth', $cookie, $minutes));
       return $response;
     }
   }
   $minutes = 60;
   $response = new \Illuminate\Http\Response('Incorrect username or password');
   $response->withCookie(cookie('login-auth', '', $minutes));
   return $response;
 }
  public function authCookie(Request $request) {
    $value = $request->cookie('login-auth');
    $trueValue = DB::select('SELECT cookie FROM creds WHERE cookie = \''.$value.'\'');
    if ($trueValue) return view("blog");
    else return redirect('/login');
  }
  public function verLogin(Request $request){
   $value = $request->cookie('login-auth');
   $trueValue = DB::select('SELECT cookie FROM creds WHERE cookie = \''.$value.'\'');
   if ($trueValue) return "<h1>Success! You've been logged in!</h1><img src=\"images/success.gif\"><p id='timer'>Redirecting in 5 seconds</p><a href=\"/\">If you don't redirect automaticly, click this link</a><script>let time = 5;setInterval(countdown,1000);function redir() {window.location.href = '/';};function countdown() {time-=1;if(time<=0) {redir()}; document.getElementById(\"timer\").innerHTML=\"Redirecting in \"+time+\" seconds\";}</script>";
   else return redirect('/login');
  }
  public function create(Request $request) {
    $first = $request['firstName'];
    $last = $request['lastName'];
    $user = $request['username'];
    $pass = $request['password'];
    $email = $request['email'];
    if (strlen($user) > 20) return "Username too long";
    if (strlen($first) > 255) return "First name too long";
    if (strlen($last) > 255) return "Last name too long";
    if (strlen($email) > 255) return "Email too long";
    if (DB::select('SELECT username FROM creds WHERE username =\''.$user.'\'')) return "Username taken";
    if (DB::select('SELECT email FROM creds WHERE email =\''.$email.'\'')) return "Email taken";
    DB::insert('INSERT INTO creds (firstName,lastName,username,password,email) VALUES (\''.$first.'\',\''.$last.'\',\''.$user.'\',\''.$pass.'\',\''.$email.'\')');
    $cookie = (string)hash('sha256',(string)rand(0,1000000000000));
    DB::update('update creds set cookie=\''.$cookie.'\' where username = \''.$request['username'].'\'');
    $minutes = 60;
    $response = new \Illuminate\Http\Response('success!');
    $response->withCookie(cookie('login-auth', $cookie, $minutes));
    return $response;
  }
}
