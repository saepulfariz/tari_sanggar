<?php $this->view('template/header'); ?>


<?= $this->alert->get(); ?>

<?= $contents; ?>


<?php $this->view('template/footer'); ?>

<script>
  function fixAlert() {
    var alertShow = document.getElementsByClassName('swal2-height-auto');

    if (alertShow) {
      document.body.classList.remove('swal2-height-auto');
    }
  }
  fixAlert();
  setInterval(fixAlert, 5);
</script>
</body>

</html>