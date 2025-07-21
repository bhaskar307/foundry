<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <title>Foundry</title>
  <link rel="icon" href="<?php echo base_url('assets/admin/images/logo_ibm.png') ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <link href="https://cdn.datatables.net/2.2.1/css/dataTables.dataTables.min.css" rel="stylesheet">
  <link href="<?= base_url('assets/clinic/css/jquery.datetimepicker.min.css') ?>" rel="stylesheet">
  <link href="<?= base_url('assets/clinic/css/custom.css') ?>" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <script src="https://cdn.datatables.net/2.2.1/js/dataTables.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script src="<?= base_url('assets/clinic/js/jquery.datetimepicker.full.min.js') ?>"></script>
  <script src="<?= base_url('assets/clinic/js/custom.js') ?>"></script>

  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <script src="<?php echo base_url('assets/admin/js/waitingModal.js') ?>"></script>
  
</head>

<body>
  <section class="pagewrap">
    <?php echo view('admin/templates/sidebar'); ?>
    <div class="content-wrap">
      <?php echo view('admin/templates/nav'); ?>
      <?php
      $user_role = session()->get('user_role');
      ?>