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

use Psr\Log\LogLevel;

use Lyavon\Logging\AbstractPriorityLogger;

/**
 * SysLogger is a psr-3-compatible lightweight logger using syslog as output.
 */
class SysLogger extends AbstractPriorityLogger
{
    /**
     * @var int $maxLogPriority Maximal priority level that is allowed with
     * this logger instance.
     */
    protected int $maxLogPriority;
    /**
     * @var string $subsystemName Subsystem name for the logger instance.
     * Allows to differentiate logs among several server subsystems.
     */
    protected string $subsystemName;

    /**
     * Construct SysLogger.
     *
     * @param int $maxLogPriority Maximal priority level that is allowed with
     * this logger instance. LOG_ERR by default.
     * @param string $subsystemName Subsystem name for the logger instance.
     * Allows to differentiate logs among several server subsystems.
     */
    public function __construct(
        int $maxLogPriority = LOG_ERR,
        string $subsystemName = 'HttpServer',
    ) {
        $this->maxLogPriority = $maxLogPriority;
        $this->subsystemName = $subsystemName;
    }

    /**
     * @inheritDoc
     */
    public function log(mixed $level, string|\Stringable $message, array $context = []): void
    {
        $priority = $this->logLevelPriority($level);

        if ($priority > $this->maxLogPriority) {
            return;
        }
        openlog($this->subsystemName, LOG_CONS, LOG_DAEMON);
        syslog($priority, $this->substitute($message, $context));
        closelog();
    }
}
