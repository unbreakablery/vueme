@extends('layouts.app')
@section('metas')
@parent
<link rel="canonical" href="https://www.respectfully.com">
<meta name="keywords" content="Model blog">
<meta name="description"
    content="Discover the latest in psychic news via Respectfully’s™ blog. Browse by category to learn more about our services. Get advice & guidance exactly when you need it.">
@endsection
@section('title', 'Model Blog | Over 2,000 Spiritual Advisors | ')
@section('content')

{{--https://webdevetc.com/laravel/packages/blogetc-blog-system-for-your-laravel-app/help-documentation/laravel-blog-package-blogetc#guide_to_views--}}
<v-flex class="d-none d-md-flex">
    <v-img src="/images/blog_images/blog_header2.png" aspect-ratio="1"
        max-height="180" class="align-center justify-center">
        
        @if(isset($blogetc_category) && $blogetc_category)
        {{-- <h2 class='text-center primary--text blog_category' style="">{{$blogetc_category->category_name}}</h2> --}}
        <div class="text-center" style="font-size: 30px; font-weight: 600; color: #F0F0F7">The
            New Age Blog</div>
        <div class="text-center mt-4" style="font-size: 18px; font-weight: 600; color: #F0F0F7">
            Insightful {{$blogetc_category->category_name}} Articles</div>
        @else
        <div class="text-center" style="font-size: 30px; font-weight: 600; color: #F0F0F7">The
            New Age Blog</div>
        <div class="text-center  mt-4" style="font-size: 18px; font-weight: 600; color: #F0F0F7">
            Read the Latest Model News on Our Radar</div>
        @endif
        {{--<h2
                    class="subtitle-1 text-center white--text"
                    style="font-size:25px !important"
            >Immediate Advice You Can Trust From Your Personal Spiritual Advisor</h2>--}}
    </v-img>
</v-flex>
<v-flex class="d-flex d-md-none">
    <v-img src="/images/blog_images/blog_header_mobile.png" aspect-ratio="1"
        max-height="153" class="align-center justify-center">
        @if(isset($blogetc_category) && $blogetc_category)
        {{-- <h2 class='text-center primary--text blog_category' style="">{{$blogetc_category->category_name}}</h2> --}}
        <h1 class="text-center white--text" style="margin-top: 45px; font-size: 18px; font-weight: 600; color: #8EBEF8">The
            New Age Blog</h1>
        <h1 class="text-center mt-4 white--text" style="font-size: 12px; font-weight: 400; color: #8EBEF8">
            Insightful {{$blogetc_category->category_name}} Articles</h1>
        @else
        <h1 class="text-center white--text" style="margin-top: 45px; font-size: 18px; font-weight: 600">The
            New Age Blog</h1>
        <h1 class="text-center mt-4 white--text" style="font-size: 12px; font-weight: 400">
            Read the Latest Model News on Our Radar</h1>
        @endif
        {{--<h2
                    class="subtitle-1 text-center white--text"
                    style="font-size:25px !important"
            >Immediate Advice You Can Trust From Your Personal Spiritual Advisor</h2>--}}
    </v-img>
</v-flex>
<div  style="background-color: white">

    <div class="container">
        <div class='row'>
            <div class='col-sm-12 blogetc_container px-0'>
                @if(\Auth::check() && \Auth::user()->canManageBlogEtcPosts())
                <div class="text-center">
                    <p class='mb-1'>You are logged in as a blog admin user.
                        <br>
    
                        <a href='{{route("blogetc.admin.index")}}' class='btn border  btn-outline-primary btn-sm '>
    
                            <i class="fa fa-cogs" aria-hidden="true"></i>
    
                            Go To Blog Admin Panel</a>
    
    
                    </p>
                </div>
                @endif
                @if(isset($blogetc_category) && $blogetc_category)
                <div class='mt-3 mx-5'>
                    <a href="/blog">
                        <img style="-webkit-transform:rotate(180deg);
                    -moz-transform: rotate(180deg);
                    -ms-transform: rotate(180deg);
                    -o-transform: rotate(180deg);
                    transform: rotate(180deg);" src="{{config('app.url')}}/images/blog_images/all_articles.png" width="30" />
                        <span style="font-size: 14px; color: #8EBEF8; font-weight: 600">All Articles</span>
                    </a>
                </div>
                @endif

                <div class="row mt-3">
                    <div class="col-6">
                        <div class="mx-3">

                        @if($posts->previousPageUrl())
                        <a href="{{$posts->previousPageUrl()}}">
                            <img style="-webkit-transform:rotate(180deg);
                        -moz-transform: rotate(180deg);
                        -ms-transform: rotate(180deg);
                        -o-transform: rotate(180deg);
                        transform: rotate(180deg);" src="{{config('app.url')}}/images/blog_images/chevron.png" width="30" />
                            <span style="font-size: 14px; color: #8EBEF8; font-weight: 600">Previous</span>
                        </a>
                        @endif
                        </div>
                    </div>
                    <div class="col-6 text-right">
                        <div class="mx-3">
                        @if($posts->nextPageUrl())
                    <a href="{{$posts->nextPageUrl()}}" class="ml-0 ml-md-4">
                        <span style="font-size: 14px; color: #8EBEF8; font-weight: 600">Next</span><img src="{{config('app.url')}}/images/blog_images/chevron.png" width="30" />
                    </a>
                    @endif
                        </div>
                    </div>
                </div>
                
                {{-- <div class='text-right mt-3 mx-5'>
                    
                    
                </div> --}}
    
                @if(empty($posts))
                <div class='alert alert-danger'>No posts</div>
                @else
                <div class="row">
                    @foreach ($posts as $post)
                    @include("blogetc::partials.index_loop")
                    @endforeach
                </div>
                @endif
    
                {{-- @include("blogetc::sitewide.search_form")--}}
    
            </div>
        </div>
    </div>
</div>
@endsection

<style>
.post-title{
            font-size: 18px
        }
.v-application .list p{
        margin-bottom: 0px !important;
    }
    .container-blog {
        width: 100%;
        padding: 12px;
        margin-right: auto;
        margin-left: auto;
    }

    .image_container {
        height: 320px;
        width: 100%;
        max-width: 500px;
        background-repeat: no-repeat;
        background-size: cover;
    }

    .post-list-text{
        width: 100%;
        max-width: 500px; 
    }

    .blog_title {
        font-size: 60px;
    }

    .blog_category {
        font-size: 32px;
    }

    .article_blog {
        margin: 50px auto;
    }

    .blog_article_title {
        font-size: 24px !important;
    }

    @media (max-width: 500px) {
        .image_container {
            height: 180px;
            width:  100%;
            background-repeat: no-repeat;
            background-size: cover;
        }

        .blog_article_title {
            font-size: 20px !important;
        }

        .article_blog {
            margin: 10px auto;
        }

        .blog_title {
            font-size: 24px;
        }

        .blog_category {
            font-size: 14px;
        }

        .post-title{
            font-size: 15px
        }

    }


    @media (min-width: 901px) {
        .container-blog {
            max-width: 900px !important;
        }
        
    }
</style>