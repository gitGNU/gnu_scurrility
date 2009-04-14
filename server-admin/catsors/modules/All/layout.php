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

$called_footers = 0;
$called_headers = 0;
$doing_login = false;

# html_headers sets up the html page by providing the head information.
#
# It also ensures that a user is currently logged-in before access to
# any page.
#
# html_headers ensures that it will only be instantiated once for any page.
class html_headers extends actor {

	function execute() {
		global $site_title, $title_size, $called_headers, $auth, $doing_login;

		# html_headers is a singleton
		if (!$called_headers) {
			$called_headers = 1;

			# login
			if (!$doing_login) {
				$authed = trigger("check_auth");
			}

			# print some headers
		?>
                <html>
                    <head>
                        <title><?php echo $site_title; ?></title>
                        <style type="text/css">
                          <!--
                            @import url(styles.css);
                        -->
                        </style>
                    </head>
                    <body>
                    <h<?php echo $title_size; ?>>
                        <?php echo $site_title; ?>
                    </h<?php echo $title_size; ?>>
                    <div id="main">
        	    <?php
			if (!$doing_login && $authed->success()) {
				trigger("menu");
			} else if (!$doing_login) {
				trigger("show_login");
				return $authed;
			}
		}
	return new return_result(true);
	}
}

# html_footers closes off the body and html tags of every page.  It is a
# singleton to ensure that page mistakes are eliminated.
#
# It also displays some copyright and disclaimer information at the bottom
# of every page.
class html_footers extends actor {
	function execute() {
		global $disclaimer;
		global $copyright;
		global $called_footers;

		# make html_footers a singleton
		if (!$called_footers) {
			$called_footers = 1;
			print "</div><P><small><center>$disclaimer<br>$copyright</center></small>";
			print "</body></html>";
		}

		return new return_result(true);
	}
}

register_handler(new html_headers("html_headers",50));
register_handler(new html_footers("html_footers",50));

?>
