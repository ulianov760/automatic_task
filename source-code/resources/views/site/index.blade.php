<?php

?>
    <!DOCTYPE html>
<html class="desktop mbr-site-loaded" style=""><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">


    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1">
    <title>Создать страницу с полями пароля, почты и кнопкой резервного копирования</title>
    <link rel="stylesheet" href="{{asset('css/mobirise2.css')}}">
    <link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/bootstrap-grid.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/bootstrap-reboot.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/style.css')}}">
    <link rel="stylesheet" href="{{asset('css/styles.css')}}">
    <link rel="stylesheet" href="{{asset('css/style(1).css')}}">
    <noscript><link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto+Flex:wght@400;700&display=swap&display=swap"></noscript>
    <link rel="stylesheet" href="{{asset('css/mbr-additional.css')}}" type="text/css">
    <style>
        .navbar-fixed-top {
            top: auto;
        }
        #mobirisePromo.container-banner {
            height: 11rem;
            opacity: 1;
            -webkit-animation: 11s linear animationHeight;
            -moz-animation: 11s linear animationHeight;
            -o-animation: 11s linear animationHeight;
            animation: 11s linear animationHeight;
            transition: all  0.5s;
        }
        #mobirisePromo.container-banner.container-banner-closing {
            pointer-events: none;
            height: 0;
            opacity: 0;
            -webkit-animation: 0.5s linear animationClosing;
            -moz-animation:  0.5s linear animationClosing;
            -o-animation:  0.5s linear animationClosing;
            animation:  0.5s linear animationClosing;
        }
        #mobirisePromo .banner {
            min-height: 11rem;
            position:fixed;
            top: 0;
            left: 0;
            right: 0;
            background: #fff;
            padding: 10px;
            opacity:1;
            -webkit-animation: 11s linear animationBanner;
            -moz-animation: 11s linear animationBanner;
            -o-animation: 11s linear animationBanner;
            animation: 11s linear animationBanner;
            z-index: 1031;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        #mobirisePromo .banner p {
            overflow: hidden;
            display: -webkit-box;
            -webkit-line-clamp: 4;
            -webkit-box-orient: vertical;
            animation: none;
            visibility: visible;
        }
        #mobirisePromo .buy-license {
            text-decoration: underline;
        }
        #mobirisePromo .banner .btn {
            margin: 0.3rem 0.5rem;
            animation: none;
            visibility: visible;
        }
        .navbar.opened {
            z-index: 1032;
        }
        #mobirisePromo .mbr-section-abuse-report {
            margin-top: 0.8rem;
            font-size: 80%;
        }
        #mobirisePromo .mbr-section-abuse-report a {
            color: #aaa;
        }
        @-webkit-keyframes animationBanner { 0% { opacity: 0; top: -11rem; } 91% { opacity: 0; top: -11rem; } 100% { opacity: 1; top: 0; } }
        @-moz-keyframes animationBanner { 0% { opacity: 0; top: -11rem; } 91% { opacity: 0; top: -11rem; } 100% { opacity: 1; top: 0; } }
        @-o-keyframes animationBanner { 0% { opacity: 0; top: -11rem; } 91% { opacity: 0; top: -11rem; } 100% { opacity: 1; top: 0; } }
        @keyframes animationBanner { 0% { opacity: 0; top: -11rem; } 91% { opacity: 0; top: -11rem; } 100% { opacity: 1; top: 0; } }
        @-webkit-keyframes animationHeight { 0% { height: 0; } 91% { height: 0; } 100% { height: 11rem; } }
        @-moz-keyframes animationHeight { 0% { height: 0; } 91% { height: 0; } 100% { height: 11rem; } }
        @-o-keyframes animationHeight { 0% { height: 0; } 91% { height: 0; } 100% { height: 11rem; } }
        @keyframes animationHeight { 0% { height: 0; } 91% { height: 0; } 100% { height: 11rem; } }

        @-webkit-keyframes animationClosing { 0% { height: 11rem; opacity: 1; } 30% { height: 11rem; opacity: 0.5;} 100% { height: 0; opacity: 0;} }
        @-moz-keyframes animationClosing { 0% { height: 11rem; opacity: 1; } 30% { height: 11rem; opacity: 0.5;} 100% { height: 0; opacity: 0;} }
        @-o-keyframes animationClosing { 0% { height: 11rem; opacity: 1; } 30% { height: 11rem; opacity: 0.5;} 100% { height: 0; opacity: 0;} }
        @keyframes animationClosing { 0% { height: 11rem; opacity: 1; } 30% { height: 11rem; opacity: 0.5;} 100% { height: 0; opacity: 0;} }

        @media(max-width: 575px) {
            #mobirisePromo.container-banner {
                height: 14rem;
            }
            #mobirisePromo .banner {
                min-height: 14rem;
            }
            @-webkit-keyframes animationBanner { 0% { opacity: 0; top: -14rem; } 91% { opacity: 0; top: -14rem; } 100% { opacity: 1; top: 0; } }
            @-moz-keyframes animationBanner { 0% { opacity: 0; top: -14rem; } 91% { opacity: 0; top: -14rem; } 100% { opacity: 1; top: 0; } }
            @-o-keyframes animationBanner { 0% { opacity: 0; top: -14rem; } 91% { opacity: 0; top: -14rem; } 100% { opacity: 1; top: 0; } }
            @keyframes animationBanner { 0% { opacity: 0; top: -14rem; } 91% { opacity: 0; top: -14rem; } 100% { opacity: 1; top: 0; } }
            @-webkit-keyframes animationHeight { 0% { height: 0; } 91% { height: 0; } 100% { height: 14rem; } }
            @-moz-keyframes animationHeight { 0% { height: 0; } 91% { height: 0; } 100% { height: 14rem; } }
            @-o-keyframes animationHeight { 0% { height: 0; } 91% { height: 0; } 100% { height: 14rem; } }
            @keyframes animationHeight { 0% { height: 0; } 91% { height: 0; } 100% { height: 14rem; } }

            @-webkit-keyframes animationClosing { 0% { height: 14rem; opacity: 1; } 30% { height: 14rem; opacity: 0.5;} 100% { height: 0; opacity: 0;} }
            @-moz-keyframes animationClosing { 0% { height: 14rem; opacity: 1; } 30% { height: 14rem; opacity: 0.5;} 100% { height: 0; opacity: 0;} }
            @-o-keyframes animationClosing { 0% { height: 14rem; opacity: 1; } 30% { height: 14rem; opacity: 0.5;} 100% { height: 0; opacity: 0;} }
            @keyframes animationClosing { 0% { height: 14rem; opacity: 1; } 30% { height: 14rem; opacity: 0.5;} 100% { height: 0; opacity: 0;} }
        }
    </style>
