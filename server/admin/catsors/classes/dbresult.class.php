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

class DBResult {

	var $resultset;
	var $rownum;
	var $arr;
	var $maxrows;
	var $query;

	function DBResult($rs,$q) {

		$this->query = $q;

		if ($rs == FALSE) {
			$this->maxrows = 0;
			print "<p>SQL FAILURE (Query follows...)<p>".$this->query."<p>";
		} else {
			$this->maxrows = db_get_max_rows($rs);
		}

		$this->resultset = $rs;
		$this->arr = NULL;
		$this->rownum = 0;
	}

	function has_next() {
		return $this->rownum < $this->maxrows;
	}

	function get_row() {

		if ($this->has_next()) {
			$this->arr = db_fetch_array($this->resultset);
			$this->rownum++;
		}

		return $this->arr;
	}

	# resets the internal counters to 0 so that get_row() will return row 0
	function reset() {
		db_data_seek($this->resultset,0);
		$this->rownum = 0;
	}

	function print_all() {

		print "<p>";
		while ($this->has_next()) {
			$row = $this->get_row();
			print_r($row);
			print "<p>";
		}
		print "<p>";

		$this->reset();
	}

	function has_more($num) {
		if ($this->maxrows > $num)
			return true;
		else
			return false;
	}
}
?>
