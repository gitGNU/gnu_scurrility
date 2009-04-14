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

# This file contains a PHP SMTP client
class cats_smtp {

	var $connection;
	var $host;
	var $port;

	function cats_smtp() {
		global $smtp_host;
		global $smtp_port;

		if (!isset($smtp_host)) {
			$this->host = "localhost";  # try the localhost
		} else {
			$this->host = $smtp_host;
		}

		if (!isset($smtp_port)) {
			$this->port = 25;  # use default smtp port
		} else {
			$this->port = $smtp_port;
		}

		$this->connection = 0;
	}

	function connect() {
		$this->connection = fsockopen($this->host,$this->port);

		if (!$this->connection) {
			$r = new return_result(false);
			$r->add_message("No Connection\n");
			return $r;
		}

		$result = $this->get_sock_data();

		if (strncmp($result,"220",3) != 0) {
			$r = new return_result(false);
			$r->add_message("Error connecting\n$result\n");
			return $r;
		}

		return new return_result(true);
	}

	function disconnect() {
		fclose($this->connection);
		$this->connection = 0;
	}

	# read as much data from the socket as possible
	function get_sock_data() {
		$data = "";

		while($str = fgets($this->connection,515)) {
			$data .= $str;
			if (substr($str,3,1) == " ") {
				break;
			}
		}

		return $data;
	}

	# write data to a socket and append "\r\n"
	function put_sock_data($data) {
		fwrite($this->connection, $data . "\r\n");
	}

	# SMTP Commands
	function cmd_helo() {

		$this->put_sock_data("ehlo " . $this->host);
		$result = $this->get_sock_data();

		if (strncmp($result,"250",3) != 0) {
			$r = new return_result(false);
			$r->add_message("Error with HELO command\n$result\n");
			return $r;
		}

		return new return_result(true);
	}

	function cmd_auth() {
		global $smtp_user, $smtp_pass;

		$coded_pass = base64_encode("$smtp_user\0$smtp_user\0$smtp_pass");

		$this->put_sock_data("AUTH PLAIN " . $coded_pass);
		$result = $this->get_sock_data();

		if (strncmp($result,"235",3) != 0) {
			$r = new return_result(false);
			$r->add_message("Error with AUTH command\n$result\n");
			return $r;
		}

		return new return_result(true);
	}

	function cmd_quit() {
		$this->put_sock_data("quit");
		$result = $this->get_sock_data();

		if (strncmp($result,"221",3) != 0) {
			$r = new return_result(false);
			$r->add_message("Error with QUIT command\n$result\n");
			return $r;
		}

		return new return_result(true);
	}

	function cmd_mail_from($addr) {
		$this->put_sock_data("mail from: $addr");
		$result = $this->get_sock_data();

		if (strncmp($result,"250",3) != 0) {
			$r = new return_result(false);
			$r->add_message("Error with MAIL FROM: $addr command\n$result\n");
			return $r;
		}

		return new return_result(true);
	}

	function cmd_rcpt_to($addr) {
		$this->put_sock_data("rcpt to: $addr");
		$result = $this->get_sock_data();

		if (strncmp($result,"250",3) != 0) {
			$r = new return_result(false);
			$r->add_message("Error with RCPT TO: $addr command\n$result\n");
			return $r;
		}

		return new return_result(true);
	}

	function cmd_data($from,$to,$subject,$data) {
		$this->put_sock_data("DATA");
		$result = $this->get_sock_data();

		if (strncmp($result,"354",3) != 0) {
			$r = new return_result(false);
			$r->add_message("Error with DATA command\n$result\n");
			return $r;
		}

		$this->put_sock_data("From: $from");
		$this->put_sock_data("To: $to");
		$this->put_sock_data("Subject: $subject");
		$this->put_sock_data($data);
		$this->put_sock_data(".");
		$result = $this->get_sock_data();

		if (strncmp($result,"250",3) != 0) {
			$r = new return_result(false);
			$r->add_message("Error with DATA command\n$result\n");
			return $r;
		}

		return new return_result(true);
	}
}

?>
