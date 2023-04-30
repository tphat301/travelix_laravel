@extends('admin.index')

@section('title', 'Dashboard')

@section('content')


        <div class="container-fluid pt-4 px-4">
            {!! $chart->container() !!}
        </div>


    @include("admin.layout.chart")


@endsection