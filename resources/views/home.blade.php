@extends('layouts.sidebar')

@section('main_content')
<div class="container col-10 offset-2">
    <div class="col-md-12 main pl-0 pr-0">
        <div class="card">
                <div class="card-header" >
                    <h2>Manage your Passwords</h2>
                </div>

                <div class="card-body ">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <table class="table">
                        <tr>
                            <th class="col-2 tb-head">Site/App Name</th>
                            <th class="col-2 tb-head">Email</th>
                            <th class="col-2 tb-head">Username</th>
                            <th class="col-2 tb-head">Password</th>
                            <th class="col-2 tb-head">Note</th>
                            <th class="col-2 tb-head">Actions</th>
                        </tr>
                        <tr>
                            <td class="col-2">Site/App Name</td>
                            <td class="col-2">Email</td>
                            <td class="col-2">Username</td>
                            <td class="col-2">Password</td>
                            <td class="col-2">Note</td>
                            <td class="col-2">Last Modified</td>
                        </tr>
                    </table>
                </div>
        </div>
    </div>
</div>
@endsection
