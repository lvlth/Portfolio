<?php

/**
 * Use an HTML form to create a new entry in the
 * users table.
 *
 */


if (isset($_POST['submit'])) {
    require "../config.php";
    require "../common.php";




    try  {
        $connection = new PDO($dsn, $username, $password, $options);

        $new_user = array(
            "userID"    =>  $_POST['userID'],
            "firstName" => $_POST['firstName'],
            "middleInitial" => $_POST['middleInitial'],
            "lastName"  => $_POST['lastName'],
            "email"     => $_POST['email'],
            "dob"       => $_POST['dob']
        );

        $free_user = array(
            "userID" => $_POST['userID'],
            "usageQuota" => 0.1
        );


        $sql = sprintf(
                "INSERT INTO %s (%s) values (%s)",
                "users",
                implode(", ", array_keys($new_user)),
                ":" . implode(", :", array_keys($new_user))
        );

        $sql2 = sprintf(
                "INSERT INTO %s (%s) values (%s)",
                "freeuser",
                implode(", ", array_keys($free_user)),
                ":" . implode(", :", array_keys($free_user))
        );


        $statement = $connection->prepare($sql);
        $statement->execute($new_user);
        $statement2 = $connection->prepare($sql2);
        $statement2->execute($free_user);
        

    } catch(PDOException $error) {
        echo $sql . "<br>" . $error->getMessage();
    }
}
?>

<?php require "templates/header.php"; ?>

<?php if (isset($_POST['submit']) && $statement && $statement2) { ?>
    <blockquote><?php echo $_POST['firstName']; ?> successfully added.</blockquote>
<?php } ?>

<h2>Add a user</h2>

<form method="post">
    <label for="userID">ID</label>
    <input type="number" name="userID" id="userID" required>
    <label for="firstName">First Name</label>
    <input type="text" name="firstName" id="firstName" required>
    <label for="middleInitial">Middle Initial</label>
    <input type="text" name="middleInitial" id="middleInitial">
    <label for="lastName">Last Name</label>
    <input type="text" name="lastName" id="lastName" required>
    <label for="email">Email Address</label>
    <input type="email" name="email" id="email" required>
    <label for="dob">Birthday</label>
    <input type="date" name="dob" id="dob" required>
    <input type="submit" name="submit" value="Submit">

</form>

<a href="index.php">Back to home</a>

<?php require "templates/footer.php"; ?>
