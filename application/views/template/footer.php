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

<script type="text/javascript" src="<?= base_url(); ?>assets/DataTables/datatables.min.js"></script>

<?= $this->alert->init('jquery'); ?>

<script>
  var table = $('.table').DataTable({
    // responsive: true,
    "dom": 'Bflrtip',
    buttons: [{
      extend: 'excel',
      footer: false,
      // exportOptions: {
      //   columns: [0, 1, 2, 3, 4, 5]
      // }
    }],
    "pageLength": 5,
    "lengthMenu": [
      [5, 100, 1000, -1],
      [5, 100, 1000, "ALL"],
    ],

  })

  // document.addEventListener('DOMContentLoaded', function() {
  //   var calendarEl = document.getElementById('calendar');
  //   var calendar = new FullCalendar.Calendar(calendarEl, {
  //     initialView: 'dayGridMonth'
  //   });
  //   calendar.render();

  // });

  function formatRupiah(num) {
    let rupiahFormat = new Intl.NumberFormat('id-ID', {
      style: 'currency',
      currency: 'IDR',
      minimumFractionDigits: 0,
    }).format(num);

    return rupiahFormat;
  }

  var calendarEl = document.getElementById('calendar');
  if (calendarEl) {
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
  }

  function calSisa() {
    var harga_paket = document.getElementById('harga_paket');
    if (harga_paket) {
      var harga_paket = parseFloat(document.getElementById('harga_paket').value);
      var bayar1 = parseFloat(document.getElementById('bayar1').value);
      var bayar2 = parseFloat(document.getElementById('bayar2').value);

      document.getElementById('sisa').value = harga_paket - (bayar1 + bayar2);
    }
  }

  function set_paket() {

    var id = $('#id_sanggar').val();
    <?php if ($this->session->userdata('id_role') == 1) : ?>
      $('#id_paket').removeAttr('disabled');
    <?php endif; ?>
    $.ajax({
      url: '<?= base_url('order/ajax_paket'); ?>',
      method: 'GET', // POST
      data: {
        id: id
      },
      dataType: 'json', // json
      success: function(data) {
        var list = '';
        var id_paket = $('#id_paket').val();
        for (let index = 0; index < data.length; index++) {
          if (id_paket == data[index].id) {
            list += `<option selected value="` + data[index].id + `">` + data[index].nama_paket + ` | ` + formatRupiah(data[index].harga_paket) + `</option>`;
          } else {
            list += `<option value="` + data[index].id + `">` + data[index].nama_paket + ` | ` + formatRupiah(data[index].harga_paket) + `</option>`;

          }

        }
        $('#id_paket').html(list);
        set_paket_harga();
      }
    });
  }

  function set_paket_harga() {
    var id = $('#id_paket').val();
    $.ajax({
      url: '<?= base_url('order/ajax_paket_detail'); ?>',
      method: 'GET', // POST
      data: {
        id: id
      },
      dataType: 'json', // json
      success: function(data) {
        $('#harga_paket').val(data.harga_paket);
        calSisa();
      }
    });
  }

  if ($('#id_sanggar')) {
    set_paket();
    $('#id_sanggar').on('change', set_paket);
  }

  if ($('#id_paket')) {
    set_paket_harga();
    $('#id_paket').on('change', set_paket_harga);
  }

  if ($('#bayar1')) {
    $('#bayar1').on('keyup', calSisa);
  }

  if ($('#bayar2')) {
    $('#bayar2').on('keyup', calSisa);
  }
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