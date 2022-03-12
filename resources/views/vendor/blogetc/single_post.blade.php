@extends("layouts.app",['title'=>$post->gen_seo_title()])
@section("content")


{{--https://webdevetc.com/laravel/packages/blogetc-blog-system-for-your-laravel-app/help-documentation/laravel-blog-package-blogetc#guide_to_views--}}
{{-- <v-flex>
    <v-img src="/images/blog_images/blog_header.png" aspect-ratio="1" :max-height="$vuetify.breakpoint.smAndDown ? '104' : '242'" class="align-center justify-center">
        <h1 class="text-center font-weight-bold white--text blog_title" style="">The Blog</h1>
        @if(isset($blogetc_category) && $blogetc_category)
        <h2 class='text-center primary--text blog_category' style="">{{$blogetc_category->category_name}}</h2>

        @endif --}}
        {{--<h2
                    class="subtitle-1 text-center white--text"
                    style="font-size:25px !important"
            >Immediate Advice You Can Trust From Your Personal Spiritual Advisor</h2>--}}
    {{-- </v-img>
</v-flex> --}}
<div  style="background-color: white">
<div class='container-blog pt-0'>
    <div class='row'>
    
        <div class='col-sm-12 col-md-12 col-lg-12 blogetc_container px-0'>

            @include("blogetc::partials.show_errors")
            @include("blogetc::partials.full_post_details")


            @if(config("blogetc.comments.type_of_comments_to_show","built_in") !== 'disabled')
            <div class="" id='maincommentscontainer'>
                <h2 class='text-center' id='blogetccomments'>Comments</h2>
                @include("blogetc::partials.show_comments")
            </div>
            @else
            {{--Comments are disabled--}}
            @endif


        </div>
    </div>
</div>
</div>
@endsection

<style>

    .post-title{
            font-size: 18px
        }
    .container-blog {
        width: 100%;
        padding: 12px;
        margin-right: auto;
        margin-left: auto;
    }

    .image_container {
        height: 335px;
        background-repeat: no-repeat;
        background-size: cover;
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

        .post-title{
            font-size: 15px
        }
        .image_container {
            height: 180px;
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

    }


    @media (min-width: 901px) {
        .container-blog {
            max-width: 900px !important;
        }
    }
</style>