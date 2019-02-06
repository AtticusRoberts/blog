@extends('template')
@section('content')
<create-post v-if="!loading"></create-post>
@endsection
@section('head')
<title>Post to blog</title>
@endsection
