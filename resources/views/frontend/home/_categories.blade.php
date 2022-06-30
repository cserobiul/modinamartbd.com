<section class="collection-banner section-pt-space b-g-white ">
    <div class="custom-container">
        <div class="row collection2">
            @foreach($categories as $key => $category)
                @if($key == 3)
                    @break
                @endif
                <div class="col-md-4">
                    <a href="{{ route('categoryDetailsSlug',$category->slug) }}">
                        <div class="collection-banner-main banner-1  p-right">
                            <div class="collection-img">
                                <img src="{{ asset($category->photo) }}" class="img-fluid bg-img  " alt="banner">
                            </div>
                            <div class="collection-banner-contain">
                                <div>
                                    <h4>{{ \App\Models\Settings::unicodeName($category->name) }}</h4>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
</section>
