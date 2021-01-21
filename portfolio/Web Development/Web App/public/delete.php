<?php

/**
  * Delete a user
  */

require "../config.php";
require "../common.php";


if (isset($_GET["userID"])) {
  try {
    $connection = new PDO($dsn, $username, $password, $options);

    $id = $_GET["userID"];

    $sql = "DELETE FROM users WHERE userID = :userID";

    $statement = $connection->prepare($sql);
    $statement->bindValue(':userID', $id);
    $statement->execute();

    $success = "User successfully deleted";
  } catch(PDOException $error) {
    echo $sql . "<br>" . $error->getMessage();
  }
}

try {
  $connection = new PDO($dsn, $username, $password, $options);

  $sql = "SELECT * FROM users";

  $statement = $connection->prepare($sql);
  $statement->execute();

  $result = $statement->fetchAll();
} catch(PDOException $error) {
  echo $sql . "<br>" . $error->getMessage();
}
?>
<?php require "templates/header.php"; ?>

<h2>Delete users</h2>

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
      <th>Delete</th>
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
      <td><a href="delete.php?userID=<?php echo escape($row["userID"]); ?>">Delete</a></td>
    </tr>
  <?php endforeach; ?>
  </tbody>
</table>

<a href="index.php">Back to home</a>

<?php require "templates/footer.php"; ?>