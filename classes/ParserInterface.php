<?php

namespace Deezer\Utils;

/**
 * Class to Parse XML
 * @author Romain Fockking
 */
Interface ParserInterface
{
    public function parse($file);

    public function findAlbums(\SimpleXMLElement $xml);

    function findSoundTracks(\SimpleXMLElement $xml);

    function findDeals(\SimpleXMLElement $xml);

}
