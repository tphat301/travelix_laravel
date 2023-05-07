@extends('welcome')

@section('title', 'Dịch vụ')


@section('content')
    <!-- Home -->
	<div class="home">
		
		@include('partials.slide')

	</div>
    <div class="pad-top-bottom">
        <div class="container">
            <div class="blog_post_container">
				<div class="blog_post">
					<div class="blog_post_image">
						<img src="{{ asset('public/backend/uploads/'.$serviceBySlug->photo) }}">
						<div class="blog_post_date d-flex flex-column align-items-center justify-content-center">
							<div class="blog_post_day">{{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $serviceBySlug->created_at)->format('d') }}</div>
							<div class="blog_post_month">{{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $serviceBySlug->created_at)->format('m/Y') }}</div>
						</div>
					</div>
					<div class="blog_post_meta">
						<ul>
							<li class="blog_post_meta_item"><a href="">Giá: {{ number_format($serviceBySlug->price, 0, ',', '.') }}VND</a></li>
							<li class="blog_post_meta_item"><a href="">Giá cũ: {{ number_format($serviceBySlug->price_old, 0, ',', '.') }}VND</a></li>
							<li class="blog_post_meta_item"><a href="">Giảm: {{ $serviceBySlug->discount }}%</a></li>
						</ul>
					</div>
					<div>
						<a class="service_show-add" href="{{ route('order.create', $serviceBySlug->id) }}">Mua ngay</a>
					</div>
					<div class="blog_post_title"><a href="#">Tên dịch vụ</a></div>
					<div class="blog_post_text">
						<strong>Mô tả: </strong>
						<p>{!! $serviceBySlug->desc !!}</p>
					</div>
					<div class="blog_post_text">
						<strong>Nội dung: </strong>
						<p>{!! $serviceBySlug->content !!}</p>
					</div>
				</div>
			</div>
        </div>
    </div>
@endsection