<div class="row clearfix">
    <div class="col-sm-12">
        <div class="card">
            <div class="header">
                <h2>All <strong>{{ isset($pageTitle) ?  $pageTitle : 'Warranty' }}</strong> List</h2>
            </div>
            @include('backend.layouts._alert')
            <div class="body" style="border: 2px solid #dddddd;">
                @if(!empty($warranties))
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                            <thead>
                            <tr class="text-center">
                                <th>SL</th>
                                <th>Warranty Name</th>
                                <th>Create By</th>
                                <th>Update By</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                            </thead>

                            <tbody>
                            @foreach($warranties as $key => $warranty)
                                <tr class="text-center">
                                    <td>{{ $key+1 }}</td>
                                    <td>
                                        <a href="{{ route('warranty.edit',$warranty->id) }}">
                                            {{ \App\Models\Settings::unicodeName($warranty->warranty_name) }}
                                        </a>
                                    </td>
                                    <td>{{ ucwords($warranty->user->name) }}</td>
                                    <td>{{ $warranty->updateBy ? ucwords($warranty->updateBy->name) : 'N/A' }}</td>
                                    <td>{{ ucwords($warranty->status) }}</td>
                                    @canany(['warranty.update'])
                                        <td><a href="{{ route('warranty.edit',$warranty->id) }}">Edit</a></td>
                                    @endcanany
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="col-md-6">
                        <h6 class="pt-3 text-danger"> No Warranty Found...
                            @canany(['warranty.create'])
                                <a class="btn btn-raised btn-primary btn-round waves-effect" href="{{ route('warranty.create') }}">Create New Warranty</a>
                            @endcanany
                        </h6>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
