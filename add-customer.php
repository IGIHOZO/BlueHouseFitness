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
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="assets/vendor/quill/quill.snow.css" rel="stylesheet">
  <link href="assets/vendor/quill/quill.bubble.css" rel="stylesheet">
  <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="assets/vendor/simple-datatables/style.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="assets/css/style.css" rel="stylesheet">
    <!-- Bootstrap CSS -->


</head>

<body>
<?php include("menus.php")?>
  <main id="main" class="main">

    <div class="pagetitle">
      <h1>New Customer</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
          <li class="breadcrumb-item">New Customer</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section">
      <div class="row">
        <div class="col-lg-5">

          <div class="card">
            <div class="card-body">
              <h5 class="card-title">New Customer details</h5>

              <!-- General Form Elements -->
              <form id="customerForm">
                <div class="row mb-5">
                    <label for="inputText" class="col-sm-5 col-form-label">First Name:</label>
                    <div class="col-sm-7">
                        <input type="text" class="form-control" id="inputFirstName">
                    </div>
                </div>
                <div class="row mb-5">
                    <label for="inputEmail" class="col-sm-5 col-form-label">Last Name:</label>
                    <div class="col-sm-7">
                        <input type="text" class="form-control" id="inputLastName">
                    </div>
                </div>
                <div class="row mb-5">
                    <label for="inputPassword" class="col-sm-5 col-form-label">Phone Number:</label>
                    <div class="col-sm-7">
                        <input type="text" class="form-control" id="inputPhoneNumber">
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-7 offset-sm-5">
                    <button type="button" class="btn btn-primary" onclick="saveCustomer()"><i class="bi bi-save"></i> Save </button>
                    </div>
                </div>

                <!-- Display success or error message -->
                <div id="messageContainer" class="mt-3"></div>
            </form>
              <!-- End General Form Elements -->

            </div>
          </div>

        </div>

        <div class="col-lg-7">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Customer Data</h5>

            <table id="customerTable" class="table" style="font-size: 11px;">
        <thead>
            <tr>
                <th>#</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Phone</th>
                <th>Recorded Date</th>
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

function saveCustomer() {
    var firstName = document.getElementById('inputFirstName').value;
    var lastName = document.getElementById('inputLastName').value;
    var phoneNumber = document.getElementById('inputPhoneNumber').value;
    var messageContainer = document.getElementById('messageContainer');
    var customerForm = document.getElementById('customerForm');

    // Check if all fields are filled
    if (!firstName || !lastName || !phoneNumber) {
        messageContainer.innerHTML = '<div class="alert alert-danger">Please fill in all fields before saving.</div>';
        return;
    }

    // Prepare data object
    var data = {
        "registerCustomer": true,
        "CustomerFname": firstName,
        "CustomerLname": lastName,
        "phone": phoneNumber
    };

    // Send POST request to "bluehouse/main/action.php"
    fetch('main/action.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify(data),
    })
    .then(response => {
        if (response.status === 404) {
            throw new Error('Page not found (404)');
        }
        return response.json(); // Parse the JSON response
    })
    .then(responseData => {
        if (responseData.success) {
            messageContainer.innerHTML = '<div class="alert alert-success">' + responseData.message + '</div>';
            
            customerForm.reset();
        } else if (responseData.error) {
            messageContainer.innerHTML = '<div class="alert alert-danger">' + responseData.message + '</div>';
        } else {
            messageContainer.innerHTML = '<div class="alert alert-warning">Unexpected response. Please try again.</div>';
        }
    })
    .catch(error => {
        console.error('Error:', error);

        messageContainer.innerHTML = '<div class="alert alert-danger">Failed to save customer. Please try again.</div>';
    });
}





</script>


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





