<?php

/**
 * List all users with a link to edit
 *
 */

    try  {

        require "../config.php";
        require "../common.php";

        $connection = new PDO($dsn, $username, $password, $options);

        $sql = "SELECT *
                        FROM users";



        $statement = $connection->prepare($sql);
        $statement->execute();

        $result = $statement->fetchAll();
    } catch(PDOException $error) {
        echo $sql . "<br>" . $error->getMessage();
    }

?>
<?php require "templates/header.php"; ?>

        <h2>Update users</h2>

        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>First Name</th>
                    <th>Middle Initial</th>
                    <th>Last Name</th>
                    <th>Email Address</th>
                    <th>Birthday</th>
                </tr>
            </thead>
            <tbody>
        <?php foreach ($result as $row) : ?>
            <tr>
                <td><?php echo escape($row["userID"]); ?></td>
                <td><?php echo escape($row["firstName"]); ?></td>
                <td><?php echo escape($row["middleInitial"]); ?></td>
                <td><?php echo escape($row["lastName"]); ?></td>
                <td><?php echo escape($row["email"]); ?></td>
                <td><?php echo escape($row["dob"]); ?> </td>
                <td><a href="update-single.php?userID=<?php echo escape($row["userID"]);
                ?>">Edit</a></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

        <a href="index.php">Back to home</a>

        <?php require "templates/footer.php"; ?>