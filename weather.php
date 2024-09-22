<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Weather Forecast</title>
    <link rel="stylesheet" href="forecast.css">
</head>
<body style="background-image: url('weather.jpg'); background-repeat: no-repeat; background-size: cover;">


<h1>Weather Forecast</h1>

<form method="post">
    <label for="city">Enter your city:</label>
    <input type="text" id="city" name="city" value="<?php echo isset($_POST['city']) ? htmlspecialchars($_POST['city']) : ''; ?>" required><br><br>
    <?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $apiKey = "6ac3ad55a10cf3a9ff4c5409971ee30d";
    $city = htmlspecialchars($_POST['city']);
    $apiUrl = "http://api.openweathermap.org/data/2.5/weather?q=$city&appid=$apiKey&units=metric";

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $apiUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $response = curl_exec($ch);
    curl_close($ch);

    if ($response === FALSE) {
        die('Error occurred');
    }

    $data = json_decode($response, true);

    if ($data['cod'] != 200) {
        echo "<script>alert('City not found');</script>";
        exit();
    }

    $temperature = $data['main']['temp'];
    $weather = $data['weather'][0]['description'];
    $humidity = $data['main']['humidity'];
    $windSpeed = $data['wind']['speed'];

    echo "<table>";
    echo "<tr><th colspan='2'>Weather in $city</th></tr>";
    echo "<tr><td>Temperature:</td><td>" . $temperature . "°C</td></tr>";
    echo "<tr><td>Weather:</td><td>" . ucfirst($weather) . "</td></tr>";
    echo "<tr><td>Humidity:</td><td>" . $humidity . "%</td></tr>";
    echo "<tr><td>Wind Speed:</td><td>" . $windSpeed . " m/s</td></tr>";
}