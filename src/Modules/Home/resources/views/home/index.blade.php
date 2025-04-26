@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ Module::asset('home:css/homeStyle.css') }}">

@include('home::home.header')
@include('home::home.about')
@include('home::home.curasuite')

@endsection