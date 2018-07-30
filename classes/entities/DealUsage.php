<?php

namespace Deezer\Entity;

/**
 * Class definition of deal
 * @author Romain Fockking
 */
class DealUsage
{

    /**
     * @var string
     */
    private $dealId;

    /**
     * @var string
     */
    private $usageDeal;

    /**
     * DealUsage constructor.
     * @param array $usage
     */
    public function __construct($usageDeal)
    {
        $this->usageDeal = $usageDeal;
    }

    /**
     * @return string
     */
    public function getUsageDeal()
    {
        return $this->usageDeal;
    }

    /**
     * @param string $usage
     */
    public function setUsageDeal($usageDeal)
    {
        $this->usageDeal = $usageDeal;
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
        return sprintf("DealUsage for deal %s - usageDeal : %s  \n",
            $this->getDealId(),
            $this->getUsageDeal()
        );
    }


}

