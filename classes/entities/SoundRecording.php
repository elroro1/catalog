<?php
namespace Deezer\Entity;

/**
 * Class definition of an SounfRecording
 * @author Romain Fockking
 */
class SoundRecording
{

    /**
     * @var string
     */
    private $iscr;

    /**
     * @var string
     */
    private $duration;

    /**
     * SoundRecording constructor.
     * @param string $iscr
     * @param string $duration
     */
    public function __construct($iscr, $duration)
    {
        $this->iscr = $iscr;
        $this->duration = $duration;
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
    public function getDuration()
    {
        return $this->duration;
    }

    /**
     * @param string $duration
     */
    public function setDuration($duration)
    {
        $this->duration = $duration;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return sprintf("SoundRecording - ISCR : %s - duration : %s \n",
            $this->getIscr(),
            $this->getDuration()
        );
    }
}

