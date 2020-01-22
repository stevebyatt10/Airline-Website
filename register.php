<?php
   
   session_start();

   $user = null;

   $isadmin = false;


    $connection = new mysqli('localhost', 'twa032', 'twa032xf', 'cooper_flights032');
    if($connection->connect_error) {
        die("failed to connect to the database: " . $connection->connect_error);
    }

    if(isset($_POST["submit"])){
        if(validateForm($_POST)){
            // form has been validated
                createUser($_POST);
        }
    }
    

?>


<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="description" content="Book flights all over the world at great prices.">
        <meta name="keywords" content="Stephen Airlines">
        <meta name="author" content="Stephen Byatt">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Stephen Airlines</title>
        <title>Stephen Airlines</title>

        <link href="https://fonts.googleapis.com/css?family=PT+Sans&display=swap" rel="stylesheet">


        <link rel="stylesheet" href="styles.css">

        
    </head>
    <body>
        <header>
            <h1>Stephen Airlines</h1>
           <nav>

                <a href="index.php">Home</a>

                <?php if($user != null) : ?>
                <a href="profile.php">My Profile</a>
                <a href="newbooking.php">New Booking</a>
                <a href="bookings.php">Bookings</a>

                <?php if($isadmin) :?> 
                <a href="flights.php">Flights</a>
                <?php endif ?>

                <a href="logout.php">Logout</a>

                <?php else: ?>
                <a href="register.php">Register</a>
                <a href="login.php">Login</a>
                <?php endif ?>
            </nav>

           
        </header>

        <div class="form">
            <h1>Create an account for Stephen Airlines</h1>
            <p>Keep your details, bookings, web check-in, and special deals 
                and offers all in one place.</p>


            <form id="register" method="post" action="register.php">
                
                    <div>
                        <label for="fname">First Name <img id="fnameEicon" src="error.png" width="20" height="20"></label>
                        <input class="invalid" type="text" id="fname" name="fname" placeholder="" onblur="">
                        <p>First name requires a capital letter</p>
                    </div>
    
                    <div>
                        <label for="lname">Last Name <img id="fnameEicon" src="error.png" width="20" height="20"></label>
                        <input type="text" id="lname" name="lname" placeholder="" onblur="">
                        <p>Last name requires a capital letter</p>
                    </div>
                

                <div>
                    <label for="email">Email <img id="fnameEicon" src="error.png" width="20" height="20"></label>
                    <input type="text" id="email" name="email" placeholder="Eg. john.smith@email.com" onblur="">
                    <p>Email is invalid</p>
                </div>

                <div>
                    <label for="phone">Phone Number <img id="fnameEicon" src="error.png" width="20" height="20"></label>
                    <input type="text" id="phone" name="phone" placeholder="" onblur="">
                    <p>Phone number is invalid</p>
                </div>


                <div>
                    <label for="address">Address <img id="fnameEicon" src="error.png" width="20" height="20"></label>
                    <input type="text" id="address" name="address" placeholder="" onblur="">
                    <p>Address is required</p>
                </div>

                <div>
                    <label for="suburb">Suburb <img id="fnameEicon" src="error.png" width="20" height="20"></label>
                    <input type="text" id="suburb" name="suburb" placeholder="" onblur="">
                    <p>Suburb is required</p>
                </div>
               
                    <div>
                        <label for="state">State <img id="fnameEicon" src="error.png" width="20" height="20"></label>
                        <select name="state" id="state" onblur="">
                            <option value="" selected="" disabled="">Select State</option>
                            <option value="NSW">NSW</option>
                            <option value="ACT">ACT</option>
                            <option value="QLD">QLD</option>
                            <option value="VIC">VIC</option>
                            <option value="WA">WA</option>
                            <option value="SA">SA</option>
                            <option value="NT">NT</option>
                            <option value="TAS">TAS</option>
                        </select>
                        <p>State is required</p>
                    </div>
                  
    
                    <div>
                        <label for="postcode">Post Code <img id="fnameEicon" src="error.png" width="20" height="20"></label>
                        <input type="text" id="postcode" name="postcode" placeholder="" onblur="">
                        <p>Postcode is invalid</p>
                    </div>                                    
                
               
                <div>
                    <label for="password">Password <img id="fnameEicon" src="error.png" width="20" height="20"></label>
                    <input type="password" id="password" name="password" placeholder="" onblur="">
                    <p>Password must be at least 8 characters and have at least one number</p>
                </div>

                <div>
                    <label for="confpassword">Confirm Password <img id="fnameEicon" src="error.png" width="20" height="20"></label>
                    <input type="password" id="confpassword" name="confpassword" placeholder="" onblur="">
                    <p>Passwords do not match</p>
                </div>

                <div>
                    <span>
                        <input type="checkbox" value="true" name="admin" id="admin" onclick="">
                        <label for="admin">This account is an administator.</label>
                    </span>
                </div>
               

                <div>
                    <input type="submit" name="submit" id="submit" value="Create Account">
                </div>

                <div>
                    <p>Already have an account? <a>Log in</a></p>
                </div>


            </form>


        </div>
    
    </body>
