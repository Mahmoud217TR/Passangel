@extends('layouts.sidebar')

@section('main_content')
<div class="container col-10 offset-2">
    <div class="col-md-12 main pl-0 pr-0">
        <div class="card">
                <div class="card-header" >
                    <h2>Contact Support team for issues</h2>
                </div>

                <div class="card-body ">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <div class="row">
                        <div class="offset-2 col-2">
                            <span><strong>Support Email:</strong></span>
                        </div>
                        <div class="col-5">
                            <span>team.passangel@gmail.com</span>
                        </div>
                    </div>  
                    
                </div>
        </div>
    </div>
</div>
@endsection
