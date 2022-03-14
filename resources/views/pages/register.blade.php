@extends('layouts.main-layout')

@section('content')

<my-header-component-due></my-header-component-due>

<div class="login-register">
    @guest

    <h2 class="text-order">Registrati</h2>
    @if ($errors -> any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors -> all() as $error)
                    <li> {{ $error }} </li>
                @endforeach    
            </ul>    
        </div>       
    @endif
    <form action="{{ route('register') }}" method="POST">
    
        @method('POST')
        @csrf
    
        <label for="name">Nome</label>
        <input type="text" name="name" maxlength="255" onkeypress="return /[a-zA-Z\u00C0-\u00FF\u0020]/i.test(event.key)" required>
    
        <label for="surname">Cognome</label>
        <input type="text" name="surname" maxlength="255" onkeypress="return /[a-zA-Z\u00C0-\u00FF\u0020]/i.test(event.key)" required>
    
        <label for="business_name">Nome Attività</label>
        <input type="text" name="business_name" maxlength="255" required >
    
        <label for="email">Email</label>
        <input type="email" name="email" maxlength="255" required>
    
        <label for="password">Password</label>
        <input type="password" name="password" maxlength="20" required>
    
        <label for="password_confirmation">Conferma password</label>
        <input type="password"  name="password_confirmation" maxlength="20" required>
    
        <label for="address">Indirizzo</label>
        <input type="text" name="address" maxlength="255" required >
    
        <label for="p_iva">Partita IVA</label>
        <input type="text" name="p_iva"  maxlength="11" required onkeypress="return event.charCode>=48 && event.charCode<=57">
    
        
        <input type="submit" value="REGISTRATI" class="register-button">
    
    </form>

    @else
    <h2>Registrati</h2>
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
    
        <label for="password_confirmation">Conferma password</label><br>
        <input type="password"  name="password_confirmation"><br>
    
        <label for="address">Indirizzo</label><br>
        <input type="text" name="address" ><br>
    
        <label for="p_iva">Partita IVA</label><br>
        <input type="text" name="p_iva" ><br>
    
        <br>
        <input type="submit" value="REGISTRATI">
    
    </form>
    @endguest
</div>   



@endsection