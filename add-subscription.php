<?php 
require("main/view.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Add Customer - Blue Huose Fitness</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="assets/img/logoo.png" rel="icon">
  <link href="assets/img/logoo.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <!-- <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet"> -->
  <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="assets/vendor/quill/quill.snow.css" rel="stylesheet">
  <link href="assets/vendor/quill/quill.bubble.css" rel="stylesheet">
  <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="assets/vendor/simple-datatables/style.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="assets/css/style.css" rel="stylesheet">
    <!-- Bootstrap CSS -->

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">

    <!-- Select2 CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.19.0/font/bootstrap-icons.css">

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Bootstrap JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.min.js"></script>

    <!-- Select2 JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

</head>

<body>
<?php include("menus.php")?>
  <main id="main" class="main">

    <div class="pagetitle">
      <h1>Subscription Records</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
          <li class="breadcrumb-item">Subscription Records</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section">
      <div class="row">
      <div class="col-lg-4">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">New Subscription Details</h5>

    <form id="subscriptionForm">
    <div class="row mb-5">
        <label for="inputSelect" class="col-sm-5 col-form-label">Customer:</label>
        <div class="col-sm-7">
            <select class="form-select" id="inputSelect">
                <option value="" selected>Search Customer here ...</option>
                <!-- Options will be dynamically loaded here -->
            </select>
        </div>
    </div>
    <div class="row mb-3">
        <label for="inputInitAmount" class="col-sm-5 col-form-label">Amount to Record/Add:</label>
        <div class="col-sm-7">
            <input type="text" class="form-control" id="inputInitAmount">
        </div>
    </div>

    <div class="row">
        <div class="col-sm-7 offset-sm-5">
            <button type="button" class="btn btn-primary" onclick="saveSubscription()"><i class="bi bi-save"></i> Save </button>
        </div>
    </div>

    <!-- Display success or error message -->
    <div id="subscriptionMessageContainer" class="mt-3"></div>
</form>
            <!-- End Subscription Form -->

        </div>
    </div>
</div>


<div class="col-lg-8">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Customer Data</h5>

            <table id="customerTable" class="table" style="font-size: 11px;width:fit-content">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Names</th>
                        <th>Phone</th>
                        <th>Recorded Date</th>
                        <th>Init Amount</th>
                        <th>Consumed Amount</th>
                        <th>Remaining Amount</th>
                        <th>Init Days</th>
                        <th>Consumed Days</th>
                        <th>Remaining Days</th>
                    </tr>
                </thead>
                <tbody id="customerTableBody"></tbody>
            </table>

        </div>
    </div>
</div>


      </div>
    </section>

  </main><!-- End #main -->

  <?php include("footer.php")?>


  <script>
    function fetchCustomers() {
        return fetch('main/view.php?all_customers=1')
            .then(response => response.json())
            .then(data => data.data);
    }

    function updateCustomerDropdown() {
        const inputSelect = $('#inputSelect');
        inputSelect.empty();
        inputSelect.append('<option value="" selected>Search Customer here ...</option>');

        fetchCustomers().then(customers => {
            customers.forEach(customer => {
                const option = $('<option>').val(customer.CustomerID).text(`${customer.CustomerFname} ${customer.CustomerLname}`);
                inputSelect.append(option);
            });

            inputSelect.select2({
                placeholder: 'Search Customer here ...',
                theme: 'bootstrap-5',
                // Additional options as needed
            });
        });
    }

    $(document).ready(function() {
        // Initial load of customers
        updateCustomerDropdown();
    });

    function saveSubscription() {
        const client = $('#inputSelect').val();
        const amount = $('#inputInitAmount').val();

        // Check if the client and amount are selected/entered
        if (!client || !amount) {
            $('#subscriptionMessageContainer').html('<div class="alert alert-danger" role="alert">Please select a customer and enter the amount.</div>');
            return;
        }

        // Prepare data for submission
        const data = {
            recordSubscription: 1,
            client: client,
            amount: amount
        };

        // Make a POST request to main/action.php
        fetch('main/action.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(data),
        })
        .then(response => response.json())
        .then(response => {
            if (response.success) {
                $('#subscriptionMessageContainer').html('<div class="alert alert-success" role="alert">' + response.message + '</div>');
                // Reload the page after displaying the response
                setTimeout(() => {
                    location.reload();
                }, 2000); // Delay for 2 seconds (adjust as needed)
            } else {
                $('#subscriptionMessageContainer').html('<div class="alert alert-danger" role="alert">' + response.message + '</div>');
            }
        })
        .catch(error => {
            console.error('Error submitting data:', error);
            $('#subscriptionMessageContainer').html('<div class="alert alert-danger" role="alert">An error occurred while submitting the form.</div>');
        });
    }





    document.addEventListener('DOMContentLoaded', function () {
        // Make a GET request to main/view.php with the data parameter
        fetch('main/view.php?all_subscriptions=1')
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
                data.data.forEach(subscription => {
                    html += '<tr>';
                    html += '<td>' + cnt + '</td>';
                    html += '<td>' + subscription.CustomerFname + ' ' + subscription.CustomerLname + '</td>';
                    html += '<td>' + subscription.CustomerPhone + '</td>';
                    html += '<td>' + subscription.CustomerRecordedDate + '</td>';
                    html += '<td>' + subscription.SubscriptionInitAmount + '</td>';
                    html += '<td>' + subscription.SubscriptionConsumedAmount + '</td>';
                    html += '<td>' + subscription.SubscriptionRemainingAmount + '</td>';
                    html += '<td>' + subscription.SubscriptionInitDays + '</td>';
                    html += '<td>' + subscription.SubscriptionConsumedDays + '</td>';
                    html += '<td>' + subscription.SubscriptionRemainingDays + '</td>';
                    // html += '<td>' + subscription.SubscriptionRecordedDate + '</td>';
                    html += '</tr>';
                    cnt++;
                });

                // Append the HTML to the table body
                tableBody.innerHTML = html;

                // Initialize DataTables
                $('#customerTable').DataTable();
            })
            .catch(error => {
                console.error('There was a problem with the fetch operation:', error);
            });
    }); 
</script>
