#!/bin/sh
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

set -e

echo "***********************"
echo "*** EXEC RUBY START ***"
echo "***********************"
cd ruby
ruby client.rb
cd ..
echo "***********************"
echo "***  EXEC RUBY END  ***"
echo "***********************"
echo ""
echo "***********************"
echo "** EXEC PYTHON START **"
echo "***********************"
cd python
python client.py
cd ..
echo "***********************"
echo "*** EXEC PYTHON END ***"
echo "***********************"
echo ""
echo "***********************"
echo "*** EXEC PHP START  ***"
echo "***********************"
cd php
php client.php
cd ..
echo "***********************"
echo "***  EXEC PHP END   ***"
echo "***********************"
echo ""
echo "***********************"
echo "***  EXEC PERL END  ***"
echo "***********************"
cd perl
perl client.pl
cd ..
echo "***********************"
echo "***  EXEC PERL END  ***"
echo "***********************"
