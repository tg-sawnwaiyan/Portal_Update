<?php

namespace App\Http\Controllers\SmartFeed;

/**
 * Class Channel
 */
class Channel
{
    /** @var string */
    protected $title;

    /** @var string */
    protected $url;

    /** @var string */
    protected $description;

    /** @var string */
    protected $language;

    /** @var string */
    protected $copyright;

    /** @var int */
    protected $pubDate;

    /** @var int */
    protected $lastBuildDate;

    /** @var int */
    protected $ttl;

    /** @var string */
    protected $logo;

    /** @var string */
    protected $darklogo;

    /** @var Item[] */
    protected $items = [];

    /**
     * Set channel title
     * @param string $title
     * @return $this
     */
    public function title($title)
    {
        $this->title = $title;
        return $this;
    }

    /**
     * Set channel URL
     * @param string $url
     * @return $this
     */
    public function url($url)
    {
        $this->url = $url;
        return $this;
    }

    /**
     * Set channel description
     * @param string $description
     * @return $this
     */
    public function description($description)
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @param string $language
     * @return $this
     */
    public function language($language)
    {
        $this->language = $language;
        return $this;
    }

    /**
     * Set channel copyright
     * @param string $copyright
     * @return $this
     */
    public function copyright($copyright)
    {
        $this->copyright = $copyright;
        return $this;
    }

    /**
     * Set channel published date
     * @param int $pubDate Unix timestamp
     * @return $this
     */
    public function pubDate($pubDate)
    {
        $this->pubDate = $pubDate;
        return $this;
    }

    /**
     * Set channel last build date
     * @param int $lastBuildDate Unix timestamp
     * @return $this
     */
    public function lastBuildDate($lastBuildDate)
    {
        $this->lastBuildDate = $lastBuildDate;
        return $this;
    }

    /**
     * Set channel ttl (minutes)
     * @param int $ttl
     * @return $this
     */
    public function ttl($ttl)
    {
        $this->ttl = $ttl;
        return $this;
    }

    /**
     * Set channel logo
     * @param string $logo
     * @return $this
     */
    public function logo($logo)
    {
        $this->logo = $logo;
        return $this;
    }

    /**
     * Set channel darklogo
     * @param string $darklogo
     * @return $this
     */
    public function darklogo($darklogo)
    {
        $this->darklogo = $darklogo;
        return $this;
    }

    /**
     * Add item object
     * @param Item $item
     * @return $this
     */
    public function addItem(Item $item)
    {
        $this->items[] = $item;
        return $this;
    }

    /**
     * Append to feed
     * @param Feed $feed
     * @return $this
     */
    public function appendTo(Feed $feed)
    {
        $feed->addChannel($this);
        return $this;
    }

    /**
     * Return XML object
     * @return SimpleXMLElement
     */
    public function asXML()
    {
        $xml = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8" ?><channel></channel>', LIBXML_NOERROR | LIBXML_ERR_NONE | LIBXML_ERR_FATAL);
        $xml->addChild('title', $this->title);
        $xml->addChild('link', $this->url);
        $xml->addChild('description', $this->description);

        if ($this->logo !== null) {
            $logoxml = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8" ?><snf:logo></snf:logo>', LIBXML_NOERROR | LIBXML_ERR_NONE | LIBXML_ERR_FATAL);
            $element = $logoxml->addChild('url', $this->logo);
            $toDom = dom_import_simplexml($xml);
            $fromDom = dom_import_simplexml($logoxml);
            $toDom->appendChild($toDom->ownerDocument->importNode($fromDom, true));
        }

        if ($this->darklogo !== null) {
            $logoxml = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8" ?><snf:darkModeLogo></snf:darkModeLogo>', LIBXML_NOERROR | LIBXML_ERR_NONE | LIBXML_ERR_FATAL);
            $element = $logoxml->addChild('url', $this->darklogo);
            $toDom = dom_import_simplexml($xml);
            $fromDom = dom_import_simplexml($logoxml);
            $toDom->appendChild($toDom->ownerDocument->importNode($fromDom, true));
        }

        if ($this->language !== null) {
            $xml->addChild('language', $this->language);
        }

        if ($this->copyright !== null) {
            $xml->addChild('copyright', $this->copyright);
        }

        if ($this->pubDate !== null) {
            $xml->addChild('pubDate', date(DATE_RSS, $this->pubDate));
        }

        if ($this->lastBuildDate !== null) {
            $xml->addChild('lastBuildDate', date(DATE_RSS, $this->lastBuildDate));
        }

        if ($this->ttl !== null) {
            $xml->addChild('ttl', $this->ttl);
        }
        
        foreach ($this->items as $item) {
            $toDom = dom_import_simplexml($xml);
            $fromDom = dom_import_simplexml($item->asXML());
            $toDom->appendChild($toDom->ownerDocument->importNode($fromDom, true));
        }

        return $xml;
    }
}
