<x-mail::message>
<div class="text-center" style="text-align:center">
    <img src="https://res.cloudinary.com/duk6hzmju/image/upload/v1696441954/digital-logo_micxsx.jpg" class="logo" alt="Laravel Logo">
</div>
<br>
<h1 class="">{{$subject}}</h1> 
<br>

<p class="">{{$message}}</p>

<br><br>
Merci cordialement,<br>
{{ config('app.name') }}
</x-mail::message>
