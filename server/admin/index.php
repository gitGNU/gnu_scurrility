<?php
/*
 * Copyright (C) 2009 Thomas Cort <tcort@tomcort.com>
 * Copyright (C) 2004 Adam Beaumont, Thomas Cort, Patrick McLean, Scott Stoddard
 *
 * This file is part of scurrility.
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

define('SCURRILITY', true);

include_once("catsors/main.php");
$action = isset($_REQUEST['a']) ? $_REQUEST['a'] : "default";
load_modules($action);

# Run the action
$actions = $action_table->get($action);

if ($actions == false) {
	# someone entered an action that doesn't have any registered actions
	# ex someone did something like index.php?a=0u9gfqej09fqnoi

	$action = "default";
	load_modules($action);
	$actions = $action_table->get($action);

	if ($actions == false) {
		# If we get here then we are total screwed. No default action or 
		# requested action. This should only happen if the modules are deleted
		echo "<html><head><title>Fatal Error!</title></head><body>";
		echo "<h1><font color=\"#FF0000\">Fatal System Error</font></h1><hr>No module to available to complete the requested action. The default module was missing too! Contact an administrator immediately.";
		echo "</body></html>";
	} else {
		while (list($key, $value) = each($actions)) {
			$action_result = $actions[$key]->execute();

			# on failure get messages
			if (!$action_result->success()) {
				$msg = $handler_result->get_messages();

				for ($i = 0; $i < count($msg); $i++) {
					$result->add_message($msg[$i]);
				}

				if ($result->success()) {
					$result->set_result(false);
				}
			}
		}
	}

	return true;

} else {
	while (list($key, $value) = each($actions)) {
		$action_result = $actions[$key]->execute();

		# on failure get messages
		if (!$action_result->success()) {
			$msg = $action_result->get_messages();

			if (is_object($result)) {

				for ($i = 0; $i < count($msg); $i++) {
					$result->add_message($msg[$i]);
				}

				if ($result->success()) {
					$result->set_result(false);
				}
			}
		}
	}
}

?>
