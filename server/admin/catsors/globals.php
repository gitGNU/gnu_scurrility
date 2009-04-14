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

# A place to put our global variables

# Database type this install will use:
# (Current options are:  postgres || mysql)
$db_type = "mysql";

# Name of database the system will use
$db_name = "scurrility";
# Database user name
$db_user = "root";
# Password corresponding to above user name
$db_pass = "abc123";
# Hostname of mysql server
$db_host = "localhost";

# SMTP Address
$smtp_host = "localhost";
$smtp_port = 25;
$smtp_user = "username_here";
$smtp_pass = "password_here";

# Session timeout (in minutes)
$session_timeout = 20;

# whether to use session cookies or not
$use_cookies = false;

# everything below this point is for internal use and is not user configurable
$auth;
$db_conn;
$auth_registering = false;
$event_table = new collection();
$action_table = new collection();

?>
