@extends('layouts.sidebar')

@section('main_content')
<div class="container col-10 offset-2">
    <div class="col-md-12 main pl-0 pr-0">
        <div class="card">
                <div class="card-header" >
                    <h2>Account Settings</h2>
                </div>

                <div class="card-body ">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    
                    <div class="row">
                        <div class="col-3 offset-1">
                            <h3>Change your Password</h3>
                        </div>
                    </div>

                    <br>

                    <form method="POST" action="/changepassword">
                        @csrf
                        <div class="form-group row">
                            <label for="password" class="col-md-3 col-form-label text-md-right">{{ __('Password') }}</label>

                            <div class="col-md-4">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-3 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                            <div class="col-md-4">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-3">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Change') }}
                                </button>
                            </div>
                        </div>
                    </form>
                    
                </div>
        </div>
    </div>
</div>
@endsection
