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

Optional logging level argument sets threshold for the logger.

```php
<?php

use Lyavon\Logging\SysLogger;
use Lyavon\Logging\StdLogger;


$stdLogger = new StdLogger(LOG_DEBUG); // LOG_ERR if omitted

$sysLogger = new SysLogger(
    LOG_INFO, // LOG_ERR if omitted
    'MyCoolApp', // 'HttpServer' if omitted
);

```
