@extends('layout.admin')

@section('stylesheets')
  <!-- Bootstrap 3.3.5 -->
  <link rel="stylesheet" href="{{ asset('admin/bootstrap/css/bootstrap.min.css') }}">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- fullCalendar 2.2.5-->
  <link rel="stylesheet" href="{{ asset('admin/plugins/fullcalendar/fullcalendar.min.css') }}">
  <link rel="stylesheet" href="{{ asset('admin/plugins/fullcalendar/fullcalendar.print.css" media="print') }}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('admin/dist/css/AdminLTE.min.css') }}">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="{{ asset('admin/dist/css/skins/_all-skins.min.css') }}">
@endsection

@section('content')
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Calendar
      <small>Dashboard</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-calendar"></i> Calendar</a></li>
      <li class="active">Dashboard</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-md-9">
        <div class="box box-primary">
          <div class="box-body no-padding">
            <!-- THE CALENDAR -->
            <div id="calendar"></div>
          </div><!-- /.box-body -->
        </div><!-- /. box -->
      </div><!-- /.col -->
      <div class="col-md-3">
        <!-- small box -->
        <div class="small-box bg-aqua">
          <div class="inner">
            <h3>{{ Helper::get_reservation()->where('status_id', 1)->count() }}</h3>
            <p>Reservation</p>
          </div>
          <div class="icon">
            <i class="fa fa-bookmark"></i>
          </div>
          <a href="{{ route('reports.index') }}" class="small-box-footer">View Reports <i class="fa fa-arrow-circle-right"></i></a>
        </div>

        <!-- small box -->
        <div class="small-box bg-green">
          <div class="inner">
            <h3>{{ Helper::get_reservation()->where('status_id', 2)->count() }}<sup style="font-size: 20px"></sup></h3>
            <p>Check In</p>
          </div>
          <div class="icon">
            <i class="fa fa-calendar-check-o" style="font-size: 65px"></i>
          </div>
          <a href="{{ route('reports.index') }}" class="small-box-footer">View Reports <i class="fa fa-arrow-circle-right"></i></a>
        </div>

        <!-- small box -->
        <div class="small-box bg-yellow">
          <div class="inner">
            <h3>{{ Helper::get_reservation()->where('status_id', 3)->count() }}</h3>
            <p>Check Out</p>
          </div>
          <div class="icon">
            <i class="fa fa-calendar-times-o" style="font-size: 65px"></i>
          </div>
          <a href="{{ route('reports.index') }}" class="small-box-footer">View Reports <i class="fa fa-arrow-circle-right"></i></a>
        </div>

        <!-- small box -->
        <div class="small-box bg-red">
          <div class="inner">
            <h3>{{ Helper::get_reservation()->where('status_id', 4)->count() }}</h3>
            <p>Cancelled</p>
          </div>
          <div class="icon">
            <i class="fa fa-bookmark-o"></i>
          </div>
          <a href="{{ route('reports.index') }}" class="small-box-footer">View Reports <i class="fa fa-arrow-circle-right"></i></a>
        </div>

      </div><!-- /.col -->
      
    </div><!-- /.row -->
  </section><!-- /.content -->
@endsection

