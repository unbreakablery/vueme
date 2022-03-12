<div class='mb-2'>
    @foreach($post->categories as $category)
    @if(isset($category_selected) && $category_selected == $category->category_name)
    <a class='' href='{{$category->url()}}' style="color: #9759FF; font-size: 12px; font-weight: 600">
        {{$category->category_name}}
    </a>
    @else
    <a class='' href='{{$category->url()}}' style="color: #43425D; font-size: 12px; font-weight: 600">
        {{$category->category_name}}
    </a>
    @endif
    @if (!$loop->last)
    <span class="mx-2" style="color: #C0C0C0; font-size: 12px;">|</span>
    @endif
    @endforeach
</div>