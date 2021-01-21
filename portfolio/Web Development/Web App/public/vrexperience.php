<?php

/**
 * Use an HTML form to create a new entry in the
 * vrexperience table.
 *
 */


if (isset($_POST['submit'])) {
    require "../config.php";
    require "../common.php";




    try  {
        $connection = new PDO($dsn, $username, $password, $options);

        $new_vr = array(
            "expID"    =>  $_POST['expID'],
            "_name" => $_POST['_name'],
            "maintainer" => $_POST['maintainer']
        );

        $new_device = array(
            "expID"    =>  $_POST['expID'],
            "device" => $_POST['device']
        );


        $sql = sprintf(
                "INSERT INTO %s (%s) values (%s)",
                "vrexperience",
                implode(", ", array_keys($new_vr)),
                ":" . implode(", :", array_keys($new_vr))
        );

        $sql2 = sprintf(
                "INSERT INTO %s (%s) values (%s)",
                "supporteddevices",
                implode(", ", array_keys($new_device)),
                ":" . implode(", :", array_keys($new_device))
        );

        $statement = $connection->prepare($sql);
        $statement->execute($new_vr);
        $statement = $connection->prepare($sql2);
        $statement->execute($new_device);
        

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

<form method="post">
    <label for="expID">Experience ID</label>
    <input type="number" name="expID" id="expID" required>
    <label for="_name">Name</label>
    <input type="text" name="_name" id="_name" required>
    <label for="maintainer">maintainer ID</label>
    <input type="number" name="maintainer" id="maintainer">
    <label for="devices">Device</label>
    <select name="device" id="device">
        <option value="deviceA">Device A</option>
        <option value="deviceB">Device B</option>
        <option value="deviceC">Device C</option>
        <option value="deviceD">Device D</option>
    </select>
    <input type="submit" name="submit" value="Submit">

</form>

<a href="index.php">Back to home</a>

<?php require "templates/footer.php"; ?>