<!DOCTYPE html>
<html lang="en">
<head>
  <title>NPS- Admin Panel</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="<?= base_url('vendor/bootstrap/css/bootstrap.css') ?>">
  <link rel="stylesheet" href="<?= base_url('vendor/fontawesome-free/css/all.css') ?>">
  <link rel="stylesheet" href="<?= base_url('css/sb-admin.css') ?>">

</head>
<body class="">

   <?= $this->renderSection("body") ?>

</body>

<?php echo script_tag('vendor/jquery/jquery.min.js'); ?>
<?php echo script_tag('vendor/bootstrap/js/bootstrap.bundle.min.js'); ?>
<?php echo script_tag('vendor/jquery-easing/jquery.easing.min.js'); ?>
<?php echo script_tag('js/sb-admin.js'); ?>
<?php echo script_tag('vendor/chart.js/Chart.min.js'); ?>


</html>