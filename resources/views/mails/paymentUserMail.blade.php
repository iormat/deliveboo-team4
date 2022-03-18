Ciao {{$user -> name}},
<br>
<br>
Hai appena ricevuto un nuovo ordine da: {{$customer -> name}}
<br>
Di seguito ti rimandiamo allo storico del'ordine che ha effettuato:
<br>
<br>

@foreach ($dishes as $item)
Nome piatto: {{$item -> dish_name}} - Quantità: {{$item -> quantity}}
<br>
@endforeach
<br>
Il totale dell'ordine è di: EUR {{number_format($order -> total_price, 2)}}
<br>
<br>

-Lo staff di DeliveBoo
