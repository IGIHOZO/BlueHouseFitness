<?php 
require("main/view.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Customers Report - Blue Huose Fitness</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="assets/img/logoo.png" rel="icon">
  <link href="assets/img/logoo.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="assets/vendor/quill/quill.snow.css" rel="stylesheet">
  <link href="assets/vendor/quill/quill.bubble.css" rel="stylesheet">
  <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="assets/vendor/simple-datatables/style.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="assets/css/style.css" rel="stylesheet">

</head>

<body>

<?php include("menus.php")?>

  <main id="main" class="main">

    <div class="pagetitle">
      <h1>Customers</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
          <li class="breadcrumb-item active">Customer Report</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section">
      <div class="row">
        <div class="col-lg-12">

          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Customers Report</h5>

<!-- Table with stripped rows -->
<table id="customerTable" class="table table-striped table-dark" style="font-size: 12px;">
    <thead>
        <tr>
            <th>#</th>
            <th>Name</th>
            <th>Phone</th>
            <th>Status</th>
            <th>Recorded Date</th>
            <!-- Add more header columns as needed based on your data -->
        </tr>
    </thead>
    <tbody id="customerTableBody">
        <!-- Table rows will be dynamically added here -->
    </tbody>
</table>
<!-- End Table with stripped rows -->


            </div>
          </div>

        </div>
      </div>
    </section>

  </main><!-- End #main -->
  <?php include("footer.php")?>

  <script>


document.addEventListener('DOMContentLoaded', function () {
            // Make a GET request to main/view.php with the data parameter
            fetch('main/view.php?all_customers=1')
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    // Get the reference to the table body
                    var tableBody = document.getElementById('customerTableBody');

                    // Clear existing rows
                    tableBody.innerHTML = '';

                    // Iterate through the data and construct HTML for each row
                    var html = '';
                    var cnt = 1;
                    data.data.forEach(customer => {
                        html += '<tr>';
                        html += '<td>' + cnt + '</td>';
                        html += '<td>' + customer.CustomerFname + '</td>';
                        html += '<td>' + customer.CustomerLname + '</td>';
                        html += '<td>' + customer.CustomerPhone + '</td>';
                        html += '<td>' + customer.CustomerRecordedDate + '</td>';
                        html += '</tr>';
                        cnt++;
                    });

                    // Append the HTML to the table body
                    tableBody.innerHTML = html;

                    // Initialize Simple DataTable
                    new simpleDatatables.DataTable('#customerTable');
                })
                .catch(error => {
                    console.error('There was a problem with the fetch operation:', error);
                });
        });
  </script>