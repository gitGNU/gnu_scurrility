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

# A sort that we use with the actor class. It allows us to sort by priority
function priority_sort($a,$b) {

	if ($a->get_priority() == $b->get_priority()) {
		return 0;
	}

	return ($a->get_priority() < $b->get_priority()) ? -1 : 1;
}

# General Collection Class
class collection {
	var $items;

	# $key should be a string
	# $value should be an actor
	function put($key,$value) {

		if ($this->items[$key]) {
			$this->items[$key][count($this->items[$key])] = $value;
			uasort($this->items[$key], "priority_sort");
		} else {
			$this->items[$key] = array($value);
		}
	}

	# get will return an array of actors or false
	# You _MUST_ use php's iterator each() to access to elements in order
	# indexing them 0,1,...,n-1 will not work because sorting != re-indexing
	# There is a working example of this class at the bottom of this file...
	function get($key) {

		if ($this->items[$key]) {
			return $this->items[$key];
		} else {
			return false;
		}
	}
}

# Example Code using class collection.
#
# $col = new collection();
# include("event_handler.class.php");
#
# $one = new event_handler();
# $two = new event_handler();
# $thr = new event_handler();
#
# $one->set_priority(1);
# $two->set_priority(2);
# $thr->set_priority(3);
#
# $one->set_name("one");
# $two->set_name("two");
# $thr->set_name("thr");
#
# $col->put("event_name",$thr); # 3
# $col->put("event_name",$one); # 1
# $col->put("event_name",$two); # 2
#
# $x = $col->get("event_name");
# while (list($key, $value) = each($x)) {
#   echo $x[$key]->get_priority();
#   echo " ";
# }
# echo "\n";

?>
