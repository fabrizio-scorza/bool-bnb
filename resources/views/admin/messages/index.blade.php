@extends('layouts.app')

@section('title','Messaggi')

@section('content')
    <div class="container">
        <h2 class="text-center mt-2 mb-5">
            I messaggi ai miei annunci
        </h2>
    </div>
    <div class="container">
        <div class="row row-cols-1">
            @if($messages->isEmpty())
                <div class="d-flex text-center align-items-center">
                    <h2>Nessun messaggio da visualizzare</h2>
                </div>
            @else
                @foreach ($messages as $message)
                    <div class="col">
                        <div class="card">
                            <div class="card-header">
                            {{$message->house->title}}
                            </div>
                            <div class="card-body">
                            <blockquote class="blockquote mb-0">
                                <p>{{$message->text}}</p>
                                <footer class="blockquote-footer">{{$message->name}} {{$message->surname}} - {{$message->email}}</footer>
                            </blockquote>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
@endsection