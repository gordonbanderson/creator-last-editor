<?php 
class CreatorOnlyCanEditFormExtension extends Extension {
	function updateEditForm(&$form) {
		error_log('Creator id:'.$this->owner->CreatorID);
		error_log('Current member id:'.Member::currentUserID());

		$creatorID = Member::currentUserID();
		$formfields = $form->fields;
		$formid = $formfields->fieldbyName('ID');
		error_log($formid->value());
		$sql = "select CreatorID from SiteTree where ID=".$formid->value().' Limit 1';
		$result = DB::query($sql);
		$first = $result->first();
		$creatorID = $first['CreatorID'];
		error_log('CREATOR: '.$creatorID);

		if (!(Permission::check('ADMIN'))) {
			if ($creatorID != Member::currentUserID()) {
				$form->makeReadonly();
			}
		}
	}
}