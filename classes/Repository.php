<?php

namespace Deezer\Utils;
use Deezer\Entity\Album;
use Deezer\Entity\Deal;
use Deezer\Entity\DealDate;
use Deezer\Entity\DealUsage;
use Deezer\Entity\SoundTrack;

require_once 'entities/Album.php';
require_once 'entities/SoundRecording.php';
require_once 'entities/SoundTrack.php';
require_once 'entities/Deal.php';
require_once 'entities/DealDate.php';
require_once 'entities/DealUsage.php';

/**
 * Class Repository , used to store SQL action to the DB
 * @author Romain Fockking
 */
class Repository
{

    const NO_DATA_FOUND = 0;
    const DATA_FOUND = 1;

    /**
     * @param Album $album
     */
    public function checkIfAlbumExist(Album $album)
    {
        $sql = sprintf(
            "SELECT * 
            FROM album 
            WHERE icpn = '%s'",
            $album->getIcpn()
        );
        return $this->executeSelectRequest($sql);
    }

    /**
     * @param Album $album
     * @param $data
     */
    public function persistAlbum(Album $album, $data)
    {
        $date = new \DateTime('now');
        if (count($data) === SELF::NO_DATA_FOUND) {
            $sql = sprintf(
                "INSERT INTO album
                (icpn, grid, genre, artist, title, label, date_insert)
                VALUES
                ('%s','%s','%s','%s','%s','%s','%s') ",
                $album->getIcpn(),
                $album->getGrid(),
                $album->getGenre(),
                $album->getArtist(),
                $album->getTitle(),
                $album->getLabel(),
                $date->format('Y-m-d h:m:s')
            );

            $this->executeRequest($sql);
        }
        else if (count($data) === SELF::DATA_FOUND){
            $sql = sprintf(
                "UPDATE album
                SET grid = '%s', genre = '%s', artist = '%s', title = '%s', label = '%s', date_update = '%s'
                WHERE icpn = '%s'",
                $album->getGrid(),
                $album->getGenre(),
                $album->getArtist(),
                $album->getTitle(),
                $album->getLabel(),
                $date->format('Y-m-d h:m:s'),
                $album->getIcpn()
            );

            $this->executeRequest($sql);
        }
    }

    /**
     * @param SoundTrack $soundTrack
     */
    public function checkIfSoundtrackExist(SoundTrack $soundTrack)
    {
        $sql = sprintf(
            "SELECT * 
            FROM soundtrack 
            WHERE iscr = '%s'",
            $soundTrack->getIscr()
        );
        return $this->executeSelectRequest($sql);
    }

    /**
     * @param SoundTrack $soundTrack
     * @param $data
     */
    public function persistSoundtrack(SoundTrack $soundTrack, $data)
    {
        $date = new \DateTime('now');
        if (count($data) === SELF::NO_DATA_FOUND) {
            $sql = sprintf(
                "INSERT INTO soundtrack
                (iscr, genre, artist, title, label, duration, icpn_album, date_insert)
                VALUES
                ('%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s') ",
                $soundTrack->getIscr(),
                $soundTrack->getGenre(),
                $soundTrack->getArtist(),
                $soundTrack->getTitle(),
                $soundTrack->getLabel(),
                $soundTrack->getDuration(),
                $soundTrack->getIcpnAlbum(),
                $date->format('Y-m-d h:m:s')
            );

            $this->executeRequest($sql);
        }
        else if (count($data) === SELF::DATA_FOUND){
            $sql = sprintf(
                "UPDATE soundtrack
                SET  genre = '%s', artist = '%s', title = '%s', label = '%s', duration = '%s',
                icpn_album = '%s', date_update = '%s'
                WHERE iscr = '%s'",
                $soundTrack->getGenre(),
                $soundTrack->getArtist(),
                $soundTrack->getTitle(),
                $soundTrack->getLabel(),
                $soundTrack->getDuration(),
                $soundTrack->getIcpnAlbum(),
                $date->format('Y-m-d h:m:s'),
                $soundTrack->getIscr()
            );

            $this->executeRequest($sql);
        }
    }

