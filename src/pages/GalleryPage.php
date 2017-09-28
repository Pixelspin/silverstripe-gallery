<?php

namespace Pixelspin\Gallery;

use Page;
use Pixelspin\Gallery\GalleryItem;
use SilverStripe\Forms\GridField\GridField;
use SilverStripe\Forms\GridField\GridFieldConfig_RecordEditor;
use Symbiote\GridFieldExtensions\GridFieldOrderableRows;

class GalleryPage extends Page
{

    private static $singular_name = 'Gallery page';
    private static $plural_name = 'Gallery pages';
    private static $description = 'Page to display photos and videos';

    private static $has_many = array(
        'Items' => GalleryItem::class
    );

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();

        $itemsConfig = GridFieldConfig_RecordEditor::create();
        $itemsConfig->addComponent(new GridFieldOrderableRows());
        $fields->addFieldToTab('Root.GalleryItems', new GridField('Items', 'Items', $this->Items(), $itemsConfig));

        return $fields;
    }

}


//Alles door de translate

//Module van maken
//Display logic toevoegen (ook in composer)
//Gridfield dingen toevoegen in composer