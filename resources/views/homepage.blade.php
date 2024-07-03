@extends('layouts.app')
@section('content')


<homepage :houses='@json($houses)' :logged_user='@json($logged_user_id)'></homepage>
@endsection