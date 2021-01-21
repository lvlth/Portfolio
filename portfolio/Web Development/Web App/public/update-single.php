<?php
/**
  * Use an HTML form to edit an entry in the
  * users table.
  *
  */
require "../config.php";
require "../common.php";



if (isset($_POST['submit'])) {
  try {
    $connection = new PDO($dsn, $username, $password, $options);
    $user =[
      "userID"        => $_POST['userID'],
      "firstName" => $_POST['firstName'],
      "middleInitial" => $_POST['middleInitial'],
      "lastName"  => $_POST['lastName'],
      "email"     => $_POST['email'],
      "dob"       => $_POST['dob']
    ];

    $sql = "UPDATE users
            SET userID = :userID,
              firstName = :firstName,
              lastName = :lastName,
              email = :email,
              dob = :dob,
              middleInitial = :middleInitial
            WHERE userID = :userID";

  $statement = $connection->prepare($sql);
  $statement->execute($user);
  } catch(PDOException $error) {
      echo $sql . "<br>" . $error->getMessage();
  }
}

if (isset($_GET['userID'])) {
  try {
    $connection = new PDO($dsn, $username, $password, $options);
    $id = $_GET['userID'];
    $sql = "SELECT * FROM users WHERE userID = :userID";
    $statement = $connection->prepare($sql);
    $statement->bindValue(':userID', $id);
    $statement->execute();

    $user = $statement->fetch(PDO::FETCH_ASSOC);
  } catch(PDOException $error) {
      echo $sql . "<br>" . $error->getMessage();
  }
} else {
    echo "Something went wrong!";
    exit;
}
?>

<?php require "templates/header.php"; ?>

<?php if (isset($_POST['submit']) && $statement) : ?>
  <?php echo escape($_POST['firstname']); ?> successfully updated.
<?php endif; ?>

<h2>Edit a user</h2>

<form method="post">
    <?php foreach ($user as $key => $value) : ?>
      <label for="<?php echo $key; ?>"><?php echo ucfirst($key); ?></label>
      <input type="text" name="<?php echo $key; ?>" id="<?php echo $key; ?>" value="<?php echo escape($value); ?>" <?php echo ($key === 'id' ? 'readonly' : null); ?> required>
    <?php endforeach; ?>
    <input type="submit" name="submit" value="Submit">

</form>

<a href="index.php">Back to home</a>

<?php require "templates/footer.php"; ?>