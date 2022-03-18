

Ciao <strong>{{$customer-> name}}.</strong> 
<br>
<br>
Con la presente ti confermiamo il pagamento dell'ordine.
<br>
Di seguito ti rimandiamo allo storico del'ordine che hai effettuato:
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

Grazie per aver acquistato sul nostro sito 
<br>
<br>
-Lo staff di DeliveBoo