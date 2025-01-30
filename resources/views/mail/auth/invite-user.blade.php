<x-mail::message>
Hello,<br>

You’ve been invited to join [customer portal]. To set up your account, simply click on the link below.

<x-mail::button :url="$acceptUrl">
    Set up your account
</x-mail::button>

Best,<br>
The {{ config('app.name') }} team
</x-mail::message>
