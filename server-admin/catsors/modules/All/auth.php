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

# Add logout to the menu for all accesslevels
# menu_item#99#logout#Logout#ST
# menu_item#99#logout#Logout#FY
# menu_item#99#logout#Logout#DN
# menu_item#99#logout#Logout#RC
# menu_item#99#logout#Logout#RA
# menu_item#99#logout#Logout#DV

# menu_item#60#passwd#Change Password#ST
# menu_item#60#passwd#Change Password#FY
# menu_item#60#passwd#Change Password#DN
# menu_item#60#passwd#Change Password#RC
# menu_item#60#passwd#Change Password#RA
# menu_item#60#passwd#Change Password#DV

class auth_user {
	var $session;
	var $username;
	var $userid;
	var $first;
	var $last;
	var $email;
	var $accesslevel;
	
	function auth_user($session, $username, $userid, $first, $last,
		$email, $accesslevel) {
		
		$this->session = $session;
		$this->username = $username;
		$this->userid = $userid;
		$this->first = $first;
		$this->last = $last;
		$this->email = $email;
		$this->accesslevel = $accesslevel;
	}
	
	function get_session() { return $this->session; }
	function get_username() { return $this->username; }
	function get_userid() { return $this->userid; }
	function get_first() { return $this->first; }
	function get_last() { return $this->last; }
	function get_email() { return $this->email; }
	function get_accesslevel() { return $this->accesslevel; }
	
	function set_first($new_first) {
		if (db_exec("UPDATE \"Users\" 
				SET first = '" . doslashes($new_first) . "'
				WHERE user_id = " . $this->userid . ";"
			)) {
			
			$this->first = $new_first;
			
			return true;
		}
		
		return false;
	}
	
	function set_last($new_last) {
		if (db_exec("UPDATE \"Users\" 
				SET last = '" . doslashes($new_last) . "'
				WHERE user_id = " . $this->userid . ";"
			)) {
			
			$this->last = $new_last;
			
			return true;
		}
		
		return false;
	}
	
	function set_email($new_email) {
		if (ereg("([a-zA-Z0-9.-_])*[@]{1}[a-zA-Z0-9.-_]*[.]{1}[a-zA-Z0-9.-_]{2,5}", $new_email)) {
			if (db_exec("UPDATE \"Users\"
					SET email = '" . doslashes($new_email) . "'
					WHERE user_id = " . $this->userid . ";"
				)) {
			
				$this->email = $new_email;
				
				return true;
			}
		}
		
		return false;
	}
	
	// TODO: add some validation here
	function set_accesslevel($new_accesslevel) {
		if (db_exec("UPDATE \"Users\" 
				SET accesslevel = '" . doslashes($new_accesslevel) . "'
				WHERE user_id = " . $this->userid . ";"
			)) {
			
			$this->accesslevel = $new_accesslevel;
			
			return true;
		}
		
		return false;
	}
	
	function set_passwd($new_passwd) {
		 return db_exec("UPDATE \"Users\" 
			SET passwd = '" . md5($new_passwd) . "'
			WHERE user_id = " . $this->userid . ";"
		);
	}
}

class auth_user_student extends auth_user {
	var $student_num;
	
	function auth_user_student($session, $username, $userid, $first, $last,
		$email, $accesslevel, $student_num) {
		
		$this->session = $session;
		$this->username = $username;
		$this->userid = $userid;
		$this->first = $first;
		$this->last = $last;
		$this->email = $email;
		$this->accesslevel = $accesslevel;
		$this->student_num = $student_num;
		
	}
	
	function get_student_num() { return $this->student_num; }
	
	function set_student_num($new_student_num) {
		if (db_exec("UPDATE \"Students\" 
			SET student_num = '" . doslashes($student_num) . "'
			WHERE user_id = " . $this->userid . ";"
		)) {
			
			$this->student_num = $new_student_num;
			return true;
		}
		
		return false;
	}
}

class auth_user_faculty extends auth_user {
	var $office;
	var $preface;
	var $extension;
	
	function auth_user_faculty($session, $username, $userid, $first, $last,
		$email, $accesslevel, $office, $preface, $extension) {
		
		$this->session = $session;
		$this->username = $username;
		$this->userid = $userid;
		$this->first = $first;
		$this->last = $last;
		$this->email = $email;
		$this->accesslevel = $accesslevel;
		$this->office = $office;
		$this->preface = $preface;
		$this->extension = $extension;
	}
	
