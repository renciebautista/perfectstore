@extends('layouts.default')

@section('content')

@include('shared.notifications')

<section class="content">
	<div class="row">
		<div class="col-md-6">
			<div class="box box-primary">
				<div class="box-header with-border">
				  	<h3 class="box-title">New SOS Tag</h3>
				</div>
				{!! Form::open(array('route' => 'sostag.store')) !!}
				  	<div class="box-body">
				  		<div class="form-group">
					   		{!! Form::label('sos_tag', 'SOS Tag'); !!}
	                    	{!! Form::text('sos_tag',null,['class' => 'form-control','placeholder' => 'SOS Tag']) !!}
						</div>
				  	</div><!-- /.box-body -->

				 	<div class="box-footer">
						<button type="submit" class="btn btn-success">Submit</button>
						{!! link_to_route('sostag.index','Back',array(),['class' => 'btn btn-default']) !!}
				  	</div>


				{!! Form::close() !!}
			  </div>
		</div>
	</div>
</section>
@endsection