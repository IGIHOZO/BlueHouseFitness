<?php 
require("main/view.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>All Salles - Blue Huose Fitness</title>
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
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.18.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">
  <!-- Template Main CSS File -->
  <link href="assets/css/style.css" rel="stylesheet">


</head>

<body>

<?php include("menus.php")?>

  <main id="main" class="main">

    <div class="pagetitle">
      <h1>All Salles</h1>
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
              <h5 class="card-title">All Salles</h5>

<!-- Table with stripped rows -->
<table id="customerTable" class="table table-striped table-dark" style="font-size:12px">
        <thead>
            <tr>
                <th>#</th>
                <th>Names</th>
                <th>Phone</th>
                <th>Amount</th>
                <th>Payment Category</th>
                <th>Time</th>
            </tr>
        </thead>
        <tbody id="customerTableBody">
        </tbody>
        <tfoot>
            <tr>
                <td colspan="3"></td>
                <td id="totalAmount"></td>
                <td colspan="2"></td>
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




<!-- ... -->

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Make a GET request to main/view.php with the data parameter
        fetch('main/view.php?all_entrance_history=1')
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                // Get the reference to the table body and total amount element
                var tableBody = document.getElementById('customerTableBody');
                var totalAmountElement = document.getElementById('totalAmount');

                // Clear existing rows and total amount
                tableBody.innerHTML = '';
                totalAmountElement.textContent = '';

                // Iterate through the data and construct HTML for each row and calculate total amount
                var html = '';
                var totalAmount = 0;
                var cnt = 1;

                data.data.forEach(customer => {
                    var ttype = customer.EntranceType == 1 ? "unsubscribed" : "Subscribed";
                    var entranceAmount = parseFloat(customer.EntranceAmount) || 0;

                    totalAmount += entranceAmount;

                    html += '<tr>';
                    html += '<td>' + cnt + '</td>';
                    html += '<td>' + (customer.CustomerFname || '-') + ' ' + (customer.CustomerLname || '-') + '</td>';
                    html += '<td>' + (customer.CustomerPhone || '-') + '</td>';
                    html += '<td>' + entranceAmount.toLocaleString('en-US', { style: 'decimal', minimumFractionDigits: 2, maximumFractionDigits: 2 }) + '</td>';
                    html += '<td>' + ttype + '</td>';
                    html += '<td>' + (customer.EntranceTime || '-') + '</td>';
                    html += '</tr>';
                    cnt++;
                });

                // Append the HTML to the table body
                tableBody.innerHTML = html;

                // Display the total amount
                totalAmountElement.textContent = 'Total Amount: ' + totalAmount.toLocaleString('en-US', { style: 'decimal', minimumFractionDigits: 2, maximumFractionDigits: 2 });

                // Initialize DataTable with options to include the footer
                $('#customerTable').DataTable({
                    "footerCallback": function (row, data, start, end, display) {
                        var api = this.api(), data;

                        // Remove the formatting to get integer data for summation
                        var intVal = function (i) {
                            return typeof i === 'string' ?
                                i.replace(/[\$,]/g, '') * 1 :
                                typeof i === 'number' ?
                                i : 0;
                        };

                        // Total over all pages
                        total = api
                            .column(3)
                            .data()
                            .reduce(function (a, b) {
                                return intVal(a) + intVal(b);
                            }, 0);

                        // Update total amount in the footer
                        totalAmountElement.textContent = 'Total Amount: ' + total.toLocaleString('en-US', { style: 'decimal', minimumFractionDigits: 2, maximumFractionDigits: 2 });
                    }
                });
            })
            .catch(error => {
                console.error('There was a problem with the fetch operation:', error);
            });
    });
</script>


<script src="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.18.0/dist/js/bootstrap-icons.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script> 

<!-- ... -->

