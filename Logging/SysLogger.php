<?php

namespace Lyavon\Logging;

use Psr\Log\LogLevel;

use Lyavon\Logging\AbstractPriorityLogger;

class SysLogger extends AbstractPriorityLogger
{
  protected int $maxLogPriority;
  protected string $subsystemName;

  public function __construct(
    int $maxLogPriority = LOG_ERR,
    string $subsystemName = 'HttpServer',
  ) {
    $this->maxLogPriority = $maxLogPriority;
    $this->subsystemName = $subsystemName;
  }

  public function log(mixed $level, string|\Stringable $message, array $context = []): void
  {
    $priority = $this->logLevelPriority($level);

    if ($priority > $this->maxLogPriority)
      return;
    openlog($this->subsystemName, LOG_CONS, LOG_DAEMON);
    syslog($priority, $this->substitute($message, $context));
    closelog();
  }
}

