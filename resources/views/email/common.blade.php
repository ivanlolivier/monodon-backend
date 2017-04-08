@extends('layouts.email')

@section('title')
    {{$title}}
@endsection

@section('content')
    @foreach ($introLines as $line)
        <p style="margin-top: 0; color: #74787E; font-size: 16px; line-height: 1.5em; text-align: center;">
            {{ $line }}
        </p>
    @endforeach

    @if (isset($actionText))
        <table style="width: 100%; margin: 30px auto; padding: 0; text-align: center;" align="center" width="100%" cellpadding="0" cellspacing="0">
            <tr>
                <td align="center">
                    <?php
                    switch ($level) {
                        case 'success':
                            $actionColor = '#22BC66';
                            break;
                        case 'error':
                            $actionColor = '#dc4d2f';
                            break;
                        default:
                            $actionColor = '#3869D4';
                    }
                    ?>

                    <a href="{{ $actionUrl }}"
                       style="font-family: Arial, 'Helvetica Neue', Helvetica, sans-serif; display: block; display: inline-block; width: 200px; min-height: 20px; padding: 10px;
                               border-radius: 3px; color: #ffffff; font-size: 15px; line-height: 25px; text-align: center; text-decoration: none;
                               -webkit-text-size-adjust: none; background-color: {{$actionColor}};"
                       class="button"
                       target="_blank">
                        {{ $actionText }}
                    </a>
                </td>
            </tr>
        </table>
    @endif

    @foreach ($outroLines as $line)
        <p style="margin-top: 0; color: #74787E; font-size: 16px; line-height: 1.5em; text-align: center;">
            {{ $line }}
        </p>
    @endforeach
@endsection
