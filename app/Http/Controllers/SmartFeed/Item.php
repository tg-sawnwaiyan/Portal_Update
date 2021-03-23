<?php

namespace App\Http\Controllers\SmartFeed;

/**
 * Class Item
 */
class Item
{
    /** @var string */
    protected $title;

    /** @var string */
    protected $url;

    /** @var string */
    protected $description;

    /** @var string */
    protected $contentEncoded;

    /** @var string */
    protected $category;

    /** @var string */
    protected $guid;

    /** @var bool */
    protected $isPermalink;

    /** @var int */
    protected $pubDate;

    /** @var string */
    protected $author;

    /** @var string */
    protected $creator;

    /** @var string */
    protected $media;

    /** @var string */
    protected $googleanalytics;

    /** @var string */
    protected $status;

    /** @var array */
    protected $advertisements = [];

    protected $preferCdata = false;

    public function title($title)
    {
        $this->title = $title;
        return $this;
    }

    public function url($url)
    {
        $this->url = $url;
        return $this;
    }

    public function description($description)
    {
        $this->description = $description;
        return $this;
    }

    public function contentEncoded($content)
    {
        $this->contentEncoded = $content;
        return $this;
    }

    public function category($name)
    {
        $this->category = $name;
        return $this;
    }

    public function guid($guid, $isPermalink = false)
    {
        $this->guid = $guid;
        $this->isPermalink = $isPermalink;
        return $this;
    }

    public function pubDate($pubDate)
    {
        $this->pubDate = $pubDate;
        return $this;
    }

    public function author($author)
    {
        $this->author = $author;
        return $this;
    }

    public function creator($creator)
    {
        $this->creator = $creator;
        return $this;
    }

    public function media($media)
    {
        $this->media = $media;
        return $this;
    }

    public function status($status)
    {
        $this->status = $status;
        return $this;
    }

    public function preferCdata($preferCdata)
    {
        $this->preferCdata = (bool)$preferCdata;
        return $this;
    }

    public function advertisements(array $advertisements)
    {
        $this->advertisements = $advertisements;
        return $this;
    }

    public function googleanalytics($googleanalytics)
    {
        $this->googleanalytics = $googleanalytics;
        return $this;
    }

    public function appendTo(Channel $channel)
    {
        $channel->addItem($this);
        return $this;
    }

    public function asXML()
    {
        $xml = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8" ?><item></item>', LIBXML_NOERROR | LIBXML_ERR_NONE | LIBXML_ERR_FATAL);

        if ($this->title) {
            if ($this->preferCdata) {
                $xml->addCdataChild('title', $this->title);
            } else {
                $xml->addChild('title', $this->title);
            }
        }

        if ($this->url) {
            $xml->addChild('link', $this->url);
        }

        // At least one of <title> or <description> must be present
        if ($this->description || ! $this->title) {
            if ($this->preferCdata) {
                $xml->addCdataChild('description', $this->description);
            } else {
                $xml->addChild('description', $this->description);
            }
        }

        if ($this->contentEncoded) {
            $xml->addCdataChild('xmlns:content:encoded', $this->contentEncoded);
        }
        
        if ($this->category) {
            $xml->addChild('category', $this->category);
        }

        if ($this->guid) {
            $guid = $xml->addChild('guid', $this->guid);

            if ($this->isPermalink === false) {
                $guid->addAttribute('isPermaLink', 'false');
            }
        }

        if (!empty($this->status)) {
            $xml->addChild('xmlns:media:status', $this->status);
        }

        if ($this->pubDate !== null) {
            $xml->addChild('pubDate', date(DATE_RSS, $this->pubDate));
        }

        if (!empty($this->author)) {
            $xml->addChild('author', $this->author);
        }

        if (!empty($this->media)) {
            $xml->addChild('xmlns:media:thumbnail', $this->media);
        }

        if (!empty($this->creator)) {
            $xml->addChild('xmlns:dc:creator', $this->creator);
        }

        if(isset($this->advertisements)){
            $adsxml = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8" ?><snf:advertisement></snf:advertisement>', LIBXML_NOERROR | LIBXML_ERR_NONE | LIBXML_ERR_FATAL);
            foreach ($this->advertisements as $ads) {
                $element = $adsxml->addChild('xmlns:snf:sponsoredLink');
    
                if (isset($ads)) {
                    $link = $ads["link"] ? $ads["link"] : $this->url."upload/static/".$ads["pdf"];
                    $advertiser = $ads["description"] ? strtok($ads["description"], " \n\t") : $ads["title"];
                    $thumbnail = "".$this->url."upload/advertisement/".$ads["photo"];
                    $element->addAttribute('link', $link);
                    $element->addAttribute('title', $ads['title']);
                    $element->addAttribute('thumbnail', htmlspecialchars($thumbnail));
                    $element->addAttribute('advertiser', $advertiser);
                }
            }
            $toDom = dom_import_simplexml($xml);
            $fromDom = dom_import_simplexml($adsxml);
            $toDom->appendChild($toDom->ownerDocument->importNode($fromDom, true));
        }

        if ($this->googleanalytics) {
            $xml->addCdataChild('xmlns:snf:analytics', $this->googleanalytics);
        }

        return $xml;
    }
}
