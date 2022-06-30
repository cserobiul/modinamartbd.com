<div class="row clearfix">
    <div class="col-sm-12">
        <div class="card">
            <div class="header">
                <h2>All <strong>{{ isset($pageTitle) ?  $pageTitle : 'Size' }}</strong> List</h2>
            </div>
            @include('backend.layouts._alert')
            <div class="body" style="border: 2px solid #dddddd;">
                @if(!empty($sizes))
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                            <thead>
                            <tr class="text-center">
                                <th>SL</th>
                                <th>Size Name</th>
                                <th>Create By</th>
                                <th>Update By</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                            </thead>

                            <tbody>
                            @foreach($sizes as $key => $size)
                                <tr class="text-center">
                                    <td>{{ $key+1 }}</td>
                                    <td>
                                        <a href="{{ route('size.edit',$size->id) }}">
                                            {{ \App\Models\Settings::unicodeName($size->size_name) }}
                                        </a>
                                    </td>
                                    <td>{{ ucwords($size->user->name) }}</td>
                                    <td>{{ $size->updateBy ? ucwords($size->updateBy->name) : 'N/A' }}</td>
                                    <td>{{ ucwords($size->status) }}</td>
                                    @canany(['size.update'])
                                        <td><a href="{{ route('size.edit',$size->id) }}">Edit</a></td>
                                    @endcanany
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="col-md-6">
                        <h6 class="pt-3 text-danger"> No Sizes Found...
                            @canany(['size.create'])
                                <a class="btn btn-raised btn-primary btn-round waves-effect" href="{{ route('size.create') }}">Create New Size</a>
                            @endcanany
                        </h6>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
