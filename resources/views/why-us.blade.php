@extends('majordesign')

@section('content')
  <section class="why_section layout_padding">
    <div class="container">
      <div class="heading_container heading_center">
        <h2>
          Why Shop With Us
        </h2>
      </div>
      <div class="row">
        <div class="col-md-4">
          <div class="box ">
            <div class="img-box">
              {{-- Use FontAwesome icons for a professional look --}}
              <i class="fa fa-truck" aria-hidden="true" style="font-size: 35px; color: #db4566;"></i>
            </div>
            <div class="detail-box">
              <h5>
                Fast Delivery
              </h5>
              <p>
                We ensure your gifts reach your loved ones on time, every time, across the city.
              </p>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="box ">
            <div class="img-box">
              <i class="fa fa-money" aria-hidden="true" style="font-size: 35px; color: #db4566;"></i>
            </div>
            <div class="detail-box">
              <h5>
                Free Shipping
              </h5>
              <p>
                Enjoy free shipping on all orders over $50. No hidden costs at checkout.
              </p>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="box ">
            <div class="img-box">
              <i class="fa fa-star" aria-hidden="true" style="font-size: 35px; color: #db4566;"></i>
            </div>
            <div class="detail-box">
              <h5>
                Best Quality
              </h5>
              <p>
                Every product is hand-picked and checked for quality before being listed.
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  @endsection