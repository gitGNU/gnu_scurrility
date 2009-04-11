/*
 * @licstart  The following is the entire license notice for the Javascript code in this page.
 *
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
 *
 * @licend  The above is the entire license notice for the Javascript code in this page.
 */

// @source: http://git.savannah.gnu.org/cgit/scurrility.git/tree/clients/javascript

var soapHost = 'www.scurrility.ws';
var soapURI = 'http://' + soapHost + '/scurrility/scurrility.php';

function scurrility_response(response) {
	var soapenvelope = response.documentElement;

	if (soapenvelope.nodeName != 'soapenv:Envelope' && soapenvelope.nodeName != 'SOAP-ENV:Envelope') {
		alert('Error: cannot find SOAP Envelope');
		return;
	}

	if (!soapenvelope.hasChildNodes()) {
		alert('Error: SOAP Envelope has no children');
		return;
	}

	var soapbody = soapenvelope.firstChild;

	if (soapbody.nodeName != 'soapenv:Body' && soapbody.nodeName != 'SOAP-ENV:Body') {
		alert('Error: cannot find SOAP Body');
		return;
	}

	if (!soapbody.hasChildNodes()) {
                alert('Error: SOAP Body has no children');
		return;
	}

	var scurrilityResponse = soapbody.firstChild;

	if (scurrilityResponse.nodeName != 'ScurrilityResponse') {
		alert('Error: cannot find Scurrility Response');
		return;
	}

	if (!scurrilityResponse.hasChildNodes()) {
		alert('Error: Scurrility Response has no children');
		return;
	}

	var message = scurrilityResponse.firstChild;

	if (message.nodeName != 'message') {
		alert('Error: cannot find message');
		return;
	}

	if (!message.hasChildNodes()) {
		alert('Error: message has no children');
		return;
	}

	var messageValue = message.firstChild.nodeValue;

	if (messageValue == null || messageValue == '') {
		alert('Error: Empty message');
		return;
	}

	alert(messageValue);

	return;
}

function scurrility_request(msg) {

	// if this script is not hosted on the same server as the SOAP service,
        // then we need to enable UniversalBrowserRead to allow XMLHttpRequests.
	if (soapHost.toLowerCase().replace(/www./i,"") != location.hostname.toLowerCase().replace(/www./i,"")) {
		try {
			netscape.security.PrivilegeManager.enablePrivilege("UniversalBrowserRead");
		} catch (e) {
			alert('Error: Enable Privilege [UniversalBrowserRead] Failed');
		}
	}


	var request = null;
	if (window.XMLHttpRequest) {
		request = new XMLHttpRequest();
	} else if (window.ActiveXObject) {
		request = new ActiveXObject("Microsoft.XMLHTTP");
	}

	if (request == null) {
                alert('Error: Cannot create XMLHttpRequest');
		return;
	}

	request.open('POST', soapURI, true);
	request.setRequestHeader("SOAPAction", "http://www.scurrility.ws/scurrility/Scurrility");
	request.setRequestHeader("Content-Type", "text/xml; charset=utf-8");

	request.onreadystatechange = function() {
		if (request.readyState == 4) {
			if (request.status == 200) {
				if (request.responseXML) {
					scurrility_response(request.responseXML);
				} else {
					alert('Error: Server didn\'t return a result');
				}
			} else {
                                alert('Error: Server didn\'t return 200 OK');
			}
		}
	}

	var soap = "<?xml version=\"1.0\" encoding=\"utf-8\"?>"						+
		"<soap:Envelope "									+
			"xmlns:xsi=\"http://www.w3.org/2001/XMLSchema-instance\" "			+
			"xmlns:xsd=\"http://www.w3.org/2001/XMLSchema\" "				+
			"xmlns:soap=\"http://schemas.xmlsoap.org/soap/envelope/\">"			+
			"<soap:Body>"									+
				"<m:ScurrilityRequest xmlns:m=\"http://www.scurrility.ws/scurrility\">"	+
					"<message>" + msg + "</message>"				+
				"</m:ScurrilityRequest>"						+
			"</soap:Body>"									+
		"</soap:Envelope>";

	request.send(soap);

	return;
}

