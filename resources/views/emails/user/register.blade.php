@component('mail::message')
# Welcome {{ $user->name }} to AQIS Database.

@component('mail::panel')
    Your new Client profile has been created on the AQIS online database.
    Please click below to Create Profile.

@endcomponent

@component('mail::button', ['url' => 'https://AQIS/Client/register/'.encrypt($user->client_id)])
Sign Up
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
