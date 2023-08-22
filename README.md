# Logging

This repository contains impementation of psr-3 compatible loggers with level
control.

## Installation

Add the following entries to the __composer.json__:
```json
"require": {
    "lyavon/logging": "dev-master"
},
"repositories": [
    {
        "url": "https://github.com/Lyavon/php_logging.git",
        "type": "vcs"
    }
],
```

## Usage

This repository provides __StdLogger__ and __SysLogger__ inside the
__Lyavon\Logging__ namespace.

```php
<?php

use Lyavon\Logging\SysLogger;
use Lyavon\Logging\StdLogger;


$stdLogger = new StdLogger(LOG_DEBUG); // LOG_ERR if omitted

$sysLogger = new SysLogger(
    LOG_INFO, // LOG_ERR if omitted
    'MyCoolApp', // 'HttpServer' if omitted
);

// Further usage as in psr-3:
$stdLogger->critical('Ouch, my {item} hurts!', ['item' => 'hand']);
$sysLogger->error('A plain old error.');

```

## Scripts usage
php\_logging provides several scripts for convenience:

```sh
# Generate phpdoc (output is going to *documentation* directory of project
# root. Expects phpdoc to be installed globally).
sh scripts/documentation.sh
# or
composer run-script documentation

# Show documentation (opens in the default browser. Will try to run
# _documentation_ if it has not been done yet).
sh scripts/show-documentation.sh
# or
composer run-script show-documentation

# Fix codestyle (Expects php-cs-fixer to be installed globally).
sh scripts/codestyle.sh
# or
composer run-script codestyle
```

## License
This program is free software: you can redistribute it and/or modify it under
the terms of the GNU General Public License as published by the Free Software
Foundation, either version 3 of the License, or (at your option) any later
version.

This program is distributed in the hope that it will be useful, but WITHOUT ANY
WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A
PARTICULAR PURPOSE. See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with
this program (see LICENSE file in this directory). If not, see
<https://www.gnu.org/licenses/>.
