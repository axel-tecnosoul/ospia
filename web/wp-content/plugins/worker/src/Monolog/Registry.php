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
 * Monolog log registry
 *
 * Allows to get `Logger` instances in the global scope
 * via static method calls on this class.
 *
 * <code>
 * $application = new Monolog\Logger('application');
 * $api = new Monolog\Logger('api');
 *
 * Monolog\Registry::addLogger($application);
 * Monolog\Registry::addLogger($api);
 *
 * function testLogger()
 * {
 *     Monolog\Registry::api()->addError('Sent to $api Logger instance');
 *     Monolog\Registry::application()->addError('Sent to $application Logger instance');
 * }
 * </code>
 *
 * @author Tomas Tatarko <tomas@tatarko.sk>
 */
class Monolog_Registry
{
    /**
     * List of all loggers in the registry (ba named indexes)
     *
     * @var Monolog_Logger[]
     */
    private static $loggers = array();

    /**
     * Adds new logging channel to the registry
     *
     * @param Monolog_Logger $logger    Instance of the logging channel
     * @param string|null    $name      Name of the logging channel ($logger->getName() by default)
     * @param boolean        $overwrite Overwrite instance in the registry if the given name already exists?
     *
     * @throws InvalidArgumentException If $overwrite set to false and named Logger instance already exists
     */
    public static function addLogger(Monolog_Logger $logger, $name = null, $overwrite = false)
    {
        $name = $name ? $name : $logger->getName();

        if (isset(self::$loggers[$name]) && !$overwrite) {
            throw new InvalidArgumentException('Logger with the given name already exists');
        }

        self::$loggers[$name] = $logger;
    }

    /**
     * Removes instance from registry by name or instance
     *
     * @param string|Monolog_Logger $logger Name or logger instance
     */
    public static function removeLogger($logger)
    {
        if ($logger instanceof Monolog_Logger) {
            if (false !== ($idx = array_search($logger, self::$loggers, true))) {
                unset(self::$loggers[$idx]);
            }
        } else {
            unset(self::$loggers[$logger]);
        }
    }

    /**
     * Clears the registry
     */
    public static function clear()
    {
        self::$loggers = array();
    }

    /**
     * Gets Logger instance from the registry
     *
     * @param string $name Name of the requested Logger instance
     *
     * @return Monolog_Logger           Requested instance of Logger
     * @throws InvalidArgumentException If named Logger instance is not in the registry
     */
    public static function getInstance($name)
    {
        if (!isset(self::$loggers[$name])) {
            throw new InvalidArgumentException(sprintf('Requested "%s" logger instance is not in the registry', $name));
        }

        return self::$loggers[$name];
    }
}
