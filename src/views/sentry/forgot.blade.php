@extends( Config::get("sentry-manager::layouts.auth") )

@section("title")
Forgot Password
@stop

@section("content")
<div class="col-md-6">
    {{ Form::open([
    "method" => "post"
    ]) }}

    <div class="form-group">
        {{ Form::label(\Config::get("cartalyst/sentry::users.login_attribute"), null, [
        "class" => "form-label"
        ]) }}

        {{ Form::text(\Config::get("cartalyst/sentry::users.login_attribute"), null, [
        "class" => "form-control"
        ]) }}
    </div>

    <button class="btn btn-primary pull-right">Reset Password</button>

    {{ link_to("sentry/login", "Login", ["class" => "btn btn-link"]) }}

    {{ Form::close() }}
</div>
<div class="col-md-6">
    <p>Forgot Your Password? We'll get you back up and running.</p>

    <p>Customize this view by running <code>php artisan view:publish kkeiper1103/sentry-manager</code>.</p>
</div>
@stop