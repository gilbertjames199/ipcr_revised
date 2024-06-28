{{-- @component('mail::message') --}}
<p>Hello</p>
<h2>This is from Davao de Oro Provincial ICT Office</h2>
<p>You are receiving this email because we received a password reset request for your account.</p>
<p><b>Note:</b><i>This link will expire after 15 minutes</i></p>

{{-- @component('mail::button', ['url' => $url]) --}}
{{-- <p></p>{{ $url }} --}}
<span>Your <b><u>OTP</u></b> is: </span><u><b>{{ $my_one }}</b></u><br>
Instructions:
<ol>Input your OTP and email through this link: {{ $url }}</ol>
<ol>Once verified, you will be asked to update your password.</ol>
<ol>Input <b><u>password1.</u></b> as your old password</ol>
<ol>Type your new password</ol>
{{-- @endcomponent --}}
{{-- <p>Or click this <a href='{{ $url }}'>link</a> to change your password</p> --}}
<p></p>

<p>If you did not request a password reset, no further action is required.</p>
<br>

Thanks,<br>
PM Team<br>
{{-- <img src="{{ asset('ddo-bp-logo.png') }}" alt="Your Image Description" style="width: 100%; max-width: 600px;"> --}}

{{-- @endcomponent --}}
{{-- @component('mail::message')
Greeting
@if (!empty($greeting))
# {{ $greeting }}
@else
@if ($level === 'error')
# @lang('Whoops!')
@else
# @lang('Hello!')
@endif
@endif

Intro Lines comment ni
@foreach ($introLines as $line)
{{ $line }}

@endforeach

Action Button comment pud ni
@isset($actionText)
//<?php
// switch ($level) {
//     case 'success':
//     case 'error':
//         $color = $level;
//         break;
//     default:
//         $color = 'primary';
// }
//
?>
@component('mail::button', ['url' => $actionUrl, 'color' => $color])
{{ $actionText }}
@endcomponent
@endisset

Outro Lines comment ni
@foreach ($outroLines as $line)
{{ $line }}

@endforeach

Salutation comment pud no
@if (!empty($salutation))
{{ $salutation }}
@else
@lang('Regards'),<br>
{{ config('app.name') }}
@endif

Subcopy -comment ni data  neenclose sa {{ -- -- }}
@isset($actionText)
@slot('subcopy')
@lang(
    "If you're having trouble clicking the \":actionText\" button, copy and paste the URL below\n".
    'into your web browser:',
    [
        'actionText' => $actionText,
    ]
) <span class="break-all">[{{ $displayableActionUrl }}]({{ $actionUrl }})</span>
@endslot
@endisset
@endcomponent --}}
