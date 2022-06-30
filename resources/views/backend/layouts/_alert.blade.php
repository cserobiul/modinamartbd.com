@if(session()->has('success'))
    <div class="alert alert-success"  role="alert">
        <div class="container">
            <div class="alert-icon">
                <i class="zmdi zmdi-thumb-up"></i>
            </div>
            <strong>Well done!</strong>  {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">
                <i class="zmdi zmdi-close"></i>
            </span>
            </button>
        </div>
    </div>
@endif

@if(session()->has('warning'))
    <div class="alert alert-warning" role="alert">
        <div class="container">
            <div class="alert-icon">
                <i class="zmdi zmdi-notifications"></i>
            </div>
            <strong>Warning!</strong> {{ session('warning') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">
                <i class="zmdi zmdi-close"></i>
            </span>
            </button>
        </div>
    </div>
@endif
