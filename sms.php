<?php
require("main/view.php");
$MainView = new MainView();
$unit = $MainView->loadUnitValue();
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>SMS - Blue Huose Fitness</title>
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
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
    <!-- Other scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>

  <!-- Template Main CSS File -->
  <link href="assets/css/style.css" rel="stylesheet">

  <style>
    /* Custom styles for the card */
    .custom-card {
      width: 300px; /* Adjust the width as needed */
      margin: 20px; /* Adjust the margin as needed */
      border: 1px solid #ccc;
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    /* Custom styles for the card body */
    .custom-card-body {
      padding: 20px;
    }

    /* Custom styles for the input group */
    .custom-input-group {
      margin-bottom: 15px; /* Adjust the margin as needed */
    }

    /* Custom styles for the update button */
    .custom-update-btn {
      display: none;
      margin-top: 10px; /* Adjust the margin as needed */
    }
  </style>


</head>

<body>

<?php include("menus.php")?>

  <main id="main" class="main">

    <div class="pagetitle">
      <h1>Send SMS</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
          <li class="breadcrumb-item">Send SMS</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section">
      <div class="row">
        <div class="col-lg-6">


        
        <div class="card custom-card">
    <div class="card-body custom-card-body">
        <h5 class="card-title">SMS Contents</h5>
        <div class="form-group custom-input-group">
            <div class="form-check">
                <input type="checkbox" class="form-check-input" id="isAll">
                <label class="form-check-label" for="isAll">Send to All</label>
            </div>
        </div>
        <div class="form-group custom-input-group">
            <label for="customUsers">Select User:</label>
            <select class="form-control" id="customUsers">
                <?php 
                $sel = $con->prepare("SELECT * FROM customers WHERE CustomerStatus=1 ORDER BY CustomerFname, CustomerLname");
                $sel->execute();
                if($sel->rowCount()>=1){
                    echo "<option value=''>Select Customer</option>";
                    while($ft_sel = $sel->fetch(PDO::FETCH_ASSOC)){
                        echo "<option value='".$ft_sel['CustomerPhone']."'>".strtoupper($ft_sel['CustomerFname'])." ".strtoupper($ft_sel['CustomerLname'])." | ".strtoupper($ft_sel['CustomerPhone'])."</option>";
                    }
                }
                ?>
            </select>
        </div>
        <div class="form-group custom-input-group">
            <label for="SMSValue">SMS Contents:</label>
            <textarea class="form-control" id="SMSValue" cols="30" rows="4" placeholder="Write your SMS to be sent here ..."></textarea>
        </div>
        <div class="form-group custom-input-group">
            <button class="btn btn-primary" id="sendButton">
                <i class="bi bi-arrow-right-circle"></i> Send
            </button>
        </div>
        <!-- Single div for messages -->
        <div id="responseMessage" class="alert" style="display: none;"></div>
    </div>
</div>

<script>

$(document).ready(function() {
    $('#isAll').change(function() {
        var isAllChecked = $(this).prop('checked');
        $('#customUsers').prop('disabled', isAllChecked);
        if (isAllChecked) {
            $('#customUsers').val('').trigger('change');
        }
    });

    $('#customUsers').select2();

    $('#sendButton').click(function() {
        // Determine if the "Send to All" checkbox is checked
        var isAll = $('#isAll').is(':checked');

        // If the checkbox is not checked, check if a customer is selected
        var newIsAll = 'no';
        if (!isAll) {
            var selectedCustomer = $('#customUsers').val();
            if (!selectedCustomer) {
                displayMessage('Please select a customer.', 'danger');
                newIsAll = 'no';
                return; // Exit the function if no customer is selected
            }
        }else{
                newIsAll = 'yes';
            }

        // Check if the message textarea is empty
        var message = $('#SMSValue').val().trim();
        if (message === '') {
            displayMessage('Please enter a message.', 'danger');
            return; // Exit the function if the message is empty
        }

        // If all conditions are met, send the AJAX request
        var customUsers = $('#customUsers').val();
        var SMSValue = $('#SMSValue').val();
        $.ajax({
            url: 'main/action.php',
            method: 'POST',
            data: {
                send_email_to_customer: true,
                isAll: newIsAll,
                customUsers: customUsers,
                SMSValue: SMSValue
            },
            success: function(response) {
                // Handle success response
                displayMessage('Message sent successfully.', 'success');
                console.log('AJAX request successful');
            },
            error: function(xhr, status, error) {
                // Handle error
                displayMessage('Failed to send message. Please try again later.', 'danger');
                console.error('AJAX request failed:', error);
            }
        });
    });

    // Function to display messages
    function displayMessage(message, type) {
        var alertClass = type === 'success' ? 'alert-success' : 'alert-danger';
        $('#responseMessage').removeClass('alert-success alert-danger').addClass(alertClass).text(message).show();
    }
});


</script>
    



<style>
    .form-check-input-lg {
        transform: scale(1.5);
    }
</style>



        </div>

        <div class="col-lg-6">

          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Note !</h5>
              <p>This is the gateway for sending Short Messages (SMSs) to the customers, here is the way for two options:(Send to all, and Custom Sending.)
                <br><br>One you tick <b>Send to all</b>, the SMS content will be sent to all customers registrerd with in the system, else by unticking the checkbox, and select <b>Select User</b>, the SMS content will be sent to that selected customer.
               <br><br>
               <b>Make sure you've sufficient balance in you SMS-Portal, if not you've to <u><i>Top-Up</i></u>.</b> 
              </p>

            </div>
          </div>

        </div>
      </div>
    </section>

  </main><!-- End #main -->

  <?php include("footer.php")?>



  <script>
  var originalValue = document.getElementById('exampleInput').value;

  function handleInputChange(input) {
    var updateBtn = document.querySelector('.custom-update-btn');
    updateBtn.style.display = input.value !== originalValue ? 'inline-block' : 'none';
  }

  function enableInput() {
    var inputElement = document.getElementById('exampleInput');
    inputElement.disabled = !inputElement.disabled;

    var updateBtn = document.querySelector('.custom-update-btn');
    updateBtn.style.display = 'none'; // Hide the button when editing is enabled
  }

  function updateValue() {
    var inputValue = document.getElementById('exampleInput').value;
    var responseMessage = document.getElementById('responseMessage');

    // Send POST request to "/main/action.php"
    fetch('main/action.php', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
      },
      body: JSON.stringify({
        SetEntranceUnit: true,
        UnitValue: parseInt(inputValue, 10), // Assuming inputValue is a numeric value
      }),
    })
    .then(response => response.json())
    .then(data => {
      // Display the response message
      responseMessage.textContent = data.message;
      responseMessage.className = 'alert alert-success mt-3';
      responseMessage.style.display = 'block';

      // Hide the update button after a successful update
      var updateBtn = document.querySelector('.custom-update-btn');
      updateBtn.style.display = 'none';
    })
    .catch(error => {
      // Display error message
      responseMessage.textContent = 'Update failed. Please try again.';
      responseMessage.className = 'alert alert-danger mt-3';
      responseMessage.style.display = 'block';

      console.error('Error:', error);
    });
  }
</script>

