@extends('template')
@section('content')
<login-box v-if='!loading'></login-box>
@endsection
@section('head')
<title>Login</title>
@endsection
