@component('mail::message')

<h1 style="color: #3d4852; font-size: 18px;">Dear {!! $mailData["to_name"] !!}!</h1>

<p style="color: #718096;">{!! $mailData["message"] !!}</p>

<table cellpadding="0" cellspacing="0" style="width: 100%; border-bottom: 1px solid #e8e5ef; padding-bottom: 25px; margin-bottom: 25px;">
    <tr>
        <td style="padding: 10px 10px; width: 25%; border: 1px solid #ddd"><strong>Plan Summary:</strong></td>
        <td style="padding: 10px 10px; border: 1px solid #ddd">{!! $mailData["plan_summary"] !!}</td>
    </tr>
    <tr>
        <td style="padding: 10px 10px; width: 25%; border: 1px solid #ddd"><strong>Start Date:</strong></td>
        <td style="padding: 10px 10px; border: 1px solid #ddd">{!! $mailData["start_date"] !!}</td>
    </tr>
    <tr>
        @if ($mailData["is_recurring"] == 'Yes')
        <td style="padding: 10px 10px; width: 25%; border: 1px solid #ddd"><strong>Next Billing Date:</strong></td>
        @else
        <td style="padding: 10px 10px; width: 25%; border: 1px solid #ddd"><strong>Expiry Date:</strong></td>
        @endif
        <td style="padding: 10px 10px; border: 1px solid #ddd">{!! $mailData["expiry_date"] !!}</td>
    </tr>
    <tr>
        <td style="padding: 10px 10px; width: 25%; border: 1px solid #ddd"><strong>Amount:</strong></td>
        <td style="padding: 10px 10px; border: 1px solid #ddd">{!! $mailData["amount"] !!}</td>
    </tr>
    <tr>
        <td style="padding: 10px 10px; width: 25%; border: 1px solid #ddd"><strong>Is Recurring?:</strong></td>
        <td style="padding: 10px 10px; border: 1px solid #ddd">{!! $mailData["is_recurring"] !!}</td>
    </tr>
    @if (isset($mailData["payment_method"]))
    <tr>
        <td style="padding: 10px 10px; width: 25%; border: 1px solid #ddd"><strong>Payment Method:</strong></td>
        <td style="padding: 10px 10px; border: 1px solid #ddd">{!! $mailData["payment_method"] !!}</td>
    </tr>
    @endif
    @if (isset($mailData["payment_id"]))
    <tr>
        <td style="padding: 10px 10px; width: 25%; border: 1px solid #ddd"><strong>Payment ID:</strong></td>
        <td style="padding: 10px 10px; border: 1px solid #ddd">{!! $mailData["payment_id"] !!}</td>
    </tr>
    @endif

</table>

<p style="color: #718096;">Regards,<br>
{{ config('app.name') }}</p>

@endcomponent
