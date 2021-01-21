<?php

/**
 * Function to query information based on
 * an email, experience ID, or Dev unit ID.
 *
 */

if (isset($_POST['submit'])) {
    try  {

        require "../config.php";
        require "../common.php";

        
        $connection = new PDO($dsn, $username, $password, $options);

        $sql = "SELECT *
                        FROM users
                        WHERE email = :email";

        $email = $_POST['email'];

        $statement = $connection->prepare($sql);
        $statement->bindParam(':email', $email, PDO::PARAM_STR);
        $statement->execute();

        $result = $statement->fetchAll();
    } catch(PDOException $error) {
        echo $sql . "<br>" . $error->getMessage();
    }
}

if (isset($_POST['submit2'])) {
    try  {

        require "../config.php";
        require "../common.php";

        
        $connection = new PDO($dsn, $username, $password, $options);

        $sql = "SELECT *
                        FROM vrexperience
                        WHERE expID = :expID";

        $expID = $_POST['expID'];

        $statement = $connection->prepare($sql);
        $statement->bindParam(':expID', $expID, PDO::PARAM_STR);
        $statement->execute();
        $result = $statement->fetchAll();
    } catch(PDOException $error) {
        echo $sql . "<br>" . $error->getMessage();
    }
}

if (isset($_POST['submit3'])) {
    try  {

        require "../config.php";
        require "../common.php";

        
        $connection = new PDO($dsn, $username, $password, $options);

        $sql = "SELECT *
                        FROM devunit
                        WHERE unitID = :unitID";

        $unitID = $_POST['unitID'];

        $statement = $connection->prepare($sql);
        $statement->bindParam(':unitID', $unitID, PDO::PARAM_STR);
        $statement->execute();
        $result = $statement->fetchAll();

    } catch(PDOException $error) {
        echo $sql . "<br>" . $error->getMessage();
    }
}
?>
<?php require "templates/header.php"; ?>

<?php
if (isset($_POST['submit'])) {
    if ($result && $statement->rowCount() > 0) { ?>
        <h2>Results</h2>

        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>First Name</th>
                    <th>Middle Initial</th>
                    <th>Last Name</th>
                    <th>Email Address</th>
                    <th>Birth Date</th>
                </tr>
            </thead>
            <tbody>
        <?php foreach ($result as $row) { ?>
            <tr>
                <td><?php echo escape($row["userID"]); ?></td>
                <td><?php echo escape($row["firstName"]); ?></td>
                <td><?php echo escape($row["middleInitial"]); ?></td>
                <td><?php echo escape($row["lastName"]); ?></td>
                <td><?php echo escape($row["email"]); ?></td>
                <td><?php echo escape($row["dob"]); ?> </td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
    <?php } else { ?>
        <blockquote>No results found for <?php echo escape($_POST['email']); ?>.</blockquote>
    <?php }
    }
    
if (isset($_POST['submit2'])) {
    if ($result && $statement->rowCount() > 0) { ?>
        <h2>Results</h2>

        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Experience Title</th>
                    <th>Maintainer ID</th>
                </tr>
            </thead>
            <tbody>
        <?php foreach ($result as $row) { ?>
            <tr>
                <td><?php echo escape($row["expID"]); ?></td>
                <td><?php echo escape($row["_name"]); ?></td>
                <td><?php echo escape($row["maintainer"]); ?></td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
    <?php } else { ?>
        <blockquote>No results found for <?php echo escape($_POST['email']); ?>.</blockquote>
    <?php }
   }

if (isset($_POST['submit3'])) {
    if ($result && $statement->rowCount() > 0) { ?>
        <h2>Results</h2>

        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Unit Name</th>
                    <th>Unit description</th>
                </tr>
            </thead>
            <tbody>
        <?php foreach ($result as $row) { ?>
            <tr>
                <td><?php echo escape($row["unitID"]); ?></td>
                <td><?php echo escape($row["unitName"]); ?></td>
                <td><?php echo escape($row["unitDesc"]); ?></td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
    <?php } else { ?>
        <blockquote>No results found for <?php echo escape($_POST['email']); ?>.</blockquote>
    <?php }
   }


?>


 

<h2>Search for a user by email</h2>

<form method="post">
    <label for="email">Email</label>
    <input type="email" id="email" name="email">
    <input type="submit" name="submit" value="View Results">
</form>

<h2>Search for a VR Experience</h2>

<form method="post">
    <label for="expID">Experience ID</label>
    <input type="number" id="expID" name="expID">
    <input type="submit" name="submit2" value="View Results">
</form>

<h2>Search for a Development Unit </h2>

<form method="post">
    <label for="expID">Unit ID</label>
    <input type="number" id="unitID" name="unitID">
    <input type="submit" name="submit3" value="View Results">
</form>

<a href="index.php">Back to home</a>

<?php require "templates/footer.php"; ?>
