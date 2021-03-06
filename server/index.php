<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <!--
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
    -->
    <title>scurrility javascript client demo</title>
    <meta http-equiv="Content-Language" content="English" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <script type="text/javascript" src="js/client.js"></script>
    <link rel="stylesheet" type="text/css" href="css/client.css" media="screen" />
  </head>
  <body>
    <div id="header">
      scurrility
    </div>
    <div id="container">
      <div id="content">
        <table>
          <tr>
            <td>
              <form action="javascript:scurrility_request()" id="sf">
                <fieldset>
                  <p>
                    <textarea name="msgi" id="msgi" rows="4" cols="35"></textarea>
                  </p><p class="centered">
                    <input type="submit" id="submit" value="Apply scurrility Filter Now!"/><br/>
                  </p><p>
                    <textarea name="msgf" id="msgf" rows="4" cols="35"></textarea>
                  </p>
                </fieldset> 
              </form>
            </td>
          </tr>
          <tr>
            <td>
              <p class="centered" id="footer">
                <a href="https://savannah.nongnu.org/projects/scurrility/">{project}</a>
                <a href="http://identi.ca/group/scurrility">{blog}</a>
                <a href="http://lists.nongnu.org/mailman/listinfo/scurrility-discuss">{mail}</a>
                <a href="http://git.savannah.gnu.org/cgit/scurrility.git">{src}</a>
                <a href="http://www.scurrility.ws/scurrility/scurrility.php">{soap}</a>
                <a href="http://www.scurrility.ws/scurrility/scurrility.php?wsdl">{wsdl}</a>
              </p>
            </td>
          </tr>
          <tr>
            <td>
              <p class="centered">
                <a href="http://www.fsf.org/licensing/licenses/agpl-3.0.html"><img src="img/agplv3-155x51.png" alt="[AGPL v3.0 Logo]" border="0" /></a>
            </td>
          </tr>
        </table>
      </div>
    </div>
  </body>
</html>