    /**
     * @param Deal $deal
     */
    public function deleteIfDealExist(Deal $deal)
    {
        $sql = sprintf(
            "DELETE  
            FROM deal 
            WHERE model = '%s' AND country = '%s' AND icpn_album = '%s' AND iscr_soundtrack = '%s' AND enabled = true",
            $deal->getModel(),
            $deal->getCountry(),
            $deal->getIcpnAlbum(),
            $deal->getIsrcSoundtrack()
        );
        return $this->executeDeleteRequest($sql);
    }

    /**
     * @param Deal $deal
     */
    public function persistDeal(Deal $deal)
    {
        $date = new \DateTime('now');
        $sql = sprintf(
            "INSERT INTO deal
            (model, %s, country, enabled, date_insert)
            VALUES
            ('%s', '%s', '%s', 1, '%s') ",
            (empty($deal->getIcpnAlbum()) ? 'iscr_soundtrack' : 'icpn_album'),
            $deal->getModel(),
            (empty($deal->getIcpnAlbum()) ? $deal->getIsrcSoundtrack() : $deal->getIcpnAlbum()),
            $deal->getCountry(),
            $date->format('Y-m-d h:m:s')
        );

        return $this->executeRequest($sql);

    }

    /**
     * @param Deal $deal
     */
    public function persistDealDate(Deal $deal)
    {
        $today = new \DateTime('now');

        foreach ($deal->getDate() as $date){
            /** @var  DealDate $date */
            $sql = sprintf(
                "INSERT INTO deal_date
            (deal_id, type_date, date_value, date_insert)
            VALUES
            ('%s', '%s', '%s', '%s') ",
                $deal->getId(),
                $date->getType(),
                $date->getDate(),
                $today->format('Y-m-d h:m:s')
            );
            $this->executeRequest($sql);
        }

        return $this->executeRequest($sql);
    }

    /**
     * @param Deal $deal
     */
    public function persistDealUsage(Deal $deal)
    {
        $today = new \DateTime('now');
        $sql = '';

        foreach ( $deal->getUsage() as $usage){
            /** @var  DealUsage $usage */
            $sql = sprintf(
                "INSERT INTO deal_usage
            (deal_id, usage_deal, date_insert)
            VALUES
            ('%s', '%s', '%s') ",
                $deal->getId(),
                (string)$usage->getUsageDeal(),
                $today->format('Y-m-d h:m:s')
            );

            $this->executeRequest($sql);
        }

        return (!empty($sql) ? $this->executeRequest($sql) : null);
    }

    /**
     * @param $sql
     * @return int|mixed
     */
    public function executeRequest($sql) {

        $servername = "localhost";
        $username = "deezer";
        $password = "deezer";
        $dbname = "deezer_catalog";
        try{
            $conn = new \mysqli($servername, $username, $password, $dbname);

        } catch(\Exception $e){
            die("Connection to mysql failed: ".$e->getMessage());
        }

        if ($conn->connect_error) {
            die("Connection failed: \n" . $conn->connect_error);
        }

        if ($conn->query($sql) === TRUE) {

            echo "New record successfully saved\n";
            $result = $conn->insert_id;
        } else {
            $result = 0;
            echo "Error: " . $sql . "<br>" . $conn->error;
        }

        $conn->close();

        return $result;

    }

    /**
     * @param $sql
     * @return array
     */
    public function executeSelectRequest($sql) {

        $servername = "localhost";
        $username = "deezer";
        $password = "deezer";
        $dbname = "deezer_catalog";
        try{
            $conn = new \mysqli($servername, $username, $password, $dbname);

        } catch(\Exception $e){
            die("Connection to mysql failed: ".$e->getMessage());
        }

        $result = $conn->query($sql);
        $rows = array();
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $rows[] = $row;
            }
        } else {
            echo "0 result";
        }
        $conn->close();
        return $rows;
    }

    /**
     * @param $sql
     * @return array
     */
    public function executeDeleteRequest($sql) {

        $servername = "localhost";
        $username = "deezer";
        $password = "deezer";
        $dbname = "deezer_catalog";
        try{
            $conn = new \mysqli($servername, $username, $password, $dbname);

        } catch(\Exception $e){
            die("Connection to mysql failed: ".$e->getMessage());
        }

        if ($conn->query($sql) === TRUE) {
            echo "Record deleted successfully";
        } else {
            echo "Error deleting record: " . $conn->error;
        }
        $conn->close();
    }

}

