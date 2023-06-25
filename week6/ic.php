<!DOCTYPE html>
<html>

<head>
    <title>Malaysian IC Validation</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5 text-center fs-5">
        <h1>Malaysian IC Validation</h1>
        <form method="POST" action="">
            <label for="ic_number">Enter Malaysian IC Number:</label><br>
            <input type="text" id="ic_number" name="ic_number" required pattern="[0-9]{6}-[0-9]{2}-[0-9]{4}">
            <small>(Format: 123456-78-9012)</small><br><br>
            <input type="submit" value="Submit">
        </form>
        <?php
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $icNumber = $_POST["ic_number"];
            $pattern = "/^[0-9]{6}-[0-9]{2}-[0-9]{4}$/";
            $month = array('JAN', 'FEB', 'MAR', 'APR', 'MAY', 'JUN', 'JUL', 'OGO', 'SEP', 'OCT', 'NOV', 'DEC');

            // Check if the IC number is valid
            if (preg_match($pattern, $icNumber)) {
                $birthYear = substr($icNumber, 0, 2);
                $birthMonth = substr($icNumber, 2, 2);
                $birthDay = substr($icNumber, 4, 2);
                $stateCode = substr($icNumber, 7, 2);
                if (($birthYear + 2000) > date('Y')) {
                    $year = $birthYear + 1900;
                } else {
                    $year = $birthYear + 2000;
                }
                // Check if the date of birth is valid
                if (checkdate($birthMonth, $birthDay, $year)) {
                    $imonth = $birthMonth - 1;


                    // Calculate the Chinese Zodiac sign
                    $zodiacSigns = array(
                        0 => array(
                            'name' => "Monkey",
                            'image' => "img/monkey.jpg"
                        ),
                        1 => array(
                            'name' => "Rooster",
                            'image' => "img/rooster.jpg"
                        ),
                        2 => array(
                            'name' => "Dog",
                            'image' => "img/dog.jpg"
                        ),
                        3 => array(
                            'name' => "Pig",
                            'image' => "img/pig.jpg"
                        ),
                        4 => array(
                            'name' => "Rat",
                            'image' => "img/rat.jpg"
                        ),
                        5 => array(
                            'name' => "Ox",
                            'image' => "img/ox.jpg"
                        ),
                        6 => array(
                            'name' => "Tiger",
                            'image' => "img/tiger.jpg"
                        ),
                        7 => array(
                            'name' => "Rabbit",
                            'image' => "img/rabbit.jpg"
                        ),
                        8 => array(
                            'name' => "Dragon",
                            'image' => "img/dragon.jpg"
                        ),
                        9 => array(
                            'name' => "Snake",
                            'image' => "img/snake.jpg"
                        ),
                        10 => array(
                            'name' => "Horse",
                            'image' => "img/horse.jpg"
                        ),
                        11 => array(
                            'name' => "Sheep",
                            'image' => "img/goat.jpg"
                        )
                    );
                    $zodiacIndex = ($year) % 12;

                    $zodiacName = $zodiacSigns[$zodiacIndex]['name'];
                    $zodiacImage = $zodiacSigns[$zodiacIndex]['image'];
                    // Calculate the Star Zodiac sign
                    $starZodiacSigns = array(
                        'Aquarius' => 'img/aquarius.jpg',
                        'Pisces' => 'img/pisces.jpg',
                        'Aries' => 'img/aries.jpg',
                        'Taurus' => 'img/taurus.jpg',
                        'Gemini' => 'img/gemini.jpg',
                        'Cancer' => 'img/cancer.jpg',
                        'Leo' => 'img/leo.jpg',
                        'Virgo' => 'img/virgo.jpg',
                        'Libra' => 'img/libra.jpg',
                        'Scorpio' => 'img/scorpio.jpg',
                        'Sagittarius' => 'img/sagittarius.jpg',
                        'Capricorn' => 'img/capricorn.jpg'
                    );
                    $starZodiacName = '';
                    $starZodiacImage = '';


                    if (($birthMonth == 1 && $birthDay >= 20) || ($birthMonth == 2 && $birthDay <= 18)) {
                        $starZodiacName = 'Aquarius';
                    } elseif (($birthMonth == 2 && $birthDay >= 19) || ($birthMonth == 3 && $birthDay <= 20)) {
                        $starZodiacName = 'Pisces';
                    } elseif (($birthMonth == 3 && $birthDay >= 21) || ($birthMonth == 4 && $birthDay <= 19)) {
                        $starZodiacName = 'Aries';
                    } elseif (($birthMonth == 4 && $birthDay >= 20) || ($birthMonth == 5 && $birthDay <= 20)) {
                        $starZodiacName = 'Taurus';
                    } elseif (($birthMonth == 5 && $birthDay >= 21) || ($birthMonth == 6 && $birthDay <= 20)) {
                        $starZodiacName = 'Gemini';
                    } elseif (($birthMonth == 6 && $birthDay >= 21) || ($birthMonth == 7 && $birthDay <= 22)) {
                        $starZodiacName = 'Cancer';
                    } elseif (($birthMonth == 7 && $birthDay >= 23) || ($birthMonth == 8 && $birthDay <= 22)) {
                        $starZodiacName = 'Leo';
                    } elseif (($birthMonth == 8 && $birthDay >= 23) || ($birthMonth == 9 && $birthDay <= 22)) {
                        $starZodiacName = 'Virgo';
                    } elseif (($birthMonth == 9 && $birthDay >= 23) || ($birthMonth == 10 && $birthDay <= 22)) {
                        $starZodiacName = 'Libra';
                    } elseif (($birthMonth == 10 && $birthDay >= 23) || ($birthMonth == 11 && $birthDay <= 21)) {
                        $starZodiacName = 'Scorpio';
                    } elseif (($birthMonth == 11 && $birthDay >= 22) || ($birthMonth == 12 && $birthDay <= 21)) {
                        $starZodiacName = 'Sagittarius';
                    } elseif (($birthMonth == 12 && $birthDay >= 22) || ($birthMonth == 1 && $birthDay <= 19)) {
                        $starZodiacName = 'Capricorn';
                    }
                    $starZodiacImage = $starZodiacSigns[$starZodiacName];

                    $states = [
                        "01" => ["name" => "Johor", "flag" => "img/johor_bahru.jpg"],
                        "02" => ["name" => "Kedah", "flag" => "img/kedah.jpg"],
                        "03" => ["name" => "Kelantan", "flag" => "img/kelantan.jpg"],
                        "04" => ["name" => "Melaka", "flag" => "img/melaka_flag.jpg"],
                        "05" => ["name" => "Negeri Sembilan", "flag" => "img/Negeri_Sembilan.jpg"],
                        "06" => ["name" => "Pahang", "flag" => "img/pahang.jpg"],
                        "07" => ["name" => "Pulau Pinang", "flag" => "img/penang.jpg"],
                        "08" => ["name" => "Perak", "flag" => "img/perak.jpg"],
                        "09" => ["name" => "Perlis", "flag" => "img/perlis.jpg"],
                        "10" => ["name" => "Selangor", "flag" => "img/selangor.jpg"],
                        "11" => ["name" => "Terengganu", "flag" => "img/terengganu.jpg"],
                        "12" => ["name" => "Sabah", "flag" => "simg/sabah.jpg"],
                        "13" => ["name" => "Sarawak", "flag" => "img/sarawak_flag.jpg"],
                        "14" => ["name" => "Wilayah Persekutuan Kuala Lumpur", "flag" => "img/kuala_lumpur.jpg"],
                        "15" => ["name" => "Wilayah Persekutuan Labuan", "flag" => "img/labuan.jpg"],
                        "16" => ["name" => "Wilayah Persekutuan Putrajaya", "flag" => "img/putrajaya.jpg"],
                        "21" => ["name" => "Johor", "flag" => "img/johor_bahru.jpg"],
                        "22" => ["name" => "Johor", "flag" => "img/johor_bahru.jpg"],
                        "23" => ["name" => "Johor", "flag" => "img/johor_bahru.jpg"],
                        "24" => ["name" => "Johor", "flag" => "img/johor_bahru.jpg"],
                        "25" => ["name" => "Kedah", "flag" => "img/kedah.jpg"],
                        "26" => ["name" => "Kedah", "flag" => "img/kedah.jpg"],
                        "27" => ["name" => "Kedah", "flag" => "img/kedah.jpg"],
                        "28" => ["name" => "Kelantan", "flag" => "img/kelantan.jpg"],
                        "29" => ["name" => "Kelantan", "flag" => "img/kelantan.jpg"],
                        "30" => ["name" => "Melaka", "flag" => "img/melaka_flag.jpg"],
                        "31" => ["name" => "Negeri Sembilan", "flag" => "img/Negeri_Sembilan.jpg"],
                        "32" => ["name" => "Pahang", "flag" => "img/pahang.jpg"],
                        "33" => ["name" => "Pahang", "flag" => "img/pahang.jpg"],
                        "34" => ["name" => "Pulau Pinang", "flag" => "img/penang.jpg"],
                        "35" => ["name" => "Pulau Pinang", "flag" => "img/penang.jpg"],
                        "36" => ["name" => "Perak", "flag" => "img/perak.jpg"],
                        "37" => ["name" => "Perak", "flag" => "img/perak.jpg"],
                        "38" => ["name" => "Perak", "flag" => "img/perak.jpg"],
                        "39" => ["name" => "Perak", "flag" => "img/perak.jpg"],
                        "40" => ["name" => "Perlis", "flag" => "img/perlis.jpg"],
                        "41" => ["name" => "Selangor", "flag" => "img/selangor.jpg"],
                        "42" => ["name" => "Selangor", "flag" => "img/selangor.jpg"],
                        "43" => ["name" => "Selangor", "flag" => "img/selangor.jpg"],
                        "44" => ["name" => "Selangor", "flag" => "img/selangor.jpg"],
                        "45" => ["name" => "Terengganu", "flag" => "img/terengganu.jpg"],
                        "46" => ["name" => "Terengganu", "flag" => "img/terengganu.jpg"],
                        "47" => ["name" => "Sabah", "flag" => "simg/sabah.jpg"],
                        "48" => ["name" => "Sabah", "flag" => "simg/sabah.jpg"],
                        "49" => ["name" => "Sabah", "flag" => "simg/sabah.jpg"],
                        "50" => ["name" => "Sarawak", "flag" => "img/sarawak_flag.jpg"],
                        "51" => ["name" => "Sarawak", "flag" => "img/sarawak_flag.jpg"],
                        "52" => ["name" => "Sarawak", "flag" => "img/sarawak_flag.jpg"],
                        "53" => ["name" => "Sarawak", "flag" => "img/sarawak_flag.jpg"],
                        "54" => ["name" => "Wilayah Persekutuan Kuala Lumpur", "flag" => "img/kuala_lumpur.jpg"],
                        "55" => ["name" => "Wilayah Persekutuan Kuala Lumpur", "flag" => "img/kuala_lumpur.jpg"],
                        "56" => ["name" => "Wilayah Persekutuan Kuala Lumpur", "flag" => "img/kuala_lumpur.jpg"],
                        "57" => ["name" => "Wilayah Persekutuan Kuala Lumpur", "flag" => "img/kuala_lumpur.jpg"],
                        "58" => ["name" => "Wilayah Persekutuan Labuan", "flag" => "img/labuan.jpg"],
                        "59" => ["name" => "Negeri Sembilan", "flag" => "img/Negeri_Sembilan.jpg"],
                    ];

                    if (isset($states[$stateCode])) {
                        $stateName = $states[$stateCode]["name"];
                        $stateFlag = $states[$stateCode]["flag"];
                    } else {
                        $stateName = "Not found";
                        $stateFlag = "";
                    }

                    // Display the IC number, formatted date of birth, and Zodiac sign

                    echo "IC Number: $icNumber<br>";

                    echo "Date of Birth: " . $month[$imonth] . " " . $birthDay . ", " . $year . "<br>";

                    echo "Chinese Zodiac Sign: $zodiacName<br>";
                    echo "<img src='$zodiacImage' alt='$zodiacName' width=10%'><br>";

                    echo "Star Zodiac Sign: $starZodiacName<br>";
                    echo "<img src='$starZodiacImage' alt='$starZodiacName' width='10%'><br>";

                    echo "<br>Place of Birth: $stateName<br>";
                    echo "<img src='$stateFlag' width='10%'><br><br>";
                } else {
                    echo "Invalid date of birth.";
                }
            } else {
                echo "Invalid IC number.";
            }
        }
        ?>
    </div>

</body>

</html>