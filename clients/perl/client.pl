#!/usr/bin/perl -w
#
# Copyright (C) 2009 Thomas Cort <tcort@tomcort.com>
#
# This file is part of scurrility.
#
# This program is free software: you can redistribute it and/or modify
# it under the terms of the GNU Affero General Public License as published by
# the Free Software Foundation, either version 3 of the License, or
# (at your option) any later version.
#
# This program is distributed in the hope that it will be useful,
# but WITHOUT ANY WARRANTY; without even the implied warranty of
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
# GNU Affero General Public License for more details.
#
# You should have received a copy of the GNU Affero General Public License
# along with this program.  If not, see <http://www.gnu.org/licenses/>.

use strict;
use SOAP::Lite;

sub filter {
	my($msg) = @_;

	return SOAP::Lite
		-> uri('http://www.scurrility.ws/scurrility')
		-> proxy('http://www.scurrility.ws/scurrility/scurrility.php')
		-> Scurrility($msg)
		-> result;
}

sub getSourceCode {
	return SOAP::Lite
		-> uri('http://www.scurrility.ws/scurrility')
		-> proxy('http://www.scurrility.ws/scurrility/scurrility.php')
		-> GetSourceCode('server')
		-> result;
}

print &filter('go to hell') . "\n";
print &getSourceCode() . "\n";
