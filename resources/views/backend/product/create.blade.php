@extends('backend.layouts.master')
@section('title', isset($pageTitle) ?  $pageTitle : 'New Product')
@section('productCreate','active')
@section('customPluginCSS')
<!-- Multi Select Css -->
<link rel="stylesheet" href="{{ asset('assets/plugins/multi-select/css/multi-select.css') }}">
<link rel="stylesheet" href="{{ asset('assets/plugins/summernote/dist/summernote.css') }}">
<!-- Bootstrap Select Css -->
<link rel="stylesheet" href="{{ asset('assets/plugins/bootstrap-select/css/bootstrap-select.css') }}" />
<!-- Select2 -->
<link rel="stylesheet" href="{{ asset('assets/plugins/select2/select2.css') }}" />
@endsection
@section('mainContent')
<div class="body_scroll">
    <div class="block-header">
        <div class="row">
            <div class="col-lg-7 col-md-6 col-sm-12">
                <h2> {{ isset($pageTitle) ?  $pageTitle : 'Product Create' }}</h2>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="zmdi zmdi-home"></i> Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('product.index') }}">Products</a></li>
                    <li class="breadcrumb-item active">New Product</li>
                </ul>
                <button class="btn btn-primary btn-icon mobile_menu" type="button"><i class="zmdi zmdi-sort-amount-desc"></i></button>
            </div>
            <div class="col-lg-5 col-md-6 col-sm-12">
                <button class="btn btn-primary btn-icon float-right right_icon_toggle_btn" type="button"><i class="zmdi zmdi-arrow-right"></i></button>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row clearfix">
            <div class="col-sm-12">
                <div class="card">
                    <div class="header">
                        <h2><strong>{{ isset($pageTitle) ?  $pageTitle : 'New Product' }}</strong></h2>
                        @canany(['product.all'])
                            <a class="btn btn-raised btn-primary btn-round waves-effect" href="{{ route('product.index') }}">Product List</a>
                        @endcanany
                    </div>
                    @include('backend.layouts._alert')
                    @include('backend.layouts._error_display')
                    <div class="body" style="border: 2px solid #dddddd;">
                        <form id="form_advanced_validation" method="POST" action="{{ route('product.store') }}" enctype="multipart/form-data">
                            @csrf
                             <div class="card">
                                <div class="body">
                                    <div class="row clearfix">
                                        <div class="col-md-12 pb-2">
                                            <label for="name">Product Name</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="zmdi zmdi-shopping-cart"></i></span>
                                                </div>
                                                <input type="text" name="name" id="name" value="{{ old('name') }}" class="form-control" placeholder="Type Full Name" autofocus required>
                                            </div>
                                            @error('name')
                                            <div class="text-danger pt-2">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row clearfix">
                                        <div class="col-md-6 pb-2">
                                            <label for="code">Code</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="zmdi zmdi-code"></i></span>
                                                </div>
                                                <input type="text" name="code" value="{{ old('code') }}" class="form-control" placeholder="Type Product Code">
                                            </div>
                                            @error('code')
                                            <div class="text-danger pt-2">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-6 pb-2">
                                            <label for="brand_name">Brand</label>
                                            <select name="brand_name" class="form-control show-tick ms select2" data-placeholder="Select">
                                                <option value="">--Select Brand--</option>
                                                @foreach(\App\Models\Brand::where('status','active')->orderBy('brand_name')->get() as $brand)
                                                    <option value="{{ $brand->id }}" @if(old('brand_name') == $brand->id) selected @endif>{{ ucwords($brand->brand_name) }}</option>
                                                @endforeach
                                            </select>
                                            @error('brand_name')
                                            <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row clearfix">
                                        <div class="col-md-6 pb-2">
                                            <label for="category_name">Category</label>
                                            <select name="category_name" class="form-control show-tick ms select2" data-placeholder="Select">
                                                <option value="">--Select Category--</option>
                                                @foreach($categories as $category)
                                                    <option value="{{ $category->id }}">{{ ucwords($category->name) }}</option>
                                                    @foreach($category->children as $child)
                                                        <option value="{{ $child->id }}" class="font-weight-bold" @if(old('category_name') == $child->id) selected @endif>&nbsp;&nbsp; - {{ ucwords($child->name) }}</option>
                                                        @foreach($child->children as $child2)
                                                            <option value="{{ $child2->id }}" class="font-weight-bold" @if(old('category_name') == $child2->id) selected @endif>&nbsp;&nbsp;&nbsp;&nbsp;-- {{ ucwords($child2->name) }}</option>
                                                        @endforeach
                                                    @endforeach
                                                @endforeach
                                            </select>
                                            @error('category_name')
                                            <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-6 pb-2">
                                            <label for="unit_name">Unit</label>
                                            <select name="unit_name" class="form-control show-tick ms select2" data-placeholder="Select">
                                                {{-- <option value="">--Select Unit--</option>--}}
                                                @foreach(\App\Models\Unit::where('status','active')->orderBy('id')->get() as $unit)
                                                    <option value="{{ $unit->id }}" >{{ ucwords($unit->unit_name) }}</option>
                                                @endforeach
                                            </select>
                                            @error('unit_name')
                                            <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row clearfix">
                                        <div class="col-md-6 pb-2">
                                            <label for="sale_price">Sale Price</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="zmdi zmdi-money"></i></span>
                                                </div>
                                                <input type="number" min="1" max="9999999" name="sale_price" value="{{ old('sale_price') }}"  class="form-control" placeholder="Input Sale Price" required>
                                            </div>
                                            @error('sale_price')
                                            <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-6 pb-2">
                                            <label for="discount_amount">Discount Amount</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="zmdi zmdi-money"></i></span>
                                                </div>
                                                <input type="number" min="1" max="9999999" name="discount_amount" value="{{ old('discount_amount') }}"  class="form-control" placeholder="Blank if no discount">
                                            </div>
                                            @error('discount_amount')
                                            <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row clearfix">
                                        <div class="col-md-6 pb-2">
                                            <label for="view_section">View Section</label>
                                            <select name="view_section" class="form-control show-tick ms select2" data-placeholder="Select">
                                                <option value="">--Select View Section--</option>
                                                <option>BEST_SELLER</option>
                                                <option selected>NEW_ARRIVAL</option>
                                                <option>JUST_FOR_YOU</option>
                                                <option>MOST_POPULAR</option>
                                                <option>FLASH_SELL</option>
                                                <option>SPECIAL_OFFER</option>
                                            </select>
                                            @error('view_section')
                                            <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-3 pb-2">
                                            <label for="point">Reward Point</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="zmdi zmdi-money"></i></span>
                                                </div>
                                                <input type="number" min="1" max="10000" name="point" value="{{ old('point') }}"  class="form-control" placeholder="e.g: 100" required>
                                            </div>
                                            @error('point')
                                            <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-3 pb-2">
                                            <label for="hasStock"> Has Stock</label>
                                            <div class="checkbox">
                                                <input name="has_stock" id="hasStock" value="1" type="checkbox">
                                                <label for="hasStock">
                                                    Checked if Has Stock
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row clearfix">
                                        <div class="col-md-6 pb-2">
                                            <label for="photo">Product Default Photo</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="zmdi zmdi-image-o"></i></span>
                                                </div>
                                                <input type="file" name="photo" class="form-control" placeholder="photo">
                                            </div>
                                            <span style="color: red !important;">Note: Recommended Photo Size 800px X 800px</span>
                                            @error('photo')
                                            <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-6 pb-2">
                                            <label for="multiple_photo">Product Multiple Photo</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="zmdi zmdi-collection-image"></i></span>
                                                </div>
                                                <input type="file" name="multiple_photo[]" class="form-control" placeholder="multiple photo" multiple>
                                            </div>
                                            @error('multiple_photo')
                                            <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>

                                    </div>

                                    <div class="row clearfix">
                                        <div class="col-md-6 pb-2">
                                            <label for="details">Product Short Description</label>
                                            <textarea name="excerpts" class="summernote">
                                                {{ old('excerpts') }}
                                            </textarea>
                                            <span style="">Note: Max Character length 250</span>
                                        </div>
                                        <div class="col-md-6 pb-2">
                                            <label for="details">Product Full Description</label>
                                            <textarea name="details" class="summernote">
                                                {{ old('details') }}
                                            </textarea>
                                            <span style="">Note: Max Character length 1000</span>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <button type="submit" class="btn btn-raised btn-primary btn-round waves-effect">Create Product</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('customPluginJS')
<script src="{{ asset('assets/plugins/multi-select/js/jquery.multi-select.js') }}"></script> <!-- Multi Select Plugin Js -->
<script src="{{ asset('assets/plugins/select2/select2.min.js') }}"></script> <!-- Select2 Js -->
@endsection
@section('customJS')
<script src="{{ asset('assets/js/pages/forms/advanced-form-elements.js') }}"></script>
<script src="{{ asset('assets/js/pages/forms/form-validation.js') }}"></script>
<script src="{{ asset('assets/plugins/summernote/dist/summernote.js') }}"></script>
<script>
    $(function() {
        $( "#name" ).focus();
    });
</script>
@endsection
