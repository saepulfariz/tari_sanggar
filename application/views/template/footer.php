<!-- jQuery -->
<script src="<?= base_url(); ?>assets/plugins/jquery/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="<?= base_url(); ?>assets/plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>

<!-- Bootstrap 4 -->
<script src="<?= base_url(); ?>assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- overlayScrollbars -->
<script src="<?= base_url(); ?>assets/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="<?= base_url(); ?>assets/dist/js/adminlte.min.js"></script>

<script src="<?= base_url(); ?>assets/plugins/fullcalendar/index.global.min.js"></script>
<script src="<?= base_url(); ?>assets/plugins/fullcalendar/moment.js"></script>

<?= $this->alert->init('jquery'); ?>

<script>
  // document.addEventListener('DOMContentLoaded', function() {
  //   var calendarEl = document.getElementById('calendar');
  //   var calendar = new FullCalendar.Calendar(calendarEl, {
  //     initialView: 'dayGridMonth'
  //   });
  //   calendar.render();

  // });

  var calendarEl = document.getElementById('calendar');
  var calendar = new FullCalendar.Calendar(calendarEl, {
    initialView: 'dayGridMonth',
    timeZone: 'UTC',
    eventTimeFormat: {
      hour: '2-digit', //2-digit, numeric
      minute: '2-digit', //2-digit, numeric
      // second: '2-digit', //2-digit, numeric
      meridiem: false, //lowercase, short, narrow, false (display of AM/PM)
      hour12: false //true, false
    },
    // dayMaxEvents: true, // allow "more" link when too many events
    eventSources: [
      // your event source
      {
        events: function(info, successCallback, failureCallback) {
          let start = moment(info.start.valueOf()).format('YYYY-MM-DD');
          let end = moment(info.end.valueOf()).format('YYYY-MM-DD');
          $.ajax({
            url: "<?= base_url(); ?>sanggar/calendar",
            type: 'GET',
            dataType: 'json', // json
            data: {
              start: start,
              end: end,
              id_sanggar: $('#id_sanggar').val(),
            },
            success: function(res) {
              successCallback(res);
            }
          });
        },
        // color: 'yellow', // an option!
        textColor: 'black' // an option!
      }
      // any other sources...
    ],
  });

  $('#modalCalendar').on('shown.bs.modal', function(event) {
    calendar.render();
  })
</script>

<script>
  function previewImage(input, previewDom) {

    if (input.files && input.files[0]) {

      $(previewDom).show();

      var reader = new FileReader();

      reader.onload = function(e) {
        $(previewDom).find('img').attr('src', e.target.result);
      }

      reader.readAsDataURL(input.files[0]);
    } else {
      $(previewDom).hide();
    }

  }
</script>