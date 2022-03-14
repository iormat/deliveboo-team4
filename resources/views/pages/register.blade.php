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
    <form action="{{ route('register') }}" method="POST" enctype="multipart/form-data">
    
        @method('POST')
        @csrf
    
        <label for="name">Nome</label>
        <input class="p-1" type="text" name="name" maxlength="255" onkeypress="return /[a-zA-Z\u00C0-\u00FF\u0020]/i.test(event.key)" required>
    
        <label for="surname">Cognome</label>
        <input class="p-1" type="text" name="surname" maxlength="255" onkeypress="return /[a-zA-Z\u00C0-\u00FF\u0020]/i.test(event.key)" required>
    
        <label for="business_name">Nome Attività</label>
        <input class="p-1" type="text" name="business_name" maxlength="255" required >
    
        <label for="email">Email</label>
        <input class="p-1" type="email" name="email" maxlength="255" required>
    
        <label for="password">Password</label>
        <input class="p-1" type="password" name="password" maxlength="20" required>
    
        <label for="password_confirmation">Conferma password</label>
        <input class="p-1" type="password"  name="password_confirmation" maxlength="20" required>
    
        <label for="address">Indirizzo</label>
        <input class="p-1" type="text" name="address" maxlength="255" required >
    
        <label for="p_iva">Partita IVA</label>
        <input class="p-1" type="text" name="p_iva"  maxlength="11" required onkeypress="return event.charCode>=48 && event.charCode<=57">
        
        <label for="img_rest">
            Aggiungi l'immagine del tuo ristorante&colon;
            <input class="p-1"type="file" name="img_rest">
        </label>  

        <label for="type">
            Seleziona il genere del tuo ristorante&colon;
                @foreach ($types as $type)
                    <input type="checkbox" name={{$type -> id}}>
                    <label for={{$type -> type_name}}>{{$type -> type_name}}</label>
                @endforeach 
        </label>
        
        <input type="submit" value="REGISTRATI" class="register-button">
    
    </form>

    @endguest
</div>   



@endsection