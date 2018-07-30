<?php

namespace Deezer\Entity;

/**
 * Class definition of deal
 * @author Romain Fockking
 */
class DealDate
{

    /**
     * @var string
     */
    private $dealId;

    /**
     * @var string
     */
    private $date;

    /**
     * @var string
     */
    private $type;

    /**
     * DealDate constructor.
     * @param string $date
     * @param string $type
     */
    public function __construct($date, $type)
    {
        $this->date = $date;
        $this->type = $type;
    }

    /**
     * @return string
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param string $date
     */
    public function setDate($date)
    {
        $this->date = $date;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @return string
     */
    public function getDealId()
    {
        return $this->dealId;
    }

    /**
     * @param string $dealId
     */
    public function setDealId($dealId)
    {
        $this->dealId = $dealId;
    }



    /**
     * @return string
     */
    public function __toString()
    {
        return sprintf("DealDate for deal %s - type : %s - date : %s  \n",
            $this->getDealId(),
            $this->getType(),
            $this->getDate()
        );
    }

}

