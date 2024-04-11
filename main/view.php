<?php
require("config.php");
class MainView extends DBConnect
{
 public function loadUnitValue(){
    $con = parent::connect();
    try {
        $stmt = $con->prepare("SELECT * FROM entranceunit LIMIT 1");
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC)['UnitValue'];
    } catch (PDOException $e) {
        $response = array('error' => true, 'message' => 'Database error: ' . $e->getMessage());
    }
 }


 public function all_customers()
 {
     $con = parent::connect();
     
     try {
         $sel = $con->prepare("SELECT * FROM customers WHERE CustomerStatus = 1 ORDER BY CustomerFname ASC");
         $sel->execute();
         $customers = $sel->fetchAll(PDO::FETCH_ASSOC);
 
         if ($customers) {
             $response = array('message' => 'success', 'data' => $customers);
         } else {
             $response = array('message' => 'success', 'data' => array());
         }
 
     } catch (PDOException $e) {
         $response = array('error' => true, 'message' => 'Database error: ' . $e->getMessage());
     }
 
     $con = null;
     return json_encode($response);
 }


 public function all_subscriptions()
 {
     $con = parent::connect();
 
     try {
         $query = "SELECT * FROM customer_subscriptions 
                   JOIN customers ON customer_subscriptions.customer_id  = customers.CustomerID 
                   WHERE customers.CustomerStatus = 1 AND customer_subscriptions.status = 1";
 
         $sel = $con->prepare($query);
         $sel->execute();
 
         $subscriptions = $sel->fetchAll(PDO::FETCH_ASSOC);
 
         if ($subscriptions) {
             $response = array('message' => 'success', 'data' => $subscriptions);
         } else {
             $response = array('found' => false, 'message' => 'No subscriptions found');
         }
 
     } catch (PDOException $e) {
         $response = array('error' => true, 'message' => 'Database error: ' . $e->getMessage());
     }
 
     $con = null;
     return json_encode($response);
 }
 public function active_subscriptions()
 {
     $con = parent::connect();
 
     try {
        //  $query = "SELECT * FROM customer_subscriptions 
        //            JOIN customers ON customer_subscriptions.customer_id  = customers.CustomerID 
        //            WHERE customers.CustomerStatus = 1 AND customer_subscriptions.status = 1 AND SubscriptionRemainingDays >=1";
        // $query = "SELECT * FROM customer_subscriptions 
        //   JOIN customers ON customer_subscriptions.customer_id = customers.CustomerID 
        //   WHERE customers.CustomerStatus = 1 AND customer_subscriptions.status = 0 AND customer_subscriptions.ending_date < NOW()";
        $query = "SELECT * FROM customer_subscriptions 
        JOIN customers ON customer_subscriptions.customer_id = customers.CustomerID 
        WHERE customers.CustomerStatus = 1 AND customer_subscriptions.status = 1 AND DATE(customer_subscriptions.ending_date) >= CURDATE()";



 
         $sel = $con->prepare($query);
         $sel->execute();
 
         $subscriptions = $sel->fetchAll(PDO::FETCH_ASSOC);
 
         if ($subscriptions) {
             $response = array('message' => 'success', 'data' => $subscriptions);
         } else {
             $response = array('found' => false, 'message' => 'No subscriptions found');
         }
 
     } catch (PDOException $e) {
         $response = array('error' => true, 'message' => 'Database error: ' . $e->getMessage());
     }
 
     $con = null;
     return json_encode($response);
 }
 
 public function expired_subscriptions()
 {
     $con = parent::connect();
 
     try {
         $query = "SELECT * FROM customer_subscriptions 
                   JOIN customers ON customer_subscriptions.customer_id = customers.CustomerID 
                   WHERE customers.CustomerStatus = 1 AND customer_subscriptions.remaining_months <1";
 
         $sel = $con->prepare($query);
         $sel->execute();
 
         $subscriptions = $sel->fetchAll(PDO::FETCH_ASSOC);
 
         if ($subscriptions) {
             $response = array('message' => 'success', 'data' => $subscriptions);
         } else {
             $response = array('found' => false, 'message' => 'No subscriptions found');
         }
 
     } catch (PDOException $e) {
         $response = array('error' => true, 'message' => 'Database error: ' . $e->getMessage());
     }
 
     $con = null;
     return json_encode($response);
 }
 public function all_entrance_history()
 {
     $con = parent::connect();
 
     try {
         $query = "SELECT entrances.*, customers.*, subscriptions.* 
                    FROM entrances
                    JOIN customers ON entrances.EntranceClient = customers.CustomerID 
                    LEFT JOIN subscriptions ON entrances.EntranceType = 2 AND subscriptions.SubscriptionClient = customers.CustomerID
                    WHERE customers.CustomerStatus = 1 AND entrances.EntranceStatus = 1 ORDER BY EntranceID DESC";
 
         $sel = $con->prepare($query);
         $sel->execute();
 
         $entrance = $sel->fetchAll(PDO::FETCH_ASSOC);
 
         if ($entrance) {
             $response = array('message' => 'success', 'data' => $entrance);
         } else {
             $response = array('found' => false, 'message' => 'No Entrance history found');
         }
 
     } catch (PDOException $e) {
         $response = array('error' => true, 'message' => 'Database error: ' . $e->getMessage());
     }
 
     $con = null;
     return json_encode($response);
 }
 
 public function all_SubSalleRep_history()
 {
     $con = parent::connect();
 
     try {
         $query = "SELECT * FROM customers,subscriptions_transactions WHERE subscriptions_transactions.client_id =customers.CustomerID ORDER BY subscriptions_transactions.transaction_id DESC";
 
         $sel = $con->prepare($query);
         $sel->execute();
 
         $entrance = $sel->fetchAll(PDO::FETCH_ASSOC);
 
         if ($entrance) {
             $response = array('message' => 'success', 'data' => $entrance);
         } else {
             $response = array('found' => false, 'message' => 'No Sales history found');
         }
 
     } catch (PDOException $e) {
         $response = array('error' => true, 'message' => 'Database error: ' . $e->getMessage());
     }
 
     $con = null;
     return json_encode($response);
 }

 public function all_SubSalleRep_history_date($date_from, $date_to)
 {
     $con = parent::connect();
 
     try {
         $query = "SELECT * FROM customers, subscriptions_transactions WHERE subscriptions_transactions.client_id = customers.CustomerID";
 
         // Add date filtering to the query
         if (!empty($date_from) && !empty($date_to)) {
             $query .= " AND DATE(subscriptions_transactions.recorded_date) BETWEEN :date_from AND :date_to";
         }
 
         $query .= " ORDER BY subscriptions_transactions.transaction_id DESC";
 
         $sel = $con->prepare($query);
 
         // Bind date parameters if provided
         if (!empty($date_from) && !empty($date_to)) {
             $sel->bindParam(':date_from', $date_from);
             $sel->bindParam(':date_to', $date_to);
         }
 
         $sel->execute();
 
         $entrance = $sel->fetchAll(PDO::FETCH_ASSOC);
 
         if ($entrance) {
             $response = array('message' => 'success', 'data' => $entrance);
         } else {
             $response = array('found' => false, 'message' => 'No Sales history found');
         }
     } catch (PDOException $e) {
         $response = array('error' => true, 'message' => 'Database error: ' . $e->getMessage());
     }
 
     $con = null;
     return json_encode($response);
 }
 
 
 

 public function all_nonSub_salles_report()
 {
     $con = parent::connect();
 
     try {
         $query = "SELECT * FROM entrances,customers WHERE entrances.EntranceClient=customers.CustomerID AND entrances.EntranceType=1 AND entrances.EntranceStatus=1";
 
         $sel = $con->prepare($query);
         $sel->execute();
 
         $entrance = $sel->fetchAll(PDO::FETCH_ASSOC);
 
         if ($entrance) {
             $response = array('message' => 'success', 'data' => $entrance);
         } else {
             $response = array('found' => false, 'message' => 'No Entrance history found');
         }
 
     } catch (PDOException $e) {
         $response = array('error' => true, 'message' => 'Database error: ' . $e->getMessage());
     }
 
     $con = null;
     return json_encode($response);
 }

 public function displayExpenses()
{
    $con = parent::connect();

    try {
        $sel = $con->prepare("SELECT * FROM expenses WHERE ExpenseStatus = 1 ORDER BY ExpenseDate DESC");
        $sel->execute();
        $expenses = $sel->fetchAll(PDO::FETCH_ASSOC);

        if ($expenses) {
            $response = array('message' => 'success', 'data' => $expenses);
        } else {
            $response = array('found' => false, 'message' => 'No expenses found');
        }

    } catch (PDOException $e) {
        $response = array('error' => true, 'message' => 'Database error: ' . $e->getMessage());
    }

    $con = null;
    return json_encode($response);
}

