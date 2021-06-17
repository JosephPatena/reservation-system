@extends('layout.guest')

@section('stylesheets')
  <style type="text/css">
    [type="radio"]:checked,
    [type="radio"]:not(:checked) {
      position: absolute;
      left: -9999px;
    }
    [type="radio"]:checked + label,
    [type="radio"]:not(:checked) + label {
      position: relative;
      padding-left: 28px;
      cursor: pointer;
      line-height: 20px;
      display: inline-block;
      color: #666;
    }
    [type="radio"]:checked + label:before,
    [type="radio"]:not(:checked) + label:before {
      content: "";
      position: absolute;
      left: 0;
      top: 0;
      width: 18px;
      height: 18px;
      border: 1px solid #ddd;
      border-radius: 100%;
      background: #fff;
    }
    [type="radio"]:checked + label:after,
    [type="radio"]:not(:checked) + label:after {
      content: "";
      width: 12px;
      height: 12px;
      background: #d2b55b;
      position: absolute;
      top: 4px;
      left: 4px;
      border-radius: 100%;
      -webkit-transition: all 0.2s ease;
      transition: all 0.2s ease;
    }
    [type="radio"]:not(:checked) + label:after {
      opacity: 0;
      -webkit-transform: scale(0);
      transform: scale(0);
    }
    [type="radio"]:checked + label:after {
      opacity: 1;
      -webkit-transform: scale(1);
      transform: scale(1);
    }

    .customize {
      padding-left: 100px; padding-right: 100px;
    }

    @media screen and (max-width: 768px) {
      .customize {
        padding-left: 15px; padding-right: 15px;
      }
    }

  </style>
@endsection

@section('content')
  
  <section class="site-hero site-hero-innerpage overlay" data-stellar-background-ratio="0.5" style="background-image: url('{{ Helper::get_contents()[0]->default ? asset('guest/images/big_image_1.jpg') : url('storage/image/' . Helper::get_contents()[0]->image->hash_name) }}');">
      <div class="container">
        <div class="row align-items-center site-hero-inner justify-content-center">
          <div class="col-md-12 text-center">

            <div class="mb-5 element-animate">
              <h1>My Inquiries</h1>
            </div>

          </div>
        </div>
      </div>
    </section>
    <!-- END section -->

    <section class="site-section" id="site-section">
      <div class="customize">
        <div class="row">
          <div class="col-md-12 table-responsive">
            <h2 class="mb-5">My Inquiries</h2>
            <table class="table table table-striped table-condensed table-bordered">
              <thead>
                <tr>
                  <th>Guest</th>
                  <th>Phone</th>
                  <th>Email</th>
                  <th>Message</th>
                  <th>Response</th>
                </tr>
              </thead>
              <tbody>
                @foreach($inquiries as $value)
                    <tr>
                      <td>
                        <img style="width: 25px; height: 25px;" src="{{ (!empty($value->guest->image->hash_name) && $value->same_as_profile) ? url('storage/image/'.$value->guest->image->hash_name) : asset('admin/dist/img/default-user.png') }}" alt="Room Image">&nbsp;&nbsp;{{ $value->name }}</td>
                      <td>{{ $value->phone }}</td>
                      <td>{{ $value->email }}</td>
                      <td>{{ $value->message }}</td>
                      <td>{{ $value->response }}</td>
                    </tr>
                  @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </section>
    <!-- END section -->

    <section class="section-cover" data-stellar-background-ratio="0.5" style="background-image: url('{{ Helper::get_contents()[2]->default ? asset('guest/images/img_5.jpg') : url('storage/image/' . Helper::get_contents()[2]->image->hash_name) }}');">
      <div class="container">
        <div class="row justify-content-center align-items-center intro">
          <div class="col-md-9 text-center element-animate">
            {!! Helper::get_contents()[2]->text !!}
            <div class='btn-play-wrap'><a href='{{ Helper::get_contents()[2]->link }}' class='btn-play popup-vimeo '><span class='ion-ios-play'></span></a></div>
          </div>
        </div>
      </div>
    </section>
    <!-- END section -->

    <script type="text/javascript">
      var pathname = window.location.pathname;
      var origin   = window.location.origin;
      window.location.href = origin + pathname + "#site-section"
    </script>
@endsection