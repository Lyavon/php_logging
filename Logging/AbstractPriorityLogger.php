<?php

namespace Lyavon\Logging;

use Psr\Log\AbstractLogger;
use Psr\Log\LogLevel;

abstract class AbstractPriorityLogger extends AbstractLogger
{
    protected static function logLevelPriority(mixed $level): int
    {
        switch ($level) {
            case LogLevel::EMERGENCY:
                return LOG_EMERG;
            case LogLevel::ALERT:
                return LOG_ALERT;
            case LogLevel::CRITICAL:
                return LOG_CRIT;
            case LogLevel::ERROR:
                return LOG_ERR;
            case LogLevel::WARNING:
                return LOG_WARNING;
            case LogLevel::NOTICE:
                return LOG_NOTICE;
            case LogLevel::INFO:
                return LOG_INFO;
            default:
            case LogLevel::DEBUG:
                return LOG_DEBUG;
        }
    }

    protected static function substitute(string $message, array $context = []): string
    {
        foreach ($context as $k => $v) {
            if (is_string($v) || method_exists($v, '__toString')) {
                $message = str_replace('{' . $k . '}', $v, $message);
            }
        }
        return $message;
    }
}
