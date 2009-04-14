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

if (!defined('SCURRILITY')) { exit(1); }

# This event displays the menu on the screen.  Menu items are displayed
# appropriately depending on access level and priority.
#
# Output is simple and should be improved with the use of css in the future.
#
# The menu has no associated action (ie. it cannot be directly keyed-into.
class menu_event extends actor {
	function execute() {
		global $auth;

		$session = $auth->get_session();
		$access = $auth->get_accesslevel();

		# Get the menu items for the user's access level
		$db_result = db_query("select * from menu where accesslevel = '$access' order by priority;");

		echo "<ul class=\"navbar\">";

		# print them all out
		while ($db_result->has_next()) {
			$row = $db_result->get_row();
			echo "<a href=\"./index.php?a=$row[1]&s=$session\"><li><b>$row[2]</b></li></a>";
		}

		echo "</ul>";
		return new return_result(true);
	}
}

register_handler(new menu_event("menu",50));

?>
