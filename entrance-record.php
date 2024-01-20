<?php 
require("main/view.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Entrance Record - Blue Huose Fitness</title>
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
    /* Add some basic styles to make the list visually appealing */
    .customer-list {
        list-style-type: none;
        padding: 0;
    }

    .customer-item {
        cursor: pointer;
        padding: 8px;
        margin: 2px;
        border: 1px solid #ddd;
        border-radius: 5px;
        background-color: #f9f9f9;
        transition: background-color 0.3s;
    }

    .customer-item:hover {
        background-color: #e0e0e0;
    }
</style>

</head>

<body>

<?php include("menus.php")?>

  <main id="main" class="main">

    <div class="pagetitle">
      <h1>Check Entrance</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="dashoboard.php">Home</a></li>
          <li class="breadcrumb-item active">Check Entrance</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section">
      <div class="row">
        <div class="col-lg-6">

          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Write Here Customer's Phone Number</h5>


                <div class="row mb-3">
                  <div class="col-sm-10">
                    <input type="text" class="form-control" id="customerPhoneHolder">
                  </div>
                </div>
                <div class="row">
                  <div class="col-sm-10" id="responseContainer">
                       <!-- where to place the responses -->
                  </div>
                </div>

            </div>
          </div>

        </div>

        <div class="col-lg-6">

          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Customer Details: 
              </h5>

              <div id="customerDetailsContainer" class="mt-5">
    <div class="row mb-4">
        <label class="col-sm-4 col-form-label"><b><u>Names:</u></b></label>
        <div class="col-sm-8">
            <div class="form-check form-switch" id="customerName1"></div>
            <div class="form-check form-switch" id="customerName2"></div>
            <div class="form-check form-switch" id="customerName3"></div>
        <span id="infoDetails"></span>
        </div>
    </div>

    <label class="col-sm-4 col-form-label"><b><u>Subscription:</u></b></label>

    <div class="row mb-4" id="daysSection">
        <label class="col-sm-4 col-form-label">Period:</label>
        <div class="col-sm-8">
            <div class="form-check form-switch" id="initialMonths"></div>
            <div class="form-check form-switch" id="consumedMonths"></div>
            <div class="form-check form-switch" id="remainingMonths" style="font-weight: bolder"></div>

            <div class="form-check form-switch" id="startingDate"></div>
            <div class="form-check form-switch" id="endingDate"></div><br><br>
            <div class="form-check form-switch" id="initialDays"></div>
            <div class="form-check form-switch" id="consumedDays"></div>
            <div class="form-check form-switch" id="remainingDays" style="font-weight: bolder">
            
        </div>


        </div>
    </div>

    <div id="recordEntranceButtonContainer" class="mt-3"></div>
</div>






        </div>
      </div>
    </section>

  </main><!-- End #main -->

  <?php include("footer.php")?>



  <script>
    // Wait for the DOM to be ready
    document.addEventListener('DOMContentLoaded', function () {
        // Get the reference to the input field
        var customerPhoneHolder = document.getElementById('customerPhoneHolder');

        // Attach an event listener to the input field on change
        customerPhoneHolder.addEventListener('input', function () {
            // Get the phone value from the input field
            var phone = customerPhoneHolder.value;

            // Make an Ajax request to main/action.php with the searchUSerByPhone data
            fetch('main/action.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    searchUSerByPhone: 1,
                    phone: phone,
                }),
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                // Get the reference to the element where responses will be placed
                var responseContainer = document.getElementById('responseContainer');

                // Clear existing responses
                responseContainer.innerHTML = '';

                // Check if the message is "found" and data is not empty
                if (data.message === 'found' && data.data.length > 0) {
                    // Display customer names and phones as clickable items
                    var html = '<p>Customers:</p><ul class="customer-list">';
                    data.data.forEach(customer => {
                        html += '<li class="customer-item" onclick="selectCustomer(' + customer.CustomerID + ')">' + customer.CustomerFname + ' ' + customer.CustomerLname + ' - ' + customer.CustomerPhone + '</li>';
                    });
                    html += '</ul>';

                    // Append the HTML to the response container
                    responseContainer.innerHTML = html;
                } else {
                    // Display a message if no customers are found
                    responseContainer.innerHTML = '<p>No customers found</p>';
                }
            })
            .catch(error => {
                console.error('There was a problem with the fetch operation:', error);
            });
        });
    });
//=========================================== recording entrance

let isRecordEntranceButtonAdded = false;
let currentCustomerID = null; // Variable to store the current selected customer ID

