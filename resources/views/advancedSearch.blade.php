@extends('layouts.app')
@section('content')


<advanced-search
    :services='@json($services)'
    :houses='@json($houses)'
    :logged_user='@json($logged_user_id)'
    :show_route='@json(url('/public'))'
    :admin_show_route='@json(url('/admin/houses'))'
>
</advanced-search>
@endsection