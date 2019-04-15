@component('mail::message')

    Your mail has been received, we will answer as fast as we can!
    Until then I recommend to check out our FAQ(Frequently Asked Questions)
    @component('mail::button', ['url' => 'powershare.fund/faq'])
        FAQ
    @endcomponent

    Thanks,<br>
    {{ config('app.name') }}
@endcomponent
