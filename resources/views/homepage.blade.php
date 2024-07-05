@extends('layouts.app')
@section('content')


<homepage :houses='@json($houses)' :logged_user='@json($logged_user_id)' :search_route='@json(route('advanced'))'></homepage>
@endsection