@extends('layouts.sidebar')

@section('main_content')
<div class="container col-10 offset-2">
    <div class="col-md-12 main pl-0 pr-0">
        <div class="card">
                <div class="card-header" >
                    <h2>More Informations & Options</h2>
                </div>

                <div class="card-body ">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div class="row">
                        <div class="col-2 offset-1 text-md-right">
                            <span>
                                <strong>Site/App Name:</strong>
                            </span>
                        </div>
                        <div class="col-6">
                            <span>{{ $password->name }}</span>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-2 offset-1 text-md-right">
                            <span>
                                <strong>Username:</strong>
                            </span>
                        </div>
                        <div class="col-6">
                            <span>{{ $password->username }}</span>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-2 offset-1 text-md-right">
                            <span>
                                <strong>Email:</strong>
                            </span>
                        </div>
                        <div class="col-6">
                            <span>{{ $password->email }}</span>
                        </div>
                    </div>

                    <hr class="offset-1 col-8"> 

                    <div class="row">
                        <div class="col-2 offset-1 text-md-right">
                            <span>
                                <strong>Password:</strong>
                            </span>
                        </div>
                        <div class="col-6">
                            <span>{{ $password->encrypt($password->password) }}</span>
                        </div>
                    </div>

                    <hr class="offset-1 col-8"> 

                    <div class="row">
                        <div class="col-2 offset-1 text-md-right">
                            <span>
                                <strong>Note:</strong>
                            </span>
                        </div>
                        <div class="col-6">
                            <span>{{ $password->note }}</span>
                        </div>
                    </div>

                    <hr class="offset-1 col-8"> 

                    <div class="row">
                        <div class="col-2 offset-1 text-md-right">
                            <span>
                                <strong>Created Date:</strong>
                            </span>
                        </div>
                        <div class="col-6">
                            <span>{{ $password->created_at }}</span>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-2 offset-1 text-md-right">
                            <span>
                                <strong>Last Update:</strong>
                            </span>
                        </div>
                        <div class="col-6">
                            <span>{{ $password->updated_at }}</span>
                        </div>
                    </div>

                    <hr class="offset-1 col-8">

                    <div class="row">
                        <div class="col-2 offset-1 text-md-right">
                            <a class="btn btn-primary" href ="/editpassword/{{ $password->id }}">
                                <svg class='pb-1' xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"><path d="M1.438 16.872l-1.438 7.128 7.127-1.438 12.642-12.64-5.69-5.69-12.641 12.64zm2.271 2.253l-.85-.849 11.141-11.125.849.849-11.14 11.125zm20.291-13.436l-2.817 2.819-5.69-5.691 2.816-2.817 5.691 5.689z"/></svg>
                                <strong>Edit</strong>
                            </a>
                        </div>
                        <div class="col-2">
                            <a class="btn btn-back" href ="/deletepassword/{{ $password->id }}">
                                <svg class='pb-1' xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"><path d="M3 6v18h18v-18h-18zm5 14c0 .552-.448 1-1 1s-1-.448-1-1v-10c0-.552.448-1 1-1s1 .448 1 1v10zm5 0c0 .552-.448 1-1 1s-1-.448-1-1v-10c0-.552.448-1 1-1s1 .448 1 1v10zm5 0c0 .552-.448 1-1 1s-1-.448-1-1v-10c0-.552.448-1 1-1s1 .448 1 1v10zm4-18v2h-20v-2h5.711c.9 0 1.631-1.099 1.631-2h5.315c0 .901.73 2 1.631 2h5.712z"/></svg>
                                <strong>Delete</strong>
                            </a>
                        </div>
                    </div>

                </div>
        </div>
    </div>
</div>
@endsection
