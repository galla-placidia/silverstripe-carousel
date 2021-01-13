<?php

use SilverStripe\ORM\DataObjectInterface;
use SilverStripe\Forms\TextField;
use SilverStripe\Forms\HTMLEditor\HTMLEditorField;
use SilverStripe\Core\Injector;


/**
 * This class is needed in order to handle the 'Content' field of the
 * 'File' table with the WYSIWYG editor. That field is TEXT, hence just
 * using HtmlEditorField will result in an error when the 'saveInto'
 * method is called.
 *
 * @package silverstripe-carousel
 */
class CarouselCaptionField extends HtmlEditorField
{
    /**
     * Override the default constructor to have saner settings.
     *
     * @param string      $name  The internal field name, passed to forms.
     * @param string|null $title The human-readable field label.
     * @param mixed       $value The value of the field.
     */
    public function __construct($name, $title = null, $value = '')
    {
        parent::__construct($name, $title, $value);
        $this->rows = 5;
        // The .htmleditor class enables TinyMCE
        $this->addExtraClass('htmleditor');
    }

    /**
     * Implementation directly borrowed from HtmlEditorField
     * without the blocking or useless code.
     *
     * @param DataObjectInterface $record
     */
    public function saveInto(DataObjectInterface $record)
    {
        $htmlValue = Injector::inst()->create('HTMLValue', $this->value);

        // Sanitise if requested
        if ($this->config()->sanitise_server_side) {
            $santiser = Injector::inst()->create('HtmlEditorSanitiser', HtmlEditorConfig::get_active());
            $santiser->sanitise($htmlValue);
        }

        $this->extend('processHTML', $htmlValue);
        $record->{$this->name} = $htmlValue->getContent();
    }
}
