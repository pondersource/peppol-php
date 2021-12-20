Requirements:
- php7
- php-soap
- Saxon\C (https://www.saxonica.com/saxon-c/documentation/index.html#!starting/installing), if someone knows a different library to use here i'm all ears. ideally actually written in php (or c) instead of a transpiled-to-C java codebase that has reached eol

usage:

php -S localhost:8080 soapServer.php

to run client, see client-3