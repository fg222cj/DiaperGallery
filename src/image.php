<?php
/**
 * Created by PhpStorm.
 * User: Foss
 * Date: 2015-07-19
 * Time: 19:19
 */

class Image {
    private $id;
    private $url;
    private $urlThumbnail;

    public function __construct($id = 0, $url, $urlThumbnail) {
        $this->id = $id;
        $this->url = $url;
        $this->urlThumbnail = $urlThumbnail;
    }

    public function getId() {
        return $this->id;
    }

    public function getUrl() {
        return $this->url;
    }

    public function getUrlThumbnail() {
        return $this->urlThumbnail;
    }

    public function setId($id) {
        $this->id = $id;
    }
}