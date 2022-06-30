<!--title-start-->
<div class="title8 section-mb-space ">
    <h4>featured brands</h4>
</div>
<!--title-end-->

<section class="brand-second section-big-mb-space">
    <div class="container-fluid">
        <div class="row brand-block">
            <div class="col-12">
                <div class="brand-slide12 no-arrow mb--5">
                    @foreach($brands = \App\Models\Brand::where('status','active')->get() as $brand)
                    <div>
                        <div class="brand-box">
                            @if($brand->photo)
                            <img src="{{ asset($brand->photo) }}" alt="brand" class="img-fluid">
                            @else
                                <img src="{{ asset('frontend') }}/assets/images/mega-store/brand/6.png" alt="brand" class="img-fluid">
                            @endif
                        </div>
                    </div>
                    @endforeach

                    <div>
                        <div class="brand-box">
                            <img src="{{ asset('frontend') }}/assets/images/mega-store/brand/6.png" alt="brand" class="img-fluid">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
