@component('mail::message')
    # Hello!

    You are receiving this email because we received a password reset request for your account.

    @component('mail::button', ['url' => $actionUrl, 'color' => 'primary'])
        Reset Password
    @endcomponent

    This password reset link will expire in 60 minutes.

    If you did not request a password reset, no further action is required.

    Regards,<br>
    From PICTO

    Copy and paste this link to your browser's url bar if you can't clikc the button above: {{ $actionUrl }}
@endcomponent
