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

# Get the number of rows
function db_get_max_rows($rs) {
	return mysql_num_rows($rs);
}

function db_fetch_array($rs) {
	return mysql_fetch_array($rs);
}

# Query the database with an SQL and get a result
function db_query($query) {
	global $db_conn;

	db_connect();
	$result = mysql_query($query, $db_conn);
	return new DBResult($result,$query);
}


# Send a query to the database
# This is usually an insert or delete or something that you don't expect a results from
# returns a boolean if it exec'd ok or failed
function db_exec($query) {
	global $db_conn;

	db_connect();
	$result = mysql_query($query, $db_conn);
	if (mysql_affected_rows($db_conn) > 0) {
		return TRUE;
	} else {
		return FALSE;
	}
}

# Singleton, Connects to Database
function db_connect() {
	global $db_conn, $db_name, $db_user, $db_pass, $db_host;

	if ($db_conn == NULL || $db_conn == FALSE) {
		$db_conn = mysql_connect($db_host, $db_user, $db_pass);
		mysql_select_db($db_name);
	}
}

# Seek results
function db_data_seek($rs, $pos) {
	mysql_data_seek($rs, $pos);
}

# close the connection
function db_close() {
	global $db_conn;

	mysql_close($db_conn);
}

?>
