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
foreach($diapers as $diaper) {
    echo "  <div>
            <h3>" . $diaper->getName() . "</h3>
            <img src='" . $diaper->getImage()->getUrlThumbnail() . "' />
            </div>";
}
?>

</body>
</html>