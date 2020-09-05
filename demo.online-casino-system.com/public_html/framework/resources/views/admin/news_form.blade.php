

	<div class="row">
		<div class="col-sm-12">
			<div class="panel panel-default" data-widget='{"draggable": "false"}'>
				<div class="panel-heading">
					<h2>{{ Lang::get('news.news_details_grid') }}</h2>
					<div class="panel-ctrls" data-actions-container="" data-action-collapse='{"target": ".panel-body, .panel-footer"}'></div>
				</div>
				<div class="panel-body">
					<div class="form-group">
						<label class="col-md-3 control-label">{{ Lang::get('news.title_field') }}</label>
						<div class="col-md-9">
							@if($is_new)
							<input type="text" class="required form-control" id="title_txt" name="title_txt" value="{{ old('title_txt') }}" placeholder="{{ Lang::get('news.title_field') }}" required>
							@else
							<input type="text" class="required form-control" id="title_txt" name="title_txt" value="{{ $news->title }}" placeholder="{{ Lang::get('news.title_field') }}" required>
							@endif
						</div>
					</div>

					<div class="form-group">
						<label class="col-md-3 control-label">{{ Lang::get('news.content_field') }}</label>
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
				                CKEDITOR.replace( 'content_txt' , {
						            //filebrowserImageBrowseUrl: document.getElementsByName('base_url')[0].getAttribute('content') + '/panel/admin/laravel-filemanager?type=Images'
						        	filebrowserImageBrowseUrl: document.getElementsByName('base_url')[0].getAttribute('content') + '/Filemanager-master/index.html'
						        });
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
							<button type="submit" class="btn-success btn" value="submit" id="submit_btn" name="submit_btn">{{ Lang::get('general.submit_action') }}</button>
						</div>
					</div>
				</div>