<?php

/**
 * Use an HTML form to create a new avatar
 * 
 *
 */


if (isset($_POST['submit'])) {
    require "../config.php";
    require "../common.php";




    try  {
        $connection = new PDO($dsn, $username, $password, $options);

        $new_avatar = array(
            "userID"    =>  $_POST['userID'],
            "_name" => $_POST['_name'],
            "species" => $_POST['species']
        );


        $sql = sprintf(
                "INSERT INTO %s (%s) values (%s)",
                "avatar",
                implode(", ", array_keys($new_avatar)),
                ":" . implode(", :", array_keys($new_avatar))
        );

     


        $statement = $connection->prepare($sql);
        $statement->execute($new_avatar);
        

    } catch(PDOException $error) {
        echo $sql . "<br>" . $error->getMessage();
    }
}
?>


<?php require "templates/header.php"; ?>

<?php if (isset($_POST['submit']) && $statement) { ?>
    <blockquote> Avatar successfully added.</blockquote>
<?php } ?>

<h2>Create an avatar</h2>

<form method="post">
    <label for="userID">ID</label>
    <input type="number" name="userID" id="userID" required>
    <label for="_name">Name</label>
    <input type="text" name="_name" id="_name" required>
    <label for="species">Species</label>
    <select name="species" id="species">
        <option value="Alpha">Alpha</option>
        <option value="Bravo">Bravo</option>
        <option value="Charlie">Charlie</option>
        <option value="Delta">Delta</option>
    </select>
    <input type="submit" name="submit" value="Submit">
</form>


<?php require "templates/footer.php"; ?>