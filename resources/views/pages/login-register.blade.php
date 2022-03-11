@extends('layouts.main-layout')

@section('content')


    

<div class="loginRegister">
    @guest

    <h2>Login</h2>
    <form action="{{ route('login') }}" method="POST">
    
        @method('POST')
        @csrf
    
        <label for="email">Email</label><br>
        <input type="email" name="email"><br>
        <label for="password">Password</label><br>
        <input type="password" name="password"><br>
        <br>
        <input type="submit" value="LOGIN">
    
    </form>

    <h2>Register</h2>
    <form action="{{ route('register') }}" method="POST">
    
        @method('POST')
        @csrf
    
        <label for="name">Nome</label><br>
        <input type="text" name="name" ><br>
    
        <label for="surname">Cognome</label><br>
        <input type="text" name="surname" ><br>
    
        <label for="business_name">Nome Attività</label><br>
        <input type="text" name="business_name" ><br>
    
        <label for="email">Email</label><br>
        <input type="email" name="email"><br>
    
        <label for="password">Password</label><br>
        <input type="password" name="password"><br>
    
        <label for="password_confirmation">Password confirmation</label><br>
        <input type="password"  name="password_confirmation"><br>
    
        <label for="address">Indirizzo</label><br>
        <input type="text" name="address" ><br>
    
        <label for="p_iva">Partita IVA</label><br>
        <input type="text" name="p_iva" ><br>
    
        <br>
        <input type="submit" value="REGISTER">
    
    </form>

    @else
    <h2>Register</h2>
    <form action="{{ route('register') }}" method="POST">
    
        @method('POST')
        @csrf
    
        <label for="name">Nome</label><br>
        <input type="text" name="name" ><br>
    
        <label for="surname">Cognome</label><br>
        <input type="text" name="surname" ><br>
    
        <label for="business_name">Nome Attività</label><br>
        <input type="text" name="business_name" ><br>
    
        <label for="email">Email</label><br>
        <input type="email" name="email"><br>
    
        <label for="password">Password</label><br>
        <input type="password" name="password"><br>
    
        <label for="password_confirmation">Password confirmation</label><br>
        <input type="password"  name="password_confirmation"><br>
    
        <label for="address">Indirizzo</label><br>
        <input type="text" name="address" ><br>
    
        <label for="p_iva">Partita IVA</label><br>
        <input type="text" name="p_iva" ><br>
    
        <br>
        <input type="submit" value="REGISTER">
    
    </form>
    @endguest
</div>   






@endsection