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

# this file contains miscellanous general use functions

function print_day($day, $characters) {
	/* function that prints the day of the week given a numeric day from
	 * the registration database
	 */
	$days;

	if ($characters == 1)
		$days = array("S", "M", "T", "W", "H", "F", "A");
	else
		$days = array("Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday");

	return (characters == 2) ? strtoupper(substr($days[$day], 0, $characters)) : substr($days[$day], 0, $characters);
}

/* takes a list of GET variables in var=val&var2=val2 format and
 * returns the app's URL with the GET variables appended
 */
function url_vars($vars) {
	global $auth;

	if ($use_cookies) {
		return dirname($_SERVER['PHP_SELF']) . "./index.php?" . $vars;
	}

	return dirname($_SERVER['PHP_SELF']) . "./index.php?s=" . $auth->session . "&" . $vars;
}


/* print out the hidden "s" field for a form, if necessary */
function do_form_s() {
	global $auth;

	if (!$use_cookies) {
		?><input type="hidden" name="s" value="<?php print($auth->session); ?>"><?php
	}
}


/* redirect the browser to $url, showing a redirection page if the
 * browser for some reason does not support redirection
 */
function redirect_to($url) {
	header("Location: " . $url);
	?>
        <html>
            <head>
                <title>Redirecting</title>
            </head>
            <body>
            <center><h2><br><br><br>Redirecting to <a href="<?php print($url); ?>">here</a>.</h2></center>
            </body>
        </html>
	<?php
	exit(0);
}


?>
