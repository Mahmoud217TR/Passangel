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

                    <table class="table col-12">
                        <tr>
                            <th class="col-2 tb-head">Site/App Name</th>
                            <th class="col-2 tb-head">Email</th>
                            <th class="col-2 tb-head">Username</th>
                            <th class="col-3 tb-head">Password</th>
                            <th class="col-2 tb-head">Last Modified</th>
                            <th class="col-1 tb-head">Actions</th>
                        </tr>
                        
                        @foreach ($passwords as $p)
                        <tr>
                            <td class="col-2">{{ $p->name }}</td>
                            <td class="col-2">{{ $p->email }}</td>
                            <td class="col-2">{{ $p->username }}</td>
                            <td class="col-3"><copy-on-click data ="{{ $p->decrypt($p->password) }}" counter = "data{{ $loop->index }}"></copy-on-click></td>
                            <td class="col-2">{{ $p->updated_at }}</td>
                            <td class="col-1  p-2"><a class="btn btn-back" href="show/{{ $p->id }}">More</a></td>
                        </tr>
                        @endforeach
                    </table>
                </div>
        </div>
    </div>
</div>
@endsection
