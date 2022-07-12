<div class="row">
    <div class="col-md-2">
        <img src="{{ $reactioner->user->profile_image }}" style="width: 100%;" />
    </div>

    <div class="col-md-2" style="margin: auto 0px;">
        {{ $reactioner->user->name }}
    </div>

    <div class="col-md-8 text-right" style="margin: auto 0px;">
        {{ ($reactioner->comment == null) ? '' : $reactioner->comment }}

        @if (isset($reactioner->shared_post_id))
            <a href="{{ url('/posts/' . $reactioner->post_id) }}" target="_blank">
                Post
            </a>
        @endif
    </div>
</div>