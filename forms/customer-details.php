<?php
    try {
        $forename = $surname = $email = $phonenumber = "";

        $result = $db->query("SELECT forename, surname, email, phonenumber FROM users WHERE id=$_SESSION[id]");

        
            while ($rows = $result->fetch()) {
                $forname = $rows['forename'];
                $surname = $rows['surname'];
                $email = $rows['email'];
                $phonenumber = $rows['phonenumber'];
            }

    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }

?>
