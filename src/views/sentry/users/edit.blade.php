@extends( Config::get("sentry-manager::layouts.admin") )

@section("title")
Editing {{ $user->{Config::get("cartalyst/sentry::users.login_attribute")} }}
@stop

@section("content")
<div class="col-md-12">
    <h2>Editing {{ $user->{Config::get("cartalyst/sentry::users.login_attribute")} }}</h2>

    @include(
    "sentry-manager::sentry.users._form",
    array("user" => $user)
    )

</div>
@stop