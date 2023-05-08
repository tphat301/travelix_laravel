<!-- Header -->
@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fa fa-exclamation-circle me-2"></i><strong>{{ session('success') }}</strong>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif
<header class="header">

    <!-- Top Bar -->

    <div class="top_bar">
        <div class="container">
            <div class="row">
                <div class="col d-flex flex-row">
                    <div class="phone">+{{ preg_replace('/[^0-9]/', '', $settingConvert['call']); }}</div>
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
                    
                    <div class="user_box ml-auto d-flex">
                        <div class="user_box_login user_box_link mr-3"><a href="{{ route('login') }}">{{ __('Log in') }}</a></div>
                        <div id="translate_select"></div>
                    </div>
                </div>
            </div>
        </div>		
    </div>

    @include('partials.menu')

</header>