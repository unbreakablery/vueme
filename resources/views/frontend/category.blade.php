@extends('layouts.app')
@section('metas')
@parent
<link rel="canonical" href="https://www.respectfully.com">
<meta name="description" content="Discover hundreds of top-rated online psychics and spiritual advisors at respectfully™. Enjoy personal psychic readings online and get $5 off your first reading!">
<link href="css/fontawesome-all.min.css" rel="stylesheet">
@endsection
<style>
    .category-content {
        background:#F9F9F9 0% 0% no-repeat padding-box;
    }
    .category-content .container {
        display: flex;
        flex-direction: column;
        align-items: center;
    }
    .loggedin .page-title {
        margin-top: 96px;
    }
    .page-title
    {
        font-size:18px;
        font-weight:700;
        line-height:22px;
        margin-bottom:25px;
        margin-top:56px;
        color:#6537B1 !important;
        padding-top: 30px;
        text-transform: capitalize;
    }
    .toggle-title
    {
        width:280px;
        height:48px;
        background: #E7E6E8 0% 0% no-repeat padding-box;
        border-radius: 24px;
        padding:4px;
        margin:auto;
        margin-bottom:20px;
    }
    .toggle-title .t-btn
    {
        font-size:16px;
        font-weight:600;
        line-height:26px;
        width:134px;
        height:40px;
        text-align:center;
        line-height:40px;
        color: #6537B1;
        opacity: 0.2;
        display:inline-block;
    }
    .toggle-title .t-btn.active
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

        .loggedin .page-title, .page-title {
            margin-top: 56px;
            padding-top: 23px;
        }
    }
</style>
@section('title', '')
@section('content')
<section class="category-content">
    <div class="container @if(Auth::user()){{'loggedin'}}@endif">
        <div class="page-title text-center d-md-block">{{$cat_name}}</div>
        {{-- <div class="toggle-title d-block d-md-none"><a href="#" class="t-btn active">Explore</a> <a   href="#" class="t-btn">Models</a></div> --}}
        <category-spec
            ref="categoryspec"
            cat="{{$slug}}"
            :guest="{{json_encode(\Illuminate\Support\Facades\Auth::guest())}}"
        />
    </div>
</section>
@endsection
<script>
    document.addEventListener('DOMContentLoaded', () => {

        let myBtns=document.querySelectorAll('.toggle-title .t-btn');
        myBtns.forEach(function(btn) {

            btn.addEventListener('click', () => {
            myBtns.forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
            });

        });
    });
  
</script>