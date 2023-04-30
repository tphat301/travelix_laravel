<!DOCTYPE html>
<html lang="en">
<head>
    @include("partials.head")

    @include("partials.css")
</head>

<body>

<div class="super_container">
	
	@include('partials.header')

	{{-- @include('partials.menu') --}}

	@yield('content')

    @include("partials.footer")
</div>

@include("partials.js")

</body>

</html>