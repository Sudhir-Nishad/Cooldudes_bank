<?php

include 'partials/_dbconnect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $to = $_POST['to'];
    $loan = $_POST['loan'];

    // check if loan amount is negative
    if (($loan) < 0) {
        echo '<script type="text/javascript">alert("Oops! Negative values cannot be given as loan") </script>';
    } else {
        // get the current balance of the selected user
        $sql = "SELECT * FROM users WHERE id=$to";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        $current_balance = $row['amount'];

        // add the loan amount to the user's balance
        $new_balance = $current_balance + $loan;
        $sql = "UPDATE users SET amount=$new_balance WHERE id=$to";
        $result = mysqli_query($conn, $sql);

        if ($result) {
            echo "<script> alert('Loan Successful'); window.location='index.php'; </script>";
        } else {
            echo "<script> alert('Error: Loan could not be processed'); window.location='index.php'; </script>";
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.3/css/all.css" integrity="sha384-SZXxX4whJ79/gErwcOYf+zWLeJdY/qpuqC4cAa9rOGUstPomtqpuNWT9wdPEn2fk" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/navbar.css">
    <link rel="stylesheet" href="css/footer.css">
    <link rel="stylesheet" href="css/index.css">
    <link rel="stylesheet" href="css/table.css">
    <title>GIVE LOAN</title>
</head>
<style>
    .loanprocess {
    width: 80%;
    max-width: 500px; /* Adjust the max-width as per your design needs */
    margin: 80px auto; /* This centers the form on the page */
    padding: 20px;
    background: #ffffff; /* A light background for the form */
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* A subtle shadow for depth */
    border-radius: 10px; /* Rounded corners for the form */
    font-family: 'Poppins', sans-serif;
}

.loanprocess select,
.loanprocess input[type=number] {
    width: calc(100% - 24px); /* Adjusts width to account for padding */
    padding: 10px;
    margin-bottom: 16px; /* Spacing between each form element */
    border: 1px solid #ccc; /* A subtle border */
    border-radius: 5px; /* Slightly rounded corners for the inputs */
    background: #f9f9f9; /* A very light background to distinguish the inputs */
    font-size: 16px; /* Slightly larger font for better readability */
}

.loanprocess button {
    width: 100%;
    padding: 12px;
    border: none;
    background-color: #007bff; /* A bright, noticeable color for the action button */
    color: #ffffff; /* White text for contrast */
    cursor: pointer; /* Changes the cursor to indicate it's clickable */
    border-radius: 5px; /* Matches the input border-radius */
    font-size: 18px; /* Larger font size for clarity */
    font-weight: 500; /* Medium font weight for emphasis */
    transition: background-color 0.3s ease; /* Smooth transition for the background color */
}

.loanprocess button:hover {
    background-color: #0056b3; /* Darker shade of the button color on hover */
}

/* Enhancing the select dropdown */
.loanprocess select {
    -webkit-appearance: none; /* Removes default chrome and safari appearance */
    -moz-appearance: none; /* Removes default Firefox appearance */
    appearance: none; /* Removes default appearance for supported browsers */
    background-image: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 4 5"><path fill="none" stroke="%23333" stroke-width="1" d="M2 1L0 4h4z"/></svg>'); /* Custom dropdown arrow */
    background-repeat: no-repeat;
    background-position: right 10px center; /* Positions the arrow icon */
    background-size: 12px; /* Sizes the arrow appropriately */
}

/* Focus styles for accessibility */
.loanprocess select:focus,
.loanprocess input[type=number]:focus,
.loanprocess button:focus {
    outline: 2px solid #007bff; /* Adds a blue outline to the focused element */
    outline-offset: 2px; /* Distance between the outline and the element */
}
.heading
{
    position: relative;
    top: 50px;
}

</style>
<body>

    <?php include 'partials/_navbar.php'?>
    <div class="cover"></div>

    <h1 class="heading">GIVE &nbsp; LOAN</h1>

    <!--  fatching available users details  -->
    <?php
        include 'partials/_dbconnect.php';
        $sql = "SELECT * FROM  users";
        $result=mysqli_query($conn,$sql);
        if(!$result)
        {
            echo "Error : ".$sql."<br>".mysqli_error($conn);
        }
   ?>

    <form class="loanprocess" method="POST">
        <select id="select" name="to" required>
            <option disabled selected>GIVE LOAN TO </option>
            <?php
                while($row = mysqli_fetch_assoc($result)) {
                    echo '<option value="'.$row["id"].'">'.$row["name"].' (CURRENT BALANCE : '.$row["amount"].' )</option>';
                } 
           ?>
        </select>
        <input type="number" name="loan" placeholder="LOAN AMOUNT" required>
        <button type="submit">GIVE LOAN</button>
    </form>
    <br>
    <a href="loanees.php">View Loanees</a>

    <?php include 'partials/_footer.php';?>
    <!-- script -->
    <script src="js/navscroll.js"></script>
</body>

</html>