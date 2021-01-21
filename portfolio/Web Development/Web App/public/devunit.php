<?php

/**
 * Use an HTML form to create a new entry in the
 * devunit table.
 *
 */


if (isset($_POST['submit'])) {
    require "../config.php";
    require "../common.php";




    try  {
        $connection = new PDO($dsn, $username, $password, $options);

        $new_du = array(
            "unitID"    =>  $_POST['unitID'],
            "unitName" => $_POST['unitName'],
            "unitDesc" => $_POST['unitDesc']
        );


        $sql = sprintf(
                "INSERT INTO %s (%s) values (%s)",
                "vrexperience",
                implode(", ", array_keys($new_du)),
                ":" . implode(", :", array_keys($new_du))
        );



        $statement = $connection->prepare($sql);
        $statement->execute($new_du);
        

    } catch(PDOException $error) {
        echo $sql . "<br>" . $error->getMessage();
    }
}
?>

<?php require "templates/header.php"; ?>

<?php if (isset($_POST['submit']) && $statement && $statement2) { ?>
    <blockquote><?php echo $_POST['_name']; ?> successfully added.</blockquote>
<?php } ?>

<h2>Add a VR Experience</h2>

<form method="post" id="devunitform">
    <label for="unitID">Development Unit ID</label>
    <input type="number" name="unitID" id="unitID" required>
    <label for="unitName">Unit Name</label>
    <input type="text" name="unitName" id="unitName" required>
    <label for="unitDesc">Description</label>
    <textarea name="unitDesc" id="unitDesc"></textarea>
    <input type="submit" name="submit" value="Submit">
</form>



<a href="index.php">Back to home</a>

<?php require "templates/footer.php"; ?>