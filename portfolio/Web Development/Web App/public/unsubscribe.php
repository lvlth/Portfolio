<?php

/**
  * Unsubscribe a user
  */

require "../config.php";
require "../common.php";


if (isset($_GET["userID"])) {
  try {
    $connection = new PDO($dsn, $username, $password, $options);

    $id = $_GET["userID"];
   

    $sql = "INSERT INTO freeuser(userID, usageQuota) VALUES (:userID, '0.1')";
    $sql2 = "DELETE FROM payinguser WHERE userID = :userID";

    $statement = $connection->prepare($sql);
    $statement2 = $connection->prepare($sql2);
    $statement->bindValue(':userID', $id);
    $statement2->bindValue(':userID', $id);
    $statement->execute();
    $statement2->execute();

    $success = "User successfully unsubscribed";
  } catch(PDOException $error) {
    echo $sql . "<br>" . $error->getMessage();
  }
}

try {
  $connection = new PDO($dsn, $username, $password, $options);

  $sql = "SELECT userID, firstName, middleInitial, lastName, email, dob FROM payinguser natural left join users";;

  $statement = $connection->prepare($sql);
  $statement->execute();

  $result = $statement->fetchAll();
} catch(PDOException $error) {
  echo $sql . "<br>" . $error->getMessage();
}
?>
<?php require "templates/header.php"; ?>

<h2>Unsubscribe users</h2>

<?php if ($success) echo $success; ?>

<table>
  <thead>
    <tr>
      <th>#</th>
      <th>First Name</th>
      <th>Middle Initial</th>
      <th>Last Name</th>
      <th>Email Address</th>
      <th>Birth day</th>
      <th>Subcribe</th>
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
      <td><?php echo escape($row["dob"]); ?></td>
      <td><a href="unsubscribe.php?userID=<?php echo escape($row["userID"]); ?>">Unsubscribe</a></td>
    </tr>
  <?php endforeach; ?>
  </tbody>
</table>

<a href="index.php">Back to home</a>

<?php require "templates/footer.php"; ?>