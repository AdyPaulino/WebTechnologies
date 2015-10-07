<?php
  //Handle the form
  function validateFeedbackForm($arr) {
    extract($arr);

    if(!isset($name, $email)) return;

    if(!$name) {
      return "Please enter your name";
    }

    if(!preg_match("/^\S+@\S+$/", $email)) {
      return "Please enter a valid email address";
    }
  }

  if(isset($_POST['order'])) {
    $errorMsg = validateFeedbackForm($_POST);
  }
?>
<!DOCTYPE html>
<html>
  <head>
    <title>Assignment #1</title>
    <!-- LOAD CSS AND JS HERE -->
  </head>

  <body>
    <form method="POST" action="<?PHP echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" accept-charset="UTF-8">
      <?php
        if(isset($errorMsg) && $errorMsg) {
          echo "<p class=\"alert alert-danger\">", htmlspecialchars($errorMsg), "</p>\n\n";
        }
      ?>
      <label for="name">Name</label>
      <input type="text" name="name" value="<?php if(isset($_POST['name'])) echo htmlspecialchars($_POST['name']); ?>">

      <label for="email">Email</label>
      <input type="email" size="48" name="email" value="<?PHP if(isset($_POST['email'])) echo htmlspecialchars($_POST['email']); ?>">

      <input type="submit" name="order" value="Send Order">
    </form>
  </body>
</html>
