<?php

use SilverStripe\Security\Member;
use SilverStripe\Forms\FieldList;
use SilverStripe\Security\Permission;
use SilverStripe\Forms\DropdownField;
use SilverStripe\ORM\DataExtension;

class CreatorLastEditorExtension extends DataExtension
{
    private static $has_one = array(
        'Creator' => Member::class,
        'LastEditor' => Member::class,
    );

    /*
    1) Save the creator as the current editing member if there is not creator already assigned
    2) Save the last editor (e.g. an admin) as the person who last edited this document
    */
    public function onBeforeWrite()
    {
        if ($this->owner->CreatorID == 0) {
            $this->owner->CreatorID = Member::currentUserID();
        }
        $this->owner->LastEditorID = Member::currentUserID();
    }

    /*
    Allow the admin to override the creator and last editor
    */
    public function updateCMSFields(FieldList $fields)
    {
        if (Permission::check('ADMIN')) {
            $memberField = new DropdownField('CreatorID', 'Creator', Member::get()->map('ID', 'Username', '-- Please select --'));
            $fields->addFieldToTab('Root.Creator', $memberField);
        }

        return $fields;
    }
}
