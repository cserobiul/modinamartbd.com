<div class="row clearfix">
    <div class="col-sm-12">
        <div class="card">
            <div class="header">
                <h2>All <strong>{{ isset($pageTitle) ?  $pageTitle : 'Payment Method' }}</strong> List</h2>
            </div>
            @include('backend.layouts._alert')
            <div class="body" style="border: 2px solid #dddddd;">
                @if(!empty($paymentmethods))
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                            <thead>
                            <tr class="text-center">
                                <th>SL</th>
                                <th>Payment Method Name</th>
                                <th>Details</th>
                                <th>Create By</th>
                                <th>Update By</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                            </thead>

                            <tbody>
                            @foreach($paymentmethods as $key => $paymentmethod)
                                <tr class="text-center">
                                    <td>{{ $key+1 }}</td>
                                    <td>
                                        <a href="{{ route('payment_method.edit',$paymentmethod->id) }}">
                                            {{ \App\Models\Settings::unicodeName($paymentmethod->payment_name) }}
                                        </a>
                                    </td>
                                    <td>{{ \App\Models\Settings::unicodeName($paymentmethod->details) }}</td>

                                    <td>{{ ucwords($paymentmethod->user->name) }}</td>
                                    <td>{{ $paymentmethod->updateBy ? ucwords($paymentmethod->updateBy->name) : 'N/A' }}</td>
                                    <td>{{ ucwords($paymentmethod->status) }}</td>
                                    @canany(['payment_method.update'])
                                        <td><a href="{{ route('payment_method.edit',$paymentmethod->id) }}">Edit</a></td>
                                    @endcanany
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="col-md-6">
                        <h6 class="pt-3 text-danger"> No Payment Method Found...
                            @canany(['payment_method.create'])
                                <a class="btn btn-raised btn-primary btn-round waves-effect" href="{{ route('payment_method.create') }}">Create New Payment Method</a>
                            @endcanany
                        </h6>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
