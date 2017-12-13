<?php

use SilverStripe\Security\Member;
use SilverStripe\Security\Permission;
use SilverStripe\Core\Extension;

class CreatorOnlyCanEditExtension extends Extension
{
    /*
    Only allow editing when the current user is the same as the creator for each of cycling route, cycling exploration and cycling short
    */
    public function canEdit($member = null)
    {
        //return in_array($this->owner->ClassName, array('RideFolder','Ride','CyclingShort','CyclingRoute','CyclingExploration'));
        $caneditasowner = true;
        if (in_array($this->owner->ClassName, array('CyclingShort', 'CyclingRoute', 'CyclingExploration'))) {
            if ($this->owner->CreatorID != Member::currentUserID()) {
                $caneditasowner = false;
            }
        }

        return (Permission::check('ADMIN')) || $caneditasowner;
    }
}
