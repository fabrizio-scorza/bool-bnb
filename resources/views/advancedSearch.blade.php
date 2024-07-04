@extends('layouts.app')
@section('content')


<advanced-search :houses='@json($houses)' :logged_user='@json($logged_user_id)'></advanced-search>
@endsection