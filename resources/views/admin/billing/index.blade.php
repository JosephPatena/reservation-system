@extends('layout.admin')

@section('stylesheets')
  <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="{{ asset('admin/bootstrap/css/bootstrap.min.css') }}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('admin/plugins/datatables/dataTables.bootstrap.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('admin/dist/css/AdminLTE.min.css') }}">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="{{ asset('admin/dist/css/skins/_all-skins.min.css') }}">

    <style type="text/css">
        .toggle {
            --width: 40px;
            --height: calc(var(--width) / 2);
            --border-radius: calc(var(--height) / 2);

            display: inline-block;
            cursor: pointer;
        }
        .toggle__input {
            display: none;
        }
        .toggle__fill {
            position: relative;
            width: var(--width);
            height: var(--height);
            border-radius: var(--border-radius);
            background: #dddddd;
            transition: background 0.2s;
        }
        .toggle__fill::after {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            height: var(--height);
            width: var(--height);
            background: #ffffff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.25);
            border-radius: var(--border-radius);
            transition: transform 0.2s;
        }
        .toggle__input:checked ~ .toggle__fill {
            background: #009578;
        }

        .toggle__input:checked ~ .toggle__fill::after {
            transform: translateX(var(--height));
        }
    </style>
@endsection

@section('content')
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Billing
      <small>Dashboard</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-credit-card"></i> Billing</a></li>
      <li class="active">Dashboard</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-sm-7 col-xs-12">
          <!-- Widget: user widget style 1 -->
          <div class="box box-widget widget-user-2">
            <!-- Add the bg color to the header using any of the bg-* classes -->
            <div class="widget-user-header">
              <div class="widget-user-image">
                <img src="{{ asset('admin/dist/img/pud.png') }}" alt="Icon">
              </div><!-- /.widget-user-image -->
              <h3 class="widget-user-username">Pay Upon Arrival</h3>
              <h5 class="widget-user-desc">Pay when you arriva at Resort. Let your guest pay at Resort's checkout.</h5>
            </div>
            <div class="box-footer">
              <div class="form-horizontal">

                <div class="form-group">
                  <label class="col-sm-2 control-label">Available</label>
                  <div class="col-sm-6">
                      <label class="toggle">
                          <input class="toggle__input" name="is_available" type="checkbox" {{ $payment_method[0]->is_available ? "checked" : "" }}>
                          <div class="toggle__fill"></div>
                      </label>
                  </div>
                </div>

              </div>
            </div>
          </div><!-- /.widget-user -->

          <!-- Widget: user widget style 1 -->
          <div class="box box-widget widget-user-2">
            <!-- Add the bg color to the header using any of the bg-* classes -->
            <div class="widget-user-header">
              <div class="widget-user-image">
                <img src="{{ asset('admin/dist/img/paypal.jpg') }}" alt="Icon">
              </div><!-- /.widget-user-image -->
              <h3 class="widget-user-username">Pay with PayPal</h3>
              <h5 class="widget-user-desc">Connect your PayPal account to our app to receive the payments directly from your customers.</h5>
            </div>
            <div class="box-footer">
              <form action="{{ route('billing.update', encrypt($payment_method[1]->id)) }}" method="post">
                @csrf
                @method('PUT')
                <div class="form-horizontal">

                  <div class="form-group">
                    <label class="col-sm-2 control-label">Available</label>
                    <div class="col-sm-6">
                        <label class="toggle">
                            <input class="toggle__input" name="is_available" type="checkbox" {{ $payment_method[1]->is_available ? "checked" : "" }}>
                            <div class="toggle__fill"></div>
                        </label>
                    </div>
                  </div>

                  <div class="form-group">
                    <label for="inputPublicKey" class="col-sm-2 control-label">Client ID <span style="color: red;">*</span></label>
                    <div class="col-sm-6">
                      <input name="public_key" type="text" class="form-control" id="inputPublicKey" placeholder="Client ID" required="" value="{{ $payment_method[1]->public_key }}">
                    </div>
                  </div> 

                  <div class="form-group">
                    <label for="inputDesc" class="col-sm-2 control-label">Client Secret <span style="color: red;">*</span></label>
                    <div class="col-sm-6">
                      <input name="secret_key" type="text" class="form-control" id="inputDesc" placeholder="Client Secret" required="" value="{{ $payment_method[1]->secret_key }}">
                    </div>
                  </div> 

                  <div class="form-group">
                    <label class="col-sm-2 control-label">&nbsp;</label>
                    <div class="col-sm-6">
                        <button type="submit" class="btn btn-success btn-sm">Update and Refresh</button>
                    </div>
                  </div>

                </div>
              </form>
            </div>
          </div><!-- /.widget-user -->

          <!-- Widget: user widget style 1 -->
          <div class="box box-widget widget-user-2">
            <!-- Add the bg color to the header using any of the bg-* classes -->
            <div class="widget-user-header">
              <div class="widget-user-image">
                <img src="{{ asset('admin/dist/img/stripe.png') }}" alt="Icon">
              </div><!-- /.widget-user-image -->
              <h3 class="widget-user-username">Pay with Stripe</h3>
              <h5 class="widget-user-desc">Connect your Stripe account to our app to receive the payments directly from your customers.</h5>
            </div>
            <div class="box-footer">
              <form action="{{ route('billing.update', encrypt($payment_method[2]->id)) }}" method="post">
                @csrf
                @method('PUT')
                <div class="form-horizontal">

                  <div class="form-group">
                    <label class="col-sm-2 control-label">Available</label>
                    <div class="col-sm-6">
                        <label class="toggle">
                            <input class="toggle__input" name="is_available" type="checkbox" {{ $payment_method[2]->is_available ? "checked" : "" }}>
                            <div class="toggle__fill"></div>
                        </label>
                    </div>
                  </div>

                  <div class="form-group">
                    <label for="inputPublicKey" class="col-sm-2 control-label">Publishable Key <span style="color: red;">*</span></label>
                    <div class="col-sm-6">
                      <input name="public_key" type="text" class="form-control" id="inputPublicKey" placeholder="Publishable Key" required="" value="{{ $payment_method[2]->public_key }}">
                    </div>
                  </div> 

                  <div class="form-group">
                    <label for="inputDesc" class="col-sm-2 control-label">Secret Key <span style="color: red;">*</span></label>
                    <div class="col-sm-6">
                      <input name="secret_key" type="text" class="form-control" id="inputDesc" placeholder="Secret Key" required="" value="{{ $payment_method[2]->secret_key }}">
                    </div>
                  </div> 

                  <div class="form-group">
                    <label class="col-sm-2 control-label">&nbsp;</label>
                    <div class="col-sm-6">
                        <button type="submit" class="btn btn-success btn-sm">Update and Refresh</button>
                    </div>
                  </div>

                </div>
              </form>
            </div>
          </div><!-- /.widget-user -->

          <!-- Widget: user widget style 1 -->
          <div class="box box-widget widget-user-2">
            <!-- Add the bg color to the header using any of the bg-* classes -->
            <div class="widget-user-header">
              <div class="widget-user-image">
                <img src="{{ asset('admin/dist/img/paymaya.png') }}" alt="Icon">
              </div><!-- /.widget-user-image -->
              <h3 class="widget-user-username">Pay with PayMaya</h3>
              <h5 class="widget-user-desc">Connect your Maya account to our app to receive the payments directly from your customers.</h5>
            </div>
            <div class="box-footer">
              <form action="{{ route('billing.update', encrypt($payment_method[3]->id)) }}" method="post">
                @csrf
                @method('PUT')
                <div class="form-horizontal">

                  <div class="form-group">
                    <label class="col-sm-2 control-label">Available</label>
                    <div class="col-sm-6">
                        <label class="toggle">
                            <input class="toggle__input" name="is_available" type="checkbox" {{ $payment_method[3]->is_available ? "checked" : "" }}>
                            <div class="toggle__fill"></div>
                        </label>
                    </div>
                  </div>

                  <div class="form-group">
                    <label for="inputPublicKey" class="col-sm-2 control-label">Public-facing API Key <span style="color: red;">*</span></label>
                    <div class="col-sm-6">
                      <input name="public_key" type="text" class="form-control" id="inputPublicKey" placeholder="Public Key" required="" value="{{ $payment_method[3]->public_key }}">
                    </div>
                  </div> 

                  <div class="form-group">
                    <label for="inputDesc" class="col-sm-2 control-label">Secret API Key <span style="color: red;">*</span></label>
                    <div class="col-sm-6">
                      <input name="secret_key" type="text" class="form-control" id="inputDesc" placeholder="Secret Key" required="" value="{{ $payment_method[3]->secret_key }}">
                    </div>
                  </div>

                  <div class="form-group">
                    <label class="col-sm-2 control-label">&nbsp;</label>
                    <div class="col-sm-6">
                        <button type="submit" class="btn btn-success btn-sm">Update and Refresh</button>
                    </div>
                  </div>

                </div>
              </form>
            </div>
          </div><!-- /.widget-user -->
      </div>

      <div class="col-sm-5 col-xs-12">
        <h4>
          PayPal: Set up your development environment
        </h4>
        <p>
          To generate REST API credentials for the live and sandbox environments:<br><br>

          1. <a href="https://www.paypal.com/signin?returnUri=https%3A%2F%2Fdeveloper.paypal.com%2Fdeveloper%2Fapplications&_ga=1.209652946.1946081091.1606036925" target="__blank">Log in to the Developer Dashboard&nbsp;&nbsp;<i class="fa fa-external-link"></i></a>&nbsp;&nbsp;with your PayPal account. <br>
          2. Under the <b>DASHBOARD</b> menu, select <b>My Apps & Credentials.</b><br>
          3. Make sure you're on the Live tab to get the API credentials you'll use to receive payment from your customers. Note that you can switch to sandbox tab for testing purpose only.<br>
          4. Under the <b>App Name</b> column, select <b>Default Application</b>, which PayPal creates with a new Developer Dashboard account. Select <b>Create App</b> if you don't see the default app.
        </p>

        <br><br>

        <h4>
          Stripe: Set up your development environment
        </h4>
        <p>
          To generate REST API credentials for the live and sandbox environments:<br><br>

          1. <a href="https://dashboard.stripe.com/test/apikeys" target="__blank">Log in to the Developer Dashboard&nbsp;&nbsp;<i class="fa fa-external-link"></i></a>&nbsp;&nbsp;with your Stripe account. <br>
          2. Under the <b>DEVELOPERS</b> menu, select <b>API keys.</b><br>
          3. Make sure you toggled the radio button to get the live credentials you'll use to receive payment from your customers. Note that you can switch to test data for testing purpose only.<br>
          4. Under the <b>Standard keys</b> table, you'll find your Stripe key and secret.
        </p>

        <br><br>

        <h4>
          PayMaya: Set up your development environment
        </h4>
        <p>
          To generate REST API credentials for the live and sandbox environments:<br><br>

          1. <a href="https://manager.paymaya.com/" target="__blank">Log in to your PayMaya Business Merchant Manager&nbsp;&nbsp;<i class="fa fa-external-link"></i></a>&nbsp;&nbsp;with your PayMaya account. <br>
          2.Select <b>API keys</b> tab you find in the left panel of your PayMaya Business Merchant Manager Dashboard<br>
          3. Make sure you toggled the radio button to get the live credentials you'll use to receive payment from your customers. Note that you can switch to test data for testing purpose only.<br>
          4. Copy your <b>Public</b> and <b>Secret Key</b> and paste it to the form.
        </p>
      </div>
    </div>
  </section>
