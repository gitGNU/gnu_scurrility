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

# Add menu entries for hello_world to all access levels

## menu_item#5#hello_world#Hello, World#ST
## menu_item#5#hello_world#Hello, World#FY
## menu_item#5#hello_world#Hello, World#DN
## menu_item#5#hello_world#Hello, World#RC
## menu_item#5#hello_world#Hello, World#RA
## menu_item#5#hello_world#Hello, World#DV

class hello_world_action extends actor {

	function execute() {
		$result = trigger("html_headers");

		if (!$result->success()) {
			return $result;
		}

		$result = trigger("hello_world");

		# This will never happen
		if (!$result->success()) {
			return $result;
		}

		$result = trigger("html_footers");

		# This will never happen
		if (!$result->success()) {
			return $result;
		}

		return $result;
	}
}

# This was the first event create to test and demonstrate the abilities
# of the design.  It was kept in simply as a historical memoir.
#
# Prints hello and the user's name
class hello_world_event extends actor {
	function execute() {
		global $auth;

		# Say Hello
		print "<h3><font color=\"#ff0000\">HELLO, " . $auth->get_first() . " " . $auth->get_last() . "!</font></h3>";
		return new return_result(true);
	}
}

register_handler(new hello_world_event("hello_world",50));
register_action(new hello_world_action("hello_world",50));

?>
