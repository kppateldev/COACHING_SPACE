@extends('admin.layouts.default')
@section('content')
<!-- Main section-->
<section class="section-container">
    <!-- Page content-->
    <div class="content-wrapper">
        <div class="content-heading">
            <div>Dashboard
                <small>WELCOME to Dashboard</small>
            </div>
        </div>
        <!-- START cards box-->
        <div class="row success">
            <?php 
            $adminId = 0;
            if( auth()->guard('admin')->check() ){
                $user_type = Auth::guard('admin')->user()->user_type;
            }
            ?>
            @if(isset($user_type) && $user_type == '1')
            <div class="col-lg-4">
                <a href="{{ url('admin/users')}}">
                    <!-- START card-->
                    <div class="card flex-row align-items-center align-items-stretch border-0">
                        <div class="col-4 d-flex align-items-center bg-primary-dark justify-content-center rounded-left">
                            <em class="icon-user fa-3x"></em>
                        </div>
                        <div class="col-8 py-3 bg-primary rounded-right">
                            <div class="h5 mt-0">Users</div>
                            <div class="">Active Users :
                                @if(isset($total_users)){{$total_users}}@else{{'0'}}@endif</div>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-lg-4">
                <a href="{{ url('admin/organizations')}}">
                    <!-- START card-->
                    <div class="card flex-row align-items-center align-items-stretch border-0">
                        <div class="col-4 d-flex align-items-center bg-purple-dark justify-content-center rounded-left">
                            <em class="icon-layers fa-3x"></em>
                        </div>
                        <div class="col-8 py-3 bg-purple rounded-right">
                            <div class="h5 mt-0">Organisations</div>
                            <div class="">Active Organisations :
                                @if(isset($total_organizations)){{$total_organizations}}@else{{'0'}}@endif</div>
                        </div>
                    </div>
                </a>
            </div>
            @endif
            <div class="col-lg-4">
                <a href="{{ url('admin/coach')}}">
                    <!-- START card-->
                    <div class="card flex-row align-items-center align-items-stretch border-0">
                        <div class="col-4 d-flex align-items-center bg-green-dark justify-content-center rounded-left">
                            <em class="icon-user fa-3x"></em>
                        </div>
                        <div class="col-8 py-3 bg-green rounded-right">
                            <div class="h5 mt-0">Coaches</div>
                            <div class="">Active Coaches :
                                @if(isset($total_coach)){{$total_coach}}@else{{'0'}}@endif</div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-lg-4">
                <a href="javascript:void(0);">
                    <!-- START card-->
                    <div class="card flex-row align-items-center align-items-stretch border-0">
                        <div class="col-4 d-flex align-items-center bg-primary-dark justify-content-center rounded-left">
                            <em class="icon-note fa-3x"></em>
                        </div>
                        <div class="col-8 py-3 bg-primary rounded-right">
                            <div class="h5 mt-0">Available Sessions</div>
                            <div class="">Total Available Sessions :
                                @if(isset($total_available_sessions)){{$total_available_sessions}}@else{{'0'}}@endif</div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-lg-4">
                <a href="{{ url('admin/sessions')}}">
                    <!-- START card-->
                    <div class="card flex-row align-items-center align-items-stretch border-0">
                        <div class="col-4 d-flex align-items-center bg-purple-dark justify-content-center rounded-left">
                            <em class="icon-note fa-3x"></em>
                        </div>
                        <div class="col-8 py-3 bg-purple rounded-right">
                            <div class="h5 mt-0">Booked Sessions</div>
                            <div class="">Total Booked Sessions :
                                @if(isset($total_book_sessions)){{$total_book_sessions}}@else{{'0'}}@endif</div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-lg-4">
                <a href="javascript:void(0);">
                    <!-- START card-->
                    <div class="card flex-row align-items-center align-items-stretch border-0">
                        <div class="col-4 d-flex align-items-center bg-green-dark justify-content-center rounded-left">
                            <em class="icon-note fa-3x"></em>
                        </div>
                        <div class="col-8 py-3 bg-green rounded-right">
                            <div class="h5 mt-0">Avaialble Weekly Sessions</div>
                            <div class="">Total Avaialble Weekly Sessions :
                                @if(isset($total_weekly_sessions)){{$total_weekly_sessions}}@else{{'0'}}@endif</div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-lg-4">
                @php
                $url = '/admin/sessions?session_start_date='.$weekStartDate.'&session_end_date='.$weekEndDate;
                @endphp
                <a href="{{ url($url)}}">
                    <!-- START card-->
                    <div class="card flex-row align-items-center align-items-stretch border-0">
                        <div class="col-4 d-flex align-items-center bg-primary-dark justify-content-center rounded-left">
                            <em class="icon-note fa-3x"></em>
                        </div>
                        <div class="col-8 py-3 bg-primary rounded-right">
                            <div class="h5 mt-0">Booked Weekly Sessions</div>
                            <div class="">Total Booked Weekly Sessions :
                                @if(isset($weekly_book_sessions)){{$weekly_book_sessions}}@else{{'0'}}@endif</div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-lg-4">
                <a href="{{ url('admin/coach/full-calender')}}">
                    <!-- START card-->
                    <div class="card flex-row align-items-center align-items-stretch border-0">
                        <div class="col-4 d-flex align-items-center bg-purple-dark justify-content-center rounded-left">
                            <em class="icon-note fa-3x"></em>
                        </div>
                        <div class="col-8 py-3 bg-purple rounded-right">
                            <div class="h5 mt-0">View Calender</div>
                            <div class=""></div>
                        </div>
                    </div>
                </a>
            </div>
        </div>
        <!-- END cards box-->
    </div>
</section>
@stop
@section('before_scripts')
<script>
</script>
@endsection
@section('footer_scripts')
<!-- FLOT CHART-->
<script src="{{asset('vendor/flot/jquery.flot.js')}}"></script>
<script src="{{asset('vendor/jquery.flot.tooltip/js/jquery.flot.tooltip.js')}}"></script>
<script src="{{asset('vendor/flot/jquery.flot.resize.js')}}"></script>
<script src="{{asset('vendor/flot/jquery.flot.pie.js')}}"></script>
<script src="{{asset('vendor/flot/jquery.flot.time.js')}}"></script>
<script src="{{asset('vendor/flot/jquery.flot.categories.js')}}"></script>
<script src="{{asset('vendor/jquery.flot.spline/jquery.flot.spline.js')}}"></script>
<script src="{{asset('vendor/easy-pie-chart/dist/jquery.easypiechart.js')}}"></script>
@endsection
