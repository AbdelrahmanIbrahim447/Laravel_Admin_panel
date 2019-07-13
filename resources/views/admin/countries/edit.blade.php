@extends('admin.index')
@section('content')

<div class="box">
	<div class="box-header">
		<h3 class="box-title">{{$title}}</h3>
	</div>
	<div class="box-body">
		{!! Form::open(['url'=>aurl('countries/'.$Country->id),'files'=>true,'method'=>'put' ]) !!}
		<div class="form-group">
        {!! Form::label('country_name_ar',trans('admin.country_name_ar')) !!}
        {!! Form::text('country_name_ar',$Country->country_name_ar,['class'=>'form-control']) !!}
     </div>

      <div class="form-group">
        {!! Form::label('country_name_en',trans('admin.country_name_en')) !!}
        {!! Form::text('country_name_en',$Country->country_name_en,['class'=>'form-control']) !!}
     </div>
 
     <div class="form-group">
        {!! Form::label('mob',trans('admin.mob')) !!}
        {!! Form::text('mob',$Country->mob,['class'=>'form-control']) !!}
     </div>
        <div class="form-group">
        {!! Form::label('currency',trans('admin.currency')) !!}
        {!! Form::text('currency',$Country->currency,['class'=>'form-control']) !!}
     </div>
     <div class="form-group">
        {!! Form::label('code',trans('admin.code')) !!}
        {!! Form::text('code',$Country->code,['class'=>'form-control']) !!}
     </div>
     <div class="form-group">
        {!! Form::label('logo',trans('admin.flag')) !!}
        {!! Form::file('logo',['class'=>'form-control']) !!}
     </div>
     @if(!empty($Country->logo))
			<img src="{{ Storage::url($Country->logo) }}" style='width:50px; height:50px;'>
			@endif
		{!! Form::submit(trans('admin.country_edit'),['class'=>'btn btn-primary']) !!}
		{!! Form::close() !!}
	</div>

</div>


@endsection