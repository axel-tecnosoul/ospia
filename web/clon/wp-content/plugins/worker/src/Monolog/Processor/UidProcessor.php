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
 * Adds a unique identifier into records
 *
 * @author Simon Mönch <sm@webfactory.de>
 */
class Monolog_Processor_UidProcessor implements Monolog_Processor_ProcessorInterface
{
    private $uid;

    public function __construct($length = 7)
    {
        if (!is_int($length) || $length > 32 || $length < 1) {
            throw new InvalidArgumentException('The uid length must be an integer between 1 and 32');
        }

        $this->uid = substr(hash('md5', uniqid('', true)), 0, $length);
    }

    public function callback(array $record)
    {
        $record['extra']['uid'] = $this->uid;

        return $record;
    }
}
