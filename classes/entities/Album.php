<?php

namespace Deezer\Entity;

/**
 * Class definittion of an album
 * @author Romain Fockking
 */
class Album
{
    /**
     * @var string
     */
    private $icpn;

    /**
     * @var string
     */
    private $grid;

    /**
     * @var string
     */
    private $genre;

    /**
     * @var string
     */
    private $artist;

    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $label;

    /**
     * Album constructor.
     * @param string $icpn
     * @param string $grid
     * @param string $genre
     * @param string $artist
     * @param string $title
     * @param string $label
     */
    public function __construct($icpn, $grid, $genre, $artist, $title, $label)
    {
        $this->icpn = $icpn;
        $this->grid = $grid;
        $this->genre = $genre;
        $this->artist = $artist;
        $this->title = $title;
        $this->label = $label;
    }


    /**
     * @return mixed
     */
    public function getIcpn()
    {
        return $this->icpn;
    }

    /**
     * @param mixed $icpn
     */
    public function setIcpn($icpn)
    {
        $this->icpn = $icpn;
    }

    /**
     * @return mixed
     */
    public function getGrid()
    {
        return $this->grid;
    }

    /**
     * @param mixed $grid
     */
    public function setGrid($grid)
    {
        $this->grid = $grid;
    }

    /**
     * @return mixed
     */
    public function getGenre()
    {
        return $this->genre;
    }

    /**
     * @param mixed $genre
     */
    public function setGenre($genre)
    {
        $this->genre = $genre;
    }

    /**
     * @return mixed
     */
    public function getArtist()
    {
        return $this->artist;
    }

    /**
     * @param mixed $artist
     */
    public function setArtist($artist)
    {
        $this->artist = $artist;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return mixed
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * @param mixed $label
     */
    public function setLabel($label)
    {
        $this->label = $label;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return sprintf("Album  %s - label : %s - artist : %s - genre : %s - icpn : %s - grid : %s \n",
            $this->getTitle(),
            $this->getLabel(),
            $this->getArtist(),
            $this->getGenre(),
            $this->getIcpn(),
            $this->getGrid()
        );
    }

}

