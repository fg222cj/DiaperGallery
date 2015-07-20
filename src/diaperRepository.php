<?php
/**
 * Created by PhpStorm.
 * User: Foss
 * Date: 2015-07-19
 * Time: 18:36
 */
require_once("src/repository.php");
require_once("src/diaper.php");
require_once("src/imageRepository.php");

class DiaperRepository extends Repository {
    private $imageRepository;

    public function __construct() {
        $this->imageRepository = new ImageRepository();
    }

    public function add(Diaper $diaper, $image = null) {
        $db = $this->connection();

        $image;
        if(isset($image)) {
            $diaper->setImage($this->imageRepository->saveOnServer($image, $diaper->getName()));
            $imageId = $this->imageRepository->add($diaper->getImage());
            $diaper->getImage()->setId($imageId);
        }

        $sql = "INSERT IGNORE INTO " . DBDIAPERTABLE . " (" . DBDIAPERTABLENAME . ", " . DBDIAPERTABLEYEAR . ",
         " . DBDIAPERTABLERARITY . ", " . DBDIAPERTABLEIMAGE . ") VALUES (?, ?, ?, ?)";
        $params = array($diaper->getName(), $diaper->getYear(), $diaper->getRarity(), $diaper->getImage()->getId());

        $query = $db->prepare($sql);
        $query->execute($params);
    }

    public function getAllFromDb() {
        $db = $this->connection();

        $sql = "SELECT * FROM " . DBDIAPERTABLE;

        $query = $db->prepare($sql);
        $query->execute();

        $result = $query->fetchAll();
        $diapers = array();

        foreach($result as $row) {
            $image = $this->imageRepository->getById($row[DBDIAPERTABLEIMAGE]);
            $diaper = new Diaper($row[DBDIAPERTABLEID], $row[DBDIAPERTABLENAME], $row[DBDIAPERTABLEYEAR], $row[DBDIAPERTABLERARITY], $image);
            $diapers[] = $diaper;
        }

        return $diapers;
    }
}