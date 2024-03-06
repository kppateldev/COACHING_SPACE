@extends('admin.layouts.default')
@section('content')
<!-- Main section-->
<section class="section-container">
    <!-- Page content-->
    <div class="content-wrapper">
        <div class="content-heading">
            <div>Reviews</div>
        </div>
        <!-- START card-->
        <div class="card card-default">
            <div class="card-header"> Reviews List </div>
            <div class="card-body">


                <table class="table table-striped my-4 w-100" id="reviewsTable">
                    <thead>
                        <tr role="row" class="filter">
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td>
                                <select class="form-control" name="rating" id="rating">
                                    <option value="">Sort by Rating</option>
                                    <option value="ASC">ASC</option>
                                    <option value="DESC">DESC</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <th>ID</th>
                            <th>From</th>
                            <th>To</th>
                            <th>Overall Rating</th>
                            <th>Active Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>

                </table>

            </div>
        </div>
        <!-- END card-->
    </div>
</section>

@stop

@section('before_scripts')
<!-- Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Delete Review</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Are you sure to delete this review?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                <a class="btn btn-danger" id="delete-url">Yes</a>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="viewModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            {{-- <div class="modal-header">
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
                            <td>Review By</td>
                            <td id="reviewer"></td>
                        </tr>
                        <tr>
                            <td>Review For</td>
                            <td id="user"></td>
                        </tr>
                        <tr>
                            <td>Overall Rating</td>
                            <td id="overall_rating"></td>
                        </tr>
                        <tr>
                            <td>Attentiveness</td>
                            <td id="attentiveness"></td>
                        </tr>
                        <tr>
                            <td>Communication</td>
                            <td id="communication"></td>
                        </tr>
                        <tr>
                            <td>Active Listening</td>
                            <td id="active_listening"></td>
                        </tr>
                        <tr>
                            <td>Review</td>
                            <td id="review"></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div> --}}
        </div>
    </div>
</div>
@stop

@section('header_styles')
<!-- Datatables-->
<link rel="stylesheet" href="{{asset('vendor/datatables.net-bs4/css/dataTables.bootstrap4.css')}}">
<link rel="stylesheet" type="text/css" href="{{ asset('front_assets/css/jquery.rateyo.css') }}">
@stop
@section('footer_scripts')
<!-- Datatables-->
<script src="{{asset('vendor/datatables.net/js/jquery.dataTables.js')}}"></script>
<script src="{{asset('vendor/datatables.net-bs4/js/dataTables.bootstrap4.js')}}"></script>
<script src="{{ asset('front_assets/js/jquery.rateyo.min.js') }}"></script>
<script>
$(function () {

    var oTable = $('#reviewsTable').DataTable({
        ordering: false,
        processing: true,
        serverSide: true,
        stateSave: true,
        searching: false,
        //"order": [[0, "desc"]],
        ajax: {
            url: '{!! route('admin.reviews.data') !!}',
            data: function (d) {
                d.rating = $('select[name=rating]').val();
            }
        },
        columns: [
            {data: 'id', name: 'id', orderable: false, searchable: false},
            {data: 'review_by_name', name: 'review_by_name'},
            {data: 'review_for_name', name: 'review_for_name'},
            {data: 'overall_rating', name: 'overall_rating'},
            {data: 'active_status', name: 'active_status'},
            {data: 'action', name: 'action'}
        ],
        "drawCallback": function(settings) {
           $(".rateYo").rateYo();
           $(".rateYo").rateYo('option', 'starWidth', "16px");
           $(".rateYo").rateYo('option', 'readOnly', true);
       }
    });
 
    $('#rating').on('change', function (e) {
        oTable.draw();
        e.preventDefault();
    });
});
</script>

<script type="text/javascript">
$('#deleteModal').on('show.bs.modal', function(event) {
    var button = $(event.relatedTarget);
    var url = button.data('url');
    var modal = $(this);
    modal.find('.modal-footer #delete-url').attr('href', url);
});
$('#viewModal').on('show.bs.modal', function(event) {

    var button = $(event.relatedTarget);
    var dataURL = button.data('url');

    $('.modal-content').load(dataURL,function(){
        $(".rateYo").rateYo();
    });

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