</head>
<body>
<section data-bs-version="5.1" class="menu menu01 progressm5 cid-uLRILiDnQM" once="menu" id="menu-1-uLRILiDnQM">
</section>

<section data-bs-version="5.1" class="form01 progressm5 cid-uLRILlHD4M" id="contact-form-1-uLRILlHD4M">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="content-wrapper">
                    <div class="image-wrapper">
                        <img src="{{asset('img/logo-f.jpeg')}}" alt="">
                    </div>
                    <div class="content-wrap">
                        <div class="title-wrapper">
                            <h2 class="mbr-section-title mbr-fonts-style display-2">Резервное копирование</h2>
                        </div>
                        <div class="mbr-form form-wrapper" data-form-type="formoid">
                            <form action="" method="POST" class="mbr-form form-with-styler" data-form-title="Form Name">
                                <div class="dragArea row">
                                    <div class="col-lg-12 col-md-12 col-sm-12 form-group mb-3 mb-3 mb-3 mb-3 mb-3" data-for="email">
                                        <input type="email" name="email" placeholder="Email" data-form-field="email" class="form-control display-4" value="" id="email-contact-form-1-uLRILlHD4M">
                                    </div>
                                    <div class="col-lg-12 col-md-12 col-sm-12 form-group mb-3" data-for="text">
                                        <input type="password" name="text" placeholder="Пароль" data-form-field="text" class="form-control display-4" value="" id="text-contact-form-1-uLRILlHD4M">
                                    </div>
                                    <div class="col mbr-section-btn">
                                        <button type="submit" class="btn btn-primary display-4">Создать</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="footer01 progressm5 cid-uLRILlIYyw" once="footers" id="footer-1-uLRILlIYyw" style="height: 100px">
    <div class="container">
        <div class="row">
            <div class="col-12">

                <p class="mbr-copy mbr-fonts-style display-4">© 2025 Все права защищены. </p>
            </div>
        </div>
    </div>
</section>
</body></html>