@section('scripts')
  <!-- jQuery 2.1.4 -->
  <script src="{{ asset('admin/plugins/jQuery/jQuery-2.1.4.min.js') }}"></script>
  <!-- Bootstrap 3.3.5 -->
  <script src="{{ asset('admin/bootstrap/js/bootstrap.min.js') }}"></script>
  <!-- jQuery UI 1.11.4 -->
  <script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>
  <!-- Slimscroll -->
  <script src="{{ asset('admin/plugins/slimScroll/jquery.slimscroll.min.js') }}"></script>
  <!-- FastClick -->
  <script src="{{ asset('admin/plugins/fastclick/fastclick.min.js') }}"></script>
  <!-- AdminLTE App -->
  <script src="{{ asset('admin/dist/js/app.min.js') }}"></script>
  <!-- AdminLTE for demo purposes -->
  <script src="{{ asset('admin/dist/js/demo.js') }}"></script>
  <!-- fullCalendar 2.2.5 -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.2/moment.min.js"></script>
  <script src="{{ asset('admin/plugins/fullcalendar/fullcalendar.min.js') }}"></script>
  <!-- Page specific script -->
  <script>
    $(function () {

      /* initialize the external events
       -----------------------------------------------------------------*/
      function ini_events(ele) {
        ele.each(function () {

          // create an Event Object (http://arshaw.com/fullcalendar/docs/event_data/Event_Object/)
          // it doesn't need to have a start or end
          var eventObject = {
            title: $.trim($(this).text()) // use the element's text as the event title
          };

          // store the Event Object in the DOM element so we can get to it later
          $(this).data('eventObject', eventObject);

          // make the event draggable using jQuery UI
          $(this).draggable({
            zIndex: 1070,
            revert: true, // will cause the event to go back to its
            revertDuration: 0  //  original position after the drag
          });

        });
      }
      ini_events($('#external-events div.external-event'));

      /* initialize the calendar
       -----------------------------------------------------------------*/
      //Date for the calendar events (dummy data)
      var date = new Date();
      var d = date.getDate(),
              m = date.getMonth(),
              y = date.getFullYear();
      $('#calendar').fullCalendar({
        header: {
          left: 'prev,next today',
          center: 'title',
          right: 'month,agendaWeek,agendaDay'
        },
        buttonText: {
          today: 'today',
          month: 'month',
          week: 'week',
          day: 'day'
        },
        //Random default events
        events: [
          @foreach($reservations as $reservation)
            {
              title: '{{ $reservation->status->name }}',
              start: new Date('{{ \Carbon\Carbon::parse($reservation->arrival_date)->format("Y") }}', '{{ \Carbon\Carbon::parse($reservation->arrival_date)->format("m")-1 }}', '{{ \Carbon\Carbon::parse($reservation->arrival_date)->format("d") }}'),
              end: new Date('{{ \Carbon\Carbon::parse($reservation->departure_date)->format("Y") }}', '{{ \Carbon\Carbon::parse($reservation->departure_date)->format("m")-1 }}', '{{ \Carbon\Carbon::parse($reservation->departure_date)->format("d") }}'),
              url: '{{ route('reports.show', $reservation->id) }}',
              backgroundColor: "{{ $reservation->status_id == 1 ? '#00c0ef' : ($reservation->status_id == 2 ? '#f56954' : ($reservation->status_id == 3 ? '#00a65a' : ($reservation->status_id == 4 ? '#f39c12' : ''))) }}",
              borderColor: "{{ $reservation->status_id == 1 ? '#00c0ef' : ($reservation->status_id == 2 ? '#f56954' : ($reservation->status_id == 3 ? '#00a65a' : ($reservation->status_id == 4 ? '#f39c12' : ''))) }}"
            },
          @endforeach
          
        ],
        editable: true,
        droppable: true, // this allows things to be dropped onto the calendar !!!
        drop: function (date, allDay) { // this function is called when something is dropped

          // retrieve the dropped element's stored Event Object
          var originalEventObject = $(this).data('eventObject');

          // we need to copy it, so that multiple events don't have a reference to the same object
          var copiedEventObject = $.extend({}, originalEventObject);

          // assign it the date that was reported
          copiedEventObject.start = date;
          copiedEventObject.allDay = allDay;
          copiedEventObject.backgroundColor = $(this).css("background-color");
          copiedEventObject.borderColor = $(this).css("border-color");

          // render the event on the calendar
          // the last `true` argument determines if the event "sticks" (http://arshaw.com/fullcalendar/docs/event_rendering/renderEvent/)
          $('#calendar').fullCalendar('renderEvent', copiedEventObject, true);

          // is the "remove after drop" checkbox checked?
          if ($('#drop-remove').is(':checked')) {
            // if so, remove the element from the "Draggable Events" list
            $(this).remove();
          }

        }
      });

      /* ADDING EVENTS */
      var currColor = "#3c8dbc"; //Red by default
      //Color chooser button
      var colorChooser = $("#color-chooser-btn");
      $("#color-chooser > li > a").click(function (e) {
        e.preventDefault();
        //Save color
        currColor = $(this).css("color");
        //Add color effect to button
        $('#add-new-event').css({"background-color": currColor, "border-color": currColor});
      });
      $("#add-new-event").click(function (e) {
        e.preventDefault();
        //Get value and make sure it is not null
        var val = $("#new-event").val();
        if (val.length == 0) {
          return;
        }

        //Create events
        var event = $("<div />");
        event.css({"background-color": currColor, "border-color": currColor, "color": "#fff"}).addClass("external-event");
        event.html(val);
        $('#external-events').prepend(event);

        //Add draggable funtionality
        ini_events(event);

        //Remove event from text input
        $("#new-event").val("");
      });
    });
  </script>
@endsection