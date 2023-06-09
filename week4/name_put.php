<!DOCTYPE html>
<html>

<head>
    <title>Name_Put</title>
    <style>
        .error {
            color: red;
        }
    </style>
</head>

<body>
    <h2>Question 2</h2>

    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <label for="firstName">First Name:</label>
        <input type="text" id="firstName" name="firstName"><br>

        <label for="lastName">Last Name:</label>
        <input type="text" id="lastName" name="lastName"><br>

        <button type="submit" name="submit">Submit</button>
    </form>

    <?php
    if (isset($_POST['submit'])) {
        $firstName = $_POST['firstName'];
        $lastName = $_POST['lastName'];

        if (empty($firstName) || empty($lastName)) {
            echo "<p class='error'>Please enter your name.</p>";
        } else {
            $formattedFirstName = ucwords(strtolower($firstName));
            $formattedLastName = ucwords(strtolower($lastName));

            echo "<h3>Formatted Name:</h3>";
            echo "$formattedLastName $formattedFirstName";
        }
    }
    ?>
</body>

</html>