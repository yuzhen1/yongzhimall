<!DOCTYPE html>
<html lang="zxx">
<head>
    <meta charset="UTF-8">
    <title>应用名称 - @yield('title')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1  maximum-scale=1 user-scalable=no">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-touch-fullscreen" content="yes">
    <meta name="HandheldFriendly" content="True">

    <link rel="stylesheet" href="/css/materialize.css">
    <link rel="stylesheet" href="/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="/css/normalize.css">
    <link rel="stylesheet" href="/css/owl.carousel.css">
    <link rel="stylesheet" href="/css/owl.theme.css">
    <link rel="stylesheet" href="/css/owl.transitions.css">
    <link rel="stylesheet" href="/css/fakeLoader.css">
    <link rel="stylesheet" href="/css/animate.css">
    <link rel="stylesheet" href="/css/style.css">
    <link rel="shortcut icon" href="/img/favicon.png">


    <script src="/js/jquery-3.2.1.min.js"></script>


</head>
<body>

    <!-- navbar top -->
    <div class="navbar-top">
        <!-- site brand	 -->
        <div class="site-brand">
            <a href="index.html"><h1 style="color:pink">💗迪士尼</h1></a>
        </div>
        <!-- end site brand	 -->
        <div class="side-nav-panel-right">
            <a href="#" data-activates="slide-out-right" class="side-nav-left"><i class="fa fa-user"></i></a>
        </div>
    </div>
    <div class="side-nav-panel-right">
        <ul id="slide-out-right" class="side-nav side-nav-panel collapsible">
            <li class="profil">
                @if(session('user'))
                    <img src="img/tou.jpg" alt="">
                    <h2>{{session('user.user_name')}}</h2>
                    <a href="/logout" style="color:rebeccapurple">退出登录</a>
                @else
                    <img src="img/profile.jpg" alt="">
                    <h2><a href="/login" style="color:sandybrown">去登陆</a></h2>
                @endif
            </li>
            <li><a href="setting.html"><i class="fa fa-cog"></i>Settings</a></li>
            <li><a href="/about_us"><i class="fa fa-user"></i>About Us</a></li>
            <li><a href="contact.html"><i class="fa fa-envelope-o"></i>Contact Us</a></li>
            
            <li><a href="/login"><i class="fa fa-sign-in"></i>Login</a></li>
            <li><a href="/register"><i class="fa fa-user-plus"></i>Register</a></li>

        </ul>
    </div>

    {{--内容主体--}}
    @yield('content')

    <div class="menus" id="animatedModal2">
        <div class="close-animatedModal2 close-icon">
            <i class="fa fa-close"></i>
        </div>
        <div class="modal-content">
            <div class="container">
                <div class="row">
                    <div class="col s4">
                        <a href="index.html" class="button-link">
                            <div class="menu-link">
                                <div class="icon">
                                    <i class="fa fa-home"></i>
                                </div>
                                Home
                            </div>
                        </a>
                    </div>
                    <div class="col s4">
                        <a href="/brand" class="button-link">
                            <div class="menu-link">
                                <div class="icon">
                                    <i class="fa fa-bars"></i>
                                </div>
                                商品分类
                            </div>
                        </a>
                    </div>
                    <div class="col s4">
                        <a href="shop-single.html" class="button-link">
                            <div class="menu-link">
                                <div class="icon">
                                    <i class="fa fa-eye"></i>
                                </div>
                                Single Shop
                            </div>
                        </a>
                    </div>
                </div>
                <div class="row">
                    <div class="col s4">
                        <a href="wishlist.html" class="button-link">
                            <div class="menu-link">
                                <div class="icon">
                                    <i class="fa fa-heart"></i>
                                </div>
                                Wishlist
                            </div>
                        </a>
                    </div>
                    <div class="col s4">
                        <a href="/cart/list" class="button-link">
                            <div class="menu-link">
                                <div class="icon">
                                    <i class="fa fa-shopping-cart"></i>
                                </div>
                                购物车
                            </div>
                        </a>
                    </div>
                    <div class="col s4">
                        <a href="checkout.html" class="button-link">
                            <div class="menu-link">
                                <div class="icon">
                                    <i class="fa fa-credit-card"></i>
                                </div>
                                Checkout
                            </div>
                        </a>
                    </div>
                </div>
                <div class="row">
                    <div class="col s4">
                        <a href="blog.html" class="button-link">
                            <div class="menu-link">
                                <div class="icon">
                                    <i class="fa fa-bold"></i>
                                </div>
                                Blog
                            </div>
                        </a>
                    </div>
                    <div class="col s4">
                        <a href="blog-single.html" class="button-link">
                            <div class="menu-link">
                                <div class="icon">
                                    <i class="fa fa-file-text-o"></i>
                                </div>
                                Blog Single
                            </div>
                        </a>
                    </div>
                    <div class="col s4">
                        <a href="error404.html" class="button-link">
                            <div class="menu-link">
                                <div class="icon">
                                    <i class="fa fa-hourglass-half"></i>
                                </div>
                                404
                            </div>
                        </a>
                    </div>
                </div>
                <div class="row">
                    <div class="col s4">
                        <a href="testimonial.html" class="button-link">
                            <div class="menu-link">
                                <div class="icon">
                                    <i class="fa fa-support"></i>
                                </div>
                                Testimonial
                            </div>
                        </a>
                    </div>
                    <div class="col s4">
                        <a href="about-us.html" class="button-link">
                            <div class="menu-link">
                                <div class="icon">
                                    <i class="fa fa-user"></i>
                                </div>
                                About Us
                            </div>
                        </a>
                    </div>
                    <div class="col s4">
                        <a href="contact.html" class="button-link">
                            <div class="menu-link">
                                <div class="icon">
                                    <i class="fa fa-envelope-o"></i>
                                </div>
                                Contact
                            </div>
                        </a>
                    </div>
                </div>
                <div class="row">
                    <div class="col s4">
                        <a href="setting.html" class="button-link">
                            <div class="menu-link">
                                <div class="icon">
                                    <i class="fa fa-cog"></i>
                                </div>
                                Settings
                            </div>
                        </a>
                    </div>
                    <div class="col s4">
                        <a href="/login" class="button-link">
                            <div class="menu-link">
                                <div class="icon">
                                    <i class="fa fa-sign-in"></i>
                                </div>
                                Login
                            </div>
                        </a>
                    </div>
                    <div class="col s4">
                        <a href="register.html" class="button-link">
                        <a href="/register" class="button-link">
                            <div class="menu-link">
                                <div class="icon">
                                    <i class="fa fa-user-plus"></i>
                                </div>
                                Register
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- cart menu -->
    <div class="menus" id="animatedModal">
        <div class="close-animatedModal close-icon">
            <i class="fa fa-close"></i>
        </div>
        <div class="modal-content">
            @if($res['errno']==0)
            <div class="cart-menu">
                <div class="container">
                    <div class="content">
                        @foreach($res['data'] as $k=>$v)
                        <div class="cart-1">
                            <div class="row">
                                <div class="col s5">
                                    <img src="/img/{{$v['goods_img']}}" alt="">
                                </div>
                                <div class="col s7">
                                    <h5><a href="/goodsdetail/{{$v['goods_id']}}">{{$v['goods_name']}}</a></h5>
                                </div>
                            </div>
                            <div class="row quantity">
                                <div class="col s5">
                                    <h5>购买数量</h5>
                                </div>
                                <div class="col s7">
                                    <input value="{{$v['buy_num']}}" type="text">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col s5">
                                    <h5>单价</h5>
                                </div>
                                <div class="col s7">
                                    <h5>${{$v['goods_price']}}</h5>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col s5">
                                    <h5>总价</h5>
                                </div>
                                <div class="col s7">
                                    <h5>${{$v['goods_price']*$v['buy_num']}}</h5>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col s5">
                                    <h5>Action</h5>
                                </div>
                                <div class="col s7">
                                    <div class="action"><i class="fa fa-trash"></i></div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                        <div class="divider"></div>
                        <div class="cart-2">



                        </div>
                    </div>

                    <a href="" class="btn button-default">前往购物车</a>
                </div>
            </div>
            @else
                没有数据
            @endif
        </div>
    </div>
    <!-- end cart menu -->
    <div class="footer">
        <div class="container">
            <div class="about-us-foot">
                <h6>Mstore</h6>
                <p>is a lorem ipsum dolor sit amet, consectetur adipisicing elit consectetur adipisicing elit.</p>
            </div>
            <div class="social-media">
                <a href=""><i class="fa fa-facebook"></i></a>
                <a href=""><i class="fa fa-twitter"></i></a>
                <a href=""><i class="fa fa-google"></i></a>
                <a href=""><i class="fa fa-linkedin"></i></a>
                <a href=""><i class="fa fa-instagram"></i></a>
            </div>
            <div class="copyright">
                <span>© 2017 All Right Reserved</span>
            </div>
        </div>
    </div>
    <!-- navbar bottom -->
    <div class="navbar-bottom">
        <div class="row">
            <div class="col s2">
                <a href="/"><i class="fa fa-home"></i></a>
            </div>
            <div class="col s2">
                <a href="/collect/wishlist"><i class="fa fa-heart"></i></a>
            </div>
            <div class="col s4">
                <div class="bar-center">
                    <a href="#animatedModal" id="cart-menu"><i class="fa fa-shopping-basket"></i></a>
                    <span>2</span>
                </div>
            </div>
            <div class="col s2">
                <a href="contact.html"><i class="fa fa-envelope-o"></i></a>
            </div>
            <div class="col s2">
                <a href="#animatedModal2" id="nav-menu"><i class="fa fa-bars"></i></a>
            </div>
        </div>
    </div>
    <!-- end navbar bottom -->

<script src="/js/jquery-3.2.1.min.js"></script>
<script src="/js/jquery.min.js"></script>
<script src="/js/materialize.min.js"></script>
<script src="/js/owl.carousel.min.js"></script>
<script src="/js/fakeLoader.min.js"></script>
<script src="/js/animatedModal.min.js"></script>
<script src="/js/main.js"></script>

</body>
</html>