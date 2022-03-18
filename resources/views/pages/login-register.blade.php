@extends('layouts.main-layout')

@section('content')

<my-header-component-due></my-header-component-due>
<div class="login-register">
    @guest

    <h2 class="text-order">Login</h2>
    @if ($errors -> any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors -> all() as $error)
                    <li> {{ $error }} </li>
                @endforeach    
            </ul>    
        </div>       
    @endif
    <form action="{{ route('login') }}" method="POST" class="form-login">
    
        @method('POST')
        @csrf
    
        <label for="email">Email</label>
        <input type="email" name="email">
        <label for="password">Password</label>
        <input type="password" name="password">
        
        <input type="submit" value="LOGIN" class="login-button">
    
    </form>

    <p>per registrarti clicca <a href="{{route('register')}}">qui</a></p>

    @endguest
</div>   






@endsection