@extends('layouts.default')

@section('content')

@include('shared.notifications')

<section class="content">
	<div class="row menu pull-right">
		<div class="col-xs-12">
			{!! link_to_route('formgroup.create','New Group',array(),['class' => 'btn btn-primary']) !!}
		</div>
	</div>

	<div class="row">
		<div class="col-xs-12">
			<div class="box">
				<div class="box-header">
					<h3 class="box-title">Form Group Lists</h3>
					<div class="box-tools">
						<div class="input-group" style="width: 150px;">
							<input type="text" name="table_search" class="form-control input-sm pull-right" placeholder="Search">
							<div class="input-group-btn">
								<button class="btn btn-sm btn-default"><i class="fa fa-search"></i></button>
							</div>
						</div>
					</div>
				</div><!-- /.box-header -->
				<div class="box-body table-responsive no-padding">
					<table class="table table-hover">
						<tbody>
							<tr>
								<th>ID</th>
								<th>Group</th>
								<th>Secondary Display Tag</th>
								<th>OSA Tag</th>
								<th>SOS Tag</th>
								<th>Customized Tag</th>
								<th>Used on Perfect Store</th>
								<th>Action</th>
							</tr>
							@foreach($formgroups as $group)
							<tr>
								<td>{{ $group->id }}</td>
								<td>{{ $group->group_desc }}</td>
								<td>
									@if($group->secondary_display == 1)
									<i class="fa fa-fw fa-check"></i>
									@endif
								</td>
								<td>
									@if($group->osa == 1)
									<i class="fa fa-fw fa-check"></i>
									@endif
								</td>
								<td>
									@if($group->sos == 1)
									<i class="fa fa-fw fa-check"></i>
									@endif
								</td>
								<td>
									@if($group->custom == 1)
									<i class="fa fa-fw fa-check"></i>
									@endif
								</td>
								<td>
									@if($group->perfect_store == 1)
									<i class="fa fa-fw fa-check"></i>
									@endif
								</td>
								<td>{!! link_to_action('FormGroupController@edit', 'Edit', $group->id, ['class' => 'btn btn-xs btn btn-primary']) !!}</td>
							</tr>
							@endforeach
						</tbody>
					</table>
				</div><!-- /.box-body -->
			</div><!-- /.box -->
		</div>
	</div>
</section>

@endsection