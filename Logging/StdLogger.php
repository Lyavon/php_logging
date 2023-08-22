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
 * StdLogger is a psr-3-compatible lightweight logger using stderr as output.
 */
class StdLogger extends AbstractPriorityLogger
{
    /**
     * @var int $maxLogPriority Maximal priority level that is allowed with
     * this logger instance.
     */
    protected int $maxLogPriority;

    /**
     * Construct StdLogger.
     *
     * @param int $maxLogPriority Maximal priority level that is allowed with
     * this logger instance. LOG_ERR by default.
     */
    public function __construct(
        int $maxLogPriority = LOG_ERR,
    ) {
        $this->maxLogPriority = $maxLogPriority;
        $this->fd = fopen('php://stderr', 'w');
    }

    /**
     * Destroy StdLogger.
     */
    public function __destruct()
    {
        fclose($this->fd);
    }

    /**
     * @inheritDoc
     */
    public function log(mixed $level, string|\Stringable $message, array $context = []): void
    {
        if ($this->logLevelPriority($level) > $this->maxLogPriority) {
            return;
        }
        fprintf(
            $this->fd,
            "%s [%s]: %s\n",
            (new \DateTime())->format('Y.m.d_H:i:s:v'),
            $level,
            $this->substitute($message, $context),
        );
    }
}
