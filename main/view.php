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
         $query = "SELECT * FROM subscriptions 
                   JOIN customers ON subscriptions.SubscriptionClient = customers.CustomerID 
                   WHERE customers.CustomerStatus = 1 AND subscriptions.SubscriptionStatus = 1";
 
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
         $query = "SELECT * FROM subscriptions 
                   JOIN customers ON subscriptions.SubscriptionClient = customers.CustomerID 
                   WHERE customers.CustomerStatus = 1 AND subscriptions.SubscriptionStatus = 1 AND SubscriptionRemainingDays >=1";
 
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
         $query = "SELECT * FROM subscriptions 
                   JOIN customers ON subscriptions.SubscriptionClient = customers.CustomerID 
                   WHERE customers.CustomerStatus = 1 AND subscriptions.SubscriptionStatus = 1 AND SubscriptionRemainingDays <1";
 
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
         $query = "SELECT * FROM entrances,customers,subscriptions WHERE entrances.EntranceClient=customers.CustomerID AND subscriptions.SubscriptionClient=customers.CustomerID AND entrances.EntranceType=2 AND entrances.EntranceStatus=1";
 
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
        $sel_balance = $con->prepare("SELECT * FROM subscriptions WHERE SubscriptionClient = :customer2");
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
}elseif (isset($_GET['all_nonSub_salles_report'])) {
    $result = $MainView->all_nonSub_salles_report();
    echo $result;
}elseif (isset($_GET['displayExpenses'])) {
    $result = $MainView->displayExpenses();
    echo $result;
}elseif (isset($_GET['CustomerAllDetails'])) {
    $result = $MainView->allCustomerDetails($_GET['CustomerId']);
    echo $result;
} else {

}


?>