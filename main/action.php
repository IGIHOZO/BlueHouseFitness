<?php
require("view.php");

class MainActions extends DBConnect
{
    public function loginUser($phone, $password)
    {
        $con = parent::connect();
    
        try {
            $enc_pass = md5($password);
            $stmt = $con->prepare("SELECT * FROM admin WHERE AdminPhone = :phone AND AdminPass = :pass");
            $stmt->bindParam(':phone', $phone);
            $stmt->bindParam(':pass', $enc_pass);
            $stmt->execute();
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
            if ($user) {
                // Remove the password from the user array
                unset($user['AdminPass']);
                $_SESSION['user'] = $user;
    
                $response = array('success' => true, 'message' => 'Login successful', 'user' => $user);
            } else {
                $response = array('error' => true, 'message' => 'Invalid phone or password');
            }
    
        } catch (PDOException $e) {
            $response = array('error' => true, 'message' => 'Database error: ' . $e->getMessage());
        }
    
        $con = null;
        header('Content-Type: application/json');
        return json_encode($response);
    }
    
    public function registerCustomer($fname, $lname, $phone)
    {
        $con = parent::connect();

        try {
            $checkStmt = $con->prepare("SELECT * FROM customers WHERE CustomerPhone = :phone");
            $checkStmt->bindParam(':phone', $phone);
            $checkStmt->execute();
            $existingCustomer = $checkStmt->fetch(PDO::FETCH_ASSOC);

            if ($existingCustomer) {
                $response = array('error' => true, 'message' => 'Customer with this phone number already exists');
            } else {
                $status = 1; // Default status for a new customer
                $recordedDate = date('Y-m-d H:i:s'); // Current timestamp

                $insertStmt = $con->prepare("INSERT INTO customers (CustomerFname, CustomerLname, CustomerPhone, CustomerStatus, CustomerRecordedDate) VALUES (:fname, :lname, :phone, :status, :recordedDate)");
                $insertStmt->bindParam(':fname', $fname);
                $insertStmt->bindParam(':lname', $lname);
                $insertStmt->bindParam(':phone', $phone);
                $insertStmt->bindParam(':status', $status);
                $insertStmt->bindParam(':recordedDate', $recordedDate);

                $insertStmt->execute();

                $response = array('success' => true, 'message' => 'Customer registered successfully');
            }
        } catch (PDOException $e) {
            $response = array('error' => true, 'message' => 'Database error: ' . $e->getMessage());
        }

        $con = null;
        header('Content-Type: application/json');
        return json_encode($response);
    }

    public function setUnitValue($value)
    {
        $con = parent::connect();

        try {
            $status = 1; // Default status for a new record
            $currentTimestamp = date('Y-m-d H:i:s'); // Current timestamp
            $existingRecord = $this->getUnitRecord($con);

            if ($existingRecord) {
                $updateStmt = $con->prepare("UPDATE entranceunit SET UnitValue = :value WHERE UnitID = :unitID");
                $updateStmt->bindParam(':value', $value);
                $updateStmt->bindParam(':unitID', $existingRecord['UnitID']);
                $updateStmt->execute();
            } else {
                $insertStmt = $con->prepare("INSERT INTO entranceunit (UnitValue, UnitStatus, UnitDate) VALUES (:value, :status, :currentTimestamp)");
                $insertStmt->bindParam(':value', $value);
                $insertStmt->bindParam(':status', $status);
                $insertStmt->bindParam(':currentTimestamp', $currentTimestamp);
                $insertStmt->execute();
            }

            $response = array('success' => true, 'message' => 'Record set successfully');

        } catch (PDOException $e) {
            $response = array('error' => true, 'message' => 'Database error: ' . $e->getMessage());
        }

        $con = null;
        return $response;
    }

