<?php

namespace Deezer\Entity;

/**
 * Class definittion of an SoundTrack
 * @author Romain Fockking
 */
class SoundTrack
{

    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $icpnAlbum;

    /**
     * @var string
     */
    private $iscr;

    /**
     * @var string
     */
    private $artist;

    /**
     * @var integer
     */
    private $duration;

    /**
     * @var string
     */
    private $genre;

    /**
     * @var string
     */
    private $label;

    /**
     * @var \DateTime
     */
    private $dateInsert;

    /**
     * @var \DateTime
     */
    private $dateUpdate;

    /**
     * @var array
     */
    private $deal;

    /**
     * SoundTrack constructor.
     * @param $title
     * @param $iscr
     * @param $artist
     * @param $genre
     * @param $label
     * @param $icpnAlbum
     */
    public function __construct( $title, $iscr, $artist, $genre, $label, $icpnAlbum)
    {
        $this->icpnAlbum = $icpnAlbum;
        $this->title = $title;
        $this->iscr = $iscr;
        $this->artist = $artist;
        $this->genre = $genre;
        $this->label = $label;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getIscr()
    {
        return $this->iscr;
    }

    /**
     * @param string $iscr
     */
    public function setIscr($iscr)
    {
        $this->iscr = $iscr;
    }

    /**
     * @return string
     */
    public function getArtist()
    {
        return $this->artist;
    }

    /**
     * @param string $artist
     */
    public function setArtist($artist)
    {
        $this->artist = $artist;
    }

    /**
     * @return int
     */
    public function getDuration()
    {
        return $this->duration;
    }

    /**
     * @param int $duration
     */
    public function setDuration($duration)
    {
        $this->duration = $duration;
    }

    /**
     * @return string
     */
    public function getGenre()
    {
        return $this->genre;
    }

    /**
     * @param string $genre
     */
    public function setGenre($genre)
    {
        $this->genre = $genre;
    }

    /**
     * @return string
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * @param string $label
     */
    public function setLabel($label)
    {
        $this->label = $label;
    }

    /**
     * @return \DateTime
     */
    public function getDateInsert()
    {
        return $this->dateInsert;
    }

    /**
     * @param \DateTime $dateInsert
     */
    public function setDateInsert($dateInsert)
    {
        $this->dateInsert = $dateInsert;
    }

    /**
     * @return \DateTime
     */
    public function getDateUpdate()
    {
        return $this->dateUpdate;
    }

    /**
     * @param \DateTime $dateUpdate
     */
    public function setDateUpdate($dateUpdate)
    {
        $this->dateUpdate = $dateUpdate;
    }

    /**
     * @return mixed
     */
    public function getDeal()
    {
        return $this->deal;
    }

    /**
     * @param mixed $deal
     */
    public function setDeal($deal)
    {
        $this->deal = $deal;
    }

    /**
     * @return string
     */
    public function getIcpnAlbum()
    {
        return $this->icpnAlbum;
    }

    /**
     * @param string $icpnAlbum
     */
    public function setIcpnAlbum($icpnAlbum)
    {
        $this->icpnAlbum = $icpnAlbum;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return sprintf("Soundtrack  %s - label : %s - artist : %s - genre : %s - iscr : %s - icpnAlbum : %s \n",
            $this->getTitle(),
            $this->getLabel(),
            $this->getArtist(),
            $this->getGenre(),
            $this->getIscr(),
            $this->getIcpnAlbum()
        );
    }

}

