@extends('admin.index')
@section('content')
@push('js')

<!-- Trigger the modal with a button -->
<button type="button" class="btn btn-danger fade" data-toggle="modal" data-target="#del_admin">
  <i class="fa fa-trash"></i>
</button>

<!-- Modal -->
<div id="del_admin" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">{{ trans('admin.delete') }}</h4>
      </div>

      {!! Form::open(['url' =>'','method'=>'delete','id'=>'form_id']) !!}
      <div class="modal-body">
        <div class="inline">{{ trans('admin.delete_that')}}</div><span id='id_name'></span>
       
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-info" data-dismiss="modal">{{ trans('admin.close') }}</button>
        {!! Form::submit(trans('admin.yes'),['class'=>'btn btn-danger']) !!}
      </div>
      {!! Form::close() !!}
    </div>

  </div>
</div>
<script type="text/javascript">
  $(document).ready(function(){
    $('#jstree').jstree({
  "core" : {
    'data' : {!! dep_arr() !!},
    "themes" : {
      "variant" : "large"
    }
  },
  "checkbox" : {
    "keep_selected_style" : false
  },
  "plugins" : [ "wholerow",  ]
    });
});
  $('#jstree').on('changed.jstree', function (e, data){
    var i , j ,q =[];
    var name = [];
    for (var i =0 , j=data.selected.length ;i < j;i++  ) {
          q.push(data.instance.get_node(data.selected[i]).id);
          name.push(data.instance.get_node(data.selected[i]).text);

    }
    $('#form_id').attr('action','{{ aurl('departments') }}/'+q.join(', '));
    $('#id_name').text(name.join(', '));
    if (q.join(', ') != '' ) {
        $('.show_btn').removeClass('hidden');
        $('.btnedit').attr('href','{{aurl('departments')}}'+ '/'+q.join(', ') + '/edit' );
        $('.btndel').attr('href','{{aurl('departments')}}'+ '/'+q.join(', ') + '/delete' );
    }else
    {
        $('.show_btn').addClass('hidden');

    }

});
</script>
@endpush
<div class="box">
  <div class="box-header">
    <h3 class="box-title">{{ $title }}</h3>
  </div>
  <!-- /.box-header -->
  <div class="box-body">
    <a href="" class="btn btn-info btnedit show_btn hidden" ><i class="fa fa-edit">  {{trans('admin.edit')}}</i><a>
      <a class="btn btn-danger btnedel show_btn hidden" ><i class="fa fa-trash" data-toggle="modal" data-target="#del_admin">{{trans('admin.delete')}}</i><a>
      <div id="jstree">
        <input type="hidden" name="parent_id" class="parent_id" value="">
      </div>

  </div>
  <!-- /.box-body -->
</div>
<!-- /.box -->



@endsection