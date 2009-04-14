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

# executes the required sequence of SMTP commands to send a basic [authenticated] email
function cats_mail($to, $from, $subject, $body) {
	$mailer = new cats_smtp();

	$result = $mailer->connect();

	if (!$result->success()) {
		return $result;
	} 

	$result = $mailer->cmd_helo();

	if (!$result->success()) {
		echo "HELO FAILED!";
		return $result;
	}

	$result = $mailer->cmd_auth();

	if (!$result->success()) {
		echo "AUTH FAILED!";
		return $result;
	}

	$result = $mailer->cmd_mail_from($from);

	if (!$result->success()) {
		echo "MAIL FROM FAILED";
		return $result;
	}

	$result = $mailer->cmd_rcpt_to($to);

	if (!$result->success()) {
		echo "RCPT TO FAILED";
		return $result;
	}

	$result = $mailer->cmd_data($from,$to,$subject,$body);
	if (!$result->success()) {
		echo "DATA FAILED";
		return $result;
	}

	$result = $mailer->cmd_quit();

	if (!$result->success()) {
		echo "QUIT FAILED";
		return $result;
	} 

	$mailer->disconnect();
	return new return_result(true);
}

# test code
#$smtp_host = "cs.ubishops.ca";
#$r = cats_mail("tcort@cs.ubishops.ca","tcort@cs.ubishops.ca","Final Last Tests","Hey Tom,
#Dag, yo. This email api is r0x0r. U r a  1337 h4x0r. w00t!
#Mr Deeds");

?>
