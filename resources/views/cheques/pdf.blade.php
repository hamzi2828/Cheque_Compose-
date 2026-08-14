@php
    /** @var \App\Models\Cheque $cheque */
    $client = $cheque->client;
    $bank   = $cheque->bank;
    $payee  = $cheque->payee;

    $chequeNo = (string) $cheque->cheque_number;
    $amount   = '$' . number_format((float) $cheque->amount, 2);

    // "One Thousand One Hundred Forty and 76/100 Dollars****..." per the reference PDF
    $words     = $cheque->amountInWords() . ' Dollars';
    $wordsLine = $words . str_repeat('*', max(0, 76 - strlen($words)));

    // MICR E-13B line (micrenc font): C = on-us, A = transit.
    // Cheque number gets two leading zeros, e.g. 1709 -> 001709.
    $micr = 'C00' . $chequeNo . 'C  A' . $bank->routing_number . 'A  ' . ($bank->bank_account_number ?: '') . 'C';

    $clientCityLine = trim(implode(', ', array_filter([$client->city, $client->state])) . ' ' . $client->zip_code);
    $bankCityLine   = trim(implode(', ', array_filter([$bank->city, $bank->state])) . ' ' . $bank->zip_code);
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <style>
        body {
            font-family: sans-serif;
            font-size: 9.5pt;
            color: #000;
        }

        .cheque-block { height: 88mm; }

        .notice-heading {
            font-size: 21pt;
            font-weight: bold;
            text-align: center;
            margin: 0 0 1mm 0;
        }

        .notice-subheading {
            font-size: 9pt;
            font-weight: bold;
            text-align: center;
            margin: 0 0 2mm 0;
        }

        table { border-collapse: collapse; width: 100%; }
        td    { vertical-align: top; padding: 0; }

        .party-block  { text-align: center; line-height: 1.35; }
        .party-name   { font-weight: bold; font-size: 10.5pt; }

        .cheque-no    { font-size: 13pt; font-weight: bold; text-align: right; }
        .fraction     { font-size: 8pt; text-align: right; }
        .cheque-date  { font-size: 10pt; text-align: right; margin-top: 2.5mm; }

        .pay-line     { margin-top: 8mm; font-size: 10pt; }
        .pay-label    { font-weight: bold; }
        .payee-name   { font-weight: bold; font-size: 10.5pt; }

        .words-row td {
            border-bottom: 0.3mm solid #000;
            font-weight: bold;
            font-size: 10pt;
            padding-bottom: 0.5mm;
        }
        .words-amount { text-align: right; white-space: nowrap; }

        .deposit-only { font-size: 13pt; margin-top: 2mm; }
        .us-funds     { font-size: 7.5pt; margin-top: 1mm; }

        .auth-text    { font-size: 8.5pt; line-height: 1.35; }
        .auth-signature {
            font-weight: bold;
            font-size: 9.5pt;
            border-bottom: 0.3mm solid #000;
            padding-bottom: 0.5mm;
        }

        .memo-label   { font-weight: bold; font-size: 8.5pt; }
        .memo-value   { font-size: 9.5pt; border-bottom: 0.2mm solid #000; }
        .memo-plain   { font-size: 9.5pt; }

        .micr {
            font-family: micrenc;
            font-size: 13pt;
            margin-top: 6mm;
        }

        .not-negotiable {
            font-size: 17pt;
            font-weight: bold;
            text-align: center;
            margin-top: 2mm;
        }
    </style>
</head>
<body>

@foreach([
    ['heading' => null,                              'subheading' => null],
    ['heading' => 'CHECK AUTHORIZATION NOTICE',      'subheading' => 'Send This Copy To Your Client'],
    ['heading' => 'CHECK AUTHORIZATION NOTICE SENT', 'subheading' => 'Keep This Copy For Your Records'],
] as $copy)
    @php($isCheque = $copy['heading'] === null)

    <div class="cheque-block">
        @if($copy['heading'])
            <div class="notice-heading">{{ $copy['heading'] }}</div>
            <div class="notice-subheading">{{ $copy['subheading'] }}</div>
        @endif

        <!-- Header: client | bank | cheque no + date -->
        <table>
            <tr>
                <td width="40%" class="party-block">
                    <span class="party-name">{{ $client->company_name }}</span><br>
                    @if($client->address_1){{ $client->address_1 }}<br>@endif
                    @if($client->address_2){{ $client->address_2 }}<br>@endif
                    @if($clientCityLine){{ $clientCityLine }}<br>@endif
                    @if($client->contact_no ?: $client->phone){{ $client->contact_no ?: $client->phone }}@endif
                </td>
                <td width="38%" class="party-block">
                    <span class="party-name">{{ $bank->bank_name }}</span><br>
                    @if($bank->address_1){{ $bank->address_1 }}<br>@endif
                    @if($bank->address_2){{ $bank->address_2 }}<br>@endif
                    @if($bankCityLine){{ $bankCityLine }}<br>@endif
                    @if($bank->phone){{ $bank->phone }}@endif
                </td>
                <td width="22%">
                    <div class="cheque-no">{{ $chequeNo }}</div>
                    @if($bank->bank_account_number)
                        <div class="fraction">{{ $bank->bank_account_number }}</div>
                    @endif
                    <div class="cheque-date">{{ $cheque->cheque_date->format('m/d/Y') }}</div>
                </td>
            </tr>
        </table>

        <!-- Payee -->
        <div class="pay-line">
            <span class="pay-label">Pay To The Order Of:</span>&nbsp;&nbsp;
            <span class="payee-name">{{ $payee?->name }}</span>
        </div>

        <!-- Amount in words + figures on one underlined line -->
        <table style="margin-top: 2.5mm;">
            <tr class="words-row">
                <td>{{ $wordsLine }}</td>
                <td width="14%" class="words-amount">{{ $amount }}</td>
            </tr>
        </table>

        @if($isCheque)
            <div class="deposit-only">FOR DEPOSIT ONLY</div>

            <table style="margin-top: 3mm;">
                <tr>
                    <td width="48%"></td>
                    <td width="52%" class="auth-text">
                        Payment authorized by accountholder. Indemnification
                        agreement provided by:&nbsp; {{ $payee?->name }}<br>
                        <span class="auth-signature">Signature Not Required Per Agreement</span>
                    </td>
                </tr>
            </table>

            <table style="margin-top: 2mm;">
                <tr>
                    <td width="7%" class="memo-label">Memo:</td>
                    <td width="45%" class="memo-value">{{ $cheque->memo }}</td>
                    <td width="48%"></td>
                </tr>
            </table>

            <div class="micr">{{ $micr }}</div>
        @else
            <div class="us-funds">Payable In U.S. Funds</div>

            <table>
                <tr>
                    <td width="35%"></td>
                    <td width="65%" class="not-negotiable">NOT-NEGOTIABLE</td>
                </tr>
            </table>

            <table style="margin-top: 3mm;">
                <tr>
                    <td width="7%" class="memo-label">Memo:</td>
                    <td width="45%" class="memo-plain">{{ $cheque->memo }}</td>
                    <td width="48%"></td>
                </tr>
            </table>
        @endif
    </div>
@endforeach

</body>
</html>
