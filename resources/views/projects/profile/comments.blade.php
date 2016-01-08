<script type="text/javascript">
    require(['holder'], function() {});
</script>

<div class="panel-body">
    @foreach($project->comments as $comment)
	<div class="media">
	    <div class="media-left media-middle">
		<img data-src="holder.js/40x40">
	    </div>

	    <div class="media-body">
		{{ $comment->content }}
	    </div>
	</div>
    @endforeach

    <hr />

    <form method="post" action="{{ route('comment.add') }}">

	<input type="hidden" name="object_type" value="{{ get_class($project) }}" />
	<input type="hidden" name="object_id" value="{{ $project->id }}" />

	<div class="form-group">
	    <textarea class="form-control" name="content" rows="3" placeholder="内容"></textarea>
	</div>

	<div class="form-group">
	    <button type="submit" class="btn btn-warning">
		<i class="fa fa-plus"></i> 备注追加
	    </button>
	</div>
    </form>
</div>
