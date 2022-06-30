@extends('backend.layouts.master')
@section('title', isset($pageTitle) ?  $pageTitle : 'Notebook')
@section('notebookList','active')
@section('customPluginCSS')
<link rel="stylesheet" href="{{ asset('assets/plugins/jquery-datatable/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/plugins/summernote/dist/summernote.css') }}">
<style>
    td{ vertical-align: middle !important;}
</style>
@endsection
@section('mainContent')
    <div class="body_scroll">
        <div class="block-header">
            <div class="row">
                <div class="col-lg-7 col-md-6 col-sm-12">
                    <h2> {{ isset($pageTitle) ?  $pageTitle : 'Notebook' }}</h2>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="zmdi zmdi-home"></i> Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('notebook.index') }}">{{ isset($pageTitle) ?  $pageTitle : 'Notebooks' }}</a></li>
                        <li class="breadcrumb-item active">New and Notebook List</li>
                    </ul>
                    <button class="btn btn-primary btn-icon mobile_menu" type="button"><i class="zmdi zmdi-sort-amount-desc"></i></button>
                </div>
                <div class="col-lg-5 col-md-6 col-sm-12">
                    <button class="btn btn-primary btn-icon float-right right_icon_toggle_btn" type="button"><i class="zmdi zmdi-arrow-right"></i></button>
                </div>
            </div>
        </div>
        <div class="container-fluid">
         @canany(['notebook.create'])
            <div class="row clearfix">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="body" style="border: 2px solid #dddddd;">
                        <form id="form_advanced_validation" method="POST" action="{{ route('notebook.store') }}" enctype="multipart/form-data">
                        @csrf
                            <div class="row clearfix">
                                <div class="col-md-8 pb-2">
                                    <label for="title">Note Title</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="zmdi zmdi-calendar-note"></i></span>
                                        </div>
                                        <input type="text" name="title" id="title" value="{{ old('title') }}" class="form-control" placeholder="Type Note Title" autofocus required>
                                    </div>
                                    @error('title')
                                    <div class="text-danger pt-2">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4 pb-2">
                                    <label for="phone">Phone</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="zmdi zmdi-phone"></i></span>
                                        </div>
                                        <input type="text" name="phone" value="{{ old('phone') }}" class="form-control" placeholder="Input Phone no">
                                    </div>
                                    @error('phone')
                                    <div class="text-danger pt-2">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row clearfix">
                                <div class="col-md-12 pb-2">
                                    <label for="details">Note Description</label>
                                    <textarea name="details" class="summernote">
                                                {{ old('details') }}
                                            </textarea>
                                    <span style="">Note: Max Character length 1000</span>
                                    @error('details')
                                    <div class="text-danger pt-2">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row clearfix">
                                <div class="col-md-6">
                                    <label for="photo">Note Photo</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="zmdi zmdi-collection-image"></i></span>
                                        </div>
                                        <input type="file" name="photo" class="form-control" placeholder="notebook photo">
                                    </div>
                                </div>
                            </div>
                        <button type="submit" class="btn btn-raised btn-primary btn-round waves-effect">Create</button>
                    </form>
                        </div>
                    </div>
                </div>
            </div>
         @endcanany
         @canany(['notebook.all'])
             @includeIf('backend.notebook.index')
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
<script src="{{ asset('assets/js/pages/forms/advanced-form-elements.js') }}"></script>
<script src="{{ asset('assets/js/pages/tables/jquery-datatable.js') }}"></script>
<script src="{{ asset('assets/plugins/summernote/dist/summernote.js') }}"></script>
<script>
    $(function() {
        $( "#title" ).focus();
    });
</script>
@endsection
