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

class return_result {
	var $success;
	var $messages;

	function return_result($suc) {
		$this->success = $suc;
		$this->messages = array();
	}

	# true if OK : false if failure
	function success() {
		return $this->success;
	}

	function set_result($result) {
		$this->success = $result;
	}

	function add_message($mes) {
		array_push($this->messages,$mes);
	}

	function get_messages() {

		if (count($this->messages) > 0) {
			return $this->messages;
		} else {
			$temp = array();
			array_push($temp,"");
			return $temp;
		}
	}
}

?>