	function get_office() { return $this->office; }
	function get_preface() { return $this->preface; }
	function get_extension() { return $this->extension; }
	
	function set_office($new_office) {
		if (db_exec("UPDATE \"Faculty\"
			SET office = '" . doslashes($new_office) . "'
			WHERE user_id = " . $this->userid . ";"
		)) {
			
			$this->office = $new_office;
			return true;
		}
		
		return false;
	}
	
	function set_preface($new_preface) {
		if (db_exec("UPDATE \"Faculty\" 
			SET preface = '" . doslashes($new_preface) . "'
			WHERE user_id = " . $this->userid . ";"
		)) {
			
			$this->preface = $new_preface;
			return true;
		}
		
		return false;
	}
	
	function set_extension($new_extension) {
		if (is_numeric($new_extension)) {
			if (db_exec("UPDATE \"Admin\" 
				SET ext = '" . $new_extension . "'
				WHERE user_id = " . $this->userid . ";"
			)) {
				
				$this->extension = $new_extension;
				return true;
			}
		}
		
		return false;
	}
}

class auth_user_admin extends auth_user {
	var $ext;
	var $office;
	
	function auth_user_admin($session, $username, $userid, $first, $last,
		$email, $accesslevel, $office, $extension) {
		
		$this->session = $session;
		$this->username = $username;
		$this->userid = $userid;
		$this->first = $first;
		$this->last = $last;
		$this->email = $email;
		$this->accesslevel = $accesslevel;
		$this->office = $office;
		$this->extension = $extension;
	}
		
	function get_office() { return $office; }
	function get_extension() { return $extension; }
	
	function set_office($new_office) {
		if (db_exec("UPDATE \"Faculty\" 
			SET office = '" . doslashes($new_office) . "'
			WHERE user_id = " . $this->userid . ";"
		)) {
			
			$this->office = $new_office;
			return true;
		}
		
		return false;
	}
	
	function set_extension($new_extension) {
		if (is_numeric($new_extension)) {
			if (db_exec("UPDATE \"Admin\"
				SET ext = '" . $new_extension . "'
				WHERE user_id = " . $this->userid . ";"
			)) {
				
				$this->extension = $new_extension;
				return true;
			}
		}
		
		return false;
	}
}

class show_login extends actor {
	function execute() {
		if (!trigger("html_headers")) {
			return new return_result(false);
		}
		else {
			?></div>
				<table border="0" align="center">
					<form action="index.php" method="post">
						<tr><td align="center" colspan="2"><b>Login</b></td></tr>
						<tr><td></td><td><input type="hidden" name="a" value="login" size=20></td></tr>
						<tr><td>Username</td><td><input type="text" name="user" size=20 maxlength=32></td></tr>
						<tr><td>Password</td><td><input type="password" name="pass" size=20 maxlength=512></td></tr>
						<tr><td&nbsp;</td><td align="center"><input type="submit" id="button" value="login" size=20>
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="reset" id="button" value="clear" size=20>
						</td></tr>
 					</form>
				</table><div>
			<?php
			return trigger("html_footers");
		}
	}
}

