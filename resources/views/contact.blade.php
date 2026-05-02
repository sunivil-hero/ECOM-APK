@extends('majordesign')

@section('content')
  <section class="contact_section layout_padding">
    <div class="container">
      <div class="heading_container">
        <h2>Contact Us</h2>
      </div>
      <div class="row">
        <div class="col-md-6">
          <div class="form_container">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <form action="{{ route('contact.store') }}" method="POST">
              @csrf
              <div>
                <input type="text" name="name" placeholder="Full Name" value="{{ Auth::check() ? Auth::user()->name : '' }}" required />
              </div>
              <div>
                <input type="email" name="email" placeholder="Email Address" value="{{ Auth::check() ? Auth::user()->email : '' }}" required />
              </div>
              <div>
                <input type="text" name="phone" placeholder="Phone Number" />
              </div>
              <div>
                <textarea name="message" placeholder="How can we help you?" required style="width: 100%; height: 120px; padding: 15px; margin-top: 20px; border: 1px solid #ccc;"></textarea>
              </div>
              <div class="btn_box">
                <button type="submit" style="background-color: #db4566; color: white; padding: 10px 45px; border: none; margin-top: 15px;">
                  SEND MESSAGE
                </button>
              </div>
            </form>
          </div>
        </div>
        <div class="col-md-6">
  <div class="map_container">
    <div class="map">
      <div id="googleMap" style="width:100%; height:400px; background:#e9e9e9; border-radius: 8px; overflow: hidden;">
        <iframe 
        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d126844.06348615201!2d39.18479705!3d-6.81469145!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x185c4bae101246e7%3A0x19fa764426500d46!2sDar%20es%20Salaam!5e0!3m2!1sen!2stz!4v1714130000000!5m2!1sen!2stz"
          width="100%" 
          height="100%" 
          style="border:0;" 
          allowfullscreen="" 
          loading="lazy" 
          referrerpolicy="no-referrer-when-downgrade">
        </iframe>
      </div>
    </div>
  </div>
</div>
        </div>
      </div>
    </div>
  </section>
@endsection