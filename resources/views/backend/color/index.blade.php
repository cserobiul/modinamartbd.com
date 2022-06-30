<div class="row clearfix">
    <div class="col-sm-12">
        <div class="card">
            <div class="header">
                <h2>All <strong>{{ isset($pageTitle) ?  $pageTitle : 'Color' }}</strong> List</h2>
            </div>
            @include('backend.layouts._alert')
            <div class="body" style="border: 2px solid #dddddd;">
                @if(!empty($colors))
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                            <thead>
                            <tr class="text-center">
                                <th>SL</th>
                                <th>Color Name</th>
                                <th>Color Code</th>
                                <th>Create By</th>
                                <th>Update By</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                            </thead>

                            <tbody>
                            @foreach($colors as $key => $color)
                                <tr class="text-center">
                                    <td>{{ $key+1 }}</td>
                                    <td>
                                        <a href="{{ route('color.edit',$color->id) }}">
                                            {{ \App\Models\Settings::unicodeName($color->color_name) }}
                                        </a>
                                    </td>
                                    <td>
                                        <div class="input-group colorpicker">
                                            <input type="text" class="form-control" value="{{ $color->color_code }}" disabled>
                                            <div class="input-group-append">
                                                <span class="input-group-text"><span class="input-group-addon"> <i></i> </span></span>
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{ ucwords($color->user->name) }}</td>
                                    <td>{{ $color->updateBy ? ucwords($color->updateBy->name) : 'N/A' }}</td>
                                    <td>{{ ucwords($color->status) }}</td>
                                    @canany(['color.update'])
                                        <td><a href="{{ route('color.edit',$color->id) }}">Edit</a></td>
                                    @endcanany
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="col-md-6">
                        <h6 class="pt-3 text-danger"> No Colors Found...
                            @canany(['color.create'])
                                <a class="btn btn-raised btn-primary btn-round waves-effect" href="{{ route('color.create') }}">Create New Color</a>
                            @endcanany
                        </h6>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