@endsection


@section('scripts')
  <!-- jQuery 2.1.4 -->
  <script src="{{ asset('admin/plugins/jQuery/jQuery-2.1.4.min.js') }}"></script>
  <!-- Bootstrap 3.3.5 -->
  <script src="{{ asset('admin/bootstrap/js/bootstrap.min.js') }}"></script>
  <!-- DataTables -->
  <script src="{{ asset('admin/plugins/datatables/jquery.dataTables.min.js') }}"></script>
  <script src="{{ asset('admin/plugins/datatables/dataTables.bootstrap.min.js') }}"></script>
  <!-- SlimScroll -->
  <script src="{{ asset('admin/plugins/slimScroll/jquery.slimscroll.min.js') }}"></script>
  <!-- FastClick -->
  <script src="{{ asset('admin/plugins/fastclick/fastclick.min.js') }}"></script>
  <!-- AdminLTE App -->
  <script src="{{ asset('admin/dist/js/app.min.js') }}"></script>
  <!-- AdminLTE for demo purposes -->
  <script src="{{ asset('admin/dist/js/demo.js') }}"></script>
  <!-- page script -->
  <script>
    $(function () {
      $("#example1").DataTable();
      $('#example2').DataTable({
        "paging": true,
        "lengthChange": false,
        "searching": false,
        "ordering": true,
        "info": true,
        "autoWidth": false
      });
    });
  </script>
@endsection