#!/usr/bin/ruby
=begin
=
= Copyright (C) 2009 Thomas Cort <tcort@tomcort.com>
=
= This file is part of scurrility.
=
= This program is free software: you can redistribute it and/or modify
= it under the terms of the GNU Affero General Public License as published by
= the Free Software Foundation, either version 3 of the License, or
= (at your option) any later version.
=
= This program is distributed in the hope that it will be useful,
= but WITHOUT ANY WARRANTY; without even the implied warranty of
= MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
= GNU Affero General Public License for more details.
=
= You should have received a copy of the GNU Affero General Public License
= along with this program. If not, see <http://www.gnu.org/licenses/>.
=
=end

require "soap/wsdlDriver"

def filter(msg)
	service = SOAP::WSDLDriverFactory.new('scurrility.wsdl').create_rpc_driver
	service.generate_explicit_type = true
	service.wiredump_dev = STDOUT if $DEBUG
	return service.Scurrility(:message => msg).message
end

def getSourceCode()
	service = SOAP::WSDLDriverFactory.new('scurrility.wsdl').create_rpc_driver
	service.generate_explicit_type = true
	service.wiredump_dev = STDOUT if $DEBUG
	return service.GetSourceCode('server').location
end

def getVersion()
	service = SOAP::WSDLDriverFactory.new('scurrility.wsdl').create_rpc_driver
	service.generate_explicit_type = true
	service.wiredump_dev = STDOUT if $DEBUG
	return service.GetVersion('server').version
end

puts filter('go to hell')
puts getSourceCode()
puts getVersion()
