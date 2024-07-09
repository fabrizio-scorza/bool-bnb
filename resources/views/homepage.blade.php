@extends('layouts.app')
@section('content')


<homepage 
:houses='@json($houses)' 
:logged_user='@json($logged_user_id)' 
:search_route='@json(route('advanced'))'
:show_route='@json(url('/public'))'
:admin_show_route='@json(url('/admin/houses'))'
>
</homepage>
@endsection