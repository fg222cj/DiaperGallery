<?php
/**
 * Created by PhpStorm.
 * User: Foss
 * Date: 2015-07-19
 * Time: 19:31
 */
require_once("src/repository.php");
require_once("src/image.php");

class ImageRepository extends Repository{
    public function add(Image $image) {
        $db = $this->connection();

        $sql = "INSERT IGNORE INTO " . DBIMAGETABLE . " (" . DBIMAGETABLEURL . ", " . DBIMAGETABLEURLTHUMBNAIL . ") VALUES (?, ?)";
        $params = array($image->getUrl(), $image->getUrlThumbnail());

        $query = $db->prepare($sql);
        $query->execute($params);

        return $db->lastInsertId();
    }

    public function getAllFromDb() {
        $db = $this->connection();

        $sql = "SELECT * FROM " . DBIMAGETABLE;

        $query = $db->prepare($sql);
        $query->execute();

        $result = $query->fetchAll();
        $images = array();

        foreach($result as $row) {
            $image = new Image($row[DBIMAGETABLEID], $row[DBIMAGETABLEURL], $row[DBIMAGETABLEURLTHUMBNAIL]);
            $images[] = $image;
        }

        return $images;
    }

    public function getById($id) {
        $db = $this->connection();

        $sql = "SELECT * FROM " . DBIMAGETABLE . " WHERE " . DBIMAGETABLEID . " = ?";
        $params = array($id);

        $query = $db->prepare($sql);
        $query->execute($params);

        $result = $query->fetch();

        if ($result) {
            $image = new Image($result[DBIMAGETABLEID], $result[DBIMAGETABLEURL], $result[DBIMAGETABLEURLTHUMBNAIL]);
            return $image;
        }

        // If we didn't get a result we throw an exception instead
        throw new PDOException();
    }

    public function saveOnServer($image, $name) {
        $targetDir = IMAGEDIAPERPATH;
        $imagePath = $targetDir . $this->createFilename(basename($image["name"]), $name);
        $thumbnailPath = $targetDir . $this->createFilename($imagePath, $name, true);

        if (move_uploaded_file($image["tmp_name"], $imagePath)) {
            $this->createThumbnail($imagePath, $thumbnailPath);
            return new Image(0, $imagePath, $thumbnailPath);
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }

    public function createThumbnail($imagePath, $thumbnailPath) {
        if(preg_match('/[.](jpg)$/', $imagePath)) {
            $im = imagecreatefromjpeg($imagePath);
        } else if (preg_match('/[.](gif)$/', $imagePath)) {
            $im = imagecreatefromgif($imagePath);
        } else if (preg_match('/[.](png)$/', $imagePath)) {
            $im = imagecreatefrompng($imagePath);
        }

        $ox = imagesx($im);
        $oy = imagesy($im);

        $nx = IMAGETHUMBNAILWIDTH;
        $ny = floor($oy * (IMAGETHUMBNAILWIDTH / $ox));

        $nm = imagecreatetruecolor($nx, $ny);

        imagecopyresized($nm, $im, 0,0,0,0,$nx,$ny,$ox,$oy);

        imagejpeg($nm, $thumbnailPath);
    }

    public function createFilename($path, $name, $isThumbnail = false) {
        $filename = pathinfo($path, PATHINFO_FILENAME);
        $extension = pathinfo($path, PATHINFO_EXTENSION);

        $cleanName = str_replace(" ", "_", $name);
        $cleanName = strtolower($cleanName);
        $cleanName = preg_replace("/[^a-z0-9_]/", '', $cleanName);

        $filepath = $cleanName . "." . $extension;
        $i = 0;
        while(file_exists(IMAGEDIAPERPATH . $filepath)) {
            $filepath = $cleanName . "_" . $i++ . "." . $extension;
        }

        if($isThumbnail) {
            $filepath = $filename . ".thumb." . $extension;
        }
        return $filepath;
    }
}