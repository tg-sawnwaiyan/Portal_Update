<?php

namespace App\Http\Controllers\SmartFeed;

/**
 * Class SimpleXMLElement
 */
class SimpleXMLElement extends \SimpleXMLElement
{
    /**
     * @param string $name
     * @param string $value
     * @param string $namespace
     * @return \SimpleXMLElement
     */
    public function addChild($name, $value = null, $namespace = null)
    {
        if ($value !== null and is_string($value) === true) {
            $find = ['&','&nbsp;'];
            $replace = ['&amp;',''];
            $value = str_replace($find, $replace, $value);
        }

        return parent::addChild($name, $value, $namespace);
    }

    /**
     * @param string $name
     * @param string $value
     * @param string $namespace
     * @return \SimpleXMLElement
     */
    public function addCdataChild($name, $value = null, $namespace = null)
    {
        $element = $this->addChild($name, null, $namespace);
        $dom = dom_import_simplexml($element);
        $elementOwner = $dom->ownerDocument;
        $dom->appendChild($elementOwner->createCDATASection($value));
        return $element;
    }
}
