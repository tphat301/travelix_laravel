@extends("welcome")

@section("title", "Travelix | Trang chủ")

@section("content")
<!-- Home -->

	<div class="home">
		
		@include('partials.slide')

	</div>

	<!-- Intro -->
	@if (count($categoryServiceLevel1))
        <div class="intro">
            <div class="container">
                @foreach ($categoryServiceLevel1 as $kcat1 => $vcat1)
                    <div class="category_service">
                        @if (count($categoryServiceLevel2))
                        <h2 class="intro_title text-center">{{ $vcat1->name }}</h2>
                        <p>{{ $slogan->slogan }}</p>
                            <div class="search_tabs_container mb-4">
                                <div class="search_tabs d-flex align-items-start justify-content-center">
                                    @foreach ($categoryServiceLevel2 as $kcat2 => $vcat2)
                                    @if ($vcat2->parent_id == $vcat1->id)
                                        <div class="search_tab category_lv2 d-flex align-items-center justify-content-center" data-idcat1="{{ $vcat1->id }}"  parentid2="{{$vcat2->id}}"><img src="{{ asset('public/frontend/images/'.$vcat1->photo) }}" alt="{{ $vcat2->name }}"><span>{{ $vcat2->name }}</span></div>
                                    @endif
                                    @endforeach
                                </div>
                                @if (count($services))
                                    <div class="owl-page owl-carousel owl-theme show_ser_cat" data-xsm-items="2:30" data-sm-items="2:30" data-md-items="3:30" data-lg-items="3:30" data-xlg-items="3:30" data-rewind="1" data-autoplay="1" data-loop="0" data-lazyload="0" data-mousedrag="1" data-touchdrag="1" data-smartspeed="500" data-autoplayspeed="3500" data-dots="0" data-nav="0" data-navtext="<svg xmlns='https://www.w3.org/2000/svg' class='icon icon-tabler icon-tabler-chevron-left' width='44' height='45' viewBox='0 0 24 24' stroke-width='1.5' stroke='#2c3e50' fill='none' stroke-linecap='round' stroke-linejoin='round'><path stroke='none' d='M0 0h24v24H0z' fill='none'/><polyline points='15 6 9 12 15 18' /></svg>|<svg xmlns='https://www.w3.org/2000/svg' class='icon icon-tabler icon-tabler-chevron-right' width='44' height='45' viewBox='0 0 24 24' stroke-width='1.5' stroke='#2c3e50' fill='none' stroke-linecap='round' stroke-linejoin='round'><path stroke='none' d='M0 0h24v24H0z' fill='none'/><polyline points='9 6 15 12 9 18' /></svg>" data-navcontainer=".control-pronb">
                                        @foreach ($services as $k => $v)
                                            @if ($v->parent_id1 == $vcat1->id) 
                                                <div class="intro_col service_ajax">
                                                    <div class="intro_item">
                                                        <div class="intro_item_overlay"></div>
                                                        <div class="intro_item_background" style="background-image:url({{ asset('public/backend/uploads/'.$v->photo) }})"></div>
                                                        <div class="intro_item_content d-flex flex-column align-items-center justify-content-center">
                                                            <div class="intro_date">{{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $v->created_at)->format('d/m/Y H:i:s') }}</div>
                                                            <div class="button intro_button"><div class="button_bcg"></div><a href="{{ url('/order/create/'.$v->id) }}">Đăng ký dịch vụ<span></span><span></span><span></span></a></div>
                                                            <div class="intro_center text-center">
                                                                <h1 class="name_service text-split">{{ $v->name }}</h1>
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
                                            @endif
                                        @endforeach
                                    </div>
                                @endif	
                                <div class="load_ajax_service load_ajax_service-{{ $vcat1->id }}" data-idcat1="{{ $vcat1->id }}"></div>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    @if (count($news))  
        <div class="offers">
            <div class="container">
                <div class="row">
                    <div class="col text-center">
                        <h2 class="section_title">Tin tức</h2>
                    </div>
                </div>
                <div class="row offers_items">
                    <!-- Offers Item -->
                    @foreach ($news as $k => $v)
                        @if ($k >= 0 && $k < 4)
                            <div class="col-lg-6 offers_col">
                                <div class="offers_item">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="offers_image_container">
                                                <a href="{{ route('news.show', $v->slug) }}" class="offers_image_background" style="background-image:url({{ asset('public/backend/uploads/'.$v->photo) }}); max-width: 255px;"></a>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="offers_content">
                                                <a class="news_title" href="{{ route('news.show', $v->slug) }}">{{ $v->name }}</a><br>
                                                <span class="news_created">Ngày tạo: {{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $v->created_at)->format('d/m/Y H:i:s') }}</span>
                                                <div class="offers_text text-split">{!! $v->desc !!}</div>
                                                <div class="offers_icons">
                                                    <ul class="offers_icons_list">
                                                        <li class="offers_icons_item"><img src="{{ asset('public/frontend/images/post.png') }}" alt=""></li>
                                                        <li class="offers_icons_item"><img src="{{ asset('public/frontend/images/compass.png') }}" alt=""></li>
                                                        <li class="offers_icons_item"><img src="{{ asset('public/frontend/images/bicycle.png') }}" alt=""></li>
                                                        <li class="offers_icons_item"><img src="{{ asset('public/frontend/images/sailboat.png') }}" alt=""></li>
                                                    </ul>
                                                </div>
                                                <div class="offers_link"><a href="tin-tuc">Xem thêm</a></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
    @endif


    @if (count($criteria))    
        <div class="testimonials">
            <div class="test_border"></div>
            <div class="container">
                <div class="row">
                    <div class="col text-center">
                        <h2 class="section_title">Nhận xét từ khách hàng</h2>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <div class="test_slider_container">
                            <div class="owl-carousel owl-theme test_slider">
                                @foreach ($criteria as $k => $v)
                                    <!-- Testimonial Item -->
                                    <div class="owl-item">
                                        <div class="test_item">
                                            <div class="test_image"><img src="{{ asset('public/backend/uploads/'.$v->photo) }}" alt="{{ $v->photo }}"></div>
                                            <div class="test_icon"><img src="{{ asset('public/backend/uploads/'.$v->photo1) }}" alt="{{ $v->photo1 }}"></div>
                                            <div class="test_content_container">
                                                <div class="test_content">
                                                    <div class="test_item_info">
                                                        <div class="test_name">{{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $v->created_at)->format('d/m,Y') }}</div>
                                                    </div>
                                                    <div class="test_quote_title">" {{ $v->name }} "</div>
                                                    <p class="test_quote_text">{!! $v->desc !!}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <!-- Testimonials Slider Nav - Prev -->
                            <div class="test_slider_nav test_slider_prev">
                                <svg version="1.1" id="Layer_6" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                    width="28px" height="33px" viewBox="0 0 28 33" enable-background="new 0 0 28 33" xml:space="preserve">
                                    <defs>
                                        <linearGradient id='test_grad_prev'>
                                            <stop offset='0%' stop-color='#fa9e1b'/>
                                            <stop offset='100%' stop-color='#8d4fff'/>
                                        </linearGradient>
                                    </defs>
                                    <path class="nav_path" fill="#F3F6F9" d="M19,0H9C4.029,0,0,4.029,0,9v15c0,4.971,4.029,9,9,9h10c4.97,0,9-4.029,9-9V9C28,4.029,23.97,0,19,0z
                                    M26,23.091C26,27.459,22.545,31,18.285,31H9.714C5.454,31,2,27.459,2,23.091V9.909C2,5.541,5.454,2,9.714,2h8.571
                                    C22.545,2,26,5.541,26,9.909V23.091z"/>
                                    <polygon class="nav_arrow" fill="#F3F6F9" points="15.044,22.222 16.377,20.888 12.374,16.885 16.377,12.882 15.044,11.55 9.708,16.885 11.04,18.219 
                                    11.042,18.219 "/>
                                </svg>
                            </div>
                            
                            <!-- Testimonials Slider Nav - Next -->
                            <div class="test_slider_nav test_slider_next">
                                <svg version="1.1" id="Layer_7" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                width="28px" height="33px" viewBox="0 0 28 33" enable-background="new 0 0 28 33" xml:space="preserve">
                                    <defs>
                                        <linearGradient id='test_grad_next'>
                                            <stop offset='0%' stop-color='#fa9e1b'/>
                                            <stop offset='100%' stop-color='#8d4fff'/>
                                        </linearGradient>
                                    </defs>
                                <path class="nav_path" fill="#F3F6F9" d="M19,0H9C4.029,0,0,4.029,0,9v15c0,4.971,4.029,9,9,9h10c4.97,0,9-4.029,9-9V9C28,4.029,23.97,0,19,0z
                                M26,23.091C26,27.459,22.545,31,18.285,31H9.714C5.454,31,2,27.459,2,23.091V9.909C2,5.541,5.454,2,9.714,2h8.571
                                C22.545,2,26,5.541,26,9.909V23.091z"/>
                                <polygon class="nav_arrow" fill="#F3F6F9" points="13.044,11.551 11.71,12.885 15.714,16.888 11.71,20.891 13.044,22.224 18.379,16.888 17.048,15.554 
                                17.046,15.554 "/>
                                </svg>
                            </div>

                        </div>
                        
                    </div>
                </div>

            </div>
        </div>
    @endif

	<div class="contact">
		<div class="contact_background" style="background-image:url({{ asset('public/frontend/images/contact.png') }})"></div>

		<div class="container">
			<div class="row">
				<div class="col-lg-5">
					<div class="contact_image">
						
					</div>
				</div>
				<div class="col-lg-7">
					<div class="contact_form_container">
						<div class="contact_title">Liên hệ với chúng tôi</div>
						<form action="{{ url('newsletter/store') }}" id="contact_form" class="contact_form" method="POST">
                            @csrf
							<input type="text" id="contact_form_name" name="fullname" class="contact_form_name input_field" placeholder="Họ và tên" required>
							<input type="text" id="contact_form_email" name="email" class="contact_form_email input_field" placeholder="E-mail" required>
							<input type="number" id="contact_form_subject" name="phone" class="contact_form_subject input_field" placeholder="Số điện thoại" required>
							<input type="text" id="contact_form_subject" name="address" class="contact_form_subject input_field" placeholder="Địa chỉ" required>
							<textarea id="contact_form_message" name="notes" class="text_field contact_form_message" name="message" rows="4" placeholder="Ghi chú"></textarea>
							<button type="submit" id="form_submit_button" name="btn-newsletter" class="form_submit_button button">Đăng ký<span></span><span></span><span></span></button>
						</form>
					</div>  
				</div>
			</div>
		</div>
	</div>
@endsection





