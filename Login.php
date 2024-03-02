//Important Notes

1- the $conn MUST be ABOVE the Login/Signup System or it wont work
2- do NOT delete the Name and value attribute of both HTML inputs
3- You must have a MySQL database containing a table called "Users" with atleast "Name" as "unique" and "Password", You can have my preset if you're not familiar with MySQL
4- You'll need a local apache server like XAMPP (For Linux) or WAMP64 (for Windows), and also youll need PhpMyAdmin for the locally hosted database
5- in PhpMyAdmin click Import and select the .SQL file thats the Account table preset
6- ALWAYS write HTML between $Conn and the < ?php 
7- if you have your own Database and don't want to use the preset, feel free to edit all the PHP MySQLi stuff to your Table and columns. the $conn too

!- this whole repo's contents was made by KerimKAintHere from github, do not remove this one line


<?php
    $db_server = "localhost here";
    $db_user = "Your DB acc's username";
    $db_pass = "your password, leave it blank if you dont have any";
    $db_name = "Your database name";
    $conn = "";

    $conn = mysqli_connect($db_server, $db_user, $db_pass, $db_name); //assigns $conn as the DB information you just wrote

    if ($conn){
        echo"Server: Online";
    }
    else{
        echo"Server: Offline"; //this is a debug feature to see if the server is on or off, you can keep it or delete it if you want
    }
?>

//Conn comes here, above the HTML and Login/Sign up code

<div>
    <input class="SubmitButton" name="SignUp" type="submit" value="SignUp" required><br>
    <input class="SubmitButton2" name="Login" type="submit" value="Login" required>
</div>

//HTML comes here, also side note, add more stuff if you want like title, containers, etc, these 2 are just necesarry HTML tags necesarry for this whole thing, go crazy with the CSS too



<?php 
session_start(); // Starting the session

if($_SERVER["REQUEST_METHOD"] == "POST"){ //Basically the root of the thing, however you need to specify wheter you clicked SignUp or Login which is just below

    if (isset($_POST["SignUp"])) { //Does the whole function when you click "SignUp" from the HTML input

        $Username = filter_input(INPUT_POST, "Username", FILTER_SANITIZE_SPECIAL_CHARS); //These 2 assign both Name and Pass variables to the input of Username and Password fields of the HTML
        $Password = filter_input(INPUT_POST, "Password", FILTER_SANITIZE_SPECIAL_CHARS);

        // Check if username is empty
        if (empty($Username)) {
            echo "No username";
        } elseif (empty($Password)) {
            echo "No password";
        } else {
            // Check if username already exists
            $sql_check = "SELECT * FROM users WHERE Name='$Username'";
            $result = mysqli_query($conn, $sql_check);

            if (mysqli_num_rows($result) > 0) {
                echo "Username already taken";
            } else {
                // If Username isn't taken, it'll create the account
                $sql = "INSERT INTO users (Name, Password) VALUES ('$Username', '$Password')"; //adds the User and Pass variable to the Name and Password field of the Table
                if (mysqli_query($conn, $sql)) {
                    echo "REGISTER SUCCESS";
                } else {
                    echo "Error occurred";
                }
            }
            mysqli_free_result($result); // Free the result of the check query
        }
    }
    }


    if(isset($_POST["Login"])) { //Does the whole function when you click "Login" from the HTML input
        $Username = filter_input(INPUT_POST, "Username", FILTER_SANITIZE_SPECIAL_CHARS);
        $Password = filter_input(INPUT_POST, "Password", FILTER_SANITIZE_SPECIAL_CHARS); //same stuff as in Signup
    
        if(empty($Username)){
            echo "No username";
        }
        elseif (empty($Password)){ //same stuff too
            echo "No password";
        }
        else{
            $sql = "SELECT * FROM users WHERE Name = '$Username' AND Password = '$Password'"; //checks the table if its already there
            $result = mysqli_query($conn, $sql); //will check if the pass and user is there
    
            if(mysqli_num_rows($result) == 1){ //If its found and password is correct:
                $_SESSION['Username'] = $Username; // Stores username in session
                header("location: home.php"); // Redirecting to your homepage, edit it to whatever Site file you have (.HTML, .PHP)
                exit(); // Ensuring script stops executing after redirection
            }
            else{
                echo "Invalid username or password";
            }
        }
    }
    mysqli_close($conn);
?>