@extends(Config::get("sentry-manager::layouts.auth"))

@section("title")
Login
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

    <div class="form-group">
        {{ Form::label("password", null, [
        "class" => "form-label"
        ]) }}

        {{ Form::password("password", [
        "class" => "form-control"
        ]) }}
    </div>

    <div class="form-group">
        <label class="form-label">
            {{ Form::checkbox("remember", 1, false) }} Remember Me?
        </label>
    </div>

    <button class="btn btn-primary pull-right">Log In</button>

    {{ link_to("sentry/register", "Need An Account?", ["class" => "btn btn-link"]) }}

    {{ link_to("sentry/forgot", "Forgot Your Password?", ["class" => "btn btn-link"]) }}

    {{ Form::close() }}
</div>
<div class="col-md-6">
    <p>Login to the site.</p>

    <p>Customize this view by running <code>php artisan view:publish kkeiper1103/sentry-manager</code>.</p>
</div>
@stop