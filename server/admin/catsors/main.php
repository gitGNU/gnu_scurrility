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

# This file contains our main functions

# Include classes for later use
include_once("catsors/classes/actor.class.php");
include_once("catsors/classes/collection.class.php");
include_once("catsors/classes/cats_smtp.class.php");
include_once("catsors/classes/dbresult.class.php");
include_once("catsors/classes/return_result.class.php");
# We need catsors/classes/filename because this is being executed by ../index.php

# Include global variable(s)
include_once("catsors/globals.php");

# Configuration settings
include_once("catsors/modules/modules.conf.php");

# Functions
include_once("catsors/functions/cats_mail.php");
include_once("catsors/functions/db_access.php");
include_once("catsors/functions/misc.php");

# trigger should be called from actions. trigger looks up the event name 
# that it gets as a parameter and executes it. trigger returns false if
# there are no events known by the name $event_name
function trigger($event_name) {
	global $event_table;

	$event_handlers = $event_table->get($event_name);
	if ($event_handlers == false) {
		$result = new return_result(false);
		$result->add_message("No Event Handlers for $event_name event");
		return $result;
	} else {
		$result = new return_result(true);

		while (list($key, $value) = each($event_handlers)) {
			$handler_result = $event_handlers[$key]->execute();

			# on failure get messages
			if (!$handler_result->success()) {
				$msg = $handler_result->get_messages();

				for ($i = 0; $i < count($msg); $i++) {
					$result->add_message($msg[$i]);
				}

				if ($result->success()) {
					$result->set_result(false);
				}
			}
		}

		return $result;
	}
}

function register_action($action) {
	global $action_table;

	$action_table->put($action->get_name(),$action);
}

function register_handler($event_handler) {
	global $event_table;

	$event_table->put($event_handler->get_name(),$event_handler);
}

# grab all of the php modules for a specific action.
function load_modules($action_requested) {
	global $action;

	foreach (glob("catsors/modules/$action/*.php") as $filename) {
		include_once($filename);
	}
}

# little function that escapes variables, if necessary
function doslashes($str) {
	if (!get_magic_quotes_gpc()) {
		return addslashes($str);
	}

	return $str;
}

?>
