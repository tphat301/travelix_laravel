<!-- Header -->

<header class="header">

    <!-- Top Bar -->

    <div class="top_bar">
        <div class="container">
            <div class="row">
                <div class="col d-flex flex-row">
                    <div class="phone">+45 345 3324 56789</div>
                    <div class="social">
                        @if(count($links))
                            <ul class="social_list">
                                @foreach ($links as $k => $v)  
                                    @php
                                        $properties = array('fa-pinterest', 'fa-facebook', 'fa-twitter', 'fa-dribbble', 'fa-behance', 'fa-linkedin');
                                    @endphp  
                                    <li class="social_list_item"><a target="_blank" href="{{ $v->name }}" alt="{{ $v->name }}"><i class="fa {{ $properties[$k] }}" aria-hidden="true"></i></a></li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                    <div class="user_box ml-auto">
                        <div class="user_box_login user_box_link"><a href="{{ route('login') }}">{{ __('Log in') }}</a></div>
                    </div>
                </div>
            </div>
        </div>		
    </div>

    @include('partials.menu')

</header>