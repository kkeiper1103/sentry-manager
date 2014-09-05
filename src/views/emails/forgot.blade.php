@extends('sentry-manager::emails.layout')

@section('title')
Password Reset
@stop

@section('main')
<h1 style="font-weight: bold; font-size: 36px; line-height: 1.1; color: #000; margin: 0;">
    Password Reset
</h1>

<p>To reset your password, complete this form:</p>

<a href='{{ url("sentry/reset/{$user->id}/{$token}") }}' style="display:inline-block;padding: 10px 16px;margin-bottom: 0;font-size: 16px;font-weight: normal;line-height: 1.428571429;text-align: center;white-space: nowrap;vertical-align: middle;cursor: pointer;background-image: none;border: 1px solid rgba(0, 0, 0, 0);border-radius: 4px;color: #FFF;background-color: #428BCA;border-color: #357EBD;text-decoration: none;">Reset your password</a>

<br>
<br>
@stop