@extends('backend.layouts.master')
@section('title', isset($pageTitle) ?  $pageTitle : 'Online Customer Point Details')
@section('customerPoint','active')
@section('customPluginCSS')
    <!-- Multi Select Css -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/multi-select/css/multi-select.css') }}">
    <!-- Bootstrap Select Css -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/bootstrap-select/css/bootstrap-select.css') }}"/>
    <!-- Select2 -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/select2/select2.css') }}"/>
    {{--    datatable--}}
    <link rel="stylesheet" href="{{ asset('assets/plugins/jquery-datatable/dataTables.bootstrap4.min.css') }}">
@endsection
@section('mainContent')
    <div class="body_scroll">
        <div class="block-header">
            <div class="row">
                <div class="col-lg-7 col-md-6 col-sm-12">
                    <h2> {{ isset($pageTitle) ?  $pageTitle : 'Online Customer Point Details' }}</h2>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="zmdi zmdi-home"></i>
                                Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('customerPoint') }}">Online Customer Points</a></li>
                        <li class="breadcrumb-item active">Online Customer Point Details</li>
                    </ul>
                    <button class="btn btn-primary btn-icon mobile_menu" type="button"><i
                            class="zmdi zmdi-sort-amount-desc"></i></button>
                </div>
                <div class="col-lg-5 col-md-6 col-sm-12">
                    <button class="btn btn-primary btn-icon float-right right_icon_toggle_btn" type="button"><i
                            class="zmdi zmdi-arrow-right"></i></button>
                </div>
            </div>
        </div>
        <div class="container-fluid">
            @canany(['report.show'])
                <div class="row clearfix">
                    {{-- customer list start --}}
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <div class="card">
                            <div class="header">
                                <h2><strong>Online Customer Point Details</strong></h2> <br>
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                        <tr>
                                            <th colspan="3">Customer
                                                Name: {{ \App\Models\Settings::unicodeName($customerDetails->customer_name) }}</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <th>Join Date: {{ date('d M Y',strtotime($customerDetails->created_at)) }}</th>
                                            <th>Phone: {{ $customerDetails->phone }}</th>
                                            <th>Email: {{ $customerDetails->email }}</th>
                                        </tr>
                                        <tr>
                                            <th>Total Earn
                                                Point: {{ \App\Models\Reward::customerEarnPoints($customerDetails->id) }}
                                            </th>
                                            <th>Total Withdraw
                                                Point: {{ \App\Models\Reward::customerWithdrawPoints($customerDetails->id) }}
                                            </th>
                                            <th>Total Remaining
                                                Point: {{ \App\Models\Reward::customerRemainingPoints($customerDetails->id) }}
                                            </th>
                                        </tr>

                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            {{-- Point History--}}
                            <h5><strong>Rewards Point History</strong></h5>
                            <div class="body" style="border: 2px solid #dddddd;">
                                @if(count($points) > 0)
                                    <div class="table-responsive">
                                        <table
                                            class="table table-bordered table-striped table-hover dataTable js-exportable text-center">
                                            <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Date</th>
                                                <th>Points</th>
                                                <th>Status</th>
                                                <th>Purpose</th>
                                            </tr>
                                            </thead>

                                            <tbody>
                                            @foreach($points as $key => $point)
                                                <tr>
                                                    <td>{{ $key+1 }}</td>
                                                    <td>{{ date('d M Y',strtotime($point->created_at)) }}</td>
                                                    <td>{{ $point->point }}</td>
                                                    <td>{{ $point->type == 0 ? 'Earn' : 'Withdraw' }}</td>
                                                    <td>{{ $point->purpose }}</td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @else
                                    <div class="col-md-6">
                                        <h6 class="pt-3 text-danger"> No Point History Found... </h6>
                                    </div>
                                @endif
                            </div>

                        </div>
                    </div>
                    {{-- customer list end --}}
                </div>
            @endcanany


        </div>
    </div>
@endsection
@section('customPluginJS')
    <script
        src="{{ asset('assets/plugins/multi-select/js/jquery.multi-select.js') }}"></script> <!-- Multi Select Plugin Js -->
    <script src="{{ asset('assets/plugins/select2/select2.min.js') }}"></script> <!-- Select2 Js -->
    <script src="{{ asset('assets/bundles/datatablescripts.bundle.js') }}"></script>
    <script src="{{ asset('assets/plugins/jquery-datatable/buttons/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/jquery-datatable/buttons/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/jquery-datatable/buttons/buttons.colVis.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/jquery-datatable/buttons/buttons.flash.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/jquery-datatable/buttons/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/jquery-datatable/buttons/buttons.print.min.js') }}"></script>
@endsection
@section('customJS')
    <script src="{{ asset('assets/js/pages/forms/advanced-form-elements.js') }}"></script>
    <script src="{{ asset('assets/js/pages/tables/jquery-datatable.js') }}"></script>
@endsection
