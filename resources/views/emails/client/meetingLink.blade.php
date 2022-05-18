@component('mail::message')
# Welcome {{ $user->name }} to AQIS Database.

@component('mail::panel')
  Your Meeting has been Schedualed on {{$details->date}} for {{$details->duration}} for the Program {{$details->programName}}


@endcomponent
@component('mail::button', ['url' => $details->meetingLink])
Join
@endcomponent
@component('mail::button', ['url' => env('APP_URL').'/api/meetingStatus/'.$details->id.'/Accept'])
Accept
@endcomponent
@component('mail::button', ['url' => env('APP_URL').'/api/meetingStatus/'.$details->id.'/Decline'])
Decline
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
