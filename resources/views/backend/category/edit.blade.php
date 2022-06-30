@extends('backend.layouts.master')
@section('title', isset($pageTitle) ?  $pageTitle : 'Category Update')
@section('categoryList','active')
@section('customPluginCSS')
    <link rel="stylesheet" href="{{ asset('assets/plugins/jquery-datatable/dataTables.bootstrap4.min.css') }}">
@endsection
@section('mainContent')
    <div class="body_scroll">
        <div class="block-header">
            <div class="row">
                <div class="col-lg-7 col-md-6 col-sm-12">
                    <h2> {{ isset($pageTitle) ?  $pageTitle : 'Category Update' }}</h2>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="zmdi zmdi-home"></i> Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('category.index') }}">{{ isset($pageTitle) ?  $pageTitle : 'Category' }}</a></li>
                        <li class="breadcrumb-item active">Update and Category List</li>
                    </ul>
                    <button class="btn btn-primary btn-icon mobile_menu" type="button"><i class="zmdi zmdi-sort-amount-desc"></i></button>
                </div>
                <div class="col-lg-5 col-md-6 col-sm-12">
                    <button class="btn btn-primary btn-icon float-right right_icon_toggle_btn" type="button"><i class="zmdi zmdi-arrow-right"></i></button>
                </div>
            </div>
        </div>
        <div class="container-fluid">
         @canany(['category.update'])
            <div class="row clearfix">
                <div class="col-sm-12">
                    <form id="form_advanced_validation" method="POST" action="{{ route('category.update',$category->id) }}" enctype="multipart/form-data">
                        @csrf
                        @method('put')
                        <label for="name">Category Name</label>
                        <div class="form-group">
                            <input type="text" name="name" value="{{ old('name',isset($category->name)?$category->name:null) }}" id="name" class="form-control" placeholder="Enter Category Name" required>
                        </div>
                        @error('name')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                        <label for="slug">Category Slug</label>
                        <div class="form-group">
                            <input type="text" name="slug" value="{{ old('slug',isset($category->slug)?$category->slug:null) }}" id="slug" class="form-control" placeholder="Enter Category Name" required>
                        </div>
                        @error('slug')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror

                        <label for="showOrder">Show Order</label>
                        <div class="form-group">
                            <input type="number" min="1" name="order_sl" id="order_sl" value="{{ old('order_sl',isset($category->order_sl)?$category->order_sl:null) }}" class="form-control" placeholder="Enter Order" required>
                        </div>
                        @error('order_sl')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror

                        <div class="checkbox">
                            <input name="show_home" id="show_home" value="1" type="checkbox" {{ ($category->show_home == 1)?'checked':null }}>
                            <label for="show_home">
                                Checked if Show in Home
                            </label>
                        </div>

                        <label for="parent_category_name">Parent Category</label>
{{--                        <select name="parent_category_name" class="form-control show-tick ms select2" data-placeholder="Select">--}}
{{--                            <option value="">--Select Parent Category--</option>--}}
{{--                            @foreach(\App\Models\Category::whereNull('parent_id')->orderBy('name')->get() as $subcategory)--}}
{{--                                <option value="{{ $subcategory->id }}" @if(old('parent_category_name',isset($subcategory->id )?$subcategory->id :null) == $category->parent_id) selected @endif>{{ ucwords($subcategory->name) }}</option>--}}
{{--                            @endforeach--}}
{{--                        </select>--}}
                        <select name="parent_category_name" class="form-control show-tick ms select2" data-placeholder="Select">
                            <option value="">--Select Parent Category--</option>
                            @foreach($categories as $cat1)
                                <option value="{{ $cat1->id }}"  @if(old('parent_category_name',isset($cat1->id )?$cat1->id :null) == $category->parent_id) selected @endif>{{ ucwords($cat1->name) }}</option>
                                @foreach($cat1->children as $child)
                                    <option value="{{ $child->id }}"  @if(old('parent_category_name',isset($child->id )?$child->id :null) == $category->parent_id) selected @endif>&nbsp;&nbsp; - {{ ucwords($child->name) }}</option>
                                @endforeach
                            @endforeach
                        </select>

                        @error('parent_category_name')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror

                        <label for="status" class="mt-2">Status</label>
                        <select name="status" class="form-control show-tick ms select2" data-placeholder="Select">
                            <option value="active" @if(old('status',isset($category->status)?$category->status:null) == 'active') selected @endif>Active</option>
                            <option value="inactive" @if(old('status',isset($category->status)?$category->status:null) == 'inactive') selected @endif>Inactive</option>
                        </select>

                        @error('status')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror

                        <label for="photo" class="mt-2">Photo</label>
                        @if($category->photo !=null)
                            <br>
                            <img src="{{ asset($category->photo) }}" alt="Category Image" class="rounded" style="width: 140px; margin-bottom: 15px !important; border: 1px solid red !important;">
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
