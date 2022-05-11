@component('mail::message')
# Welcome {{ $user->name }} to AQIS Database.

@component('mail::panel')
    Your new staff profile has been created on the AQIS online database.  
    Please click below to login.  
    Your username is : **{{ $user->email }}**
@endcomponent

@component('mail::button', ['url' => config('app.url')])
Login
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
