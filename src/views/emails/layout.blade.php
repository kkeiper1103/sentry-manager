{{-- based on http://internations.github.io/antwort/ --}}
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="initial-scale=1.0">    <!-- So that mobile webkit will display zoomed in -->
    <meta name="format-detection" content="telephone=no"> <!-- disable auto telephone linking in iOS -->

    <title>@yield('title')</title>
    @include('sentry-manager::emails._styles')
</head>
<body style="margin:0; padding:0;" bgcolor="#F8F8F8" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">

<!-- 100% wrapper (grey background) -->
<table border="0" width="100%" height="100%" cellpadding="0" cellspacing="0" bgcolor="#F8F8F8">
    <tr>
        <td width="95%" align="center" valign="top" bgcolor="#F8F8F8" style="background-color: #F8F8F8;">

            <br>

            <!-- 600px container (white background) -->
            <table border="0" width="600" cellpadding="0" cellspacing="0" class="container" bgcolor="#ffffff" style="border: 1px solid #E7E7E7;">
                <tr>
                    <td class="container-padding" bgcolor="#ffffff" style="background-color: #ffffff; padding-left: 30px; padding-right: 30px; font-size: 16px; line-height: 24px; font-family: Helvetica, sans-serif; color: #333;">

                        <br>

                        <!-- ### BEGIN CONTENT ### -->

                        @section('main')

                        @show

                        <!-- ### END CONTENT ### -->

                    </td>
                </tr>
            </table>
            <!--/600px container -->

            <br>

        </td>
    </tr>
</table>
<!--/100% wrapper-->
</body>
</html>