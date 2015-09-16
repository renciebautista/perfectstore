@extends('layouts.default')

@section('content')

@include('shared.notifications')

<section class="content">
	<div class="row menu pull-right">
		<div class="col-xs-12">
			{!! link_to_route('distributor.create','New Distributor',array(),['class' => 'btn btn-primary']) !!}
		</div>
	</div>

	<div class="row">
		<div class="col-xs-12">
			<div class="box">
				<div class="box-header">
					<h3 class="box-title">Distributor Lists</h3>
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
								<th>Account</th>
								<th>Customer</th>
								<th>Area</th>
								<th>Region</th>
								<th>Distributor</th>
								<th>Action</th>
							</tr>
							@foreach($distributors as $distributor)
							<tr>
								<td>{{ $distributor->id }}</td>
								<td>{{ $distributor->region->area->customer->account->account }}</td>
								<td>{{ $distributor->region->area->customer->customer  }}</td>
								<td>{{ $distributor->region->area->area }}</td>
								<td>{{ $distributor->region->region }}</td>
								<td>{{ $distributor->distributor }}</td>
								<td></td>
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