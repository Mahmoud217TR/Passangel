@extends('layouts.app')

@section('content')
<div class="col-12 p-0">
<div class="d-flex flex-column flex-shrink-0 pt-3 pb-3 pr-0 col-2 sidebar">
    <h2 class="sidebar-title"><center>Main Menu</center></h2>
    <hr>
    <ul class="nav flex-column mb-auto">
      <li class="nav-item">
        <a href="/home" class="nav-link @if(Route::current()->getName() == 'home')sb-active @endif" >
          Home
        </a>
      </li>
      <li>
        <a href="/addpassword" class="nav-link @if(Route::current()->getName() == 'addpassword')sb-active @endif">
          Add a new Password
        </a>
      </li>
      <li>
        <a href="#" class="nav-link @if(Route::current()->getName() == 'token')sb-active @endif">
          Change your Token
        </a>
      </li>
      <li>
        <a href="#" class="nav-link @if(Route::current()->getName() == 'support')sb-active @endif">
          Contact Support
        </a>
      </li>
      <li>
        <a href="#" class="nav-link @if(Route::current()->getName() == 'settings')sb-active @endif">
          Settings
        </a>
      </li>
    </ul>
    
  </div>
@yield('main_content')
</div>
@endsection
