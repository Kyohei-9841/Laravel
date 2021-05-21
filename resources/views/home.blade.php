@extends('layouts.app')

@section('content')
    <div id="container">
        <div id="inner-header">
            <h1 id="logo">
                {{-- <a href="index.html"> --}}
                    <img src="{{ asset('images/main/logo.png')}}" alt="SAMPLE WEB SITE">
                {{-- </a> --}}
            </h1>
            <!--スライドショー-->
            <aside id="mainimg">
                <img src="{{ asset('images/main/1.jpg')}}" alt="" class="slide0">
                <img src="{{ asset('images/main/1.jpg')}}" alt="" class="slide1">
                <img src="{{ asset('images/main/2.jpg')}}" alt="" class="slide2">
                <img src="{{ asset('images/main/3.jpg')}}" alt="" class="slide3">
            </aside>
        </div>
        <div id="contents">
            <div id="main">
                <section id="new">
                    <h2>コンテンツ説明</h2>
                    <p>コンテンツ説明内容コンテンツ説明内容コンテンツ説明内容コンテンツ説明内容コンテンツ説明内容コンテンツ説明内容コンテンツ説明内容コンテンツ説明内容コンテンツ説明内容コンテンツ説明内容<br>
                        コンテンツ説明内容コンテンツ説明内容コンテンツ説明内容コンテンツ説明内容コンテンツ説明内容コンテンツ説明内容コンテンツ説明内容コンテンツ説明内容コンテンツ説明内容コンテンツ説明内容</p>
                </section>
                <section>
                    <h2>イベント一覧</h2>
                </section>
                <section>
                    <h2>過去イベント一覧</h2>
                </section>

            </div>
            <!--/#main-->
            {{-- <div id="sub"> --}}
                <!--PC用（801px以上端末）メニュー-->
                {{-- <nav id="menubar">
                    <h2>Contents</h2>
                    <ul> --}}
                        {{-- <li><a href="index.html">HOME</a></li>
                        <li><a href="about.html">ABOUT</a></li>
                        <li><a href="gallery.html">GALLERY</a></li>
                        <li><a href="link.html">LINK</a></li> --}}
                        {{-- <li>HOME</li>
                        <li>ABOUT</li>
                        <li>GALLERY</li>
                        <li>LINK</li>
                    </ul>
                </nav>
                <p><a href="#"><img src="{{ asset('images/main/banner1.jpg')}}" alt="採用情報" class="pc"></a>
                <a href="#"><img src="{{ asset('images/main/banner1_sh.jpg')}}" alt="採用情報" class="sh"></a></p>
                <p>上のバナー画像は、801px以上の端末と800px以下とで画像２種類が切り替わります。<br>
                <a href="about.html#banner">詳しい説明はこちら。</a></p>
            </div> --}}
            <!--/#sub-->
        </div>
        <!--/#contents-->
    </div>
    <!--/#container-->

    <footer>
        <small>Copyright&copy; <a href="index.html">SAMPLE WEB SITE</a> All Rights Reserved.</small>
        <span class="pr"><a href="http://template-party.com/" target="_blank">《Web Design:Template-Party》</a></span>
    </footer>

    <!--ページの上部に戻る「↑」ボタン-->
    <p class="nav-fix-pos-pagetop"><a href="#">↑</a></p>
@endsection
