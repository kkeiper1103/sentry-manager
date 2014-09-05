@extends(Config::get("sentry-manager::layouts.auth"))

@section("title")
Reset Your Password
@stop

@section("content")
<div class="col-md-6">
    {{ Form::open([
    "method" => "post"
    ]) }}

    <div class="form-group">
        {{ Form::label("password", "New Password", [
        "class" => "form-label"
        ]) }}

        {{ Form::password("password", [
        "class" => "form-control"
        ]) }}
    </div>

    <div class="form-group">
        {{ Form::label("password_confirmation", null, [
        "class" => "form-label"
        ]) }}

        {{ Form::password("password_confirmation", [
        "class" => "form-control"
        ]) }}
    </div>

    <button class="btn btn-primary pull-right">Reset Password</button>

    {{ link_to("sentry/login", "Return to Login", ["class" => "btn btn-link"]) }}

    {{ Form::close() }}
</div>
<div class="col-md-6">
    <p>Reset Your Password</p>

    <p>Customize this view by running <code>php artisan view:publish kkeiper1103/sentry-manager</code>.</p>
</div>
@stop