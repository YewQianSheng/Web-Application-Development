<!DOCTYPE html>
<html>

<head>
    <title>Registration Form</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css">
</head>

<body>
    <div class="container">
        <h1>Registration Form</h1>
        <form method="post" action="register.php">
            <div class="mb-3">
                <label for="first-name" class="form-label">First Name:</label>
                <input type="text" class="form-control" id="first-name" name="first_name" required>
            </div>
            <div class="mb-3">
                <label for="last-name" class="form-label">Last Name:</label>
                <input type="text" class="form-control" id="last-name" name="last_name" required>
            </div>
            <div class="mb-3">
                <label for="dob-day" class="form-label">Date of Birth:</label>
                <div class="row">
                    <div class="col">
                        <select class="form-select" id="dob-day" name="dob_day" required>
                            <option value="" selected disabled>Select Day</option>
                            <?php
                            for ($day = 1; $day <= 31; $day++) {
                                echo "<option value=\"$day\">$day</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col">
                        <select class="form-select" id="dob-month" name="dob_month" required>
                            <option value="" selected disabled>Select Month</option>
                            <?php
                            $months = array(
                                "January", "February", "March", "April", "May", "June",
                                "July", "August", "September", "October", "November", "December"
                            );
                            foreach ($months as $month) {
                                echo "<option value=\"$month\">$month</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col">
                        <select class="form-select" id="dob-year" name="dob_year" required>
                            <option value="" selected disabled>Select Year</option>
                            <?php
                            $currentYear = date("Y");
                            for ($year = 1900; $year <= $currentYear; $year++) {
                                echo "<option value=\"$year\">$year</option>";
                            }
                            ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="mb-3">
                <label for="gender" class="form-label">Gender:</label>
                <select class="form-select" id="gender" name="gender" required>
                    <option value="" selected disabled>Select Gender</option>
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                    <option value="other">Other</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="username" class="form-label">Username:</label>
                <input type="text" class="form-control" id="username" name="username" pattern="[a-zA-Z][a-zA-Z0-9_-]{5,}" title="Username must start with a letter, and can only contain letters, numbers, underscore, or hyphen." required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password:</label>
                <input type="password" class="form-control" id="password" name="password" pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{6,}$" title="Password must be at least 6 characters long and contain at least one lowercase letter, one uppercase letter, and one number." required>
            </div>
            <div class="mb-3">
                <label for="confirm-password" class="form-label">Confirm Password:</label>
                <input type="password" class="form-control" id="confirm-password" name="confirm_password" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email:</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <button type="submit" class="btn btn-primary">Register</button>
        </form>
    </div>
</body>

</html>