<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * Exception that is thrown when a process times out.
 *
 * @author Johannes M. Schmitt <schmittjoh@gmail.com>
 */
class Symfony_Process_Exception_ProcessTimedOutException extends Symfony_Process_Exception_RuntimeException
{
    const TYPE_GENERAL = 1;
    const TYPE_IDLE = 2;

    private $process;
    private $timeoutType;

    public function __construct(Symfony_Process_Process $process, $timeoutType)
    {
        $this->process = $process;
        $this->timeoutType = $timeoutType;

        parent::__construct(sprintf(
            'The process "%s" exceeded the timeout of %s seconds.',
            $process->getCommandLine(),
            $this->getExceededTimeout()
        ));
    }

    public function getProcess()
    {
        return $this->process;
    }

    public function isGeneralTimeout()
    {
        return $this->timeoutType === self::TYPE_GENERAL;
    }

    public function isIdleTimeout()
    {
        return $this->timeoutType === self::TYPE_IDLE;
    }

    public function getExceededTimeout()
    {
        switch ($this->timeoutType) {
            case self::TYPE_GENERAL:
                return $this->process->getTimeout();

            case self::TYPE_IDLE:
                return $this->process->getIdleTimeout();

            default:
                throw new Symfony_Process_Exception_LogicException(sprintf('Unknown timeout type "%d".', $this->timeoutType));
        }
    }
}
