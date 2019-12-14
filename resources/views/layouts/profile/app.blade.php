<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->

<!-- Head BEGIN -->

<head>
    <meta charset="utf-8">
    <title>@yield('title')</title>

    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

    <meta content="Metronic Shop UI description" name="description">
    <meta content="Metronic Shop UI keywords" name="keywords">
    <meta content="keenthemes" name="author">

    <link rel="shortcut icon" href="favicon.ico">

    <!-- Fonts START -->
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700|PT+Sans+Narrow|Source+Sans+Pro:200,300,400,600,700,900&amp;subset=all"
        rel="stylesheet" type="text/css">
    <!-- Fonts END -->
    <link rel="shortcut icon" href="{{ asset(kustomisasi('logo')) }}" type="image/x-icon">

    <!-- Global styles START -->
    <link href="{{ asset('profile/plugins/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">
    <link href="{{ asset('profile/plugins/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <!-- Global styles END -->

    <!-- Page level plugin styles START -->
    <link href="{{ asset('profile/pages/css/animate.css') }}" rel="stylesheet">
    <link href="{{ asset('profile/plugins/fancybox/source/jquery.fancybox.css') }}" rel="stylesheet">
    <link href="{{ asset('profile/plugins/owl.carousel/assets/owl.carousel.css') }}" rel="stylesheet">
    <!-- Page level plugin styles END -->

    <!-- Theme styles START -->
    <link href="{{ asset('profile/pages/css/components.css') }}" rel="stylesheet">
    <link href="{{ asset('profile/pages/css/slider.css') }}" rel="stylesheet">
    <link href="{{ asset('profile/corporate/css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('profile/corporate/css/style-responsive.css') }}" rel="stylesheet">
    <link href="{{ asset('profile/corporate/css/themes/blue.css') }}" rel="stylesheet" id="style-color">
    <link href="{{ asset('profile/corporate/css/custom.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/profile.css') }}">
    @stack('css')
    <!-- Theme styles END -->
</head>
<!-- Head END -->

<!-- Body BEGIN -->

<body class="corporate">

    @include('layouts.profile.nav')

    @yield('pre-main')
    
    <div class="main">

        <div class="container{{ isset($fullwidth) && $fullwidth ? '-fluid' : '' }}">

            @yield('content')

        </div>

    </div>

    @include('layouts.profile.footer')

    <!-- Load javascripts at bottom, this will reduce page load time -->
    <!-- BEGIN CORE PLUGINS (REQUIRED FOR ALL PAGES) -->
    <!--[if lt IE 9]>
    <script src="profile/plugins/respond.min.js"></script>
    <![endif]-->
    <script src="{{ asset('profile/plugins/jquery.min.js' ) }}" type="text/javascript"></script>
    <script src="{{ asset('profile/plugins/jquery-migrate.min.js' ) }}" type="text/javascript"></script>
    <script src="{{ asset('profile/plugins/bootstrap/js/bootstrap.min.js' ) }}" type="text/javascript"></script>

    <!-- BEGIN PAGE LEVEL JAVASCRIPTS (REQUIRED ONLY FOR CURRENT PAGE) -->
    <script src="{{ asset('profile/plugins/fancybox/source/jquery.fancybox.pack.js' ) }}" type="text/javascript"></script>
    <!-- pop up -->
    <script src="{{ asset('profile/plugins/owl.carousel/owl.carousel.min.js' ) }}" type="text/javascript"></script>
    <!-- slider for products -->

    <script src="{{ asset('profile/corporate/scripts/layout.js' ) }}" type="text/javascript"></script>
    <script src="{{ asset('profile/pages/scripts/bs-carousel.js' ) }}" type="text/javascript"></script>
    <script type="text/javascript">
        jQuery(document).ready(function () {
            Layout.init();
            Layout.initOWL();
        });
    </script>
    @stack('js')
    <!-- WhatsHelp.io widget -->
    <script type="text/javascript">
        (function () {
            var options = {
                whatsapp: "{{ kustomisasi('no_telp') }}", // WhatsApp number
                call_to_action: "Message us", // Call to action
                position: "right", // Position may be 'right' or 'left'
            };
            var proto = document.location.protocol, host = "getbutton.io", url = proto + "//static." + host;
            var s = document.createElement('script'); s.type = 'text/javascript'; s.async = true; s.src = url + '/widget-send-button/js/init.js';
            s.onload = function () { 
                WhWidgetSendButton.init(host, proto, options); 
            };
            var x = document.getElementsByTagName('script')[0]; x.parentNode.insertBefore(s, x);
        })();
    </script>
    <!-- /WhatsHelp.io widget -->
    <!-- END PAGE LEVEL JAVASCRIPTS -->
</body>
<!-- END BODY -->

</html>