</html>


<?php   


function validateForm($form){

    $formvalid = true;

    echo "validating";

     if(!isset($form['state'])){
            $formvalid = false;
            echo "<p> state was not set</p>";
        }


    foreach ($_POST as $key => $value) {


        $valid = true;


        if($key == "Submit"){
            continue;
        }

       

        if(empty($value)){
            $valid = false;
            echo "<p> $key : $value is empty </p>";
        }


        switch ($key){
            
            case "fname":
            case "lname":
                if(!preg_match('/^[A-Z]/', $value)){
                    $valid = false;
                    echo "<p> $key : $value not valid </p>";
                }
            break;

            case "suburb":
                if(!preg_match('/^[a-zA-z]{2,}$/', $value)){
                    $valid = false;
                    echo "<p> $key : $value not valid </p>";
                }

            break;

            case "phone":
                if(!preg_match('/^[0-9]{10}$/', $value)){
                    $valid = false;
                    echo "<p> $key : $value not valid </p>";
                }

            break;
            case "email":
                if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
                    $valid = false;
                    echo "<p> $key : $value not valid </p>";
                }
            break;

            case "state":
                if ($value == ""){
                    $valid = false;
                    echo "<p> $key : $value not valid </p>";
                }

            break;

            case "postcode":
                if(!preg_match('/^\d{4}$/', $value)){
                    $valid = false;
                    echo "<p> $key : $value not valid </p>";
                }
            break;

            case "password":
                if(!preg_match('/^(?=.*?[0-9]).{8,}$/', $value)){
                    $valid = false;
                    echo "<p> $key : $value not valid </p>";
                }

            break;


            case "confPassword":
                if($value != $form['$password']){
                    $valid = false;
                    echo "<p> $key : $value not valid </p>";
                }
            break;
        }


        if(!$valid)
        {
            $formvalid = $valid;
            showError($key);
        }
    }

    echo $formvalid ? 'true' : 'false';

    return $formvalid;

}


    function createUser($form){

        global $connection;

        $first = $form['fname'];
        $last = $form['lname'];
        $email = $form['email'];
        $address = $form['address'];
        $suburb = $form['suburb'];
        $state = $form['state'];
        $postcode = $form['postcode'];
        $phone = $form['phone'];
        $password = hash('sha256', $form['password']);
        $admin = isset($form['admin']) ? 1 : 0;
        


        $query = "INSERT INTO customer (fname, lname, email, password, address, suburb, state, postcode, phone, admin) ";
        $query = $query . "VALUES ('$first', '$last', '$email', '$password', '$address', '$suburb', '$state', $postcode, '$phone', $admin)";


        echo $query;

        if($connection->query($query) == TRUE){
            $last_id = $connection->insert_id;
            $_SESSION["userid"] = $last_id;
            header("Location: index.php");
        } else {
            die('<p>Query Statement Error: ' . $connection->error) . "</p>";
        }


    }


    function showError($key){
        echo "<script>
        document.getElementById('$key').class = 'invalid';
        </script>";       

    }


?>