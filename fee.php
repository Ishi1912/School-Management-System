<?php 
session_start();
require 'database.php';
require 'functions.php';

// Handle Requests
$message = '';
$fees = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['add_fee'])) {
        $sid = $_POST['sid'];
        $amount = $_POST['amount'];
        $due_date = $_POST['due_date'];
        $message = addFee($conn, $sid, $amount, $due_date);
    } elseif (isset($_POST['mark_paid'])) {
        $fid = $_POST['fid'];
        $message = markFeeAsPaid($conn, $fid);
    }
}

if (isset($_GET['sid'])) {
    $sid = $_GET['sid'];
    $fees = getFees($conn, $sid);
}
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Fees Management</title><link rel="icon" href="../img/favicon2.png">
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="bower_components/Ionicons/css/ionicons.min.css">
  <link rel="stylesheet" href="bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">

  <link rel="stylesheet" href="bower_components/bootstrap-daterangepicker/daterangepicker.css">
  <!-- bootstrap datepicker -->
  <link rel="stylesheet" href="bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
  <link rel="stylesheet" href="bower_components/select2/dist/css/select2.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins -->
  <link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">

  <!-- Custom Styles -->
  <style>
      .container {
          display: flex;
          justify-content: space-between;
          margin-top: 20px;
      }

      .form-container {
          flex: 1;
          padding: 20px;
          border-right: 2px solid #ddd;
          background-color: white;  /* Make left side white */
      }

      .fees-container {
          flex: 2;
          padding: 20px;
          /* No background color change for the right side */
      }

      .form-group {
          margin-bottom: 15px;
      }

      label {
          font-weight: bold;
      }

      input[type="text"], input[type="number"], input[type="date"] {
          width: 100%;
          padding: 8px;
          border: 1px solid #ccc;
          border-radius: 4px;
      }

      button {
          background-color: #4CAF50;
          color: white;
          padding: 10px 20px;
          border: none;
          border-radius: 4px;
          cursor: pointer;
      }

      button:hover {
          background-color: #45a049;
      }

      table {
          width: 100%;
          border-collapse: collapse;
          margin-top: 20px;
      }

      table th, table td {
          padding: 10px;
          text-align: left;
          border: 1px solid #ddd;
      }

      table th {
          background-color: #f2f2f2;
      }
  </style>
</head>

<body class="hold-transition skin-green sidebar-mini">
<div class="wrapper">

  <!-- Main Header -->
  <?php include_once 'header.php'; ?>
  <!-- Left side column. contains the logo and sidebar -->
  <?php include_once 'sidebar.php'; ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Fee 
        <small>Fee Management</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Fee</a></li>
        <li class="active">Details</li>
      </ol>
    </section>

    <?php if ($message): ?>
        <p style="color: green;"><?= $message ?></p>
    <?php endif; ?>

    <div class="container">
      <!-- Left Side Form -->
      <div class="form-container">
        <h2>Add Fee</h2>
        <form method="POST">
            <input type="hidden" name="add_fee" value="1">
            <label>Student ID:</label>
            <input type="text" name="sid" required>
            <br>
            <label>Amount:</label>
            <input type="number" name="amount" step="0.01" required>
            <br>
            <label>Due Date:</label>
            <input type="date" name="due_date" required>
            <br>
            <button type="submit">Add Fee</button>
        </form>

        <h2>Mark Fee as Paid</h2>
        <form method="POST">
            <input type="hidden" name="mark_paid" value="1">
            <label>Fee ID:</label>
            <input type="number" name="fid" required>
            <br>
            <button type="submit">Mark Paid</button>
        </form>

        <h2>View Fees</h2>
        <form method="GET">
            <label>Student ID:</label>
            <input type="text" name="sid" required>
            <button type="submit">View Fees</button>
        </form>
      </div>

      <!-- Right Side Fees Table -->
      <div class="fees-container">
        <?php if ($fees): ?>
            <h3>Fees for Student ID: <?= htmlspecialchars($sid) ?></h3>
            <table border="1">
                <thead>
                    <tr>
                        <th>Fee ID</th>
                        <th>Amount</th>
                        <th>Due Date</th>
                        <th>Status</th>
                        <th>Payment Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($fees as $fee): ?>
                        <tr>
                            <td><?= $fee['fid'] ?></td>
                            <td><?= $fee['amount'] ?></td>
                            <td><?= $fee['due_date'] ?></td>
                            <td><?= $fee['status'] ?></td>
                            <td><?= $fee['payment_date'] ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
      </div>
    </div>

    <?php include_once 'footer.php'; ?>

  
<!-- /.control-sidebar -->
<!-- Add the sidebar's background. This div must be placed
immediately after the control sidebar -->
<div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->

<!-- REQUIRED JS SCRIPTS -->

<!-- jQuery 3 -->
<script src="bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="bower_components/select2/dist/js/select2.full.min.js"></script>
<!-- Select2 -->
<script src="bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>


<script src="bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<!-- bootstrap color picker -->
<script src="bower_components/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js"></script>
<!-- bootstrap time picker -->
<script src="plugins/timepicker/bootstrap-timepicker.min.js"></script>

<script src="bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<!-- iCheck 1.0.1 -->
<script src="plugins/iCheck/icheck.min.js"></script>
<!-- FastClick -->
<script src="bower_components/fastclick/lib/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
<!-- Page script -->

<script>
$(function () {
  $('#example1').DataTable()
  $('#example2').DataTable({
    'paging'      : true,
    'lengthChange': false,
    'searching'   : false,
    'ordering'    : true,
    'info'        : true,
    'autoWidth'   : false
  })
})
</script>


<script>   $('.select2').select2()
$('#datepicker').datepicker({
    autoclose: true
  });


      
          var r = document.getElementById("subject"); 
          r.className += "active"; 
         
  </script>
<!-- Optionally, you can add Slimscroll and FastClick plugins.
   Both of these plugins are recommended to enhance the
   user experience. -->

</body>
</html>