function selectCustomer(customerID) {
    // Implement your logic to handle the selected customer

    // Save the current customer ID
    currentCustomerID = customerID;

    // Make an Ajax request to main/view.php with the CustomerAllDetails data
    fetch(`main/view.php?CustomerAllDetails=1&CustomerId=${customerID}`)
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            // Handle the response from main/view.php
            console.log('Customer Details:', data);
            
            var inputElement;
var infoDetailsElement = document.getElementById("infoDetails");
var recordEntranceButtonContainer = document.getElementById("recordEntranceButtonContainer");

if (data.subscriptions === null) {
    console.log("No Subscriptions");
    // Recreate inputElement on the first condition
    if (!inputElement) {
        inputElement = document.createElement("input");
        inputElement.type = "text";
        inputElement.className = 'form-control';
        inputElement.placeholder = "Enter amount...";
        inputElement.id = "amountpaid";
        infoDetailsElement.innerHTML = ''; // Clear existing content
        infoDetailsElement.appendChild(inputElement);
        infoDetailsElement.style.display = "block";
        recordEntranceButtonContainer.style.display = "block";

    }
} else {
    console.log("There is a subscription");
    infoDetailsElement.style.display = "none";
    recordEntranceButtonContainer.style.display = "none";

}
            // Display customer names
            document.getElementById('customerName1').textContent = data.customer.CustomerFname;
            document.getElementById('customerName2').textContent = data.customer.CustomerLname;
            document.getElementById('customerName3').textContent = data.customer.CustomerPhone;

            // Check if the button is not added, then create and append it
            if (!isRecordEntranceButtonAdded) {
                // Create "Record Entrance" button
                const recordEntranceButton = document.createElement('button');
                recordEntranceButton.className = 'btn btn-primary mt-3';
                recordEntranceButton.textContent = 'Record Entrance';
                recordEntranceButton.onclick = () => recordEntry(currentCustomerID, data.subscriptions && data.subscriptions.length > 0 ? 2 : 1);

                // Append button after the days section
                const buttonContainer = document.getElementById('recordEntranceButtonContainer');
                buttonContainer.appendChild(recordEntranceButton);

                // Set the flag to true
                isRecordEntranceButtonAdded = true;
            }

            // Display balance details if available
            const balanceSection = document.getElementById('initialMonths').parentNode.parentNode;
            balanceSection.style.display = data.subscriptions && data.subscriptions.length > 0 ? 'block' : 'none';

            // Display days details
            const daysSection = document.getElementById('initialDays').parentNode.parentNode;
            daysSection.style.display = data.subscriptions ? 'block' : 'none';

            document.getElementById('initialMonths').textContent = "Initial Months: "+(data.subscriptions ? data.subscriptions[0].all_months : '');
            document.getElementById('consumedMonths').textContent = "Consumed Months: "+(data.subscriptions ? (data.subscriptions[0].all_months-data.subscriptions[0].remaining_months) : '');
            document.getElementById('remainingMonths').textContent = "Remaining Months: "+(data.subscriptions ? data.subscriptions[0].remaining_months : '');
            document.getElementById('startingDate').textContent = "Starting Date: "+(data.subscriptions ? data.subscriptions[0].starting_date : '');
            document.getElementById('endingDate').textContent = "Ending Date: "+(data.subscriptions ? data.subscriptions[0].ending_date : '');

        })
        .catch(error => {
            console.error('There was a problem with the fetch operation:', error);
        });
}

// Function to handle "Record Entrance" action
function recordEntry(customerID, type) {
    // Implement your logic for the "Record Entrance" action
    console.log('Record Entrance clicked for Customer ID:', customerID, 'Type:', type);

    // Make an Ajax request to main/action.php with the recordEntrance data
    var requestBody;

    var amountEntered = document.getElementById("amountpaid").value;

    // Validate if amountEntered is set and not equal to 0 (for type 1 only)
    if (type === 1 && (!amountEntered || amountEntered === "0")) {
        const messageContainer = document.getElementById('recordEntranceButtonContainer');
        const messageElement = document.createElement('div');
        messageElement.className = 'alert alert-danger';
        messageElement.textContent = "Invalid entrance Amount..";
        messageContainer.appendChild(messageElement);
        return; // Exit the function if validation fails
    }
        requestBody = {
            recordEntrance: 1,
            client: customerID,
            type: type,
            amountEntered: amountEntered,
            // Add additional properties specific to type 1
        };


    fetch('main/action.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify(requestBody),
    })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            // Handle the response from main/action.php
            console.log('Record Entrance Response:', data);

            // Display the success or error message to the user
            const messageContainer = document.getElementById('recordEntranceButtonContainer');

            // Create a new div for the message
            const messageElement = document.createElement('div');
            messageElement.className = `alert ${data.success ? 'alert-success' : 'alert-danger'}`;
            messageElement.textContent = data.message;

            // Append the message div after the button
            messageContainer.appendChild(messageElement);

            // Optional: Remove the message after a certain delay
            setTimeout(() => {
                messageElement.remove();
            }, 5000); // Adjust the delay (in milliseconds) as needed

            // Reload the page after 2 seconds if it was a success
            if (data.success) {
                setTimeout(() => {
                    location.reload();
                }, 2000); // Reload after 2 seconds
            }
        })
        .catch(error => {
            console.error('There was a problem with the fetch operation:', error);
        });
}





// Function to format currency
function formatCurrency(amount) {
    return new Intl.NumberFormat('en-RW', { style: 'currency', currency: 'RWF' }).format(amount);
}

</script>