public function allCustomerDetails($customerId)
{
    $con = parent::connect();

    // Fetch customer details
    $sel_cust = $con->prepare("SELECT * FROM customers WHERE CustomerID = :customer");
    $sel_cust->bindParam(':customer', $customerId);
    $sel_cust->execute();
    $custm = $sel_cust->fetchAll(PDO::FETCH_ASSOC);

    $response = array();

    if ($custm) {
        $response['customer'] = $custm[0];

        // Fetch subscription details
        $sel_balance = $con->prepare("SELECT * FROM customer_subscriptions WHERE customer_id = :customer2");
        $sel_balance->bindParam(':customer2', $customerId);
        $sel_balance->execute();
        $blncData = $sel_balance->fetchAll();

        if ($blncData) {
            $response['subscriptions'] = $blncData;
        } else {
            $response['subscriptions'] = null;
        }
    } else {
        $response = null;
    }

    return json_encode($response);
}


public function allPaymentsSalesReport()
{
    $con = parent::connect();

    try {
        $subscriptionQuery = "SELECT 'subscription' AS transaction_type, 
                                      subscriptions_transactions.transaction_id, 
                                      subscriptions_transactions.client_id, 
                                      subscriptions_transactions.amount_paid AS amount_paid,
                                      subscriptions_transactions.recorded_date AS date_saved, 
                                      subscriptions_transactions.subscriptions_months, 
                                      subscriptions_transactions.subscriptions_start, 
                                      subscriptions_transactions.subscriptions_end, 
                                      subscriptions_transactions.status AS subscription_status, 
                                      subscriptions_transactions.recorded_date AS subscription_recorded_date,
                                      customers.* 
                              FROM subscriptions_transactions
                              JOIN customers ON subscriptions_transactions.client_id = customers.CustomerID
                              ORDER BY subscriptions_start DESC, recorded_date DESC, CustomerID DESC";

        $entranceQuery = "SELECT 'entrance' AS transaction_type, 
                                   entrances.EntranceID AS transaction_id, 
                                   entrances.EntranceClient AS client_id, 
                                   entrances.EntranceAmount AS amount_paid,
                                   entrances.EntranceTime AS date_saved, 
                                   NULL AS subscriptions_months, 
                                   NULL AS subscriptions_start, 
                                   NULL AS subscriptions_end, 
                                   entrances.EntranceStatus AS entrance_status, 
                                   entrances.EntranceTime AS entrance_recorded_date,
                                   customers.* 
                          FROM entrances
                          JOIN customers ON entrances.EntranceClient = customers.CustomerID
                          ORDER BY EntranceTime DESC, CustomerID DESC";

        $data = [];

        $subscriptionStmt = $con->prepare($subscriptionQuery);
        $entranceStmt = $con->prepare($entranceQuery);

        $subscriptionStmt->execute();
        $entranceStmt->execute();

        $subscriptionRow = $subscriptionStmt->fetch(PDO::FETCH_ASSOC);
        $entranceRow = $entranceStmt->fetch(PDO::FETCH_ASSOC);

        while ($subscriptionRow || $entranceRow) {
            if ($subscriptionRow && (!$entranceRow || $subscriptionRow['subscriptions_start'] >= $entranceRow['entrance_recorded_date'])) {
                $data[] = $subscriptionRow;
                $subscriptionRow = $subscriptionStmt->fetch(PDO::FETCH_ASSOC);
            } elseif ($entranceRow) {
                $data[] = $entranceRow;
                $entranceRow = $entranceStmt->fetch(PDO::FETCH_ASSOC);
            }
        }

        if ($data) {
            $response = array('message' => 'success', 'data' => $data);
        } else {
            $response = array('found' => false, 'message' => 'No Sales history found');
        }

    } catch (PDOException $e) {
        $response = array('error' => true, 'message' => 'Database error: ' . $e->getMessage());
    }

    $con = null;
    return json_encode($response);
}


