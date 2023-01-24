<?php

namespace Lyavon\Logging;

use Psr\Log\LogLevel;

use Lyavon\Logging\AbstractPriorityLogger;


class StdLogger extends AbstractPriorityLogger
{
  protected int $maxLogPriority;

  public function __construct(
    int $maxLogPriority = LOG_ERR,
  )
  {
    $this->maxLogPriority = $maxLogPriority;
    $this->fd = fopen('php://stderr', 'w');
  }

  public function __destruct() {
    fclose($this->fd);
  }
  
  public function log(mixed $level, string|\Stringable $message, array $context = []): void
  {
    if ($this->logLevelPriority($level) > $this->maxLogPriority)
      return;
    fprintf(
      $this->fd,
      "%s [%s]: %s\n",
      (new \DateTime())->format('Y.m.d_H:i:s:v'),
      $level,
      $this->substitute($message, $context),
    );
  }
}