class check_auth extends actor {
	function execute() {	
		$session;
		global $session_timeout, $auth, $use_cookies, 
			$registering_session_timeout, $auth_registering;
	
		if (is_object($auth)) {
			return new return_result(true);
		}
	
		if ($use_cookies) {
			$session = doslashes($_COOKIE['s']);
		}
		else {
			$session = doslashes($_GET['s']);
			$session = $session != "" ? $session : doslashes($_POST['s']);
		}
		
		if (empty($session) || !is_string($session)) {
			$result = new return_result(false);
			$result->add_message("Not logged in");
			return $result;
		}
		
		db_exec("DELETE FROM \"Logins\" WHERE expiration_time < now();");
		
		$sess_db = db_query("SELECT user_id, start_time, address 
			FROM \"Logins\" 
			WHERE login_id = '" . $session . "';"
		);
		
		if (!$sess_db->has_next()) {
			$result = new return_result(false);
			$result->add_message("Invalid session");
			return $result;
		}
		
		$sess = $sess_db->get_row();
		
		if ((string) $sess['address'] != (string) $_SERVER['REMOTE_ADDR']) {
			$result = new return_result(false);
			$result->add_message("Invalid session");
			return $result;
		}
		
		$user_db = db_query("SELECT username, first, last, email, accesslevel 
			FROM \"Users\"
			WHERE user_id = " . $sess['user_id'] . ";"
		);
		
		$user_info = $user_db->get_row();
		
		switch ($user_info['accesslevel']) {
		
			/* ok, here are the access level codes, at the moment
				"ST" = Student
				"FY" = Faculty
				"DN" = Dean
				"RC" = Records Office Clerk
				"RA" = Records Office Administrator
				"DV" = Developer
			 */
			case "ST": {
				
				$u_db = db_query("SELECT student_num 
					FROM \"Students\"
					WHERE user_id = " . $sess['user_id'] . ";"
				);
				
				$u = $u_db->get_row();
				
				$auth = new auth_user_student($session, $user_info['username'],
					$sess['user_id'], $user_info['first'], $user_info['last'],
					$user_info['email'], $user_info['accesslevel'],
					$u['student_num']);
				
				if ($auth_registering) {
					/* if we are in the process of registering then then
					 * the session times out in $registering_session_timeout
					 * seconds rather than $session_timeout minutes
					 */
					$session_timeout = $registering_session_timeout;
				}
				
				else if ($_REQUEST['a'] != "register") {
					/* clean out any pending registration requests if the 
					 * action isn't register
					 */
					db_exec("DELETE FROM \"Student_Course\"
						WHERE student_id = " . $auth->get_userid() . "
							AND pending = true;"
					);
				}
				
				break;
			};
			case "FY":
			case "DN": {
				$u_db = db_query("SELECT office, preface, ext 
					FROM \"Faculty\"
					WHERE user_id = " . $sess['user_id'] . ";"
				);
				
				$u = $u_db->get_row();
				
				$auth = new auth_user_faculty($session, $user_info['username'],
					$sess['user_id'], $user_info['first'], $user_info['last'],
					$user_info['email'], $user_info['accesslevel'],
					$u['office'], $u['preface'], $u['ext']);
				
				break;
			};
			case "RC":
			case "RA": {
				$u_db = db_query("SELECT office, ext 
					FROM \"Admin\"
					WHERE user_id = " . $sess['user_id'] . ";"
				);
				
				$u = $u_db->get_row();
				
				$auth = new auth_user_admin($session, $user_info['username'],
					$sess['user_id'], $user_info['first'], $user_info['last'],
					$user_info['email'], $user_info['accesslevel'],
					$u['office'], $u['ext']);
				
				break;
			};
			
			case "DV": {
				$auth = new auth_user($session, $user_info['username'],
					$sess['user_id'], $user_info['first'], $user_info['last'],
					$user_info['email'], $user_info['accesslevel']);
				
				break;
			};
		}
		
		# update the session expiration time with each request
		db_exec("UPDATE \"Logins\" 
			SET expiration_time = now() + interval '$session_timeout minutes'
			WHERE login_id = '" . $session . "';");
		
		# turn off caching since all the pages are dynamic
		header("Cache-Control: no-cache");
		
		# make it refresh the page once the session expires
		header("Refresh: " . (($session_timeout * 60) + 2) 
			. "; URL=" . $_SERVER['PHP_SELF']);
		
		return new return_result(true);
	}
}

class login_action extends actor {
	function execute() {
		global $session_timeout, $use_cookies, $doing_login;
		$doing_login = true;
		
		$user = $_POST['user'];
		$pass = $_POST['pass'];
		
		if ($user != "") {
		
			$verify = db_query("SELECT user_id, passwd, accesslevel 
				FROM \"Users\"
				WHERE username = '" . doslashes($user) . "';"
			);

			if ($verify->has_next()) {
				$r = $verify->get_row();
				
				if ((!empty($r["passwd"])) && ($r["passwd"] == md5($pass))) {
					
					srand();
					
					$session;
					$unique_session = false;
					
					do {
						$session = md5($user_id . $user . time() . rand());
						
						$s = db_query("SELECT user_id 
							FROM \"Logins\" 
							WHERE login_id = '$session';"
						);
						
						if (!$s->has_next()) {
							$unique_session = true;
						}
						
					} while (!$unique_session);
					
					db_exec("DELETE FROM \"Logins\" 
						WHERE user_id = '" . $r["user_id"] . "';");
					
					if (!db_exec("INSERT INTO \"Logins\"
							VALUES (
								'" . $r["user_id"] 
								. "', '" . $session . "',
								now(),
								now() + interval '" . $session_timeout . " minutes', '" 
								. $_SERVER['REMOTE_ADDR'] . "'
							);"
						)) {
						
						$result = new return_result(false);
						$result->add_message("Unable to create login session");
						
						?>
							<html>
								<head>
									<title>Error</title>
								</head>
								<body>
								<center>
									<br><br><br>
									<font color="red">
										<h1>Unable to create login session</h1>
									</font>
								</center>
								</body>
							</html>
						<?php
						
						return $result;
					}
					
					# refresh to the home page once login is complete
					if ($use_cookies) {
						setcookie("s", $session);
						
						redirect_to($_SERVER['PHP_SELF']);
					}
					else {
						redirect_to($_SERVER['PHP_SELF'] . "?s=" . $session);
					}
					
					
					return new return_result(true);
				}
				else {
					trigger("html_headers");
					?>
						<center>
							<font color="red" size="+3">Login incorrect, please try again</font><br>
						</center>
					<?php
					trigger("show_login");
					trigger("html_footers");
					return new return_result(false);
				}
			}
			else {
				trigger("html_headers");
				?>
					<center>
						<font color="red" size="+3">Login incorrect, please try again</font><br>
					</center>
				<?php
				trigger("show_login");
				trigger("html_footers");
				return new return_result(false);
			}
		}
		else {
			trigger("html_headers");
			?>
				<center>
					<font size="+2">Please type a username</font><br>
				</center>
			<?php
			trigger("show_login");
			trigger("html_footers");
			return new return_result(false);
		}
	}
}

class change_password extends actor {
	function execute() {
		global $auth;
	
		$ret = trigger("check_auth");
		
		$show_form = false;
		
		if (!$ret->success())
			return $ret;
		
		if ($_REQUEST['do'] != "") {
			if (($_REQUEST['newpass1'] != $_REQUEST['newpass2']) || ($_REQUEST['newpass1'] == "")) {
				if ($_REQUEST['newpass1'] == "") {
					trigger("html_headers");
					?>
					<font color="red"><h3>Please enter a new password</h3></font>
					<?php
				
					$show_form = true;
				}
				else {
					trigger("html_headers");
					?>
					<font color="red"><h3>New passwords don't match</h3></font>
					<?php
				
					$show_form = true;
				}
			}
			else {
				$db = db_query("SELECT passwd 
					FROM \"Users\" 
					WHERE user_id = " . $auth->get_userid()
				);
				
				$c = $db->get_row();
				
				if (md5($_REQUEST['oldpass']) != $c['passwd']) {
					trigger("html_headers");
					?>
					<font color="red"><h3>Incorrect old password</h3></font>
					<?php
				
					$show_form = true;
				}
				else {
					db_exec("UPDATE \"Users\" 
						SET passwd = '" . md5($_REQUEST['newpass1']) . "'
						WHERE user_id = " . $auth->get_userid() . ";"
					);
					
					trigger("html_headers");
					?>
					<h2>Password changed</h2>
					<?
				}
			}
		}
		else {
			$show_form = true;
		}
		
		if ($show_form) {
			trigger("html_headers");
			?>
			<br>
			<form action="index.php" method="post">
				<input type="hidden" name="a" value="passwd">
				<?php do_form_s(); ?>
				<input type="hidden" name="do" value="change">
				<table>
					<tr><td><label>Old Password:</td><td><input type="password" name="oldpass"></label></td></tr>
					<tr><td><label>New Password:</td><td><input type="password" name="newpass1"></label><br></td></tr>
					<tr><td><label>Repeat:</td><td><input type="password" name="newpass2"></label><br></td></tr>
					<tr><td colspan=2 align="center"><label><input id="button" type="submit" value="Change">&nbsp;&nbsp;&nbsp;&nbsp;<input type="reset" id="button" value="Clear"></label><br></td></tr>
				</table>
			</form>
			<?php
		}
		trigger("html_footers");
		
		return new return_result(true);
	}
}

class logout_action extends actor {
	function execute() {
		global $auth, $use_cookies;
		$r = trigger("check_auth");
		
		if ($r->success()) {
			$session = $auth->get_session();
			
			if ($use_cookies) {
				setcookie("s", "");
			}
			
			db_exec("DELETE FROM \"Logins\" 
				WHERE login_id = '" . $session . "';"
			);
		}
		redirect_to($_SERVER['PHP_SELF']);
		
		return new return_result(true);
	}
}

register_handler(new show_login("show_login", 50));
register_handler(new check_auth("check_auth", 50));
register_action(new login_action("login", 50));
register_action(new logout_action("logout", 50));
register_action(new change_password("passwd", 50));

?>
