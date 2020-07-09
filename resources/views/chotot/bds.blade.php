@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">

            <!-- <form method="POST" action="/chototadd" id="myform">
                        @csrf
                        <div style="display:flex;">
                            From:  <input style="width:10%;margin-left:10px;" id="page" type="page" class="mr-3 form-control @error('page') is-invalid @enderror" name="page" value="{{ isset($page) ? $page + 1 : '' }}" required autocomplete="page" autofocus>
                                    @error('page')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                            To:  <input style="width:10%;margin-left:10px;" id="topage" type="topage" class="form-control @error('topage') is-invalid @enderror" name="topage" value="{{ isset($topage) ? $topage + 1 : '' }}" required autocomplete="topage" autofocus>
                                    @error('topage')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                            <button id="submit" type="submit" class="btn btn-primary ml-2"> ADD </button>
                        </div>

            </form> -->

            
            @isset ($add)
                Add {{ $add }}  
                Dup {{ $dup }} 
                Error {{ $error }} 
            @endisset

            <account-management id="account-management" data-app></account-management>
    </div>
    
</div>
@endsection
