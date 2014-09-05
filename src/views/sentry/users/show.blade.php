@extends( Config::get("sentry-manager::layouts.admin") )

@section("title")
User Detail: {{ $user->{ Config::get("cartalyst/sentry::users.login_attribute") } }}
@stop

@section("content")
<div class="col-md-12">
    <h2>Viewing User {{ $user->{ Config::get("cartalyst/sentry::users.login_attribute") } }}</h2>



</div>
@stop