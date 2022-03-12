@php
/** @var \WebDevEtc\BlogEtc\Models\Post $post */
@endphp

<div class="article_blog mt-0" style='padding:0;'>

    <div class='text-center image_container'
        style="background-image: url('<?=$post->image_url("large"); ?>'); position:relative; ">
        
        <div style="width: 100%; background: #43425D; opacity: 0.54; height: 40px; position: absolute; bottom: 0;">
            
        </div>
        <blog-arrows :post="{{json_encode($post)}}" :full="1"></blog-arrows>          
    </div>
    <div>

        <div class="d-block d-sm-flex justify-content-between px-5 px-sm-0" >
            <div class="mt-3">
                @includeWhen($post->categories,"blogetc::partials.categories",['post'=>$post])
            </div>
            <div class="mt-5" style="color: #A2A2A2; font-size: 12px; font-weight: 500">
                {{$post->posted_at->format('F d, Y')}}</div>
        </div>

        <div class="px-5 px-sm-0 pb-5" style="padding-top: 10px">
            <div class="post-title"><span style="font-family: 'Montserrat' !important;
                font-weight: 600 !important;
                font-stretch: normal !important;
                font-style: normal !important;
                line-height: 1.22 !important;
                letter-spacing: normal !important;
                color: #1F1E34 !important;">{{$post->title}}</span></div>
            {{-- <h5 class=''>{{$post->subtitle}}</h5>--}}

            <div style="font-family: Montserrat;
          font-size: 16px;
          font-weight: 400;
          font-stretch: normal;
          font-style: normal;
          line-height: 1.5;
          letter-spacing: normal;
          text-align: left;
          color: #5A6066; padding-top: 20px">
                <blog-body :post="{{json_encode($post)}}" :full="1"></blog-body>
            </div>
        </div>
        @if(!empty($post->tags))
        @include("blogetc::partials.tags")
        @endif
    </div>

</div>