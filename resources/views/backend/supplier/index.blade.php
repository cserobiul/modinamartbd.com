<div class="row clearfix">
    <div class="col-sm-12">
        <div class="card">
            <div class="header">
                <h2>All <strong>{{ isset($pageTitle) ?  $pageTitle : 'Supplier' }}</strong> List</h2>
            </div>
            <div class="body" style="border: 2px solid #dddddd;">
                @if(!empty($suppliers))
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                            <thead>
                            <tr class="text-center">
                                <th>SL</th>
                                <th>Supplier Name</th>
                                <th>Phone</th>
                                <th>Email</th>
                                <th>Address</th>
                                <th>Create By</th>
                                <th>Update By</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                            </thead>

                            <tbody>
                            @foreach($suppliers as $key => $supplier)
                                <tr class="text-center">
                                    <td>{{ $key+1 }}</td>
                                    <td>
                                        <a href="{{ route('supplier.edit',$supplier->id) }}">
                                            {{ \App\Models\Settings::unicodeName($supplier->name) }}
                                        </a>
                                    </td>
                                    <td>{{ $supplier->phone }}</td>
                                    <td>{{ strtolower($supplier->email) }}</td>
                                    <td>{{ ucfirst($supplier->address) }}</td>
                                    <td>{{ ucwords($supplier->user->name) }}</td>
                                    <td>{{ $supplier->updateBy ? ucwords($supplier->updateBy->name) : 'N/A' }}</td>
                                    <td>{{ ucwords($supplier->status) }}</td>
                                    @canany(['supplier.update'])
                                        <td><a href="{{ route('supplier.edit',$supplier->id) }}">Edit</a></td>
                                    @endcanany
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="col-md-6">
                        <h6 class="pt-3 text-danger"> No Suppliers Found...
                            @canany(['supplier.create'])
                                <a class="btn btn-raised btn-primary btn-round waves-effect" href="{{ route('supplier.create') }}">Create New Supplier</a>
                            @endcanany
                        </h6>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
