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
                if($response){
                    $message = "Hello ".$fname."! Welcome in BLUEHOUSE Fitness Gym, your Registration means a lot for us, Enjoy having your Physical/Mental improvement with us.";
                    parent::sendSMS($phone, $message);
                }
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
                $months = $amount / $unit;
                $days = $months*30;
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
                    $now = date('Y-m-d H:i:s');
                    $new_init_month = $subb['InitialMonths']+$months;
                    $new_rmnd_month = $subb['RemainingMonths']+$months;
                    $upd_subscr = $con->prepare("UPDATE subscriptions SET SubscriptionRecordedDate = :datee , SubscriptionInitAmount = :init_mnt , SubscriptionConsumedAmount = :cns_mnt , SubscriptionRemainingAmount = :rmnd_mnt , SubscriptionInitDays = :init_dys , SubscriptionConsumedDays = :cns_dys , SubscriptionRemainingDays = :rmnd_dys, InitialMonths = :int_months, RemainingMonths = :rmnd_mts WHERE SubscriptionClient  = :client");
                    $upd_subscr->bindParam(':datee', $now);
                    $upd_subscr->bindParam(':init_mnt', $avlbl_init_amount);
                    $upd_subscr->bindParam(':cns_mnt', $avlbl_cons_amount);
                    $upd_subscr->bindParam(':rmnd_mnt', $avlbl_remain_amount);
                    $upd_subscr->bindParam(':init_dys', $avlbl_init_days);
                    $upd_subscr->bindParam(':cns_dys', $avlbl_cons_days);
                    $upd_subscr->bindParam(':rmnd_dys', $avlbl_remain_days);
                    $upd_subscr->bindParam(':client', $user);
                    $upd_subscr->bindParam(':int_months', $new_init_month);
                    $upd_subscr->bindParam(':rmnd_mts', $new_rmnd_month);
                    $upd_subscr->execute();

                    $response = array('success' => true, 'message' => 'Subscription Updated successfully');
                }else{
                    $MainView = new MainView();
                    $unit = $MainView->loadUnitValue();
                    $days = $months*30;
                    $months = $amount / $unit;
                    $insertStmt = $con->prepare("INSERT INTO subscriptions (SubscriptionClient, SubscriptionInitAmount, SubscriptionRemainingAmount, SubscriptionInitDays, SubscriptionRemainingDays, InitialMonths, RemainingMonths) VALUES (:client, :init_amount, :remain_amount, :init_days, :remain_days, :ini_mth, :remain_mth)");
                    $insertStmt->bindParam(':client', $user);
                    $insertStmt->bindParam(':init_amount', $amount);
                    $insertStmt->bindParam(':remain_amount', $amount);
                    $insertStmt->bindParam(':init_days', $days);
                    $insertStmt->bindParam(':remain_days', $days);
                    $insertStmt->bindParam(':ini_mth', $months);
                    $insertStmt->bindParam(':remain_mth', $months);
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
    
    function isDecreasingBy30($number) {
        $MainView = new MainView();
        $unit = $MainView->loadUnitValue();
        // Check if the number is unit or follows the pattern of decreasing by unit
        return ($number == $unit) || (($number - $unit) % $unit == 0);
    }
    public function recordEntrance($client, $type, $custom_amount)
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
                // if ($type == 1) {
                    $type = 1;
                    $insertStmt = $con->prepare("INSERT INTO entrances (EntranceClient, EntranceType, EntranceAmount) VALUES (:client, :entr_type, :amount)");
                    $insertStmt->bindParam(':client', $user);
                    $insertStmt->bindParam(':entr_type', $type);
                    $insertStmt->bindParam(':amount', $custom_amount);
                    $insertStmt->execute();
                    $response = array('success' => true, 'message' => 'Entrance registered successfully');
                // } else {
                //     $type = 2;
                //     $select_sub = $con->prepare("SELECT * FROM subscriptions WHERE SubscriptionClient = :client AND SubscriptionStatus=1");
                //     $select_sub->bindParam(':client', $user);
                //     $select_sub->execute(); // Added missing execute statement
                //     $subs = $select_sub->fetch(PDO::FETCH_ASSOC);
                //     $oneday_unit = $unit/30;
                //     if ($subs) {
                //         $subscription_balance = $subs['SubscriptionRemainingAmount'];
                //         if ($subscription_balance >= $unit) {
                //             $new_remain_amount = $subscription_balance - $unit;
                //             $new_consumed_amount = $subs['SubscriptionConsumedAmount'] + $oneday_unit;
                //             $new_remain_days = $subs['SubscriptionRemainingDays'] - 1;
                //             $new_consumed_days = $subs['SubscriptionConsumedDays'] + 1;

                //             $rec_entrance = $con->prepare("INSERT INTO entrances (EntranceClient, EntranceType, EntranceInitial, EntranceAmount, EntranceRemaining) VALUES (:client , :entr_type , :entr_init , :entr_amount , :entr_remain)");
                //             $rec_entrance->bindParam(':client', $user);
                //             $rec_entrance->bindParam(':entr_type', $type);
                //             $rec_entrance->bindParam(':entr_init', $subscription_balance);
                //             $rec_entrance->bindParam(':entr_amount', $oneday_unit);
                //             $rec_entrance->bindParam(':entr_remain', $new_remain_days);
                //             $ok_rec_entrance = $rec_entrance->execute();
                //             if ($ok_rec_entrance) {
                //                 if($this->isDecreasingBy30($subs['SubscriptionConsumedDays'])){
                //                     $new_cons_mth = $subs['ConsumedMonths']+1;
                //                     $new_remained_mth = $subs['RemainingMonths']-1;
                //                     $update_subscription = $con->prepare("UPDATE subscriptions SET SubscriptionConsumedAmount = :consumed , SubscriptionRemainingAmount = :remain , SubscriptionConsumedDays = :consumed_days , SubscriptionRemainingDays = :remain_days , ConsumedMonths = :consumed_mt , RemainingMonths = :remained_mt WHERE SubscriptionClient = :client");
                //                     $update_subscription->bindParam(':consumed', $new_consumed_amount);
                //                     $update_subscription->bindParam(':remain', $new_remain_amount);
                //                     $update_subscription->bindParam(':consumed_days', $new_consumed_days);
                //                     $update_subscription->bindParam(':remain_days', $new_remain_days);
                //                     $update_subscription->bindParam(':client', $user);
                //                     $update_subscription->bindParam(':consumed_mt', $new_cons_mth);
                //                     $update_subscription->bindParam(':remained_mt', $new_remained_mth);
                //                 }else{
                //                     $update_subscription = $con->prepare("UPDATE subscriptions SET SubscriptionConsumedAmount = :consumed , SubscriptionRemainingAmount = :remain , SubscriptionConsumedDays = :consumed_days , SubscriptionRemainingDays = :remain_days , ConsumedMonths = :consumed_mt , RemainingMonths = :remained_mt WHERE SubscriptionClient = :client");
                //                     $update_subscription->bindParam(':consumed', $new_consumed_amount);
                //                     $update_subscription->bindParam(':remain', $new_remain_amount);
                //                     $update_subscription->bindParam(':consumed_days', $new_consumed_days);
                //                     $update_subscription->bindParam(':remain_days', $new_remain_days);
                //                     $update_subscription->bindParam(':client', $user);
                //                     $update_subscription->bindParam(':consumed_mt', $subs['SubscriptionConsumedDays']);
                //                     $update_subscription->bindParam(':remained_mt', $subs['RemainingMonths']);
                //                 }

                //                 $update_subscription->execute();
                //                 $response = array('success' => true, 'message' => 'Recorded successfully');
                //             } else {
                //                 $response = array('error' => true, 'message' => 'Recording Entrance Failed');
                //             }
                //         } else {
                //             $response = array('error' => true, 'message' => 'Not enough balance');
                //         }
                //     } else {
                //         $response = array('error' => true, 'message' => 'No Subscription found for this customer');
                //     }
                // }
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
    


    function save_subscription($amount, $client, $discount_value) {
        $MainView = new MainView();
        $unit = $MainView->loadUnitValue();
        $con = parent::connect();
        $sell = $con->prepare("SELECT * FROM customers WHERE customers.CustomerID='$client'");
        $sell->execute();
        if($sell->rowCount()>=1){
            $ft_sell = $sell->fetch(PDO::FETCH_ASSOC);
            $newCustomerName = $ft_sell['CustomerFname'];
            $newCustomerPhone = $ft_sell['CustomerPhone'];
        }
        $isDiscount = 0;
        $value_discount = null;
        if ($discount_value !== null) { 
            $isDiscount = 1;
            $value_discount = $discount_value;
            $unit = $value_discount;
        }

    
        // Check if the amount is a whole number of units
        if (($amount % $unit !== 0) AND ($isDiscount==0)) {
            $response = array('error' => true, 'message' => '<center>Amount entered does not correspond to the Monthly subscription cost.</center>');
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }
    
        $months = $amount / $unit;
        $today = date('Y-m-d H:i:s');
    
        $sel_sub = $con->prepare("SELECT * FROM customer_subscriptions WHERE customer_id=? AND status=?");
        $sel_sub->bindValue(1, $client);
        $sel_sub->bindValue(2, 1);
        $sel_sub->execute();
        $fet_sel_sub = $sel_sub->fetch(PDO::FETCH_ASSOC);
    
        if ($fet_sel_sub) {
            $con->beginTransaction();
    
            // Retrieve the latest transaction for the client
            $latest_transaction = $con->prepare("SELECT * FROM subscriptions_transactions WHERE client_id = ? ORDER BY transaction_id DESC LIMIT 1");
            $latest_transaction->bindValue(1, $client);
            $latest_transaction->execute();
            $latest_transaction_data = $latest_transaction->fetch(PDO::FETCH_ASSOC);
    
            // Calculate new starting and ending dates based on the latest transaction or use today's date
            $starting_date = $latest_transaction_data ? $latest_transaction_data['subscriptions_end'] : $today;
            $ending_date = date('Y-m-d H:i:s', strtotime($starting_date . ' + ' . $months . ' months'));
    
            // Update subscription
            $new_ending_date = date('Y-m-d H:i:s', strtotime($fet_sel_sub['ending_date'] . ' + ' . $months . ' months'));
            $new_remaining_months = $fet_sel_sub['remaining_months'] + $months;
            $new_all_months = $fet_sel_sub['all_months'] + $months;
            
            if($isDiscount==1){
                $update_subs_dis = $con->prepare("UPDATE customer_subscriptions 
                        SET ending_date = :new_end_dt, 
                            remaining_months = :new_remaining_months, 
                            all_months = :new_all_months, updated_date= :now_date, isDiscount= :isDiscount, DiscountValue= :DiscountValue
                        WHERE customer_subscription_id = :sub_id");
            
                    $update_subs_dis->bindValue(':new_end_dt', $new_ending_date);
                    $update_subs_dis->bindValue(':new_remaining_months', $new_remaining_months);
                    $update_subs_dis->bindValue(':new_all_months', $new_all_months);
                    $update_subs_dis->bindValue(':sub_id', $fet_sel_sub['customer_subscription_id']);
                    $update_subs_dis->bindValue(':now_date', $today);
                    $update_subs_dis->bindValue(':isDiscount', $isDiscount);
                    $update_subs_dis->bindValue(':DiscountValue', $value_discount);
                    $ok_update_subs = $update_subs_dis->execute();
            
                    // Insert transaction with the calculated starting and ending dates
                    $ins_transaction_dis = $con->prepare("INSERT INTO subscriptions_transactions (client_id, amount_paid, subscriptions_months, subscriptions_start, subscriptions_end)
                    VALUES(?,?,?,?,?)"); // Corrected closing parenthesis
                
                $ins_transaction_dis->bindValue(1, $client);
                $ins_transaction_dis->bindValue(2, $amount);
                $ins_transaction_dis->bindValue(3, $months);
                $ins_transaction_dis->bindValue(4, $starting_date);
                $ins_transaction_dis->bindValue(5, $ending_date);
                $ok_ins_transaction = $ins_transaction_dis->execute();
                
            }else{
                $update_subs = $con->prepare("UPDATE customer_subscriptions 
                    SET ending_date = :new_end_dt, 
                        remaining_months = :new_remaining_months, 
                        all_months = :new_all_months, updated_date= :now_date
                    WHERE customer_subscription_id = :sub_id");
        
                $update_subs->bindValue(':new_end_dt', $new_ending_date);
                $update_subs->bindValue(':new_remaining_months', $new_remaining_months);
                $update_subs->bindValue(':new_all_months', $new_all_months);
                $update_subs->bindValue(':sub_id', $fet_sel_sub['customer_subscription_id']);
                $update_subs->bindValue(':now_date', $today);
                $ok_update_subs = $update_subs->execute();
        
                // Insert transaction with the calculated starting and ending dates
                $ins_transaction = $con->prepare("INSERT INTO subscriptions_transactions (client_id, amount_paid, subscriptions_months, subscriptions_start, subscriptions_end)
                    VALUES(?,?,?,?,?)");
        
                $ins_transaction->bindValue(1, $client);
                $ins_transaction->bindValue(2, $amount);
                $ins_transaction->bindValue(3, $months);
                $ins_transaction->bindValue(4, $starting_date);
                $ins_transaction->bindValue(5, $ending_date);
                $ok_ins_transaction = $ins_transaction->execute();
            }

    
            if ($ok_update_subs && $ok_ins_transaction) {
                $con->commit();
                $messg = "Dear ".$newCustomerName.", your new subscription of ".$months ." month(s) are recorded successful, you're now with ".$new_remaining_months." months. Enjoy your Fitness Journey !";
                parent::sendSMS($newCustomerPhone, $messg);

                $response = array('success' => true, 'message' => 'Subscription extended successfully');
            } else {
                $con->rollBack();
                $response = array('error' => true, 'message' => 'Error recording subscription or subscription transaction');
            }
        } else {
            // Handle the case where there is no active subscription for the client
            $con->beginTransaction();
    
            // Retrieve the latest transaction for the client
            $latest_transaction = $con->prepare("SELECT * FROM subscriptions_transactions WHERE client_id = ? ORDER BY transaction_id DESC LIMIT 1");
            $latest_transaction->bindValue(1, $client);
            $latest_transaction->execute();
            $latest_transaction_data = $latest_transaction->fetch(PDO::FETCH_ASSOC);
    
            // Calculate new starting and ending dates based on the latest transaction or use today's date
            $starting_date = $latest_transaction_data ? $latest_transaction_data['subscriptions_end'] : $today;
            $ending_date = date('Y-m-d H:i:s', strtotime($starting_date . ' + ' . $months . ' months'));
            if($isDiscount==1){
                // Insert new subscription
                $insert_subs_dis = $con->prepare("INSERT INTO customer_subscriptions (customer_id, starting_date, ending_date, all_months, remaining_months, isDiscount, DiscountValue)
                    VALUES(?,?,?,?,?,?,?)");
        
                $insert_subs_dis->bindValue(1, $client);
                $insert_subs_dis->bindValue(2, $today);
                $insert_subs_dis->bindValue(3, $ending_date);
                $insert_subs_dis->bindValue(4, $months);
                $insert_subs_dis->bindValue(5, $months);
                $insert_subs_dis->bindValue(6, $isDiscount);
                $insert_subs_dis->bindValue(7, $value_discount);
                $ok_insert_subs = $insert_subs_dis->execute();
        
                // Insert transaction with the calculated starting and ending dates
                $ins_transaction_dis = $con->prepare("INSERT INTO subscriptions_transactions (client_id, amount_paid, subscriptions_months, subscriptions_start, subscriptions_end)
                    VALUES(?,?,?,?,?)");
        
                $ins_transaction_dis->bindValue(1, $client);
                $ins_transaction_dis->bindValue(2, $amount);
                $ins_transaction_dis->bindValue(3, $months);
                $ins_transaction_dis->bindValue(4, $starting_date);
                $ins_transaction_dis->bindValue(5, $ending_date);
                $ok_ins_transaction = $ins_transaction_dis->execute();
            }else{
                // Insert new subscription
                $insert_subs = $con->prepare("INSERT INTO customer_subscriptions (customer_id, starting_date, ending_date, all_months, remaining_months)
                    VALUES(?,?,?,?,?)");
        
                $insert_subs->bindValue(1, $client);
                $insert_subs->bindValue(2, $today);
                $insert_subs->bindValue(3, $ending_date);
                $insert_subs->bindValue(4, $months);
                $insert_subs->bindValue(5, $months);
                $ok_insert_subs = $insert_subs->execute();
        
                // Insert transaction with the calculated starting and ending dates
                $ins_transaction = $con->prepare("INSERT INTO subscriptions_transactions (client_id, amount_paid, subscriptions_months, subscriptions_start, subscriptions_end)
                    VALUES(?,?,?,?,?)");
        
                $ins_transaction->bindValue(1, $client);
                $ins_transaction->bindValue(2, $amount);
                $ins_transaction->bindValue(3, $months);
                $ins_transaction->bindValue(4, $starting_date);
                $ins_transaction->bindValue(5, $ending_date);
                $ok_ins_transaction = $ins_transaction->execute();
            }

    
            if ($ok_insert_subs && $ok_ins_transaction) {
                $con->commit();
                $messg = "Dear ".$newCustomerName.", your new subscription of ".$months ."month(s) is recorded successfully. Enjoy your Fitness Journey !";
                parent::sendSMS($newCustomerPhone, $messg);
                $response = array('success' => true, 'message' => 'Subscription recorded successfully');
            } else {
                $con->rollBack();
                $response = array('error' => true, 'message' => 'Error recording subscription or subscription transaction');
            }
        }
    
        header('Content-Type: application/json');
        echo json_encode($response);
    }
    
    
    public function updateSubscriptionMonths()
    {
        $con = parent::connect();
    
        try {
            $updateQuery = "UPDATE customer_subscriptions
                            SET remaining_months = TIMESTAMPDIFF(MONTH, starting_date, NOW()),
                                remaining_months = GREATEST(all_months - TIMESTAMPDIFF(MONTH, starting_date, NOW()), 0),
                                updated_date = NOW()
                            WHERE customer_subscriptions.status=1";
    
            $updateStmt = $con->prepare($updateQuery);
            $updateStmt->execute();
    
            $rowCount = $updateStmt->rowCount();
    
            $response = array(
                'message' => 'success',
                'updated_rows' => $rowCount
            );
        } catch (PDOException $e) {
            $response = array('error' => true, 'message' => 'Database error: ' . $e->getMessage());
        }
    
        $con = null;
        return json_encode($response);
    }
    
    
    
    
    function send_email_to_customer($isAll, $SMSMValue, $customerPhone){

        if($isAll=='no'){
            parent::sendSMS($customerPhone, $SMSMValue);
            // echo "Nooo";
        }else{
            // echo "Yes";

            $con = parent::connect();
            $sel = $con->prepare("SELECT * FROM customers WHERE CustomerStatus=1");
            $sel->execute();
            if($sel->rowCount()>=1){
                while ($ft_sel = $sel->fetch(PDO::FETCH_ASSOC)) {
                    $user_phone = $ft_sel['CustomerPhone'];
                    parent::sendSMS($user_phone, $SMSMValue);
                }
            }
        }
        
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
    $result = $MainActions->recordEntrance($postData['client'], $postData['type'], $postData['amountEntered']);
    echo $result; 
} elseif (isset($postData['recordExpense'])) {
    $result = $MainActions->recordExpense($postData['expTitle'], $postData['expDetails'], $postData['expValue']);
    // echo "is here";
    echo $result; 
} elseif (isset($postData['searchUSerByPhone'])) {
    $result = $MainActions->searchUSerByPhone($postData['phone']);
    echo $result; 
} elseif (isset($postData['save_subscription'])) {
    if(isset($postData['isDiscount'])) {
        $result = $MainActions->save_subscription($postData['amount'], $postData['client'], $postData['discount_value']);
    }else{
        $result = $MainActions->save_subscription($postData['amount'], $postData['client'], null);
    }
    echo $result; 
} elseif (isset($postData['updateSubscriptionMonths'])) {
    $result = $MainActions->updateSubscriptionMonths();
    echo $result; 
}else if(isset($_GET['updateSubscriptionMonths'])){
    $result = $MainActions->updateSubscriptionMonths();
}else if(isset($_POST['send_email_to_customer'])){
    if(($_POST['isAll']=='no') && isset($_POST['customUsers']) && isset($_POST['SMSValue'])){
        // Retrieve the data
        $isAll = $_POST['isAll'];
        $customUsers = $_POST['customUsers'];
        $SMSValue = $_POST['SMSValue'];
        // echo "To Custom Customer";
        $MainActions->send_email_to_customer($isAll, $SMSValue, $customUsers);


    }else if(($_POST['isAll']=='yes') &&  isset($_POST['SMSValue'])){
        // Retrieve the data
         $isAll = $_POST['isAll'];
         $customUsers = $_POST['customUsers'];
         $SMSValue = $_POST['SMSValue'];

        // echo "Send to All";
        $MainActions->send_email_to_customer($isAll, $SMSValue, 0);



    } else {
        echo "Some data is missing.";
    }
} else {
    echo json_encode(array('error' => true, 'message' => 'Invalid request.'));
}






if(isset($_GET['updateSubscriptionMonths'])){
    $result = $MainActions->updateSubscriptionMonths();
}






$result = $MainActions->updateSubscriptionMonths();   //update customers monthly subscriptions (Sync)

?>
