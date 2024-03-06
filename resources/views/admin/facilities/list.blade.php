@extends('admin.layouts.default')
@section('content')
      <!-- Main section-->
      <section class="section-container">
        <!-- Page content-->
        <div class="content-wrapper">
          <div class="content-heading">
            <div>Facilities</div>
          </div>
          <!-- START card-->
          <div class="card card-default">
             <div class="card-header"> Facilities List
               {{-- <a href="{{route('admin.facilities.create')}}" class="btn btn-primary f-right"><i class="fa fa-plus"></i> Add</a> --}}
             </div>
             <div class="card-body">


               <table class="table table-striped my-4 w-100" id="facilitiesTbl">
                  <thead>
                     <tr>
                        <th>ID</th>
                        <th>Facility Title</th>
                        <th>Icon Class</th>
                        {{-- <th>Facility Image</th> --}}
                        <th>Display Order</th>
                        <th>Add Date</th>
                        <th>Actions</th>
                     </tr>
                  </thead>
                  <tbody>
                     @foreach($data as $key=>$val)
                     <tr class="gradeU">
                        <td>{{$val->id}}</td>
                        <td>{{$val->title}}</td>
                        <td>{{$val->icon}}</td>
                        {{-- <td>
                          @if($val->image)
                          <img src="{{asset('uploads/'.$val->image)}}" height="100px">
                          @else
                          <img src="{{asset('assets/admin/img/dummy.png')}}" height="100px">
                          @endif
                        </td> --}}
                        <td>{{$val->display_order}}</td>
                        <td>{{$val->created_at}}</td>
                        <td>
                          {{-- <button data-id="{{$val->id}}" data-title="{{$val->title}}" data-icon="{{$val->icon}}" data-image="{{$val->image}}" data-toggle="modal" data-target="#viewModal" class="btn btn-info" title="View"><i class="fa fa-eye"></i></button> --}}
                          <a href="{{route('admin.facilities.edit',$val->id)}}" class="btn btn-primary" title="Edit"><i class="fa fa-edit"></i></a>
                          {{-- <button data-url="{{route('admin.facilities.delete',$val->id)}}" data-toggle="modal" data-target="#deleteModal" class="btn btn-danger" title="Delete"><i class="fa fa-trash"></i></button> --}}
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
        <h5 class="modal-title" id="exampleModalLabel">Delete Facility</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        Are you sure to delete this facility?
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
                <td>Icon</td>
                <td id="icon"></td>
              </tr>
            {{-- <tr>
              <td>Image</td>
              <td id="image"></td>
            </tr> --}}
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
    var table = $('#facilitiesTbl').DataTable({

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
  var image = button.data('image');
  var icon = button.data('icon');

  if(image)
  var url = "{{asset('uploads')}}/"+image;
  else
  var url = "{{asset('assets/admin/img/dummy.png')}}";

  var imagepath = '<a target="_blank" href="'+url+'"><img src="'+url+'" height="200px"></a>';

  var modal = $(this);
  modal.find('.modal-body #id').html(id);
  modal.find('.modal-body #title').html(title);
  modal.find('.modal-body #image').html(imagepath);
  modal.find('.modal-body #icon').html(icon);
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
