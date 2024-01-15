<?php 
require("main/view.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Subscription Sales - Blue Huose Fitness</title>
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
      <h1>Subscription Sales</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
          <li class="breadcrumb-item active">Subscription Sales</li>
        </ol>
      </nav>
    </div>
    <!-- End Page Title -->

    <section class="section">
      <div class="row">
        <div class="col-lg-12">

          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Subscription Sales</h5>

<!-- Table with stripped rows -->
<table id="customerTable" class="table table-striped table-dark" style="font-size:12px">
        <thead>
            <tr>
                <th>#</th>
                <th>Names</th>
                <th>Phone</th>
                <th>Paid Amount</th>
                <th>Non-Consumed</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody id="customerTableBody">
            <!-- Table rows will be dynamically added here -->
        </tbody>
        <tfoot>
            <tr>
                <td colspan="3"></td>
                <td id="totalPaidAmount"></td>
                <td id="totalNonConsumed"></td>
                <td colspan="1"></td>
            </tr>
        </tfoot>
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
            fetch('main/view.php?all_SubSalleRep_history=1')
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    // Get the reference to the table body and total elements
                    var tableBody = document.getElementById('customerTableBody');
                    var totalPaidAmountElement = document.getElementById('totalPaidAmount');
                    var totalNonConsumedElement = document.getElementById('totalNonConsumed');

                    // Clear existing rows and totals
                    tableBody.innerHTML = '';
                    totalPaidAmountElement.textContent = '';
                    totalNonConsumedElement.textContent = '';

                    // Iterate through the data and construct HTML for each row and calculate totals
                    var html = '';
                    var totalPaidAmount = 0;
                    var totalNonConsumed = 0;
                    var cnt = 1;

                    data.data.forEach(customer => {
                        var ttype = customer.EntranceType == 1 ? "Pay as You Enter" : "Subscription";
                        var entranceAmount = parseFloat(customer.EntranceAmount) || 0;
                        var nonConsumed = parseFloat(customer.EntranceRemaining * entranceAmount) || 0;

                        totalPaidAmount += entranceAmount;
                        totalNonConsumed += nonConsumed;

                        html += '<tr>';
                        html += '<td>' + cnt + '</td>';
                        html += '<td>' + (customer.CustomerFname || '-') + ' ' + (customer.CustomerLname || '-') + '</td>';
                        html += '<td>' + (customer.CustomerPhone || '-') + '</td>';
                        html += '<td>' + entranceAmount.toLocaleString('en-US', { style: 'currency', currency: 'Rwf', minimumFractionDigits: 2, maximumFractionDigits: 2 }) + '</td>';
                        html += '<td>' + nonConsumed.toLocaleString('en-US', { style: 'currency', currency: 'Rwf', minimumFractionDigits: 2, maximumFractionDigits: 2 }) + '</td>';
                        html += '<td>' + (customer.EntranceTime.substring(0, 18) || '-') + '</td>';
                        html += '</tr>';
                        cnt++;
                    });

                    // Append the HTML to the table body
                    tableBody.innerHTML = html;

                    // Display the total paid amount and total non-consumed
                    totalPaidAmountElement.textContent = 'Total Paid Amount: ' + totalPaidAmount.toLocaleString('en-US', { style: 'currency', currency: 'Rwf', minimumFractionDigits: 2, maximumFractionDigits: 2 });
                    totalNonConsumedElement.textContent = 'Total Non-Consumed: ' + totalNonConsumed.toLocaleString('en-US', { style: 'currency', currency: 'Rwf', minimumFractionDigits: 2, maximumFractionDigits: 2 });

                    // Initialize DataTable with options to include the footer
                    $('#customerTable').DataTable({
                        "footerCallback": function (row, data, start, end, display) {
                            totalPaidAmountElement.textContent = 'Total Paid Amount: ' + totalPaidAmount.toLocaleString('en-US', { style: 'currency', currency: 'Rwf', minimumFractionDigits: 2, maximumFractionDigits: 2 });
                            totalNonConsumedElement.textContent = 'Total Non-Consumed: ' + totalNonConsumed.toLocaleString('en-US', { style: 'currency', currency: 'Rwf', minimumFractionDigits: 2, maximumFractionDigits: 2 });
                        }
                    });
                })
                .catch(error => {
                    console.error('There was a problem with the fetch operation:', error);
                });
        });
    </script>
