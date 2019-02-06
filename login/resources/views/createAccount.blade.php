@extends('template')
@section('content')
<create-account v-if='!loading'></create-account>
@endsection
@section('head')
<title>Create Account</title>
@endsection
