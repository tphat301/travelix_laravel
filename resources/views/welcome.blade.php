<!DOCTYPE html>
<html lang="en">
<head>
    @include("partials.head")

    @include("partials.css")
</head>

<body class="preloading">
	<!-- Spinner Start -->
        <div class="bx_loader"><div class="loader"></div></div>
    <!-- Spinner End -->

<div class="super_container">
	@include('partials.header')

	{{-- @include('partials.menu') --}}

	@yield('content')

    @include("partials.footer")
</div>

@include("partials.js")

</body>

</html>