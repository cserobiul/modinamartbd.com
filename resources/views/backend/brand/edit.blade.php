@extends('backend.layouts.master')
@section('title', isset($pageTitle) ?  $pageTitle : 'Brand Update')
@section('brandList','active')
@section('customPluginCSS')
    <link rel="stylesheet" href="{{ asset('assets/plugins/jquery-datatable/dataTables.bootstrap4.min.css') }}">
@endsection
@section('mainContent')
    <div class="body_scroll">
        <div class="block-header">
            <div class="row">
                <div class="col-lg-7 col-md-6 col-sm-12">
                    <h2> {{ isset($pageTitle) ?  $pageTitle : 'Brand Update' }}</h2>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="zmdi zmdi-home"></i> Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('brand.index') }}">{{ isset($pageTitle) ?  $pageTitle : 'Brands' }}</a></li>
                        <li class="breadcrumb-item active">Update and Brand List</li>
                    </ul>
                    <button class="btn btn-primary btn-icon mobile_menu" type="button"><i class="zmdi zmdi-sort-amount-desc"></i></button>
                </div>
                <div class="col-lg-5 col-md-6 col-sm-12">
                    <button class="btn btn-primary btn-icon float-right right_icon_toggle_btn" type="button"><i class="zmdi zmdi-arrow-right"></i></button>
                </div>
            </div>
        </div>
        <div class="container-fluid">
         @canany(['brand.update'])
            <div class="row clearfix">
                <div class="col-sm-12">
                    <form id="form_advanced_validation" method="POST" action="{{ route('brand.update',$brand->id) }}" enctype="multipart/form-data">
                        @csrf
                        @method('put')
                        <label for="brandName">Brand Name</label>
                        <div class="form-group">
                            <input type="text" name="brand_name" value="{{ old('brand_name',isset($brand->brand_name)?$brand->brand_name:null) }}" id="brandName" class="form-control" placeholder="Enter Brand Name" required>
                        </div>
                        @error('brand_name')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                        <label for="brandName">Status</label>
                        <select name="status" class="form-control show-tick ms select2" data-placeholder="Select">
                            <option value="active" @if(old('status',isset($brand->status)?$brand->status:null) == 'active') selected @endif>Active</option>
                            <option value="inactive" @if(old('status',isset($brand->status)?$brand->status:null) == 'inactive') selected @endif>Inactive</option>
                        </select>

                        @error('status')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror

                        <label for="photo" class="mt-2">Photo</label>
                        @if($brand->photo !=null)
                            <br>
                            <img src="{{ asset($brand->photo) }}" alt="Brand Image" class="rounded" style="width: 140px; margin-bottom: 15px !important; border: 1px solid red !important;">
                        @endif
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="zmdi zmdi-image-o"></i></span>
                            </div>
                            <input type="file" name="photo" class="form-control" placeholder="photo">
                        </div>
                        <span style="color: red !important;">Note: Recommended Photo Size 400px X 400px</span>
                        @error('photo')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror

                        <button type="submit" class="btn btn-raised btn-primary btn-round waves-effect">Update</button>
                    </form>
                </div>
            </div>
         @endcanany
         @canany(['brand.all'])
            @include('backend.brand.index')
         @endcanany
        </div>
    </div>
@endsection
@section('customPluginJS')
    <script src="{{ asset('assets/bundles/datatablescripts.bundle.js') }}"></script>
    <script src="{{ asset('assets/plugins/jquery-datatable/buttons/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/jquery-datatable/buttons/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/jquery-datatable/buttons/buttons.colVis.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/jquery-datatable/buttons/buttons.flash.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/jquery-datatable/buttons/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/jquery-datatable/buttons/buttons.print.min.js') }}"></script>
@endsection
@section('customJS')
    <script src="{{ asset('assets/js/pages/tables/jquery-datatable.js') }}"></script>
@endsection
