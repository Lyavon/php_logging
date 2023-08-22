<?php
/* Copyright 2023 Leonid Ragunovich
 *
 * This file is part of php_logging.
 *
 * php_logging is free software: you can redistribute it and/or modify it under
 * the terms of the GNU General Public License as published by the Free
 * Software Foundation, either version 3 of the License, or (at your option)
 * any later version.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or
 * FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for
 * more details.
 *
 * You should have received a copy of the GNU General Public License along with
 * this program (see LICENSE file in parent directory). If not, see
 * <https://www.gnu.org/licenses/>.
 */

namespace Lyavon\Logging;

use Psr\Log\AbstractLogger;
use Psr\Log\LogLevel;

/**
 * AbstractPriorityLogger provides default mechanisms for context subtitution
 * and psr-3/syslog logging levels conversion.
 */
abstract class AbstractPriorityLogger extends AbstractLogger
{
    /**
     * Convert psr-3 priority level to syslog one.
     *
     * @param mixed $level psr-3 priority level.
     * @return int Syslog priority level. Returns LOG_DEBUG for unknown level
     * provided.
     */
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

    /**
     * Substitute existing message placeholders with corresponding context
     * values.
     *
     * @param string|\Stringable $message Message with placeholders.
     * @param array $context Array with values for subtitution.
     * @return string Message with all possible substitutions made.
     */
    protected static function substitute(string|\Stringable $message, array $context = []): string
    {
        foreach ($context as $k => $v) {
            $message = str_replace('{' . $k . '}', var_export($v, true), $message);
        }
        return $message;
    }
}
