

	<div class="row">
		<div class="col-sm-12">
			<div class="panel panel-default" data-widget='{"draggable": "false"}'>
				<div class="panel-heading">
					<h2>News Details</h2>
					<div class="panel-ctrls" data-actions-container="" data-action-collapse='{"target": ".panel-body, .panel-footer"}'></div>
				</div>
				<div class="panel-body">
					<div class="form-group">
						<label class="col-md-3 control-label">Title</label>
						<div class="col-md-9">
							@if($is_new)
							<input type="text" class="required form-control" id="title_txt" name="title_txt" value="{{ old('title_txt') }}" placeholder="Title" required>
							@else
							<input type="text" class="required form-control" id="title_txt" name="title_txt" value="{{ $news->title }}" placeholder="Title" required>
							@endif
						</div>
					</div>

					<div class="form-group">
						<label class="col-md-3 control-label">Content</label>
						<div class="col-md-9">
							@if($is_new)
							<textarea name="content_txt" id="content_txt" rows="20" cols="80" class="required form-control"></textarea>
							@else
							<textarea name="content_txt" id="content_txt" rows="20" cols="80" class="required form-control">
								{{ $news->content }}
							</textarea>
							@endif
							<script>
				                // Replace the <textarea id="editor1"> with a CKEditor
				                // instance, using default configuration.
				                CKEDITOR.replace( 'content_txt' );
				            </script>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

				<div class="panel-footer">
					<div class="row">
						<div class="col-sm-8 col-sm-offset-2">
							<button type="submit" class="btn-success btn" value="submit" id="submit_btn" name="submit_btn">Submit</button>
						</div>
					</div>
				</div>