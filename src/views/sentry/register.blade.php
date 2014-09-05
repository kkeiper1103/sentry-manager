@extends(Config::get("sentry-manager::layouts.auth"))

@section("title")
Register New User
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
        {{ Form::label("password_confirmation", null, [
        "class" => "form-label"
        ]) }}

        {{ Form::password("password_confirmation", [
        "class" => "form-control"
        ]) }}
    </div>

    <div class="form-group">
        {{ Form::label("first_name", null, [
        "class" => "form-label"
        ]) }}

        {{ Form::text("first_name", null, [
        "class" => "form-control"
        ]) }}
    </div>

    <div class="form-group">
        {{ Form::label("last_name", null, [
        "class" => "form-label"
        ]) }}

        {{ Form::text("last_name", null, [
        "class" => "form-control"
        ]) }}
    </div>

    <button class="btn btn-primary pull-right">Register</button>

    {{ link_to("sentry/login", "Already Registered?", ["class" => "btn btn-link"]) }}

    {{ Form::close() }}
</div>
<div class="col-md-6">
    <p>Register for a User Account.</p>

    @if( $errors->getMessages() )
     {{ var_dump($errors->getMessages()) }}
    @endif
</div>
@stop