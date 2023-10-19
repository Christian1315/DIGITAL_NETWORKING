<x-mail::message>

<br>
<h1 class="">{{$subject}}</h1> 
<br>

<p class="">{{$message}}</p>

<x-mail::button :url="''">
Visitez notre plateforme
</x-mail::button>

<br><br>
Merci cordialement,<br>
{{ config('app.name') }}
</x-mail::message>
