<!DOCTYPE html>
<html lang="en">
<head>
	@include('front.app.top')
	@yield('css')
</head>
<body class="{{ Request::is('/','login','change-password', 'video','forgotpassword') ? 'body-mw-100' : '' }}">
	@yield('model')

	<!-- Header only if user not logged in -->
	@if(!auth()->guard('user')->check())
	@include('front.app.header')
	@endif
	<!-- Header only if user not logged in -->

	@yield('content')
	@include('front.app.footer')
	@yield('js')
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