private function calculateRemainingDays($startingDate, $endingDate, $allMonths)
{
    $now = new DateTime();
    $startingDateTime = new DateTime($startingDate);
    $endingDateTime = new DateTime($endingDate);

    $remainingDays = max($endingDateTime < $now ? 0 : $endingDateTime->diff($now)->days, 0);

    return $remainingDays;
}

public function checkRemainingDays()
{
    $con = parent::connect();

    try {
        $selectQuery = "SELECT customer_subscription_id, customer_id, starting_date, ending_date, all_months, remaining_months 
                        FROM customer_subscriptions
                        WHERE status = 1 AND remaining_months > 0";

        $selectStmt = $con->prepare($selectQuery);
        $selectStmt->execute();

        $subscriptions = $selectStmt->fetchAll(PDO::FETCH_ASSOC);

        $response = array();

        foreach ($subscriptions as $subscription) {
            $remainingDays = $this->calculateRemainingDays($subscription['starting_date'], $subscription['ending_date'], $subscription['all_months']);
            
            // Corrected clientSelectQuery
            $clientSelectQuery = "SELECT * FROM customers WHERE CustomerID = :customer_id";
            $clientSelectStmt = $con->prepare($clientSelectQuery);
            $clientSelectStmt->bindParam(':customer_id', $subscription['customer_id']);
            $clientSelectStmt->execute();

            $client = $clientSelectStmt->fetch(PDO::FETCH_ASSOC);

            if ($remainingDays <= 5) {
                $response[] = array(
                    'customer_subscription_id' => $subscription['customer_subscription_id'],
                    'customer_id' => $subscription['customer_id'],
                    'starting_date' => $subscription['starting_date'],
                    'ending_date' => $subscription['ending_date'],
                    'all_months' => $subscription['all_months'],
                    'remaining_months' => $subscription['remaining_months'],
                    'remaining_days' => $remainingDays,
                    'f_name' => $client['CustomerFname'],
                    'l_name' => $client['CustomerLname'],
                    'phone' => $client['CustomerPhone'],
                );

                $this->sendSubscriptionNotification($client['CustomerPhone'], $remainingDays, $client['CustomerFname']);
            }
        }

        if (!empty($response)) {
            $message = 'success';
        } else {
            $message = 'No subscriptions found with less than 5 days remaining';
        }

        $response = array('message' => $message, 'data' => $response);
    } catch (PDOException $e) {
        $response = array('error' => true, 'message' => 'Database error: ' . $e->getMessage());
    }

    $con = null;
    return json_encode($response);
}
public function sendSubscriptionNotification($recipient, $remainingDays, $fname)
{
    $url = "https://www.intouchsms.co.rw/api/sendsms/.json";

    // Compose your message
    $message = "Hello ".$fname."! Your exclusive membership with BLUEHOUSE FITNESS GYM is expiring soon. You have {$remainingDays} day".($remainingDays > 1 ? 's' : '')." remaining.

Renew now to maintain access to our state-of-the-art facilities, personalized fitness plans, and a community committed to your wellness journey.

Don't miss out on the ultimate fitness experience!";
    // Set up the data
    $data = array(
        "sender" => 'BLUEHOUSE',
        "recipients" => $recipient,
        "message" => $message,
    );

    // Set up your InTouchSMS credentials
    $username = "BLUEHOUSE";
    $password = "MyFittness!#Gym07";

    $data = http_build_query($data);

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_USERPWD, $username . ":" . $password);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

    // Execute cURL session and get the result
    $result = curl_exec($ch);
    $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    // Close cURL session
    curl_close($ch);

    // Output the result and HTTP code
    echo $result;
    echo $httpcode;
}


