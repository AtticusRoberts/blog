<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
class cookieController extends Controller
{
  public function ver(Request $request) {
    $auth = DB::select('SELECT cookie FROM creds WHERE cookie = \''.$request['cookie'].'\'');
    if (empty($auth)) {
      return "false";
    }
    else {
      return "true";
    }
    return $request;
  }
  public function setCookie(Request $request){
   $users = DB::select('SELECT username FROM creds WHERE username = \''.$request['username'].'\'');
   $pass = DB::select('SELECT password FROM creds WHERE username = \''.$request['username'].'\'');

   if (!empty($pass)) {
     if ($pass[0]->password == $request['password']) {
         $cookie = (string)hash('sha256',(string)rand(0,1000000000000));
         DB::update('update creds set cookie=\''.$cookie.'\' where username = \''.$request['username'].'\'');
         $minutes = 60;
         $response = cookie('auth', $cookie, $minutes);
         return $cookie;
     }
     else {
       return "Incorrect password";
     }
   }
   else {
     return "Incorrect username";
   }

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
    return $cookie;
  }
}
