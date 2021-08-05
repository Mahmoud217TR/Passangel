@extends('layouts.sidebar')

@section('main_content')
<div class="container col-10 offset-2">
    <div class="col-md-12 main pl-0 pr-0">
        <div class="card">
            <div class="card-header" >
                <h2>Options</h2>
            </div>

            <div class="card-body ">
                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif
                
                <token-manager token="{{ $user->token }}"></token-manager>
                <br>
                <backup-manager></backup-manager>
                    
            </div>
        </div>
    </div>
</div>
@endsection
