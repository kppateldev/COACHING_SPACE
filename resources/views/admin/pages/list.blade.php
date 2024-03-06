@extends('admin.layouts.default')
@section('content')
      <!-- Main section-->
      <section class="section-container">
        <!-- Page content-->
        <div class="content-wrapper">
          <div class="content-heading">
            <div>Pages</div>
          </div>
          <!-- START card-->
          <div class="card card-default">
             <div class="card-header"> Pages List
               {{-- <a href="{{route('admin.pages.create')}}" class="btn btn-primary f-right"><i class="fa fa-plus"></i> Add</a> --}}
             </div>
             <div class="card-body">


               <table class="table table-striped my-4 w-100" id="pagesTbl">
                  <thead>
                     <tr>
                        <th>ID</th>
                        <th>slug</th>
                        <th>Title</th>
                        <th>Meta Title</th>
                        {{-- <th>Meta Description</th> --}}
                        <th>Add Date</th>
                        {{-- <th>Status</th> --}}
                        <th>Actions</th>
                     </tr>
                  </thead>
                  <tbody>
                     @foreach($data as $key=>$val)
                     <tr class="gradeU">
                        <td>{{$val->id}}</td>
                        <td>{{$val->slug}}</td>
                        <td>{!!$val->title!!}</td>
                        <td>{{$val->meta_title}}</td>
                        {{-- <td>
                          @if($val->meta_description)
                          {{\Illuminate\Support\Str::limit($val->meta_description)}}
                          @else
                          {{'N/A'}}
                          @endif
                        </td> --}}
                        <td>{{$val->created_at}}</td>
                        {{-- <td>
                          <label class="switch">
                            <input class="change_status" data-url="{{route('admin.pages.change_status',$val->id)}}" type="checkbox" @if($val->status == "1") checked @endif>
                            <span class="slider round"></span>
                          </label>
                        </td> --}}
                        <td>
                          {{-- <button data-id="{{$val->id}}" data-title="{{$val->title}}" data-description="{{$val->description}}"
                              data-meta_title="{{$val->meta_title}}" data-meta_keywords="{{$val->meta_keywords}}" data-meta_description="{{$val->meta_description}}"
                              data-toggle="modal" data-target="#viewModal" class="btn btn-info" title="View"><i class="fa fa-eye"></i></button> --}}
                          <a href="{{route('admin.pages.edit',$val->id)}}" class="btn btn-primary" title="Edit"><i class="fa fa-edit"></i></a>
                          {{-- <button data-url="{{route('admin.pages.delete',$val->id)}}" data-toggle="modal" data-target="#deleteModal" class="btn btn-danger" title="Delete"><i class="fa fa-trash"></i></button> --}}
                        </td>
                     </tr>
                     @endforeach
                  </tbody>
               </table>

             </div>
          </div>
          <!-- END card-->
        </div>
      </section>

@stop

@section('before_scripts')
<!-- Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Confirmation</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        Are you sure to delete this record?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
        <a class="btn btn-danger" id="delete-url">Yes</a>
      </div>
    </div>
  </div>
</div>
<!-- Modal -->
<div class="modal fade" id="viewModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Details</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <table class="table table-striped">
          <thead>
            <tr>
              <th>Field Name</th>
              <th>Data</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>Id</td>
              <td id="id"></td>
            </tr>
            <tr>
              <td>Title</td>
              <td id="title"></td>
            </tr>
            <tr>
              <td>Description</td>
              <td id="description"></td>
            </tr>
            <tr>
              <td>Meta Title</td>
              <td id="metaTitle"></td>
            </tr>
            <tr>
              <td>Meta Description</td>
              <td id="metaDescription"></td>
            </tr>
            <tr>
                <td>Meta Keywords</td>
                <td id="metaKeywords"></td>
              </tr>
          </tbody>
        </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
@stop

@section('header_styles')
<!-- Datatables-->
<link rel="stylesheet" href="{{asset('vendor/datatables.net-bs4/css/dataTables.bootstrap4.css')}}">
@stop
@section('footer_scripts')
<!-- Datatables-->
<script src="{{asset('vendor/datatables.net/js/jquery.dataTables.js')}}"></script>
<script src="{{asset('vendor/datatables.net-bs4/js/dataTables.bootstrap4.js')}}"></script>
<script>
$(document).ready(function() {
    var table = $('#pagesTbl').DataTable({

        // aaSorting: [
        //     [0, 'desc']
        // ],

    });

});
</script>
<script type="text/javascript">
$('#deleteModal').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget);
  var url = button.data('url');
  var modal = $(this);
  modal.find('.modal-footer #delete-url').attr('href',url);
});
$('#viewModal').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget);
  var id = button.data('id');
  var title = button.data('title');
  var description = button.data('description');
  var meta_title = button.data('meta_title');
  var meta_keywords = button.data('meta_keywords');
  var meta_description = button.data('meta_description');

  var modal = $(this);
  modal.find('.modal-body #id').html(id);
  modal.find('.modal-body #title').html(title);
  modal.find('.modal-body #description').html(description);
  modal.find('.modal-body #metaTitle').html(meta_title);
  modal.find('.modal-body #metaKeywords').html(meta_keywords);
  modal.find('.modal-body #metaDescription').html(meta_description);
});
</script>

<script type="text/javascript">
  $(document).on('click','.change_status',function(){
    var url = $(this).data('url');
    $.ajax({
      type: 'GET',
      url: url,
      data: '',
      success: function(response){
        toastr[response.msgType](response.msg, response.msgHead);
      }
    });
  });
</script>
@stop
