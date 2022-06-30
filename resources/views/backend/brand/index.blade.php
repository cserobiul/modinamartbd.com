<style>
    td{ vertical-align: middle !important;}
</style>
<div class="row clearfix">
    <div class="col-sm-12">
        <div class="card">
            <div class="header">
                <h2>All <strong>{{ isset($pageTitle) ?  $pageTitle : 'Brand' }}</strong> List</h2>
            </div>
            @include('backend.layouts._alert')
            <div class="body" style="border: 2px solid #dddddd;">
                @if(!empty($brands))
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                            <thead>
                            <tr class="text-center">
                                <th>SL</th>
                                <th>Brand Name</th>
                                <th>Photo</th>
                                <th>Create By</th>
                                <th>Update By</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                            </thead>

                            <tbody>
                            @foreach($brands as $key => $brand)
                                <tr class="text-center">
                                    <td>{{ $key+1 }}</td>
                                    <td>
                                        <a href="{{ route('brand.edit',$brand->id) }}">
                                            {{ \App\Models\Settings::unicodeName($brand->brand_name) }}
                                        </a>
                                    </td>
                                    <td>
                                        @if($brand->photo !=null)
                                            <br>
                                            <img src="{{ asset($brand->photo) }}" alt="brand photo" class="rounded" style="width: 140px; margin-bottom: 15px !important;">
                                        @else
                                            No Photo
                                        @endif
                                    </td>
                                    <td>{{ ucwords($brand->user->name) }}</td>
                                    <td>{{ $brand->updateBy ? ucwords($brand->updateBy->name) : 'N/A' }}</td>
                                    <td>{{ ucwords($brand->status) }}</td>
                                    @canany(['brand.update'])
                                        <td><a href="{{ route('brand.edit',$brand->id) }}">Edit</a></td>
                                    @endcanany
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="col-md-6">
                        <h6 class="pt-3 text-danger"> No Brands Found...
                            @canany(['brand.create'])
                                <a class="btn btn-raised btn-primary btn-round waves-effect" href="{{ route('brand.create') }}">Create New Brand</a>
                            @endcanany
                        </h6>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
