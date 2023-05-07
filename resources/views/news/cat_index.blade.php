@extends('welcome')

@section('title', 'Danh mục tin tức')


@section('content')
    <!-- Home -->
	<div class="home">
		
		@include('partials.slide')

	</div>

	<!-- Intro -->

    @if ($newsBySlug->total() > 1)
        <div class="service pad-top-bottom">
            <div class="container">
                <div class="intro_items loads" data-aos="fade-up" data-aos-delay="300">
                        <!-- Intro Item -->
                        @foreach ($newsBySlug as $k => $v)
                            <div class="intro_col load">
                                <div class="intro_item">
                                    <div class="intro_item_overlay"></div>
                                    <div class="intro_item_background" style="background-image:url({{ asset('public/backend/uploads/'.$v->photo) }})"></div>
                                    <div class="intro_item_content d-flex flex-column align-items-center justify-content-center">
                                        <div class="intro_date">{{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $v->created_at)->format('d/m/Y H:i:s') }}</div>
                                        <div class="intro_center text-center">
                                            <a href="{{route('service.show', $v->slug)}}" class="name_service text-split">{{ $v->name }}</a>
                                            <div class="intro_price">Giá: {{ number_format($v->price, 0,",",".") }}VND</div>
                                            <div class="rating rating_4">
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                </div>
            </div>
        </div>
    @endif
@endsection