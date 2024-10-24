<?php

/*
 * This file is part of the Monolog package.
 *
 * (c) Jordi Boggiano <j.boggiano@seld.be>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * Injects line/file:class/function where the log message came from
 *
 * Warning: This only works if the handler processes the logs directly.
 * If you put the processor on a handler that is behind a FingersCrossedHandler
 * for example, the processor will only be called once the trigger level is reached,
 * and all the log records will have the same file/line/.. data from the call that
 * triggered the FingersCrossedHandler.
 *
 * @author Jordi Boggiano <j.boggiano@seld.be>
 */
class Monolog_Processor_IntrospectionProcessor implements Monolog_Processor_ProcessorInterface
{
    private $level;

    private $skipClassesPartials;

    public function __construct($level = Monolog_Logger::DEBUG, array $skipClassesPartials = array('Monolog_'))
    {
        $this->level               = $level;
        $this->skipClassesPartials = $skipClassesPartials;
    }

    /**
     * @param array $record
     *
     * @return array
     */
    public function callback(array $record)
    {
        // return if the level is not high enough
        if ($record['level'] < $this->level) {
            return $record;
        }

        $trace = debug_backtrace();

        // skip first since it's always the current method
        array_shift($trace);
        // the call_user_func call is also skipped
        array_shift($trace);

        $i = 0;

        while (isset($trace[$i]['class'])) {
            foreach ($this->skipClassesPartials as $part) {
                if (strpos($trace[$i]['class'], $part) !== false) {
                    $i++;
                    continue 2;
                }
            }
            break;
        }

        // we should have the call source now
        $record['extra'] = array_merge(
            $record['extra'],
            array(
                'file'     => isset($trace[$i - 1]['file']) ? $trace[$i - 1]['file'] : null,
                'line'     => isset($trace[$i - 1]['line']) ? $trace[$i - 1]['line'] : null,
                'class'    => isset($trace[$i]['class']) ? $trace[$i]['class'] : null,
                'function' => isset($trace[$i]['function']) ? $trace[$i]['function'] : null,
            )
        );

        return $record;
    }
}
