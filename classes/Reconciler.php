<?php

namespace Deezer\Utils;
use Deezer\Entity\Album;
use Deezer\Entity\Deal;
use Deezer\Entity\SoundRecording;
use Deezer\Entity\SoundTrack;

require_once 'Repository.php';
require_once 'entities/Album.php';
require_once 'entities/SoundRecording.php';
require_once 'entities/SoundTrack.php';
require_once 'entities/Deal.php';


/**
 * Class Reconciler , used to handle entities founded by parser and proccess their persistence in DB
 * @author Romain Fockking
 */
class Reconciler
{
    /**
     * @param array $data
     */
    public function processData(array $data){
        $albums = $data['albums'];
        $soundTracks = $data['soundTracks'];
        $soundRecordings = $data['soundRecordings'];
        $deals = $data['deals'];

        $this->processAlbum($albums);
        $this->processSoundTracks($soundTracks, $soundRecordings);
        $this->processDeals($deals);

    }

    /**
     * @param array $albums
     */
    public function processAlbum(array $albums){
        foreach ($albums as  $album){
            /** @var  $album Album */
            $repository = new Repository();
            $data = $repository->checkIfAlbumExist($album);
            $repository->persistAlbum($album, $data);

        }
    }

    /**
     * @param array $soundTracks
     * @param array $soundRecordings
     */
    public function processSoundTracks(array $soundTracks, array $soundRecordings){
        foreach ($soundTracks as  $soundTrack){
            /** @var  $soundTrack SoundTrack */
            foreach ($soundRecordings as $soundRecording){
                /** @var  $soundRecording SoundRecording */
                if($soundRecording->getIscr() == $soundTrack->getIscr()){
                    $soundTrack->setDuration($soundRecording->getDuration());
                    break;
                }
            }

            $repository = new Repository();
            $data = $repository->checkIfSoundtrackExist($soundTrack);
            $repository->persistSoundtrack($soundTrack, $data);

        }
    }


    /**
     * @param array $deals
     */
    public function processDeals(array $deals){
        foreach ($deals as  $deal){
            /** @var  $deal Deal */
            $repository = new Repository();
            $repository->deleteIfDealExist($deal);
            if ($dealId = $repository->persistDeal($deal)){
                $deal->setId($dealId);
                $repository->persistDealDate($deal);
                $repository->persistDealUsage($deal);

            }

        }
    }

}

