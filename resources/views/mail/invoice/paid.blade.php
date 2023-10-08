<x-mail::message>

<br>
<h1 class="">{{$subject}}</h1> 
<br>

<p class="">{{$message}}</p>

<br><br>
Merci cordialement,<br>
{{ config('app.name') }}
</x-mail::message>
