<div class="comment comment-reply clearfix">
  <img src="{{ $reply->user->profile_image }}" class="comment-img  float-left" alt="">
  <h5><a href="{{ url('/user/' . $reply->user->id) }}">{{ $reply->user->name }}</a></h5>
  <time datetime="{{ explode(' ', $reply->created_at)[0] }}">{{ date_format(date_create($reply->created_at), "F d, Y") }}</time>
  <p>
    {{ $reply->reply }}
  </p>

</div>