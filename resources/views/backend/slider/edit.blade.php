@extends('backend.layouts.master')
@section('title', isset($pageTitle) ?  $pageTitle : 'Slider Update')
@section('sliderList','active')
@section('customPluginCSS')
    <link rel="stylesheet" href="{{ asset('assets/plugins/jquery-datatable/dataTables.bootstrap4.min.css') }}">
    <style>
        td{ vertical-align: middle !important;}
    </style>
@endsection
@section('mainContent')
    <div class="body_scroll">
        <div class="block-header">
            <div class="row">
                <div class="col-lg-7 col-md-6 col-sm-12">
                    <h2> {{ isset($pageTitle) ?  $pageTitle : 'Slider Update' }}</h2>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="zmdi zmdi-home"></i> Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('slider.index') }}">{{ isset($pageTitle) ?  $pageTitle : 'Sliders' }}</a></li>
                        <li class="breadcrumb-item active">Update and Slider List</li>
                    </ul>
                    <button class="btn btn-primary btn-icon mobile_menu" type="button"><i class="zmdi zmdi-sort-amount-desc"></i></button>
                </div>
                <div class="col-lg-5 col-md-6 col-sm-12">
                    <button class="btn btn-primary btn-icon float-right right_icon_toggle_btn" type="button"><i class="zmdi zmdi-arrow-right"></i></button>
                </div>
            </div>
        </div>
        <div class="container-fluid">
            @canany(['slider.create'])
                <div class="row clearfix">
                    <div class="col-sm-12">
                        <div class="card">
                            <div class="body" style="border: 2px solid #dddddd;">
                                <form id="form_advanced_validation" method="POST" action="{{ route('slider.update',$slider->id) }}" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    <div class="row clearfix">
                                        <div class="col-md-12 pb-2">
                                            <label for="title">Slider Title</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="zmdi zmdi-photo-size-select-large"></i></span>
                                                </div>
                                                <input type="text" name="title" value="{{ old('title',isset($slider->title)?$slider->title:null) }}" class="form-control" placeholder="Type Slider Title" autofocus required>
                                            </div>
                                            @error('title')
                                            <div class="text-danger pt-2">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row clearfix">
                                        <div class="col-md-3 pb-2">
                                            <label for="order">View Order</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="zmdi zmdi-code"></i></span>
                                                </div>
                                                <input type="number" name="order" min="1" value="{{ old('order',isset($slider->order)?$slider->order:null) }}" class="form-control" placeholder="Select Slider Order">
                                            </div>
                                            @error('order')
                                            <div class="text-danger pt-2">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-6 pb-2">
                                            <label for="url">URL</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="zmdi zmdi-code"></i></span>
                                                </div>
                                                <input type="url" name="url"  value="{{ old('url',isset($slider->url)?$slider->url:null) }}" class="form-control" placeholder="Input valid url https://www.facebook.com">
                                            </div>
                                            @error('url')
                                            <div class="text-danger pt-2">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-3 pb-2">
                                            <label for="status">Status</label>
                                            <select name="status" class="form-control show-tick ms select2" data-placeholder="Select">
                                                <option value="active" @if(old('status',isset($product->status)?$product->status:null) == 'active') selected @endif>Active</option>
                                                <option value="inactive" @if(old('status',isset($product->status)?$product->status:null) == 'inactive') selected @endif>Inactive</option>
                                            </select>
                                            @error('status')
                                            <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row clearfix">
                                        <div class="col-md-6 pb-2">
                                            <label for="photo">Slider Photo</label>
                                            @if($slider->photo !=null)
                                                <br>
                                                <img src="{{ asset($slider->photo) }}" alt="Slider Photo" class="rounded" style="width: 140px; margin-bottom: 15px !important;">
                                            @endif
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="zmdi zmdi-collection-image"></i></span>
                                                </div>
                                                <input type="file" name="photo" class="form-control" placeholder="slider photo">
                                            </div>
                                            @error('photo')
                                            <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-raised btn-primary btn-round waves-effect">Update</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endcanany
            @canany(['slider.all'])
                @include('backend.slider.index')
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
