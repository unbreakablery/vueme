@extends('layouts.app')
@section('metas')
@parent
<link rel="canonical" href="https://www.respectfully.com">
<meta name="description" content="Discover hundreds of top-rated online psychics and spiritual advisors at respectfully™. Enjoy personal psychic readings online and get $5 off your first reading!">
<link href="css/fontawesome-all.min.css" rel="stylesheet">
@endsection
<style>
    .content {
        background:#f9f9f9 0% 0% no-repeat padding-box;
    }
    .page-title
    {
        font-size:18px;
        font-weight:700;
        line-height:22px;
        margin-bottom:25px;
        margin-top:98px;
    }
    .toggle-title-loggedin
    {
        width:335px;
        height:48px;
        background: #E7E6E8 0% 0% no-repeat padding-box;
        border-radius: 24px;
        padding:4px;
        margin:auto;
        margin-bottom:20px;
        margin-top: 40px
    }
    .toggle-title-loggedin .t-btn
    {
        font-size:16px;
        font-weight:600;
        line-height:26px;
        width:107px;
        height:40px;
        text-align:center;
        line-height:40px;
        color: #6537B1;
        opacity: 0.2;
        display:inline-block;
    }
    .toggle-title-loggedin .active
    {
        background: #FFFFFF;
        box-shadow: 0px 1px 2px #0000001F;
        border-radius: 24px;
        opacity:1;	
    }

    /*  Small mobile :320px. */
    @media (min-width: 320px) and (max-width: 767px) {
        .toggle-title
        {
            margin-top:100px;
        }
    }
</style>
@section('title', '')
@section('content')
<section class="content">
    <div class="container">
        @guest
            <div></div>
        @else
            <div style="width: 100%; height: 40px"></div>
        @endguest
        <div class="page-title text-center d-none d-md-block" style="color: #6537B1">My Feed</div>
        <div class="toggle-title-loggedin d-block d-md-none"><a href="/myfeed" class="t-btn active">My Feed</a> <a   href="models" class="t-btn">Models</a><a   href="explore" class="t-btn">Explore</a></div>
    </div>
</section>
<myfeed-list/>
@endsection
<script>
    document.addEventListener('DOMContentLoaded', () => {

        let myBtns=document.querySelectorAll('.toggle-title-loggedin .t-btn');
        myBtns.forEach(function(btn) {

            btn.addEventListener('click', () => {
            myBtns.forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
            });

        });
    });
  
    </script>
<script async src="//platform.instagram.com/en_US/embeds.js"></script>
<script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>