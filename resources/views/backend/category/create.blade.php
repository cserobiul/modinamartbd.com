@extends('backend.layouts.master')
@section('title', isset($pageTitle) ?  $pageTitle : 'Category')
@section('categoryList','active')
@section('customPluginCSS')
<link rel="stylesheet" href="{{ asset('assets/plugins/jquery-datatable/dataTables.bootstrap4.min.css') }}">
@endsection
@section('mainContent')
    <div class="body_scroll">
        <div class="block-header">
            <div class="row">
                <div class="col-lg-7 col-md-6 col-sm-12">
                    <h2> {{ isset($pageTitle) ?  $pageTitle : 'Category' }}</h2>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="zmdi zmdi-home"></i> Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('category.index') }}">{{ isset($pageTitle) ?  $pageTitle : 'Category' }}</a></li>
                        <li class="breadcrumb-item active">New and Category List</li>
                    </ul>
                    <button class="btn btn-primary btn-icon mobile_menu" type="button"><i class="zmdi zmdi-sort-amount-desc"></i></button>
                </div>
                <div class="col-lg-5 col-md-6 col-sm-12">
                    <button class="btn btn-primary btn-icon float-right right_icon_toggle_btn" type="button"><i class="zmdi zmdi-arrow-right"></i></button>
                </div>
            </div>
        </div>
        <div class="container-fluid">
         @canany(['category.create'])
            <div class="row clearfix">
                <div class="col-sm-12">
                    <form id="form_advanced_validation" method="POST" action="{{ route('category.store') }}" enctype="multipart/form-data">
                        @csrf
                        <label for="categoryName">Category Name</label>
                        <div class="form-group">
                            <input type="text" name="name" id="name" class="form-control" placeholder="Enter new Category Name" required>
                        </div>
                        @error('name')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                        <label for="showOrder">Show Order</label>
                        <div class="form-group">
                            <input type="number" min="1" name="order_sl" id="order_sl" class="form-control" placeholder="Enter Order" required>
                        </div>
                        @error('order_sl')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror

                        <div class="checkbox">
                            <input name="show_home" id="show_home" value="1" type="checkbox" checked>
                            <label for="show_home">
                                Checked if Show in Home
                            </label>
                        </div>

                        <label for="parent_category_name">Parent Category</label>
                        <select name="parent_category_name" class="form-control show-tick ms select2" data-placeholder="Select">
                                <option value="">--Select Parent Category--</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ ucwords($category->name) }}</option>
                                @foreach($category->children as $child)
                                    <option value="{{ $child->id }}">&nbsp;&nbsp; - {{ ucwords($child->name) }}</option>
                                @endforeach
                            @endforeach
                        </select>

                        @error('parent_category_name')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror

                        <label for="photo" class="mt-2">Category Photo</label>
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

                        <button type="submit" class="btn btn-raised btn-primary btn-round waves-effect">Create</button>
                    </form>
                </div>
            </div>
         @endcanany
         @canany(['category.all'])
             @include('backend.category.index')
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
