<?php

namespace Pixelspin\Gallery;

use SilverStripe\ORM\DataObject;
use SilverStripe\Assets\Image;
use Embed\Embed;
use Pixelspin\Gallery\GalleryPage;

class GalleryItem extends DataObject
{

    private static $singular_name = 'Item';
    private static $plural_name = 'Items';

    private static $db = array(
        'Title' => 'Varchar(255)',
        'Type' => "Enum('Image,Video','Image')",
        'VideoURL' => 'Varchar(255)',
        'VideoEmbedURL' => 'Varchar(255)',
        'VideoImageURL' => 'Varchar(255)',
        'Sort' => 'Int'
    );

    private static $has_one = array(
        'Image' => Image::class,
        'Page' => GalleryPage::class
    );

    private static $summary_fields = array(
        'Title',
        'Type'
    );

    private static $default_sort = 'Sort';

    public function fieldLabels($includerelations = true)
    {
        $labels = parent::fieldLabels($includerelations);

        return $labels;
    }

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();

        $fields->removeByName('PageID');
        $fields->removeByName('VideoEmbedURL');
        $fields->removeByName('VideoImageURL');
        $fields->removeByName('Sort');

        return $fields;
    }

    public function onBeforeWrite()
    {
        parent::onBeforeWrite();
        if ($this->Type == 'Video' && $this->VideoURL && (!$this->VideoEmbedURL || $this->isChanged('VideoURL'))) {
            $embed = Embed::create($this->VideoURL);
            if ($embed && $embed->code) {
                preg_match('/src="([^"]+)"/', $embed->code, $match);
                if ($match && isset($match[1])) {
                    $this->VideoEmbedURL = $match[1];
                }
            }
            if ($embed && $embed->image) {
                $this->VideoImageURL = $embed->image;
            }
        }
    }

}