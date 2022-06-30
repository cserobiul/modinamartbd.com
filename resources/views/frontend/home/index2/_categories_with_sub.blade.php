<section class="category4 section-big-pb-space">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 pr-0">
                <div class="category-slide5two no-arrow">
                    @foreach($categories as $category)
                    <div>
                        <div class="category-box">
                            <div class="img-wrraper">
                                <a href="{{ route('categoryDetailsSlug',$category->slug) }}">
                                    @if($category->photo)
                                        <img src="{{ asset($category->photo) }}" alt="category" class="img-fluid">
                                    @else
                                        <img src="{{ asset('frontend/assets/images/mega-store/category/1.jpg') }}" alt="category" class="img-fluid">
                                    @endif
                                </a>
                            </div>
                            <div class="category-detail">
                                <a href="{{ route('categoryDetailsSlug',$category->slug) }}">
                                    <h2>{{ $category->name }}</h2>
                                </a>
                                <ul>
                                    @foreach($category->children as $child)
                                        <li>
                                            <a href="{{ route('categoryDetailsSlug',$child->slug) }}">{{ $child->name }}</a>
                                        </li>
                                    @endforeach
                                </ul>
                                <a href="{{ route('categoryDetailsSlug',$category->slug) }}" class="btn btn-rounded btn-md btn-block">shop now</a>
                            </div>
                        </div>
                    </div>
                    @endforeach

                </div>
            </div>
        </div>
    </div>
</section>
