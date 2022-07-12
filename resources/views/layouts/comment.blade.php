<div class="comment clearfix" id="comment-{{ $comment->id }}">
    <img src="{{ $comment->user->profile_image }}" class="comment-img  float-left" alt="">
    <h5>
      <a href="{{ url('/user/' . $comment->user->id) }}">{{ $comment->user->name }}</a>

      <a href="javascript:void(0);" data-comment-id="{{ $comment->id }}" onclick="showReplyModal(this);">
        <i class="icofont-reply"></i>
        Reply
      </a>

    </h5>
    <time datetime="{{ explode(' ', $comment->created_at)[0] }}">{{ date_format(date_create($comment->created_at), "F d, Y") }}</time>
    <p>
      {{ $comment->comment }}
    </p>

    <div class="replies">
      @foreach ($comment->replies as $reply)
        @include ("layouts/reply", [
          "reply" => $reply
        ])
      @endforeach
    </div>

</div>
