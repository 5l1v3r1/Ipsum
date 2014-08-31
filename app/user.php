<?php 
    require_once 'config.php';
    require 'vendor/autoload.php';


    $data = file_get_contents("php://input");

    $results = new RecursiveIteratorIterator(
        new RecursiveArrayIterator(json_decode($data, TRUE)),
        RecursiveIteratorIterator::SELF_FIRST);

    foreach ($results as $key => $val) {
        if(!is_array($val)) {
            switch ($key) {
                case 'contract':
                    $contract = $val;
                    break;
                case 'name':
                    $name = $val;
                    break;
                case 'YouTube':
                    $YouTube = $val;
                    break;
                case 'email':
                    $email = $val;
                    break;
                case 'analytics':
                    $analytics = $val;
                    break;
                case 'view':
                    $view = $val;
                    break; 
                case 'subscriber':
                    $subscriber = $val;
                    break;
                case 'skype':
                    $skype = $val;
                    break;  
                case 'connect':
                    break;
                default:
                    return;
            }
        }
    }

    if(!empty($contract) && !empty($name) && !empty($YouTube) && !empty($email) && !empty($analytics) && !empty($view) && !empty($subscriber) && !empty($skype)) {

        try {
            $DB = new PDO('mysql:host='.$host.';dbname='.$dbname.'',$user,$password);
            $DB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $e) {
            echo 'ERROR pdo: ' . $e->getMessage();
            http_response_code(500);
            exit;
        }

        $querySearch = 'SELECT count(*) FROM channel WHERE email = :email';
        $queryInsert = 'INSERT INTO channel (username, youtube, email, skype, analytics, contract, view, subscriber)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)'; 
        try {
            $search = $DB->prepare($querySearch);
            $search->execute(array(':email' => $email));
            $v = $search->fetch();
            if($v[0] == 0){
                $insert = $DB->prepare($queryInsert);
                $insert->execute(array($name,$YouTube,$email,$skype,$analytics,$contract,$view,$subscriber));
            }

            $mail = new PHPMailer;

            //$mail->SMTPDebug = 3;                               // Enable verbose debug output

            $mail->isSMTP();                                      // Set mailer to use SMTP
            $mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
            $mail->SMTPAuth = true;                               // Enable SMTP authentication
            $mail->Username = $userMail;                 // SMTP username
            $mail->Password = $passwordMail;                           // SMTP password
            $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
            $mail->Port = 587;                                    // TCP port to connect to

            $mail->FromName = 'Mailer';
            $mail->addAddress($userMail, 'Joe User');     // Add a recipient 

            $mail->isHTML(true);                                  // Set email format to HTML

            $mail->Subject = 'A new channel want to join your network';
            $mail->Body    = 'The channel <a href='.$YouTube.'>'.$name.'</a> want to join your network.
                                <br /><br />Skype: '.$skype.'
                                <br /><br />Analytics: '.number_format($analytics,0, ',', ' ').'
                                <br /><br />View: '.number_format($view,0, ',', ' ').'
                                <br /><br />Subscriber: '.number_format($subscriber,0, ',', ' ').'';

            if(!$mail->send()) {
                echo 'Message could not be sent.';
                echo 'Mailer Error: ' . $mail->ErrorInfo;
            } else {
                echo 'Message has been sent';
            }

        } catch(PDOException $e) {
            echo 'ERROR save: ' . $e->getMessage();
            http_response_code(500);
            exit;
        }

    } else {
        echo 'ERROR something went wrong';
        http_response_code(500);
        exit;
    }


