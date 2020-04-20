@component('mail::message')
# Hi,

You have the been invited to join the team
**{{ $invitation->team->name }}**.
Because you are already register to the platform, you just
need to accept or reject the invitation to your
[team management console]({{ $url }})

@component('mail::button', ['url' => $url ])
Go to Dashboard
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
