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

  <title>Unit-Fees - Blue Huose Fitness</title>
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
      <h1>Entrance Fees</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
          <li class="breadcrumb-item">Entrance Fees</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section">
      <div class="row">
        <div class="col-lg-6">

        <div class="card custom-card">
  <div class="card-body custom-card-body">
    <h5 class="card-title">Current Fees <small style="font-size:11px">(<?=number_format($unit)." Rwf"?>/Mounth)</small> </h5>
    <div class="input-group mb-3 custom-input-group">
      <input type="text" class="form-control" value="<?=$unit?>" disabled id="exampleInput" oninput="handleInputChange(this)">
      <div class="input-group-append">
        <button class="btn btn-outline-secondary" type="button" onclick="enableInput()">
          <i class="bi bi-pencil"></i>
        </button>
      </div>
    </div>
    <button class="btn btn-success custom-update-btn" type="button" onclick="updateValue()">Update</button>
    <div class="alert alert-success mt-3" role="alert" id="responseMessage" style="display: none;"></div>
  </div>
</div>

        </div>

        <div class="col-lg-6">

          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Note !</h5>
              <p>The subscription counts are calculated on a monthly basis, allowing flexibility for subscribers to choose any number of months. The pricing is proportionally affected based on the selected duration of subscription.
                <br><br>Your entrance access remains valid until the conclusion of your subscription period.</p>
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

