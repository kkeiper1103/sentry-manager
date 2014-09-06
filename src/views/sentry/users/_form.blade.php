@if( $user->exists )
{{ Form::model($user, [
    "route" => [ "{$url_base}.users.update", $user->id ],
    "method" => "patch"
]) }}
@else
{{ Form::model($user, [
    "route" => [ "{$url_base}.users.store" ],
    "method" => "post"
]) }}
@endif

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

<div class="form-group">
    <label>
        {{ Form::hidden("activated", 0) }}
        {{ Form::checkbox("activated", 1) }} Activated
    </label>
</div>

@if( Sentry::getUser()->hasAccess("admin.roles") )
<div class="form-group">
    <label class="form-label">User Groups</label>

    @if($user->isSuperUser())
    <p class="text-info bg-info alert">User is a Super User. Groups Will Have No Effect on This User.</p>
    @endif

    <div class="container">
        <div class="row">
            @foreach(Sentry::findAllGroups() as $g)
            <div class="col-xs-6 col-sm-3">
                <label>
                    {{ Form::hidden("groups[$g->id]", 0) }}
                    {{ Form::checkbox("groups[$g->id]", 1, $user->inGroup( $g )) }} {{ $g->name }}
                </label>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endif

{{ link_to_route("{$url_base}.users.index", "Back", null, [
    "class" => "btn btn-warning"
]) }}

<button class="btn btn-primary">Save User</button>

{{ Form::close() }}