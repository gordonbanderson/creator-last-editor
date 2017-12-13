<?php

use SilverStripe\Security\Member;
use SilverStripe\ORM\DB;
use SilverStripe\Security\Permission;
use SilverStripe\Core\Extension;

class CreatorOnlyCanEditFormExtension extends Extension
{
    /**
     * @param $form Referenced form for tweaking
     */
    public function updateEditForm(&$form)
    {
        $formfields = $form->fields;
        $formid = $formfields->fieldbyName('ID');
        $sql = 'select CreatorID from SiteTree where ID='.$formid->value().' Limit 1';
        $result = DB::query($sql);
        $first = $result->first();
        $creatorID = $first['CreatorID'];

        if (!(Permission::check('ADMIN'))) {
            if ($creatorID != \SilverStripe\Security\Security::getCurrentUser()->id) {
                $form->makeReadonly();
            }
        }
    }
}
