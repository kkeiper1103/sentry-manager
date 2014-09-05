<div class="col-md-12">
    @foreach (\Notify::get('success') as $alert)
    <div class="alert alert-success">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        {{ $alert }}
    </div>
    @endforeach

    @foreach (\Notify::get('error') as $alert)
    <div class="alert alert-danger">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        {{ $alert }}
    </div>
    @endforeach

    @foreach (\Notify::get('info') as $alert)
    <div class="alert alert-info">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        {{ $alert }}
    </div>
    @endforeach

    @foreach (\Notify::get('warning') as $alert)
    <div class="alert alert-warning">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        {{ $alert }}
    </div>
    @endforeach
</div>