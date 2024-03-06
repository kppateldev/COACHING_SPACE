@component('mail::message')

<h1 style="color: #3d4852; font-size: 18px;">Dear {!! $mailData["to_name"] !!}!</h1>

<p style="color: #718096; border-bottom: 1px solid #e8e5ef; padding-bottom: 25px; margin-bottom: 25px;">{!! $mailData["message"] !!}</p>

<p style="color: #718096;">Regards,<br>
{{ config('app.name') }}</p>

@endcomponent
