@extends('admin.layouts.default')
@section('content')
      <!-- Main section-->
      <section class="section-container">
        <!-- Page content-->
        <div class="content-wrapper">
          <div class="content-heading">
            <div>Email Header</div>
          </div>
          <!-- START card-->
          <div class="card card-default">
             <div class="card-header">Listings
               <a href="{{route('admin.email_header_template.add')}}" class="btn btn-primary f-right"><i class="fa fa-plus"></i> Add</a>
             </div>
             <div class="card-body">
               <table class="table table-striped my-4 w-100" id="email_header_templateTbl">
                  <thead>
                     <tr>
                        <th>ID</th>
                        <th>Title</th>
                        <th>Actions</th>
                     </tr>
                  </thead>
                  <tbody>
                     @foreach($headers as $key=>$val)
                     <tr class="gradeU">
                        <td>{{$val->id}}</td>
                        <td>{{$val->title}}</td>
                        <td>
                          <a href="{{route('admin.email_header_template.edit',$val->id)}}" class="btn btn-primary" title="Edit"><i class="fa fa-edit"></i></a>
                        </td>
                     </tr>
                     @endforeach
                  </tbody>
               </table>
               <div class="d-flex justify-content-end">
                {{ $headers->onEachSide(0)->links() }}
              </div>
             </div>
          </div>
          <!-- END card-->
        </div>
      </section>
@stop
@section('before_scripts')
@stop

@section('header_styles')
<!-- Datatables-->
<link rel="stylesheet" href="{{asset('vendor/datatables.net-bs4/css/dataTables.bootstrap4.css')}}">
@stop

@section('footer_scripts')
<!-- Datatables-->
<script src="{{asset('vendor/datatables.net/js/jquery.dataTables.js')}}"></script>
<script src="{{asset('vendor/datatables.net-bs4/js/dataTables.bootstrap4.js')}}"></script>
@stop
