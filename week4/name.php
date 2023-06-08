<!DOCTYPE html>
<html>

<head>
    <title>Name</title>
</head>

<body>
    <h2>Name Formatter</h2>

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

        $formattedFirstName = ucwords(strtolower($firstName));
        $formattedLastName = ucwords(strtolower($lastName));

        echo "<h3>Formatted Name:</h3>";
        echo "$formattedFirstName $formattedLastName";
    }
    ?>
</body>

</html>