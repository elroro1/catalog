<?php

namespace Deezer\Entity;

/**
 * Class definition of deal
 * @author Romain Fockking
 */
class Deal
{
    private $id;

    /**
     * @var string
     */
    private $model;

    /**
     * @var array
     */
    private $usage;

    /**
     * @var array
     */
    private $date;

    /**
     * @var string
     */
    private $country;

    /**
     * @var string
     */
    private $icpnAlbum;

    /**
     * @var string
     */
    private $isrcSoundtrack;


    /**
     * Deal constructor.
     * @param string $type
     * @param array $usage
     * @param array $date
     * @param string $country
     */
    public function __construct($model, array $usage, array $date, $country, $icpnAlbum, $isrcSoundtrack)
    {
        $this->model = $model;
        $this->usage = $usage;
        $this->date = $date;
        $this->country = $country;
        $this->icpnAlbum = $icpnAlbum;
        $this->isrcSoundtrack = $isrcSoundtrack;
    }


    /**
     * @return string
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * @param string $model
     */
    public function setModel($model)
    {
        $this->model = $model;
    }

    /**
     * @return array
     */
    public function getUsage()
    {
        return $this->usage;
    }

    /**
     * @param array $usage
     */
    public function setUsage(array $usage)
    {
        $this->usage = $usage;
    }

    /**
     * @return array
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param array $date
     */
    public function setDate(array $date)
    {
        $this->date = $date;
    }


    /**
     * @return string
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * @param string $country
     */
    public function setCountry($country)
    {
        $this->country = $country;
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
    public function getIsrcSoundtrack()
    {
        return $this->isrcSoundtrack;
    }

    /**
     * @param string $isrcSoundtrack
     */
    public function setIsrcSoundtrack($isrcSoundtrack)
    {
        $this->isrcSoundtrack = $isrcSoundtrack;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return sprintf("Deal  %s - country : %s - model : %s - icpnAlbum : %s - isrcSoundtrack : %s \n",
            $this->getCountry(),
            $this->getModel(),
            $this->getIcpnAlbum(),
            $this->getIsrcSoundtrack()
        );
    }

}

