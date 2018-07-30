<?php

namespace Deezer\Utils;
use Deezer\Entity\Album;
use Deezer\Entity\Deal;
use Deezer\Entity\DealDate;
use Deezer\Entity\DealUsage;
use Deezer\Entity\SoundRecording;
use Deezer\Entity\SoundTrack;

require_once 'entities/Album.php';
require_once 'entities/SoundRecording.php';
require_once 'entities/SoundTrack.php';
require_once 'entities/Deal.php';
require_once 'entities/DealDate.php';
require_once 'entities/DealUsage.php';

/**
 * Class ParserXMLDDEX341 , used to Parse XML DDEX 3.4.1 files
 * @author Romain Fockking
 */
class ParserXMLDDEX341 implements ParserInterface
{

    /**
     * @param $file
     */
    public function parse($file){
        try {
            if (file_exists($file)) {
                $xml = simplexml_load_file($file);
                $albums = $this->findAlbums($xml);
                $soundRecordings = $this->findSoundRecordings($xml);
                $soundTrack = $this->findSoundTracks($xml);
                $deals = $this->findDeals($xml);
                return array(
                    'albums' => $albums,
                    'soundTracks' => $soundTrack,
                    'soundRecordings' => $soundRecordings,
                    'deals' => $deals,
                );
            } else {
                exit(sprintf('Echec lors de l\'ouverture du fichier %s', $file));
            }
        }
        catch (\Exception $e){
            exit(sprintf('Error during parsing of  %s', $file ));
        }
    }

    /**
     * @param \SimpleXMLElement $xml
     * @return array
     */
    public function findAlbums(\SimpleXMLElement $xml){
        $albums = array();
        $xmlAlbum = $xml->xpath("//ReleaseList/Release[ReleaseType='Album']");
        foreach ($xmlAlbum as $album){
            $icpn = trim($album->xpath('./ReleaseId/ICPN')[0]);
            $grid = trim($album->xpath('./ReleaseId/GRid')[0]);
            $genre = trim($album->xpath('./ReleaseDetailsByTerritory/Genre/GenreText')[0]);
            $artist = trim($album->xpath('./ReleaseDetailsByTerritory/DisplayArtist/PartyName/FullName')[0]);
            $title = trim($album->xpath('./ReferenceTitle/TitleText')[0]);
            $label = trim($album->xpath('./ReleaseDetailsByTerritory/LabelName')[0]);
            $album = new Album($icpn, $grid, $genre, $artist, $title, $label);

            echo(sprintf("ALBUM %s founded \n", $album->getTitle() ));
            $albums[] = $album;

        }
        return $albums;
    }

    /**
     * @param \SimpleXMLElement $xml
     */
    public function findSoundTracks(\SimpleXMLElement $xml){
        $xmlSoundTrack = $xml->xpath("//ReleaseList/Release[ReleaseType='TrackRelease']");
        $soundTracks = array();

        foreach ($xmlSoundTrack as $soundTrack){

            $numberTrack = trim($soundTrack->xpath('./ReleaseResourceReferenceList/ReleaseResourceReference')[0]);
            $albumNumberTracks = $xml->xpath("//ReleaseList/Release[ReleaseType='Album']/ReleaseResourceReferenceList/ReleaseResourceReference");

            foreach($albumNumberTracks as $albumNumberTrack){
                if((string)$albumNumberTrack === (string) $numberTrack){
                    $icpnAlbum = $albumNumberTrack->xpath("./../../ReleaseId/ICPN")[0];
                    break;
                }

            }

            $title = trim($soundTrack->xpath('./ReferenceTitle/TitleText')[0]);
            $iscr = trim($soundTrack->xpath('./ReleaseId/ISRC')[0]);
            $artist = trim($soundTrack->xpath('./ReleaseDetailsByTerritory/DisplayArtistName')[0]);
            $genre = trim($soundTrack->xpath('./ReleaseDetailsByTerritory/Genre/GenreText')[0]);
            $label = trim($soundTrack->xpath('./ReleaseDetailsByTerritory/LabelName')[0]);
            $soundTrack = new SoundTrack($title, $iscr, $artist, $genre, $label, $icpnAlbum);
            $soundTracks[] = $soundTrack;
            echo(sprintf("Soundtrack %s founded \n", $soundTrack->getTitle() ));

        }
        return $soundTracks;

    }

    /**
     * @param \SimpleXMLElement $xml
     * @return array
     */
    public function findSoundRecordings(\SimpleXMLElement $xml){
        $xmlSoundRecording = $xml->xpath("//ResourceList/SoundRecording");
        $soundRecordings = array();

        foreach ($xmlSoundRecording as $soundRecording) {
            $iscr = trim($soundRecording->xpath('./SoundRecordingId/ISRC')[0]);
            $duration = trim($soundRecording->xpath('./Duration')[0]);
            $soundRecording = new SoundRecording($iscr, (string) $duration);
            $soundRecordings[] = $soundRecording;
            echo(sprintf("SoundRecording %s founded \n", $soundRecording->getIscr() ));

        }
        return $soundRecordings;
    }

    /**
     * @param \SimpleXMLElement $xml
     * @return array
     */
    public function findDeals(\SimpleXMLElement $xml){
        $xmlDeal = $xml->xpath("//DealList/ReleaseDeal");
        $deals = array();

        foreach ($xmlDeal as $xmlReleaseDeal) {
            $isrcSoundtrack= '';
            $icpnAlbum= '';
            $dealReference = $xmlReleaseDeal->xpath('./DealReleaseReference')[0];
            $dealsXml = $xmlReleaseDeal->xpath('./Deal');
            $xmlAlbum = $xml->xpath("//ReleaseList/Release[ReleaseType='Album']/ReleaseReference");

            foreach ($xmlAlbum as $albumReference) {
                if((string)$dealReference === (string) $albumReference){
                    $icpnAlbum = trim($albumReference->xpath("./../ReleaseId/ICPN")[0]);
                    break;
                }
            }

            $xmlSoundTrack = $xml->xpath("//ReleaseList/Release[ReleaseType='TrackRelease']/ReleaseReference");
            foreach ($xmlSoundTrack as $soundTrack) {
                if((string)$dealReference === (string) $soundTrack){
                    $isrcSoundtrack = trim($soundTrack->xpath("./../ReleaseId/ISRC")[0]);
                    break;
                }
            }

            foreach ($dealsXml as $deal) {
                $model = $deal->xpath('./DealTerms/CommercialModelType')[0];
                $country = $deal->xpath('./DealTerms/TerritoryCode')[0];

                $usages = array();
                foreach ($deal as $usageXml) {
                    $usage = $usageXml->xpath('./Usage/UseType')[0];
                    $usageString = (string)$usage;
                    $usageEntity = new DealUsage($usageString);
                    $usages[] = $usageEntity;
                }

                $dates = array();
                foreach ($deal->xpath('./DealTerms/ValidityPeriod') as $dateXml) {
                    $date = array_values((array)$dateXml);
                    $type = array_keys((array)$dateXml)[0];
                    $dateEntity = new DealDate($date[0], $type);
                    $dates[] = $dateEntity;
                }

                $dealEntity = new Deal($model, $usages, $dates, $country, $icpnAlbum, $isrcSoundtrack);
                $deals[] = $dealEntity;
            }

        }
        return $deals;
    }
}

