<!DOCTYPE html>
<html lang="en">

<head>
    <!-- ***** HEAD ***** -->
    @include("admin.layout.head")


    <!-- ***** CSS ***** -->
    @include("admin.layout.css")
</head>

<body>
    <div class="container-fluid position-relative d-flex p-0">

        <!-- Spinner Start -->
        @include("admin.layout.spinner")
        <!-- Spinner End -->


        <!-- Sidebar Start -->
        @include("admin.layout.sidebar")
        <!-- Sidebar End -->


        <!-- Content Start -->
        <div class="content">


            <!-- Header Start -->
            @include("admin.layout.header")
            <!-- Header End -->


            <!-- Main Content Start -->
            @yield("content")
            <!-- Main Content End -->


            <!-- Footer Start -->
            @include("admin.layout.footer")
            <!-- Footer End -->

        </div>
        <!-- Content End -->


        <!-- Back to Top -->
        <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>
    </div>

    <!-- JavaScript Libraries -->
    @include("admin.layout.js")

</body>

</html>