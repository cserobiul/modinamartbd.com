<style>
    td{ vertical-align: middle !important;}
</style>
<div class="row clearfix">
    <div class="col-sm-12">
        <div class="card">
            <div class="header">
                <h2>All <strong>{{ isset($pageTitle) ?  $pageTitle : 'Category' }}</strong> List</h2>
            </div>
            @include('backend.layouts._alert')
            <div class="body" style="border: 2px solid #dddddd;">
                @if(!empty($categories))
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                            <thead>
                            <tr class="text-center">
                                <th>SL</th>
                                <th>Category Name</th>
                                <th>Order</th>
                                <th>Photo</th>
                                <th>Create By</th>
                                <th>Update By</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                            </thead>

                            <tbody>
                            @foreach(\App\Models\Category::all() as $key => $category)
                                <tr class="text-center">
                                    <td>{{ $key+1 }}</td>
                                    <td>
                                        <a href="{{ route('category.edit',$category->id) }}">
                                            {{ \App\Models\Settings::unicodeName($category->name) }}
                                        </a>
                                    </td>
                                    <td>{{ $category->order_sl }} </td>

{{--                                    <td>--}}
{{--                                        @foreach($category->children as $child)--}}
{{--                                            <a href="{{ route('category.edit',$child->id) }}">--}}
{{--                                                {{ \App\Models\Settings::unicodeName($child->name) }}--}}
{{--                                            </a>--}}
{{--                                            <br>--}}
{{--                                            @foreach($child->children as $child2)--}}
{{--                                                <a href="{{ route('category.edit',$child2->id) }}">--}}
{{--                                                   -- {{ \App\Models\Settings::unicodeName($child2->name) }}--}}
{{--                                                </a>--}}
{{--                                            @endforeach--}}
{{--                                            <br><br>--}}
{{--                                        @endforeach--}}
{{--                                    </td>--}}
                                    <td>
                                        @if($category->photo !=null)
                                            <br>
                                            <img src="{{ asset($category->photo) }}" alt="category photo" class="rounded" style="width: 140px; margin-bottom: 15px !important;">
                                        @else
                                            No Photo
                                        @endif
                                    </td>
                                    <td>{{ ucwords($category->user->name) }}</td>
                                    <td>{{ $category->updateBy ? ucwords($category->updateBy->name) : 'N/A' }}</td>
                                    <td>{{ ucwords($category->status) }}</td>
                                    @canany(['category.update'])
                                        <td><a href="{{ route('category.edit',$category->id) }}">Edit</a></td>
                                    @endcanany
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="col-md-6">
                        <h6 class="pt-3 text-danger"> No Categories Found...
                            @canany(['category.create'])
                                <a class="btn btn-raised btn-primary btn-round waves-effect" href="{{ route('category.create') }}">Create New Category</a>
                            @endcanany
                        </h6>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
