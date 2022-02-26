@extends('layouts.main-layout');

@section('content')
    

{{-- Email *
● Password *
● Nome Attività *
● Indirizzo *
● PIVA *
● Uno o più tipologie*: --}}

<h2>Register</h2>
<form action="{{ route('register') }}" method="POST">

    @method('POST')
    @csrf

    <label for="name">Nome</label><br>
    <input type="text" name="name" ><br>

    <label for="surname">Cognome</label><br>
    <input type="text" name="surname" ><br>

    <label for="username">Nome Attività</label><br>
    <input type="text" name="username" ><br>

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

    <label for="business_description">Business Description</label><br>
    <input type="text" name="business_description" ><br>

    <br>
    <input type="submit" value="REGISTER">

</form>
<hr>        

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

@endsection