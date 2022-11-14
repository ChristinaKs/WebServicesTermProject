<?php

use GuzzleHttp\Client;
require __DIR__ . '/vendor/autoload.php';

$client = new GuzzleHttp\Client(['base_uri' => 'https://anapioficeandfire.com/api/']);

$response = $client->request('GET', 'books');

$data = $response->getBody()->getContents();

function parseBooks($data) {
    $tbs = "<table class='table table-striped'> <thead> <tr> <th>Type</th> <th>Name</th> <th>ISBN</th> <th>Publisher</th> </tr> </thead>";
    $booksData = json_decode($data);
    foreach ($booksData as $key => $book) {
        $tbs .= "<tr>";
        $tbs .= "<td>" . $book->mediaType . "</td>";
        $tbs .= "<td>" . $book->name . "</td>";
        $tbs .= "<td>" . $book->isbn . "</td>";
        $tbs .= "<td>" . $book->publisher . "</td>";
        $tbs .= "</tr>";
    }
    $tbs .= "</table>";
    echo $tbs;
}
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Music API Client</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
  </head>
  <body>
    <div class="container">
        <h1>Music API Client</h1>
        <hr />
        <h2>Tracks</h2>
        <div id="tracksResult">
            <h3>Tracklist</h3>
            <div id="tracklist">
                <?php
                    parseBooks($data);
                ?>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
  </body>
</html>
