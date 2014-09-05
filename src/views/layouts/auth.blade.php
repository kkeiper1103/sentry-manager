<!DOCTYPE html>
<html lang="en">
<head>
    <title>@yield("title")</title>
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet" media="all" />
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet" media="all" />
    @yield("head")
</head>
<body>

<div class="container">
    <header class="row">
        <div class="col-md-12">
            <h1>Login to Site</h1>
        </div>

        @if (\Notify::all())
            @include("sentry-manager::shared._flash")
        @endif

    </header>
    <div class="row">
        @yield("content")
    </div>
</div>

<script src="//code.jquery.com/jquery-2.1.1.min.js"></script>
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css"></script>
@yield("foot")
</body>
</html>