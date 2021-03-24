<?php

namespace App\Http\Controllers\SmartFeed;

use DOMDocument;

/**
 * Class Feed
 */
class Feed
{
    /** @var Channel[] */
    protected $channels = [];

    /**
     * Add channel
     * @param Channel $channel
     * @return $this
     */
    public function addChannel(Channel $channel)
    {
        $this->channels[] = $channel;
        return $this;
    }

    /**
     * Save XML
     */
    public function save_xml()
    {
        $xml = new SimpleXMLElement('
        <?xml version="1.0" encoding="UTF-8" ?>
        <rss version="2.0" 
        xmlns:content="http://purl.org/rss/1.0/modules/content/"
        xmlns:dc="http://purl.org/dc/elements/1.1/"
        xmlns:media="http://search.yahoo.com/mrss/"
        xmlns:snf="http://www.smartnews.be/snf" />', LIBXML_NOERROR | LIBXML_ERR_NONE | LIBXML_ERR_FATAL);

        foreach ($this->channels as $channel) {
            $toDom = dom_import_simplexml($xml);
            $fromDom = dom_import_simplexml($channel->asXML());
            $toDom->appendChild($toDom->ownerDocument->importNode($fromDom, true));
        }

        $dom = new DOMDocument('1.0', 'UTF-8');
        $dom->appendChild($dom->importNode(dom_import_simplexml($xml), true));
        $dom->formatOutput = true;
        $xml_file_name = './api/feed/smartnews.xml';	
        //$xml_file_name = 'smartfeed1.xml';
        $dom->save($xml_file_name);
    }

    /**
     * Render XML
     * @return string
     */
    public function render_xml()
    {
        $xml = new SimpleXMLElement('
        <?xml version="1.0" encoding="UTF-8" ?>
        <rss version="2.0" 
        xmlns:content="http://purl.org/rss/1.0/modules/content/"
        xmlns:dc="http://purl.org/dc/elements/1.1/"
        xmlns:media="http://search.yahoo.com/mrss/"
        xmlns:snf="http://www.smartnews.be/snf" />', LIBXML_NOERROR | LIBXML_ERR_NONE | LIBXML_ERR_FATAL);

        foreach ($this->channels as $channel) {
            $toDom = dom_import_simplexml($xml);
            $fromDom = dom_import_simplexml($channel->asXML());
            $toDom->appendChild($toDom->ownerDocument->importNode($fromDom, true));
        }

        $dom = new DOMDocument('1.0', 'UTF-8');
        $dom->appendChild($dom->importNode(dom_import_simplexml($xml), true));
        $dom->formatOutput = true;
        return $dom->saveXML();
    }

    /**
     * Render XML
     * @return string
     */
    public function __toString()
    {
        return $this->render_xml();
    }
}
