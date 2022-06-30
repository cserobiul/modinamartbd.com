@extends('backend.layouts.master')
@section('title', isset($pageTitle) ?  $pageTitle : 'Update Product')
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
                    <li class="breadcrumb-item active">Update Product</li>
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
                        <h2><strong>{{ isset($pageTitle) ?  $pageTitle : 'Update Product' }}</strong></h2>
                        @canany(['product.create'])
                            <a class="btn btn-raised btn-primary btn-round waves-effect" href="{{ route('product.create') }}">New Product</a>
                        @endcanany
                        @canany(['product.all'])
                            <a class="btn btn-raised btn-primary btn-round waves-effect" href="{{ route('product.index') }}">Product List</a>
                        @endcanany

                    </div>
                    @include('backend.layouts._alert')
                    @include('backend.layouts._error_display')
                    <div class="body" style="border: 2px solid #dddddd;">
                        <form id="form_advanced_validation" method="POST" action="{{ route('product.update',$product->id) }}" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                             <div class="card">
                                <div class="body">
                                    <div class="row clearfix">
                                        <div class="col-md-12 pb-2">
                                            <label for="name">Product Name</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="zmdi zmdi-shopping-cart"></i></span>
                                                </div>
                                                <input type="text" name="name" id="name" value="{{ old('name',isset($product->name)?$product->name:null) }}" class="form-control" placeholder="Type Full Name" autofocus required>
                                            </div>
                                            @error('name')
                                            <div class="text-danger pt-2">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row clearfix">
                                        <div class="col-md-12 pb-2">
                                            <label for="name">Product Slug</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="zmdi zmdi-shopping-cart"></i></span>
                                                </div>
                                                <input type="text" name="slug" value="{{ old('slug',isset($product->slug)?$product->slug:null) }}" class="form-control" placeholder="Type slug" required>
                                            </div>
                                            @error('slug')
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
                                                <input type="text" name="code" value="{{ old('code',isset($product->code)?$product->code:null) }}" class="form-control" placeholder="Type Product Code">
                                            </div>
                                            @error('code')
                                            <div class="text-danger pt-2">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-6 pb-2">
                                            <label for="brand_name">Brand</label>
                                            <select name="brand_name" class="form-control show-tick ms select2" data-placeholder="Select">
                                                <option value="">--Select Brand--</option>
                                                @foreach(\App\Models\Brand::orderBy('brand_name')->get() as $brand)
                                                    <option value="{{ $brand->id }}" @if(old('brand_name',isset($brand->id)?$brand->id : null) == $product->brand_id) selected @endif>{{ ucwords($brand->brand_name) }}</option>
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
                                                    <option value="{{ $category->id }}"> {{ ucwords($category->name) }}</option>>
                                                        @foreach($category->children as $child)
                                                            <option value="{{ $child->id }}" class="font-weight-bold"
                                                                    @if(old('category_name',isset($child->id)?$child->id : null) == $product->category_id) selected @endif>&nbsp;&nbsp; - {{ ucwords($child->name) }}</option>
                                                            @foreach($child->children as $child2)
                                                                <option value="{{ $child2->id }}" class="font-weight-bold"
                                                                        @if(old('category_name',isset($child2->id)?$child2->id : null) == $product->category_id) selected @endif>&nbsp;&nbsp;&nbsp;&nbsp;-- {{ ucwords($child2->name) }}</option>
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
                                                <option value="">--Select Unit--</option>
                                                @foreach(\App\Models\Unit::where('status','active')->orderBy('unit_name')->get() as $unit)
                                                    <option value="{{ $unit->id }}" @if(old('unit_name',isset($unit->id)?$unit->id : null) == $product->unit_id) selected @endif>{{ ucwords($unit->unit_name) }}</option>
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
                                                <input type="number" min="1" max="9999999" name="sale_price" value="{{ old('sale_price',isset($product->sale_price)?$product->sale_price:null) }}"  class="form-control" placeholder="Input Sale Price" required>
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
                                                <input type="number" min="1" max="9999999" name="discount_amount" value="{{ old('discount_amount',isset($product->discount_amount)?$product->discount_amount:null) }}"  class="form-control" placeholder="Blank if no discount">
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
                                                <option value="BEST_SELLER" @if(old('view_section',isset($product->view_section)?$product->view_section:null) == 'BEST_SELLER') selected @endif>BEST_SELLER</option>
                                                <option value="NEW_ARRIVAL" @if(old('view_section',isset($product->view_section)?$product->view_section:null) == 'NEW_ARRIVAL') selected @endif>NEW_ARRIVAL</option>
                                                <option value="JUST_FOR_YOU" @if(old('view_section',isset($product->view_section)?$product->view_section:null) == 'JUST_FOR_YOU') selected @endif>JUST_FOR_YOU</option>
                                                <option value="MOST_POPULAR" @if(old('view_section',isset($product->view_section)?$product->view_section:null) == 'MOST_POPULAR') selected @endif>MOST_POPULAR</option>
                                                <option value="FLASH_SELL" @if(old('view_section',isset($product->view_section)?$product->view_section:null) == 'FLASH_SELL') selected @endif>FLASH_SELL</option>
                                                <option value="SPECIAL_OFFER" @if(old('view_section',isset($product->view_section)?$product->view_section:null) == 'SPECIAL_OFFER') selected @endif>SPECIAL_OFFER</option>
                                            </select>
                                            @error('view_section')
                                            <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-3 pb-2">
                                            <label for="point">Point</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="zmdi zmdi-money"></i></span>
                                                </div>
                                                <input type="number" min="1" max="10000" name="point" value="{{ old('point',isset($product->point)?$product->point:null) }}"  class="form-control" placeholder="e.g: 50">
                                            </div>
                                            @error('point')
                                            <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-3 pb-2">
                                            <label for="hasStock"> Has Stock</label>
                                            <div class="checkbox">
                                                <input name="has_stock" id="hasStock" value="1" type="checkbox" {{ ($product->has_stock == 1)?'checked':null }}>
                                                <label for="hasStock">
                                                    Checked if Has Stock
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row clearfix">
                                        <div class="col-md-6 pb-2">
                                            <label for="details">Product Short Description</label>
                                            <textarea name="excerpts" class="summernote">{{ old('excerpts',isset($product->excerpts)?$product->excerpts:null) }}</textarea>
                                            <span style="">Note: Max Character length 250</span>
                                        </div>
                                        <div class="col-md-6 pb-2">
                                            <label for="details">Product Full Description</label>
                                            <textarea name="details" class="summernote">{{ old('details',isset($product->details)?$product->details:null) }}</textarea>
                                            <span style="">Note: Max Character length 1000</span>
                                        </div>
                                    </div>

                                    <div class="row clearfix">
                                        <div class="col-md-6 mt-5">
                                            <label for="logo"><strong>Product Photo</strong></label>
                                            @if($product->photo !=null)
                                                <br>
                                                <img src="{{ asset($product->photo) }}" alt="Product Image" class="rounded" style="width: 140px; margin-bottom: 15px !important; border: 1px solid red !important;">
                                            @endif
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="zmdi zmdi-image-o"></i></span>
                                                </div>
                                                <input type="file" name="photo" class="form-control" placeholder="photo">
                                            </div>
                                            <span style="">Note: Recommended Photo Size 800px X 800px</span>
                                            @error('photo')
                                            <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-6 mt-5">
                                            <label for="logo"><strong>Product Multiple Photo</strong></label>
                                            @if(count($productPhotos) > 0)
                                                <div class="input-group">
                                                    @foreach($productPhotos as $photo)
                                                        <img src="{{ asset($photo->photo) }}" alt="Product Image" class="rounded" style="width: 140px; margin-bottom: 15px !important; border: 1px solid red !important;">
                                                    @endforeach
                                                </div>
                                            @else
                                                <br>
                                                No Multiple Photo Found!
                                                <br>
                                            @endif
                                            <div class="input-group mt-3">
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
                                        <div class="col-md-6 pb-2 pt-3">
                                            <label for="status">Status</label>
                                            <select name="status" class="form-control show-tick ms select2" data-placeholder="Select">
                                                <option value="active" @if(old('status',isset($product->status)?$product->status:null) == 'active') selected @endif>Active</option>
                                                <option value="inactive" @if(old('status',isset($product->status)?$product->status:null) == 'inactive') selected @endif>Inactive</option>
                                            </select>
                                            @error('status')
                                            <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-6 pb-2 pt-3">
                                            <label for="view_section">View Section</label>
                                            <select name="view_section" class="form-control show-tick ms select2" data-placeholder="Select">
                                                <option value="BEST_SELLER" @if(old('view_section',isset($product->view_section)?$product->view_section:null) == 'BEST_SELLER') selected @endif>BEST_SELLER</option>
                                                <option value="NEW_ARRIVAL" @if(old('view_section',isset($product->view_section)?$product->view_section:null) == 'NEW_ARRIVAL') selected @endif>NEW_ARRIVAL</option>
                                                <option value="JUST_FOR_YOU" @if(old('view_section',isset($product->view_section)?$product->view_section:null) == 'JUST_FOR_YOU') selected @endif>JUST_FOR_YOU</option>
                                                <option value="MOST_POPULAR" @if(old('view_section',isset($product->view_section)?$product->view_section:null) == 'MOST_POPULAR') selected @endif>MOST_POPULAR</option>
                                                <option value="FLASH_SELL" @if(old('view_section',isset($product->view_section)?$product->view_section:null) == 'FLASH_SELL') selected @endif>FLASH_SELL</option>
                                                <option value="SPECIAL_OFFER" @if(old('view_section',isset($product->view_section)?$product->view_section:null) == 'SPECIAL_OFFER') selected @endif>SPECIAL_OFFER</option>
                                            </select>
                                            @error('view_section')
                                            <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <button type="submit" class="btn btn-raised btn-primary btn-round waves-effect">Update Product</button>
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
