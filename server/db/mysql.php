<?php
/*
 * Copyright (C) 2009 Thomas Cort <tcort@tomcort.com>
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

$dblink = false;

function db_connect() {
	global $dblink;
	global $dbhost;
	global $dbname;
	global $dbuser;
	global $dbpass;

	$dblink = mysql_connect($dbhost, $dbuser, $dbpass) or die(mysql_error());
	mysql_select_db($dbname) or die(mysql_error());
}

function db_filter($message) {
	global $dblink;

	$result = mysql_query("SELECT word FROM words WHERE MATCH (word) AGAINST ('" . mysql_real_escape_string($message) . "');", $dblink) or die(mysql_error());

	while ($row = mysql_fetch_array($result)) {
		$message = preg_replace('/' . $row['word'] . '/i', '[EXPLETIVE DELETED]', $message);
	}

	$words = preg_split('/\s/', $message);
	foreach ($words as $word) {
		if (strlen($word) < 4) {
			$result = mysql_query("SELECT word FROM words WHERE lower('" . mysql_real_escape_string($word) . "') LIKE word;");
			while ($row = mysql_fetch_array($result)) {
				$message = preg_replace('/' . $row['word'] . '/i', '[EXPLETIVE DELETED]', $message);
			}
		}
	}

	return $message;
}

function db_disconnect() {
	global $dblink;
	mysql_close($dblink);
}

?>
