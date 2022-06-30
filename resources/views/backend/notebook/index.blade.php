<div class="row clearfix">
    <div class="col-sm-12">
        <div class="card">
            <div class="header">
                <h2>All <strong>{{ isset($pageTitle) ?  $pageTitle : 'Notebook' }}</strong> List</h2>
            </div>
            @include('backend.layouts._alert')
            <div class="body" style="border: 2px solid #dddddd;">
                @if(count($notebooks) > 0)
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                            <thead>
                            <tr class="text-center">
                                <th>SL</th>
                                <th>Title</th>
                                <th>Details</th>
                                <th>Notebook Photo</th>
                                <th>Create By</th>
                                <th>Update By</th>
                            </tr>
                            </thead>

                            <tbody>
                            @foreach($notebooks as $key => $notebook)
                                <tr class="text-center">
                                    <td>{{ $key+1 }}</td>
                                    <td>
                                        <a href="{{ route('notebook.edit',$notebook->id) }}">
                                            {{ \App\Models\Settings::unicodeName($notebook->title) }}
                                        </a>
                                    </td>
                                    <td>
                                        <a href="{{ route('notebook.edit',$notebook->id) }}">
                                            {!! $notebook->details !!}
                                        </a>
                                    </td>

                                    <td>
                                        @if($notebook->photo !=null)
                                            <br>
                                            <a href="{{ asset($notebook->photo) }}" target="_new">
                                            <img src="{{ asset($notebook->photo) }}" alt="notebook photo" class="rounded" style="width: 140px; margin-bottom: 15px !important;">
                                            </a>
                                        @else
                                            No Photo
                                        @endif
                                    </td>
                                    <td>{{ ucwords($notebook->user->name) }}</td>
                                    <td>{{ $notebook->updateBy ? ucwords($notebook->updateBy->name) : 'N/A' }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="col-md-6">
                        <h6 class="pt-3 text-danger"> No Note Found...
                            @canany(['notebook.create'])
                                <a class="btn btn-raised btn-primary btn-round waves-effect" href="{{ route('notebook.index') }}">Create New Notebook</a>
                            @endcanany
                        </h6>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
