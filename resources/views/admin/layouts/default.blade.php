<!DOCTYPE html>
<html lang="en">

@include('admin.layouts.header')

<body>
    <div class="wrapper">

        @include('admin.layouts.topnavbar')

        @include('admin.layouts.sidebar')
        <style type="text/css">
            .wrapper .section-container.message_sec{
                margin-bottom: 5px!important;
            }
        </style>
        <div class="section-container message_sec" style="height: auto;padding: 10px;">
            @include('admin.includes.flash-message')
        </div>
        @yield('content')

        <!-- Page footer-->
        <footer class="footer-container">
            <p>{{get_settings('copyright_text') ?? 'Copyright Text'}}</p>
        </footer>
    </div>

    @include('admin.layouts.footer')

    <script>
        $(document).on('hidden.bs.modal', function (e) {
            $(e.target).removeData('bs.modal');
        });
    </script>

    <script type="text/javascript">
        @if(Session::has('message'))
        var type = "{{ Session::get('alert-type', 'info') }}";
        switch (type) {
            case 'info':
            toastr.info("{{ Session::get('message') }}");
            break;

            case 'warning':
            toastr.warning("{{ Session::get('message') }}");
            break;

            case 'success':
            toastr.success("{{ Session::get('message') }}");
            break;

            case 'error':
            toastr.error("{{ Session::get('message') }}");
            break;
        }
        @endif
    </script>

    <script>

    </script>

</body>

<!-- Loader Start -->
<style type="text/css">
    .lds-grid {
        position: fixed;
        z-index: 1111;
        left: 0;
        right: 0;
        top: 0;
        bottom: 0;
        margin: auto;
        width: 70px;
        height: 70px;
        text-align: center;
    }
    .lds-grid div {
        position: absolute;
        width: 16px;
        height: 16px;
        border-radius: 50%;
        background: #00aee8;
        animation: lds-grid 1.2s linear infinite;
    }
    .lds-grid div:nth-child(1) {
        top: 8px;
        left: 8px;
        animation-delay: 0s;
    }
    .lds-grid div:nth-child(2) {
        top: 8px;
        left: 32px;
        animation-delay: -0.4s;
    }
    .lds-grid div:nth-child(3) {
        top: 8px;
        left: 56px;
        animation-delay: -0.8s;
    }
    .lds-grid div:nth-child(4) {
        top: 32px;
        left: 8px;
        animation-delay: -0.4s;
    }
    .lds-grid div:nth-child(5) {
        top: 32px;
        left: 32px;
        animation-delay: -0.8s;
    }
    .lds-grid div:nth-child(6) {
        top: 32px;
        left: 56px;
        animation-delay: -1.2s;
    }
    .lds-grid div:nth-child(7) {
        top: 56px;
        left: 8px;
        animation-delay: -0.8s;
    }
    .lds-grid div:nth-child(8) {
        top: 56px;
        left: 32px;
        animation-delay: -1.2s;
    }
    .lds-grid div:nth-child(9) {
        top: 56px;
        left: 56px;
        animation-delay: -1.6s;
    }
    @keyframes lds-grid {
        0%, 100% {
            opacity: 1;
        }
        50% {
            opacity: 0.5;
        }
    }

    .sub-loader {
        position: fixed;
        z-index: 1111;
        left: 0;
        right: 0;
        top: 0;
        bottom: 0;
        margin: auto;
        background-color: rgba(255, 255, 255, 0.8);
        text-align: center;
    }
    .sub-loader img {
        position: fixed;
        left: 0;
        right: 0;
        top: 0;
        bottom: 0;
        margin: auto;
        width: 70px;
        height: 70px;
    }

</style>
<div class="sub-loader">
    <div class="lds-grid"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>
</div>
<script type="text/javascript">
    $(window).on("load", function (e) {
        $('.sub-loader').hide();
    });
    $.ajaxSetup({
        beforeSend: myFunc,
        complete: myCompleteFunc
    });
    function myFunc()
    {
        $('.sub-loader').show();
    }
    function myCompleteFunc()
    {
        $('.sub-loader').hide();
    }
</script>
<!-- Loader End -->

</html>
