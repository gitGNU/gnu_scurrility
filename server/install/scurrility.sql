-- Copyright (C) 2009 Thomas Cort <tcort@tomcort.com>
--
-- This file is part of scurrility.
--
-- This program is free software: you can redistribute it and/or modify
-- it under the terms of the GNU Affero General Public License as published by
-- the Free Software Foundation, either version 3 of the License, or
-- (at your option) any later version.
--
-- This program is distributed in the hope that it will be useful,
-- but WITHOUT ANY WARRANTY; without even the implied warranty of
-- MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
-- GNU Affero General Public License for more details.
--
-- You should have received a copy of the GNU Affero General Public License
-- along with this program.  If not, see <http://www.gnu.org/licenses/>.

CREATE DATABASE scurrility;
USE scurrility;

CREATE TABLE words (
	id INT UNSIGNED AUTO_INCREMENT NOT NULL PRIMARY KEY,
	word TEXT,
	FULLTEXT (word)
);

CREATE TABLE stats (
	id INT UNSIGNED AUTO_INCREMENT NOT NULL PRIMARY KEY,
	ip CHAR(15) NOT NULL,
	agent VARCHAR(255) NOT NULL,
	hits INT UNSIGNED NOT NULL DEFAULT 0,
	tmsp TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
