@extends('majordesign')

@section('content')
<style>
    /* Star Rating Interaction CSS */
    .star-rating {
        display: flex;
        flex-direction: row-reverse;
        justify-content: flex-end;
        padding: 10px 0;
    }

    .star-rating input {
        display: none;
    }

    .star-rating label {
        font-size: 30px;
        color: #ccc;
        cursor: pointer;
        transition: color 0.2s, transform 0.2s;
        margin-right: 5px;
    }

    /* Hover and Checked effects */
    .star-rating label:hover,
    .star-rating label:hover ~ label,
    .star-rating input:checked ~ label {
        color: #f39c12; /* Gold color */
    }

    .star-rating label:active {
        transform: scale(0.9);
    }

    /* Use FontAwesome solid star when selected/hovered */
    .star-rating input:checked ~ label:before,
    .star-rating label:hover:before,
    .star-rating label:hover ~ label:before {
        content: '\f005'; /* Solid star */
        font-family: FontAwesome;
    }

    .star_container i {
        color: #f39c12;
        margin-right: 2px;
    }
</style>

<section class="client_section layout_padding">
    <div class="container">
        <div class="heading_container heading_center">
            <h2>What Our Customers Say</h2>
        </div>
        
        <div id="customCarousel2" class="carousel carousel-fade" data-ride="carousel">
            <div class="carousel-inner">
                @forelse($testimonial as $key => $item)
                <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                    <div class="box">
                        <div class="client_info">
                            <div class="client_name">
                                <h5>{{ $item->name }}</h5>
                                <div class="star_container">
                                    @for($i = 1; $i <= 5; $i++)
                                        @if($i <= $item->rating)
                                            <i class="fa fa-star" aria-hidden="true"></i>
                                        @else
                                            <i class="fa fa-star-o" aria-hidden="true"></i>
                                        @endif
                                    @endfor
                                </div>
                            </div>
                            <i class="fa fa-quote-left" aria-hidden="true"></i>
                        </div>
                        <p>{{ $item->comment }}</p>
                    </div>
                </div>
                @empty
                <div class="carousel-item active">
                    <div class="box text-center">
                        <p>No testimonials yet. Share your experience below!</p>
                    </div>
                </div>
                @endforelse
            </div>
            
            @if(count($testimonial) > 1)
            <div class="carousel_btn-box">
                <a class="carousel-control-prev" href="#customCarousel2" data-slide="prev">
                    <i class="fa fa-angle-left"></i>
                </a>
                <a class="carousel-control-next" href="#customCarousel2" data-slide="next">
                    <i class="fa fa-angle-right"></i>
                </a>
            </div>
            @endif
        </div>
    </div>
</section>

<section class="contact_section layout_padding-bottom">
    <div class="container">
        <div class="col-md-8 col-lg-6 mx-auto">
            <div class="form_container">
                <div class="heading_container">
                    <h2>Leave a Review</h2>
                </div>
                
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <form action="{{ route('testimonial.store') }}" method="POST">
                    @csrf
                    <div>
                        <input type="text" name="name" placeholder="Your Name" value="{{ Auth::check() ? Auth::user()->name : '' }}" required />
                    </div>
                    <div>
                        <input type="email" name="email" placeholder="Email Address" value="{{ Auth::check() ? Auth::user()->email : '' }}" required />
                    </div>

                    <div class="rating_box">
                        <label style="font-weight: bold; display: block; margin-top: 15px;">Click to Rate:</label>
                        <div class="star-rating">
                            <input type="radio" id="star5" name="rating" value="5" required />
                            <label for="star5" class="fa fa-star-o" title="5 stars"></label>
                            
                            <input type="radio" id="star4" name="rating" value="4" />
                            <label for="star4" class="fa fa-star-o" title="4 stars"></label>
                            
                            <input type="radio" id="star3" name="rating" value="3" />
                            <label for="star3" class="fa fa-star-o" title="3 stars"></label>
                            
                            <input type="radio" id="star2" name="rating" value="2" />
                            <label for="star2" class="fa fa-star-o" title="2 stars"></label>
                            
                            <input type="radio" id="star1" name="rating" value="1" />
                            <label for="star1" class="fa fa-star-o" title="1 star"></label>
                        </div>
                    </div>

                    <div>
                        <textarea name="comment" placeholder="Describe your experience..." required style="width: 100%; height: 120px; padding: 15px; margin-top: 5px; border: 1px solid #ccc;"></textarea>
                    </div>
                    <div class="btn_box">
                        <button type="submit" style="background-color: #db4566; color: white; padding: 10px 45px; border: none; margin-top: 15px; cursor: pointer;">
                            Submit Testimonial
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection