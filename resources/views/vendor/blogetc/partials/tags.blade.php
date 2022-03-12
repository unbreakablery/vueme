{{-- <div class="mt-10" style="color: #a2a2a2;">Tags</div> --}}
<div class=''>

    @foreach($post->tags as $tag)
    <a class='' href='{{$tag->url()}}' style="font-size: 12px; font-weight: 600; padding: 8px 5px; border-radius: 25px;color: #8EBEF8; display: inline-block; margin-top: 10px;">
        #{{$tag->tag_name}}
    </a>
    @endforeach
</div>