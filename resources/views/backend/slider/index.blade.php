<div class="row clearfix">
    <div class="col-sm-12">
        <div class="card">
            <div class="header">
                <h2>All <strong>{{ isset($pageTitle) ?  $pageTitle : 'Slider' }}</strong> List</h2>
            </div>
            @include('backend.layouts._alert')
            <div class="body" style="border: 2px solid #dddddd;">
                @if(count($sliders) > 0)
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                            <thead>
                            <tr class="text-center">
                                <th>SL</th>
                                <th>Slider Title</th>
                                <th>Slider Photo</th>
                                <th>Order</th>
                                <th>Create By</th>
                                <th>Update By</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                            </thead>

                            <tbody>
                            @foreach($sliders as $key => $slider)
                                <tr class="text-center">
                                    <td>{{ $key+1 }}</td>
                                    <td>
                                        <a href="{{ route('slider.edit',$slider->id) }}">
                                            {{ \App\Models\Settings::unicodeName($slider->title) }}
                                        </a>
                                    </td>
                                    <td>
                                        @if($slider->photo !=null)
                                            <br>
                                            <img src="{{ asset($slider->photo) }}" alt="slider photo" class="rounded" style="width: 140px; margin-bottom: 15px !important;">
                                        @else
                                            No Photo
                                        @endif
                                    </td>
                                    <td>{{ $slider->order }}</td>
                                    <td>{{ ucwords($slider->user->name) }}</td>
                                    <td>{{ $slider->updateBy ? ucwords($slider->updateBy->name) : 'N/A' }}</td>
                                    <td>{{ ucwords($slider->status) }}</td>
                                    @canany(['slider.update'])
                                        <td><a href="{{ route('slider.edit',$slider->id) }}">Edit</a></td>
                                    @endcanany
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="col-md-6">
                        <h6 class="pt-3 text-danger"> No Sliders Found...
                            @canany(['slider.create'])
                                <a class="btn btn-raised btn-primary btn-round waves-effect" href="{{ route('slider.index') }}">Create New Slider</a>
                            @endcanany
                        </h6>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
