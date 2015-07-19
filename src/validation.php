<?php
/**
 * Created by PhpStorm.
 * User: Foss
 * Date: 2015-07-19
 * Time: 20:07
 */

class Validation {
    public function validateUploadedImage($image) {
        $target_dir = IMAGEDIAPERPATH;
        $target_file = $target_dir . basename($image["name"]);

        $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);

        // Check if image file is a actual image or fake image
        $check = getimagesize($image["tmp_name"]);
        if($check !== false) {
            echo "File is an image - " . $check["mime"] . ".";
        } else {
            echo "File is not an image.";
            return false;
        }

        // Check if file already exists
        if (file_exists($target_file)) {
            echo "Sorry, file already exists.";
            return false;
        }

        // Check file size
        if ($image["size"] > 500000) {
            echo "Sorry, your file is too large.";
            return false;
        }

        // Allow certain file formats
        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
            && $imageFileType != "gif" ) {
            echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            return false;
        }

        // If all checks passed we return true
        return true;
    }
}