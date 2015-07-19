<?php
/**
 * Created by PhpStorm.
 * User: Foss
 * Date: 2015-07-19
 * Time: 18:14
 */

define("DBHOST", "localhost");
define("DBDATABASE", "diapergallery");
define("DBUSERNAME", "diaperadmin");
define("DBPASSWORD", "sShffTZtZBBG83VE");
define("DBCONNECTION", "mysql:host=" . DBHOST . ";dbname=" . DBDATABASE . ";charset=utf8");

define("DBDIAPERTABLE", "diapers");
define("DBDIAPERTABLEID", "id");
define("DBDIAPERTABLENAME", "name");
define("DBDIAPERTABLEYEAR", "year");
define("DBDIAPERTABLERARITY", "rarity");
define("DBDIAPERTABLEIMAGE", "image");

define("DBIMAGETABLE", "images");
define("DBIMAGETABLEID", "id");
define("DBIMAGETABLEURL", "url");
define("DBIMAGETABLEURLTHUMBNAIL", "url_thumbnail");

define("IMAGEDIAPERPATH", "images/diapers/");

define("IMAGETHUMBNAILWIDTH", "100");
?>