public function recent_entrances()
{
    $con = parent::connect();
    
    try {
        // Query to fetch sum of EntranceAmount per day for the last 7 days
        $sel = $con->prepare("
            SELECT 
                DATE(EntranceTime) as date,
                SUM(EntranceAmount) as total_amount
            FROM entrances
            WHERE EntranceTime >= NOW() - INTERVAL 30 DAY
            GROUP BY date
            ORDER BY date DESC
        ");
        $sel->execute();
        $entrance = $sel->fetchAll(PDO::FETCH_ASSOC);

        if ($entrance) {
            $response = array('message' => 'success', 'data' => $entrance);
        } else {
            $response = array('message' => 'success', 'data' => array());
        }

    } catch (PDOException $e) {
        $response = array('error' => true, 'message' => 'Database error: ' . $e->getMessage());
    }

    $con = null;
    return json_encode($response);
}

public function subscription_transactions()
{
    $con = parent::connect();

    try {
        // Query to fetch cumulative sum of amount_paid for each recorded_date in the last 30 days
        $sel = $con->prepare("
            SELECT 
                recorded_date,
                total_amount_paid,
                (SELECT SUM(amount_paid) FROM subscriptions_transactions sub 
                 WHERE sub.recorded_date = main.recorded_date) as cumulative_sum
            FROM (
                SELECT 
                    SUM(amount_paid) as total_amount_paid,
                    DATE_FORMAT(recorded_date, '%Y-%m-%d') as recorded_date
                FROM subscriptions_transactions
                WHERE recorded_date >= CURDATE() - INTERVAL 30 DAY
                GROUP BY DATE_FORMAT(recorded_date, '%Y-%m-%d')
                ORDER BY recorded_date asc
            ) as main
            ORDER BY recorded_date asc
        ");
        $sel->execute();
        $transactions = $sel->fetchAll(PDO::FETCH_ASSOC);

        if ($transactions) {
            $response = array('message' => 'success', 'data' => $transactions);
        } else {
            $response = array('message' => 'success', 'data' => array());
        }

    } catch (PDOException $e) {
        $response = array('error' => true, 'message' => 'Database error: ' . $e->getMessage());
    }

    $con = null;
    return json_encode($response);
}


















}    


$MainView = new MainView();


if (isset($_GET['all_customers'])) {
    $result = $MainView->all_customers();
    echo $result;
}elseif (isset($_GET['all_subscriptions'])) {
    $result = $MainView->all_subscriptions();
    echo $result;
}elseif (isset($_GET['active_subscriptions'])) {
    $result = $MainView->active_subscriptions();
    echo $result;
}elseif (isset($_GET['expired_subscriptions'])) {
    $result = $MainView->expired_subscriptions();
    echo $result;
}elseif (isset($_GET['all_entrance_history'])) {
    $result = $MainView->all_entrance_history();
    echo $result;
}elseif (isset($_GET['all_SubSalleRep_history'])) {
    $result = $MainView->all_SubSalleRep_history();
    echo $result;
}elseif (isset($_POST['all_SubSalleRep_history_date'])) {
    $result = $MainView->all_SubSalleRep_history_date($_POST['from'],$_POST['to']);
    echo $result;
}elseif (isset($_GET['all_nonSub_salles_report'])) {
    $result = $MainView->all_nonSub_salles_report();
    echo $result;
}elseif (isset($_GET['displayExpenses'])) {
    $result = $MainView->displayExpenses();
    echo $result;
}elseif (isset($_GET['CustomerAllDetails'])) {
    $result = $MainView->allCustomerDetails($_GET['CustomerId']);
    echo $result;
}elseif (isset($_GET['allPaymentsSalesReport'])) {
    $result = $MainView->allPaymentsSalesReport();
    echo $result;
}elseif (isset($_GET['checkRemainingDays'])) {
    $result = $MainView->checkRemainingDays();
    echo $result;
}elseif (isset($_GET['recent_entrances'])) {
    $result = $MainView->recent_entrances();
    echo $result;
}elseif (isset($_GET['subscription_transactions'])) {
    $result = $MainView->subscription_transactions();
    echo $result;
} else {

}


?>