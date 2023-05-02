<div id="messages-facebook">
    <div class="js-facebook-messenger-box onApp rotate bottom-right cfm rubberBand animated" data-anim="rubberBand">
        <svg id="fb-msng-icon" data-name="messenger icon" xmlns="//www.w3.org/2000/svg" viewBox="0 0 30.47 30.66">
            <path d="M29.56,14.34c-8.41,0-15.23,6.35-15.23,14.19A13.83,13.83,0,0,0,20,39.59V45l5.19-2.86a16.27,16.27,0,0,0,4.37.59c8.41,0,15.23-6.35,15.23-14.19S38,14.34,29.56,14.34Zm1.51,19.11-3.88-4.16-7.57,4.16,8.33-8.89,4,4.16,7.48-4.16Z" transform="translate(-14.32 -14.34)" style="fill:#fff"></path>
        </svg>
        <svg id="close-icon" data-name="close icon" xmlns="//www.w3.org/2000/svg" viewBox="0 0 39.98 39.99">
            <path d="M48.88,11.14a3.87,3.87,0,0,0-5.44,0L30,24.58,16.58,11.14a3.84,3.84,0,1,0-5.44,5.44L24.58,30,11.14,43.45a3.87,3.87,0,0,0,0,5.44,3.84,3.84,0,0,0,5.44,0L30,35.45,43.45,48.88a3.84,3.84,0,0,0,5.44,0,3.87,3.87,0,0,0,0-5.44L35.45,30,48.88,16.58A3.87,3.87,0,0,0,48.88,11.14Z" transform="translate(-10.02 -10.02)" style="fill:#fff"></path>
        </svg>
    </div>
    <div class="js-facebook-messenger-container">
        <div class="js-facebook-messenger-top-header">
            <span>Fanpage</span>
        </div>
        <div class="fb-page" data-href="https://www.facebook.com/profile.php?id=100091970813430>" data-tabs="messages" data-small-header="true" data-height="300" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true">
            {!! $settingConvert['fanpage'] !!}
        </div>
    </div>
</div>


<a class="btn-zalo btn-frame text-decoration-none" target="_blank" href="{{ $settingConvert['zalo'] }}">
    <div class="animated infinite zoomIn kenit-alo-circle"></div>
    <div class="animated infinite pulse kenit-alo-circle-fill"></div>
    <i>
        <img class="d-block lazy loaded" alt="Zalo" src="{{ asset('public/frontend/images/zl.png') }}" data-was-processed="true">
    </i>
</a>


<a class="btn-messager btn-frame text-decoration-none" target="_blank" href="{{ $settingConvert['messager'] }}">
    <div class="animated infinite zoomIn kenit-alo-circle"></div>
    <div class="animated infinite pulse kenit-alo-circle-fill"></div>
    <i>
        <img class="d-block lazy loaded" alt="Zalo" src="{{ asset('public/frontend/images/MessengerIcon.png') }}" data-was-processed="true">
    </i>
</a>
<a class="btn-call btn-frame text-decoration-none" target="_blank" href="tel:{{ preg_replace('/[^0-9]/', '', $settingConvert['call']); }}">
    <div class="animated infinite zoomIn kenit-alo-circle"></div>
    <div class="animated infinite pulse kenit-alo-circle-fill"></div>
    <i>
        <img class="d-block lazy loaded" alt="Zalo" src="{{ asset('public/frontend/images/hl.png') }}" data-was-processed="true">
    </i>
</a>

<a class="btn-order text-decoration-none" href="{{ url('/order/index') }}">
    <svg width="20px" height="20px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M16 8H17.1597C18.1999 8 19.0664 8.79732 19.1528 9.83391L19.8195 17.8339C19.9167 18.9999 18.9965 20 17.8264 20H6.1736C5.00352 20 4.08334 18.9999 4.18051 17.8339L4.84718 9.83391C4.93356 8.79732 5.80009 8 6.84027 8H8M16 8H8M16 8L16 7C16 5.93913 15.5786 4.92172 14.8284 4.17157C14.0783 3.42143 13.0609 3 12 3C10.9391 3 9.92172 3.42143 9.17157 4.17157C8.42143 4.92172 8 5.93913 8 7L8 8M16 8L16 12M8 8L8 12" stroke="#fff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
</svg>
    <span class="count-cart">{{ Cart::count() }}</span>
</a>

<div id="animated_div" class="btn-responsive"><a href="#">Để lại lời nhắn của bạn</a></div>

<div class="scrollToTop"><img src="{{ asset('public/frontend/images/top.png') }}" alt="Go Top"></div>