
<div class="col-12 col-md-6">
    <div class="mt-5 mx-5">
        <a href="{{config('app.url')}}/blog/{{$post->slug}}">
            <div class='text-center image_container'
             style="background-image: url('<?=$post->image_url("large"); ?>'); margin-bottom: 10px">
            </div>
        </a>
        @includeWhen($post->categories,"blogetc::partials.categories",['post'=>$post, 'category_selected' => isset($blogetc_category) ? $blogetc_category->category_name : null])
        <div style="color: #A2A2A2; font-size: 12px; font-weight: 500; margin-top: 20px">
            {{$post->posted_at->format('F d, Y')}}</div>
        <div class="post-list-text" style='padding-top:10px;'>
            <div class="blog_article_title">
                <a href="{{config('app.url')}}/blog/{{$post->slug}}" style="text-decoration: none">
                <span class="post-title" style="font-family: 'Montserrat' !important;

            font-weight: 600 !important;
            font-stretch: normal !important;
            font-style: normal !important;
            line-height: 1.22 !important;
            letter-spacing: normal!important;
            color: #1F1E34 !important;">{{$post->title}}
            </span>
                </a>
        </div>
        <div class="post-list-text">
            <p class="list" style="font-family: Montserrat;
      font-size: 16px;
      font-stretch: normal;
      font-style: normal;
      line-height: 1.5;
      letter-spacing: normal;
      text-align: left;
      color: #5A6066;margin-top: 20px">
                <blog-body :post="{{json_encode($post)}}" :full="0"></blog-body>
            </p>
        </div>
        </div>
    </div>
</div>