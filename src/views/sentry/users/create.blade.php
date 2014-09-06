@extends( Config::get("sentry-manager::layouts.admin") )

@section("title")
Create New User
@stop

@section("content")
<div class="col-md-12">
    <h2>Create New User</h2>

    @include(
        "sentry-manager::sentry.users._form",
        array("user" => $user, "url_base" => $url_base)
    )

</div>
@stop