@extends('welcome')

@section('title', 'Chi tiết bài viết')


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
						<img src="{{ asset('public/backend/uploads/'.$newsBySlug->photo) }}">
						<div class="blog_post_date d-flex flex-column align-items-center justify-content-center">
							<div class="blog_post_day">{{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $newsBySlug->created_at)->format('d') }}</div>
							<div class="blog_post_month">{{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $newsBySlug->created_at)->format('m/Y') }}</div>
						</div>
					</div>
					<div class="blog_post_title"><span>{{$newsBySlug->name}}</span></div>
					<div class="blog_post_text">
						<strong>Mô tả: </strong>
						<p>{!! $newsBySlug->desc !!}</p>
					</div>
					<div class="blog_post_text">
						<strong>Nội dung: </strong>
						<p>{!! $newsBySlug->content !!}</p>
					</div>
				</div>
			</div>
        </div>
    </div>
@endsection