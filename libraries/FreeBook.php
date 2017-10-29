<?php

namespace PacktpubDaily\libraries;

/**
 * Class FreeBook
 * @package PacktpubDaily\libraries
 */
class FreeBook
{

    public $title;
    public $image;
    public $formId;
    public $url;

    public function __construct($title, $image, $formId, $url)
    {
        $this->_setTitle($title);
        $this->_setImage($image);
        $this->_setFormId($formId);
        $this->_setUrl($url);
    }

    private function _setTitle($title = '')
    {
        if (!empty($title)) {
            $this->title = $title;
        } else {
            $this->title = 'No title found';
        }
    }

    private function _setImage($image = '')
    {
        if (!empty($image)) {
            $this->image = $image;
        } else {
            $this->image = 'No image found';
        }
    }

    private function _setFormId($formId = '')
    {
        if (!empty($formId)) {
            $this->formId = $formId;
        } else {
            $this->formId = 'No formId found';
        }
    }

    private function _setUrl($url = '') {
        if (!empty($url)) {
            $this->url = $url;
        } else {
            $this->url = 'No url found';
        }
    }
}