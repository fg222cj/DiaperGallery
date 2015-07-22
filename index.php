<?php
/**
 * Created by PhpStorm.
 * User: Foss
 * Date: 2015-07-19
 * Time: 18:13
 */

// BUG: Kanske problem med windowsrättigheter. Ingenting händer när scriptet körs.

require_once("config.php");
require_once("src/gallery.php");

// Move below code to a fitting controller/model structure
require_once("src/diaperRepository.php");
$diaperRepository = new DiaperRepository();

if(isset($_POST) && isset($_POST['diaper_name']) && isset($_POST['diaper_year']) && isset($_POST['diaper_rarity']) && isset($_FILES['diaper_image'])) {
    $diaper = new Diaper(0, $_POST['diaper_name'], $_POST['diaper_year'], $_POST['diaper_rarity']);
    $diaperRepository->add($diaper, $_FILES['diaper_image']);
}
?>

<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>gDiapers</title>
    <script src="js/jquery-1.11.3.min.js"></script>
    <link rel="stylesheet" type="text/css" href="css/theme.css">
    <link href="js/lightbox2-master/dist/css/lightbox.css" rel="stylesheet">
</head>
<body>
<form enctype="multipart/form-data" action="" method="post">
    <label for="diaper_name">Namn: </label>
    <input type="text" id="diaper_name" name="diaper_name"/>
    <label for="diaper_year">År: </label>
    <input type="text" id="diaper_year" name="diaper_year"/>
    <label for="diaper_rarity">Sällsynthet: </label>
    <input type="text" id="diaper_rarity" name="diaper_rarity" />
    <label for="diaper_image">Bild:</label>
    <input type="file" id="diaper_image" name="diaper_image" />
    <input type="submit" />
</form>

<?php
$diapers = $diaperRepository->getAllFromDb();
usort($diapers, "cmp"); // Sort the array according to the compare function below

$diaperRarity = $diapers[0]->getRarity();

echo "<div class='rarity" . $diaperRarity . "'>";

foreach($diapers as $diaper) {
    if($diaperRarity !== $diaper->getRarity()) {
        $diaperRarity = $diaper->getRarity();
        echo "</div>";
        echo "<div class='rarity" . $diaperRarity . "'>";
    }

    echo "  <span>
            <h3>" . $diaper->getName() . "</h3>
            <a href='" . $diaper->getImage()->getUrl() . "' data-lightbox='diaper-image-set' data-title='" . $diaper->getName() . "'>
            <img src='" . $diaper->getImage()->getUrlThumbnail() . "' />
            </a>
            </span>";
    if($newRow) {

    }
    $newRow = false;
}
echo "</div>";

function cmp($diaperA, $diaperB) {
    return  $diaperB->getRarity() - $diaperA->getRarity();
}
?>
<script src="js/lightbox2-master/dist/js/lightbox.js"></script>
</body>
</html>