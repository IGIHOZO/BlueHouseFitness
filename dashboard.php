<?php 
require("main/view.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Dashboard - Blue Huose Fitness</title>
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
  /* Add this style to make the button show a pointer cursor on hover */
  #reloadButton {
    cursor: pointer;
  }
</style>
</head>

<body>


<?php include("menus.php")?>

  <main id="main" class="main">

    <div class="pagetitle">
      <h1>Dashboard</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
          <li class="breadcrumb-item active">Dashboard</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section">
      <div class="row">

        <div class="col-lg-6">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Subscription Payments</h5>

                <!-- Line Chart -->
                <div id="lineChart"></div>

                <script>
                    document.addEventListener("DOMContentLoaded", () => {
                        // Fetch data using AJAX
                        fetch('main/view.php?subscription_transactions=1')
                            .then(response => response.json())
                            .then(data => {
                                const seriesData = {
                                    "totalAmountPaidSeries": {
                                        "data": data.data.map(entry => entry.total_amount_paid),
                                        "dates": data.data.map(entry => entry.recorded_date)
                                    }
                                };

                                new ApexCharts(document.querySelector("#lineChart"), {
                                    series: [{
                                        name: "Total Amount Paid",
                                        data: seriesData.totalAmountPaidSeries.data
                                    }],
                                    chart: {
                                        height: 350,
                                        type: 'line',
                                        zoom: {
                                            enabled: false
                                        }
                                    },
                                    dataLabels: {
                                        enabled: false
                                    },
                                    stroke: {
                                        curve: 'straight'
                                    },
                                    grid: {
                                        row: {
                                            colors: ['#f3f3f3', 'transparent'], // takes an array which will be repeated on columns
                                            opacity: 0.5
                                        },
                                    },
                                    xaxis: {
                                        categories: seriesData.totalAmountPaidSeries.dates,
                                    }
                                }).render();
                            })
                            .catch(error => console.error('Error fetching data:', error));
                    });
                </script>
                <!-- End Line Chart -->


            </div>
          </div>
        </div>

        <div class="col-lg-6">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Entrance Payments</h5>

              <!-- Area Chart -->
<!-- Area Chart -->
<div id="areaChart"></div>

<script>
    document.addEventListener("DOMContentLoaded", () => {
        // Fetch data using AJAX
        fetch('main/view.php?recent_entrances=1')
            .then(response => response.json())
            .then(data => {
                const seriesData = {
                    "totalAmountSeries": {
                        "prices": data.data.map(entry => entry.total_amount),
                        "dates": data.data.map(entry => entry.date)
                    }
                };

                new ApexCharts(document.querySelector("#areaChart"), {
                    series: [{
                        name: "Total Amount",
                        data: seriesData.totalAmountSeries.prices
                    }],
                    chart: {
                        type: 'area',
                        height: 350,
                        zoom: {
                            enabled: false
                        }
                    },
                    dataLabels: {
                        enabled: false
                    },
                    stroke: {
                        curve: 'straight'
                    },
                    subtitle: {
                        text: 'Amount Paid',
                        align: 'left'
                    },
                    labels: seriesData.totalAmountSeries.dates,
                    xaxis: {
                        type: 'datetime',
                    },
                    yaxis: {
                        opposite: true
                    },
                    legend: {
                        horizontalAlign: 'left'
                    }
                }).render();
            })
            .catch(error => console.error('Error fetching data:', error));
    });
</script>
<!-- End Area Chart -->

              <!-- End Area Chart -->

            </div>
          </div>
        </div>







      </div>
    </section>

  </main><!-- End #main -->

  <?php include("footer.php")?>

  <script>
document.addEventListener('DOMContentLoaded', function() {
  // Add click event listener to the button
  document.getElementById('reloadButton').addEventListener('click', function() {
    // Create a new XMLHttpRequest object
    var xhr = new XMLHttpRequest();

    // Set up the request
    xhr.open('GET', 'main/view.php?checkRemainingDays=1', true);

    // Define the callback function to handle the response
    xhr.onreadystatechange = function() {
      if (xhr.readyState == 4) {
        if (xhr.status == 200) {
          // Handle the AJAX response here
          console.log(xhr.responseText);
          // You can update the UI or perform other actions based on the response
        } else {
          // Handle the error if the AJAX request fails
          console.error('Error:', xhr.status, xhr.statusText);
        }
      }
    };

    // Send the request
    xhr.send();
  });
});
</script>