    private function getUnitRecord($con)    // see if the unit is arleady set
    {
        $stmt = $con->prepare("SELECT * FROM entranceunit LIMIT 1");
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function recordSubscription($client, $amount)
    {
        $con = parent::connect();
    
        try {
            if (!is_numeric($amount) || $amount <= 0) {
                throw new Exception('Invalid amount for subscription.');
            }
            $stmt = $con->prepare("SELECT * FROM customers WHERE CustomerID = :customer AND CustomerStatus = 1");
            $stmt->bindParam(':customer', $client);
            $stmt->execute();
            $user = $stmt->fetch(PDO::FETCH_ASSOC)['CustomerID'];
    
            if ($user) {
                $MainView = new MainView();
                $unit = $MainView->loadUnitValue();
                $days = $amount / $unit;
                $sel_subsc = $con->prepare("SELECT * FROM subscriptions WHERE SubscriptionClient = :client AND SubscriptionStatus = 1");
                $sel_subsc->bindParam(':client', $user);
                $sel_subsc->execute();
                $subb = $sel_subsc->fetch(PDO::FETCH_ASSOC);
                if ($subb) {
                    $avlbl_init_amount = $subb['SubscriptionInitAmount']+$amount;
                    $avlbl_cons_amount = $subb['SubscriptionConsumedAmount'];
                    $avlbl_remain_amount = $subb['SubscriptionRemainingAmount']+$amount;
                    $avlbl_init_days = $subb['SubscriptionInitDays']+$days;
                    $avlbl_cons_days = $subb['SubscriptionConsumedDays'];
                    $avlbl_remain_days = $subb['SubscriptionRemainingDays']+$days;
                    $now = date('Y-m-d H:i:s');;
                    $upd_subscr = $con->prepare("UPDATE subscriptions SET SubscriptionRecordedDate = :datee , SubscriptionInitAmount = :init_mnt , SubscriptionConsumedAmount = :cns_mnt , SubscriptionRemainingAmount = :rmnd_mnt , SubscriptionInitDays = :init_dys , SubscriptionConsumedDays = :cns_dys , SubscriptionRemainingDays = :rmnd_dys WHERE SubscriptionClient  = :client");
                    $upd_subscr->bindParam(':datee', $now);
                    $upd_subscr->bindParam(':init_mnt', $avlbl_init_amount);
                    $upd_subscr->bindParam(':cns_mnt', $avlbl_cons_amount);
                    $upd_subscr->bindParam(':rmnd_mnt', $avlbl_remain_amount);
                    $upd_subscr->bindParam(':init_dys', $avlbl_init_days);
                    $upd_subscr->bindParam(':cns_dys', $avlbl_cons_days);
                    $upd_subscr->bindParam(':rmnd_dys', $avlbl_remain_days);
                    $upd_subscr->bindParam(':client', $user);
                    $upd_subscr->execute();
                    $response = array('success' => true, 'message' => 'Subscription Updated successfully');
                }else{
                    $MainView = new MainView();
                    $unit = $MainView->loadUnitValue();
                    $days = $amount / $unit;
                    $insertStmt = $con->prepare("INSERT INTO subscriptions (SubscriptionClient, SubscriptionInitAmount, SubscriptionRemainingAmount, SubscriptionInitDays, SubscriptionRemainingDays) VALUES (:client, :init_amount, :remain_amount, :init_days, :remain_days)");
                    $insertStmt->bindParam(':client', $user);
                    $insertStmt->bindParam(':init_amount', $amount);
                    $insertStmt->bindParam(':remain_amount', $amount);
                    $insertStmt->bindParam(':init_days', $days);
                    $insertStmt->bindParam(':remain_days', $days);
                    $insertStmt->execute();
                    $response = array('success' => true, 'message' => 'Subscription registered successfully');
                }
            } else {
                $response = array('error' => true, 'message' => 'Customer not found or inactive');
            }
        } catch (PDOException $e) {
            $con->rollBack();
            $response = array('error' => true, 'message' => 'Database error: ' . $e->getMessage());
        } catch (Exception $e) {
            $response = array('error' => true, 'message' => $e->getMessage());
        }
        $con = null;
    
        return json_encode($response);
    }
    

    public function recordEntrance($client, $type)
    {
        $con = parent::connect();
        try {
            $stmt = $con->prepare("SELECT * FROM customers WHERE CustomerID = :customer AND CustomerStatus = 1");
            $stmt->bindParam(':customer', $client);
            $stmt->execute();
            $user = $stmt->fetch(PDO::FETCH_ASSOC)['CustomerID'];
            if ($user) {
                $MainView = new MainView();
                $unit = $MainView->loadUnitValue();
                if ($type == 1) {
                    $type = 1;
                    $insertStmt = $con->prepare("INSERT INTO entrances (EntranceClient, EntranceType, EntranceAmount) VALUES (:client, :entr_type, :amount)");
                    $insertStmt->bindParam(':client', $user);
                    $insertStmt->bindParam(':entr_type', $type);
                    $insertStmt->bindParam(':amount', $unit);
                    $insertStmt->execute();
                    $response = array('success' => true, 'message' => 'Entrance registered successfully');
                } else {
                    $type = 2;
                    $select_sub = $con->prepare("SELECT * FROM subscriptions WHERE SubscriptionClient = :client AND SubscriptionStatus=1");
                    $select_sub->bindParam(':client', $user);
                    $select_sub->execute(); // Added missing execute statement
                    $subs = $select_sub->fetch(PDO::FETCH_ASSOC);
                    if ($subs) {
                        $subscription_balance = $subs['SubscriptionRemainingAmount'];
                        if ($subscription_balance >= $unit) {
                            $new_remain_amount = $subscription_balance - $unit;
                            $new_consumed_amount = $subs['SubscriptionConsumedAmount'] + $unit;
                            $new_remain_days = $subs['SubscriptionRemainingDays'] - 1;
                            $new_consumed_days = $subs['SubscriptionConsumedDays'] + 1;
    
                            $rec_entrance = $con->prepare("INSERT INTO entrances (EntranceClient, EntranceType, EntranceInitial, EntranceAmount, EntranceRemaining) VALUES (:client , :entr_type , :entr_init , :entr_amount , :entr_remain)");
                            $rec_entrance->bindParam(':client', $user);
                            $rec_entrance->bindParam(':entr_type', $type);
                            $rec_entrance->bindParam(':entr_init', $subscription_balance);
                            $rec_entrance->bindParam(':entr_amount', $unit);
                            $rec_entrance->bindParam(':entr_remain', $new_remain_days);
                            $ok_rec_entrance = $rec_entrance->execute();
                            if ($ok_rec_entrance) {
                                $update_subscription = $con->prepare("UPDATE subscriptions SET SubscriptionConsumedAmount = :consumed , SubscriptionRemainingAmount = :remain , SubscriptionConsumedDays = :consumed_days , SubscriptionRemainingDays = :remain_days WHERE SubscriptionClient = :client");
                                $update_subscription->bindParam(':consumed', $new_consumed_amount);
                                $update_subscription->bindParam(':remain', $new_remain_amount);
                                $update_subscription->bindParam(':consumed_days', $new_consumed_days);
                                $update_subscription->bindParam(':remain_days', $new_remain_days);
                                $update_subscription->bindParam(':client', $user);
                                $update_subscription->execute();
                                $response = array('success' => true, 'message' => 'Recorded successfully');
                            } else {
                                $response = array('error' => true, 'message' => 'Recording Entrance Failed');
                            }
                        } else {
                            $response = array('error' => true, 'message' => 'Not enough balance');
                        }
                    } else {
                        $response = array('error' => true, 'message' => 'No Subscription found for this customer');
                    }
                }
            } else {
                $response = array('error' => true, 'message' => 'Customer not found');
            }
        } catch (PDOException $e) {
            $response = array('error' => true, 'message' => 'Database error: ' . $e->getMessage());
        }
        $con = null;
        return json_encode($response);
    }
    


    public function recordExpense($name, $details ,$value)
    {
        $con = parent::connect();
    
        try {
            $status = 1; 
            $recordedDate = date('Y-m-d H:i:s'); 
    
            $insertStmt = $con->prepare("INSERT INTO expenses (ExpenseName, ExpenseDetails, ExpenseValue, ExpenseStatus, ExpenseDate) 
                                         VALUES (:name, :details, :value, :status, :recordedDate)");
    
            $insertStmt->bindParam(':name', $name);
            $insertStmt->bindParam(':details', $details);
            $insertStmt->bindParam(':value', $value);
            $insertStmt->bindParam(':status', $status);
            $insertStmt->bindParam(':recordedDate', $recordedDate);
    
            $insertStmt->execute();
    
            $response = array('success' => true, 'message' => 'Expense recorded successfully');
    
        } catch (PDOException $e) {
            $response = array('error' => true, 'message' => 'Database error: ' . $e->getMessage());
        }
    
        $con = null;
        return json_encode($response);
    }

    public function searchUSerByPhone($phone)
    {
        $con = parent::connect();
    
        try {
            $status = 1; 
            $recordedDate = date('Y-m-d H:i:s'); 
    
            $selStmt = $con->prepare("SELECT * FROM customers WHERE CustomerPhone LIKE '%$phone%' ORDER BY CustomerPhone DESC");
            $selStmt->execute();
            $user = $selStmt->fetchAll(PDO::FETCH_ASSOC);
            if ($user) {
                $response = array('message' => 'found', 'data' => $user);
            }else{
                $response = array('message' => 'not found', 'data' => null);
            }   
        } catch (PDOException $e) {
            $response = array('error' => true, 'message' => 'Database error: ' . $e->getMessage());
        }
    
        $con = null;
        return json_encode($response);
    }
    

}

$MainActions = new MainActions();

$postData = json_decode(file_get_contents("php://input"), true);

if (isset($postData['AdminLogin']) && $postData['AdminLogin'] === "1") {
    $result = $MainActions->loginUser($postData['phone'], $postData['password']);
    echo $result;
} elseif (isset($postData['registerCustomer'])) {
    $result = $MainActions->registerCustomer($postData['CustomerFname'], $postData['CustomerLname'], $postData['phone']);
    echo $result;
} elseif (isset($postData['SetEntranceUnit'])) {
    $result = $MainActions->setUnitValue($postData['UnitValue']);
    echo json_encode($result);
} elseif (isset($postData['recordSubscription'])) {
    $result = $MainActions->recordSubscription($postData['client'], $postData['amount']);
    echo $result;
} elseif (isset($postData['recordEntrance'])) {
    $result = $MainActions->recordEntrance($postData['client'], $postData['type']);
    echo $result; 
} elseif (isset($postData['recordExpense'])) {
    $result = $MainActions->recordExpense($postData['expName'], $postData['expDetails'], $postData['expValue']);
    echo $result; 
} elseif (isset($postData['searchUSerByPhone'])) {
    $result = $MainActions->searchUSerByPhone($postData['phone']);
    echo $result; 
} else {
    echo json_encode(array('error' => true, 'message' => 'Invalid request.'));
}

?>
