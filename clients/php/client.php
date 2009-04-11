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

define('SCURRILITY', true);

require_once('./nusoap/nusoap.php');

$soapurl = 'http://localhost/scurrility/scurrility.php';

function scurrility($message) {
	global $soapurl;

	$soapaction = 'http://www.scurrility.ws/scurrility/Scurrility';
	$soapclient = new nusoap_client($soapurl);

	$soapmsg = $soapclient->serializeEnvelope('<ScurrilityRequest xmlns="http://www.scurrility.ws/scurrility"><message>' . htmlspecialchars($message, ENT_QUOTES) . '</message></ScurrilityRequest>','',array(),'document', 'literal');
	$result = $soapclient->send($soapmsg, $soapaction);

	if ($soapclient->fault) {
		// print_r($result);
		return false;
	}

	// echo $soapclient->request . "\n";
	// echo "---\n";
	// echo $soapclient->response . "\n";

	return $result['message'];
}

echo scurrility('That guy is a fuckin ass asshole') . "\n";

?>
