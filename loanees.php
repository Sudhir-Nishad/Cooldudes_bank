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
    <title>LOANEES</title>
</head>

<body>
    <?php include 'partials/_navbar.php' ?>

    <div class="cover"></div>

    <h1>LOANEES</h1>
    <div class="all_users" style="height: 500px;">
        <table>
            <tr>
                <th>ID</th>
                <th>NAME</th>
                <th>EMAIL</th>
                <th>LOAN AMOUNT</th>
            </tr>
            <?php
            include 'partials/_dbconnect.php';
            $sql = "SELECT * FROM `users` WHERE amount > (SELECT amount FROM users WHERE users.id = `users`.id)";
            $result = mysqli_query($conn, $sql);

            while ($row = mysqli_fetch_assoc($result)) {
                $initial_amount_sql = "SELECT amount FROM users WHERE id = {$row['id']}";
                $initial_amount_result = mysqli_query($conn, $initial_amount_sql);
                $initial_amount_row = mysqli_fetch_assoc($initial_amount_result);

                $loan_amount = $row['amount'] - $initial_amount_row['amount'];

                echo "
                <tr>
                    <td>{$row['id']}</td>
                    <td>{$row['name']}</td>
                    <td>{$row['email']}</td>
                    <td>$loan_amount</td>
                </tr>
                ";
            }
            ?>
        </table>
    </div>

    <?php include 'partials/_footer.php' ?>
    <!-- script -->
    <script src="js/navscroll.js"></script>
</body>

</html>