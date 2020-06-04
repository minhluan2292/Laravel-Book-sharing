@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">Chat App</div>
                <div class="card-body" id="app">

                    <chat-app :user='@json(Auth::user())'></chat-app>
                    
                </div>
            </div>
        </div> 
    </div>
    
</div>
@endsection
