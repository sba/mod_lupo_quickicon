<?php

class mod_lupo_quickiconInstallerScript extends LupoQuickiconInstallerScript {}

class LupoQuickiconInstallerScript {

	public function install($parent) {}

	public function uninstall($parent) {}

	public function update($parent) {}

	public function preflight($type, $parent) {}

	public function postflight($type, $parent) {
		
		if ( $type == 'install' ) {
			$position = 'icon';
			$module = 'mod_lupo_quickicon';
			$menuid = 0;

			$db = JFactory::getDbo();

			$query = "UPDATE #__modules, (SELECT MAX(ordering) +1 as ord FROM #__modules WHERE position = '$position') tt"
			         ." SET published = 1, position = '$position', ordering = tt.ord"
			         ." WHERE module = '$module'";
			$db->setQuery($query);
			$db->execute();

			$query = "INSERT IGNORE #__modules_menu"
			         ." SET menuid = $menuid, moduleid = (SELECT id FROM #__modules WHERE module = '$module')";
			$db->setQuery($query);
			$db->execute();

			$query = "UPDATE #__extensions, (SELECT MAX(ordering) +1 as ord FROM #__modules WHERE position = '$position') tt"
			         ." SET enabled = 1, ordering = tt.ord"
			         ." WHERE element = '$module'";
			$db->setQuery($query);
			$db->execute();
		}
	}
}