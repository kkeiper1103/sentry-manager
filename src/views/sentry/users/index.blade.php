@extends( Config::get("sentry-manager::layouts.admin") )

@section("title")
Users Overview
@stop

@section("content")
<div class="col-md-12">
    <h2>Users Administration</h2>

    <p>
        {{ link_to_route("sentry.users.create", "Add New User", null, [
        "class" => "btn btn-primary"
        ]) }}
    </p>


    <table class="table table-hover table-striped table-bordered">
        <thead>
        <tr>
            <th>{{ ucwords(Config::get("cartalyst/sentry::users.login_attribute")) }}</th>
            <th>Name</th>
            <th>Member Since</th>
            <th>Last Login</th>
            <th>Activated</th>
            <th colspan="2">Actions</th>
        </tr>
        </thead>
        <tbody>
        @foreach($users as $u)
        <tr>
            <td>{{ $u->{Config::get("cartalyst/sentry::users.login_attribute")} }}</td>
            <td>{{ $u->first_name . " " . $u->last_name }}</td>
            <td>{{ date("M j, Y", strtotime($u->created_at)) }}</td>
            <td>{{ date("M j, Y - g:i:s A", strtotime($u->last_login)) }}</td>
            <td>{{ ($u->activated) ? "Yes" : "No (" . link_to("sentry/send-activation-email/" . $u->id, "Send Activation Email") . ")" }}</td>
            <td>{{ link_to_route("sentry.users.edit", "Edit", $u->id, ["class" => "btn btn-link"]) }}</td>
            <td>
                {{ Form::open([
                    "method" => "delete",
                    "route" => array("sentry.users.destroy", $u->id)
                ]) }}

                <button class="btn btn-link">Delete</button>

                {{ Form::close() }}
            </td>
        </tr>
        @endforeach
        </tbody>
    </table>

    <p>
        {{ link_to_route("sentry.users.create", "Add New User", null, [
        "class" => "btn btn-primary"
        ]) }}
    </p>
</div>
@stop