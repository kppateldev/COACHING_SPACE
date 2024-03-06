@component('mail::message')

<h1 style="color: #3d4852; font-size: 18px;">Dear {!! $mailData["to_name"] !!}!</h1>

<p style="color: #718096;">You have new contact inquiry. Please review below details submitted by user.</p>

<table cellpadding="0" cellspacing="0" style="width: 100%; border-bottom: 1px solid #e8e5ef; padding-bottom: 25px; margin-bottom: 25px;">
    <tr>
        <td style="padding: 10px 10px; width: 25%; border: 1px solid #ddd"><strong>First Name:</strong></td>
        <td style="padding: 10px 10px; border: 1px solid #ddd">{!! $mailData["first_name"] !!}</td>
    </tr>
    <tr>
        <td style="padding: 10px 10px; width: 25%; border: 1px solid #ddd"><strong>Last Name:</strong></td>
        <td style="padding: 10px 10px; border: 1px solid #ddd">{!! $mailData["last_name"] !!}</td>
    </tr>
    <tr>
        <td style="padding: 10px 10px; width: 25%; border: 1px solid #ddd"><strong>Email:</strong></td>
        <td style="padding: 10px 10px; border: 1px solid #ddd">{!! $mailData["email"] !!}</td>
    </tr>
    <tr>
        <td style="padding: 10px 10px; width: 25%; border: 1px solid #ddd"><strong>Phone Number:</strong></td>
        <td style="padding: 10px 10px; border: 1px solid #ddd">{!! $mailData["phone_number"] !!}</td>
    </tr>
    <tr>
        <td style="padding: 10px 10px; width: 25%; border: 1px solid #ddd"><strong>Message:</strong></td>
        <td style="padding: 10px 10px; border: 1px solid #ddd">{!! nl2br($mailData["message"]) !!}</td>
    </tr>
</table>

<p style="color: #718096;">Regards,<br>
{{ config('app.name') }}</p>

@endcomponent
