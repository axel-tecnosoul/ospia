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
 * Process is a thin wrapper around proc_* functions to easily
 * start independent PHP processes.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 * @author Romain Neutron <imprec@gmail.com>
 *
 * @api
 */
class Symfony_Process_Process
{
    const ERR = 'err';
    const OUT = 'out';

    const STATUS_READY = 'ready';
    const STATUS_STARTED = 'started';
    const STATUS_TERMINATED = 'terminated';

    const STDIN = 0;
    const STDOUT = 1;
    const STDERR = 2;

    // Timeout Precision in seconds.
    const TIMEOUT_PRECISION = 0.2;

    private $callback;

    private $commandline;

    private $cwd;

    private $env;

    private $input;

    private $starttime;

    private $lastOutputTime;

    private $timeout;

    private $idleTimeout;

    private $options;

    private $exitcode;

    private $fallbackExitcode;

    private $processInformation;

    private $outputDisabled = false;

    private $stdout;

    private $stderr;

    private $enhanceWindowsCompatibility = true;

    private $enhanceSigchildCompatibility;

    private $process;

    private $status = self::STATUS_READY;

    private $incrementalOutputOffset = 0;

    private $incrementalErrorOutputOffset = 0;

    private $tty;

    private $pty;

    private $useFileHandles = false;

    /** @var Symfony_Process_Pipes_PipesInterface */
    private $processPipes;

    private $latestSignal;

    private static $sigchild;

    /**
     * Exit codes translation table.
     *
     * User-defined errors must use exit codes in the 64-113 range.
     *
     * @var array
     */
    public static $exitCodes = array(
        0   => 'OK',
        1   => 'General error',
        2   => 'Misuse of shell builtins',
        126 => 'Invoked command cannot execute',
        127 => 'Command not found',
        128 => 'Invalid exit argument',
        // signals
        129 => 'Hangup',
        130 => 'Interrupt',
        131 => 'Quit and dump core',
        132 => 'Illegal instruction',
        133 => 'Trace/breakpoint trap',
        134 => 'Process aborted',
        135 => 'Bus error: "access to undefined portion of memory object"',
        136 => 'Floating point exception: "erroneous arithmetic operation"',
        137 => 'Kill (terminate immediately)',
        138 => 'User-defined 1',
        139 => 'Segmentation violation',
        140 => 'User-defined 2',
        141 => 'Write to pipe with no one reading',
        142 => 'Signal raised by alarm',
        143 => 'Termination (request to terminate)',
        // 144 - not defined
        145 => 'Child process terminated, stopped (or continued*)',
        146 => 'Continue if stopped',
        147 => 'Stop executing temporarily',
        148 => 'Terminal stop signal',
        149 => 'Background process attempting to read from tty ("in")',
        150 => 'Background process attempting to write to tty ("out")',
        151 => 'Urgent data available on socket',
        152 => 'CPU time limit exceeded',
        153 => 'File size limit exceeded',
        154 => 'Signal raised by timer counting virtual time: "virtual timer expired"',
        155 => 'Profiling timer expired',
        // 156 - not defined
        157 => 'Pollable event',
        // 158 - not defined
        159 => 'Bad syscall',
    );

    /**
     * Constructor.
     *
     * @param string         $commandline The command line to run
     * @param string|null    $cwd         The working directory or null to use the working dir of the current PHP process
     * @param array|null     $env         The environment variables or null to inherit
     * @param string|null    $input       The input
     * @param int|float|null $timeout     The timeout in seconds or null to disable
     * @param array          $options     An array of options for proc_open
     *
     * @throws RuntimeException When proc_open is not installed
     *
     * @api
     */
    public function __construct($commandline, $cwd = null, array $env = null, $input = null, $timeout = 60, array $options = array())
    {
        if (!function_exists('proc_open') || !function_exists('proc_close')) {
            throw new Symfony_Process_Exception_RuntimeException('The Process class relies on proc_open, which is not available on your PHP installation.');
        }

        $this->commandline = $commandline;
        $this->cwd         = $cwd;

        // on Windows, if the cwd changed via chdir(), proc_open defaults to the dir where PHP was started
        // on Gnu/Linux, PHP builds with --enable-maintainer-zts are also affected
        // @see : https://bugs.php.net/bug.php?id=51800
        // @see : https://bugs.php.net/bug.php?id=50524
        if (null === $this->cwd && (defined('ZEND_THREAD_SAFE') || Symfony_Process_ProcessUtils::isWindows())) {
            $this->cwd = getcwd();
        }
        if (null !== $env) {
            $this->setEnv($env);
        }

        $this->input = $input;
        $this->setTimeout($timeout);
        $this->useFileHandles               = Symfony_Process_ProcessUtils::isWindows();
        $this->pty                          = false;
        $this->enhanceWindowsCompatibility  = true;
        $this->enhanceSigchildCompatibility = !Symfony_Process_ProcessUtils::isWindows() && $this->isSigchildEnabled();
        $this->options                      = Symfony_Process_ProcessUtils::arrayReplace(array('suppress_errors' => true, 'binary_pipes' => true), $options);
    }

    public function __destruct()
    {
        // stop() will check if we have a process running.
        $this->stop();
    }

    public function __clone()
    {
        $this->resetProcessData();
    }

    /**
     * Runs the process.
     *
     * The callback receives the type of output (out or err) and
     * some bytes from the output in real-time. It allows to have feedback
     * from the independent process during execution.
     *
     * The STDOUT and STDERR are also available after the process is finished
     * via the getOutput() and getErrorOutput() methods.
     *
     * @param callable|null $callback A PHP callback to run whenever there is some
     *                                output available on STDOUT or STDERR
     *
     * @return int The exit status code
     *
     * @throws RuntimeException When process can't be launched
     * @throws RuntimeException When process stopped after receiving signal
     * @throws LogicException   In case a callback is provided and output has been disabled
     *
     * @api
     */
    public function run($callback = null)
    {
        $this->start($callback);

        return $this->wait();
    }

    /**
     * Runs the process.
     *
     * This is identical to run() except that an exception is thrown if the process
     * exits with a non-zero exit code.
     *
     * @param callable|null $callback
     *
     * @return self
     *
     * @throws RuntimeException       if PHP was compiled with --enable-sigchild and the enhanced sigchild compatibility mode is not enabled
     * @throws Symfony_Process_Exception_ProcessFailedException if the process didn't terminate successfully
     */
    public function mustRun($callback = null)
    {
        if ($this->isSigchildEnabled() && !$this->enhanceSigchildCompatibility) {
            throw new Symfony_Process_Exception_RuntimeException('This PHP has been compiled with --enable-sigchild. You must use setEnhanceSigchildCompatibility() to use this method.');
        }

        if (0 !== $this->run($callback)) {
            throw new Symfony_Process_Exception_ProcessFailedException($this);
        }

        return $this;
    }

    /**
     * Starts the process and returns after writing the input to STDIN.
     *
     * This method blocks until all STDIN data is sent to the process then it
     * returns while the process runs in the background.
     *
     * The termination of the process can be awaited with wait().
     *
     * The callback receives the type of output (out or err) and some bytes from
     * the output in real-time while writing the standard input to the process.
     * It allows to have feedback from the independent process during execution.
     * If there is no callback passed, the wait() method can be called
     * with true as a second parameter then the callback will get all data occurred
     * in (and since) the start call.
     *
     * @param callable|null $callback A PHP callback to run whenever there is some
     *                                output available on STDOUT or STDERR
     *
     * @throws RuntimeException When process can't be launched
     * @throws RuntimeException When process is already running
     * @throws LogicException   In case a callback is provided and output has been disabled
     */
    public function start($callback = null)
    {
        if ($this->isRunning()) {
            throw new Symfony_Process_Exception_RuntimeException('Process is already running');
        }
        if ($this->outputDisabled && null !== $callback) {
            throw new Symfony_Process_Exception_LogicException('Output has been disabled, enable it to allow the use of a callback.');
        }

        $this->resetProcessData();
        $this->starttime = $this->lastOutputTime = microtime(true);
        $this->callback  = $this->buildCallback($callback);
        $descriptors     = $this->getDescriptors();

        $commandline = $this->commandline;

        if (Symfony_Process_ProcessUtils::isWindows() && $this->enhanceWindowsCompatibility) {
            $commandline = 'cmd /V:ON /E:ON /C "('.$commandline.')';
            foreach ($this->processPipes->getFiles() as $offset => $filename) {
                $commandline .= ' '.$offset.'>'.Symfony_Process_ProcessUtils::escapeArgument($filename);
            }
            $commandline .= '"';

            if (!isset($this->options['bypass_shell'])) {
                $this->options['bypass_shell'] = true;
            }
        }

        $this->process = @proc_open($commandline, $descriptors, $this->processPipes->pipes, $this->cwd, $this->env, $this->options);

        if (!is_resource($this->process)) {
            throw new Symfony_Process_Exception_RuntimeException('Unable to launch a new process.');
        }
        $this->status = self::STATUS_STARTED;

        if ($this->tty) {
            return;
        }

        $this->updateStatus(false);
        $this->checkTimeout();
    }

    /**
     * Restarts the process.
     *
     * Be warned that the process is cloned before being started.
     *
     * @param callable|null $callback A PHP callback to run whenever there is some
     *                                output available on STDOUT or STDERR
     *
     * @return Symfony_Process_Process The new process
     *
     * @throws RuntimeException When process can't be launched
     * @throws RuntimeException When process is already running
     *
     * @see start()
     */
    public function restart($callback = null)
    {
        if ($this->isRunning()) {
            throw new Symfony_Process_Exception_RuntimeException('Process is already running');
        }

        $process = clone $this;
        $process->start($callback);

        return $process;
    }

    /**
     * Waits for the process to terminate.
     *
     * The callback receives the type of output (out or err) and some bytes
     * from the output in real-time while writing the standard input to the process.
     * It allows to have feedback from the independent process during execution.
     *
     * @param callable|null $callback A valid PHP callback
     *
     * @return int The exitcode of the process
     *
     * @throws RuntimeException When process timed out
     * @throws RuntimeException When process stopped after receiving signal
     * @throws LogicException   When process is not yet started
     */
    public function wait($callback = null)
    {
        $this->requireProcessIsStarted(__FUNCTION__);

        $this->updateStatus(false);
        if (null !== $callback) {
            $this->callback = $this->buildCallback($callback);
        }

        do {
            $this->checkTimeout();
            $running = Symfony_Process_ProcessUtils::isWindows() ? $this->isRunning() : $this->processPipes->areOpen();
            $close   = !Symfony_Process_ProcessUtils::isWindows() || !$running;
            $this->readPipes(true, $close);
        } while ($running);

        while ($this->isRunning()) {
            usleep(1000);
        }

        if ($this->processInformation['signaled'] && $this->processInformation['termsig'] !== $this->latestSignal) {
            throw new Symfony_Process_Exception_RuntimeException(sprintf('The process has been signaled with signal "%s".', $this->processInformation['termsig']));
        }

        return $this->exitcode;
    }

    /**
     * Returns the Pid (process identifier), if applicable.
     *
     * @return int|null The process id if running, null otherwise
     *
     * @throws RuntimeException In case --enable-sigchild is activated
     */
    public function getPid()
    {
        if ($this->isSigchildEnabled()) {
            throw new Symfony_Process_Exception_RuntimeException('This PHP has been compiled with --enable-sigchild. The process identifier can not be retrieved.');
        }

        $this->updateStatus(false);

        return $this->isRunning() ? $this->processInformation['pid'] : null;
    }

    /**
     * Sends a POSIX signal to the process.
     *
     * @param int $signal A valid POSIX signal (see http://www.php.net/manual/en/pcntl.constants.php)
     *
     * @return Symfony_Process_Process
     *
     * @throws LogicException   In case the process is not running
     * @throws RuntimeException In case --enable-sigchild is activated
     * @throws RuntimeException In case of failure
     */
    public function signal($signal)
    {
        $this->doSignal($signal, true);

        return $this;
    }

    /**
     * Disables fetching output and error output from the underlying process.
     *
     * @return Symfony_Process_Process
     *
     * @throws RuntimeException In case the process is already running
     * @throws LogicException   if an idle timeout is set
     */
    public function disableOutput()
    {
        if ($this->isRunning()) {
            throw new Symfony_Process_Exception_RuntimeException('Disabling output while the process is running is not possible.');
        }
        if (null !== $this->idleTimeout) {
            throw new Symfony_Process_Exception_LogicException('Output can not be disabled while an idle timeout is set.');
        }

        $this->outputDisabled = true;

        return $this;
    }

    /**
     * Enables fetching output and error output from the underlying process.
     *
     * @return Symfony_Process_Process
     *
     * @throws RuntimeException In case the process is already running
     */
    public function enableOutput()
    {
        if ($this->isRunning()) {
            throw new Symfony_Process_Exception_RuntimeException('Enabling output while the process is running is not possible.');
        }

        $this->outputDisabled = false;

        return $this;
    }

    /**
     * Returns true in case the output is disabled, false otherwise.
     *
     * @return bool
     */
    public function isOutputDisabled()
    {
        return $this->outputDisabled;
    }

    /**
     * Returns the current output of the process (STDOUT).
     *
     * @return string The process output
     *
     * @throws LogicException in case the output has been disabled
     * @throws LogicException In case the process is not started
     *
     * @api
     */
    public function getOutput()
    {
        if ($this->outputDisabled) {
            throw new Symfony_Process_Exception_LogicException('Output has been disabled.');
        }

        $this->requireProcessIsStarted(__FUNCTION__);

        $this->readPipes(false, Symfony_Process_ProcessUtils::isWindows() ? !$this->processInformation['running'] : true);

        return $this->stdout;
    }

    /**
     * Returns the output incrementally.
     *
     * In comparison with the getOutput method which always return the whole
     * output, this one returns the new output since the last call.
     *
     * @throws LogicException in case the output has been disabled
     * @throws LogicException In case the process is not started
     *
     * @return string The process output since the last call
     */
    public function getIncrementalOutput()
    {
        $this->requireProcessIsStarted(__FUNCTION__);

        $data = $this->getOutput();

        $latest = substr($data, $this->incrementalOutputOffset);

        if (false === $latest) {
            return '';
        }

        $this->incrementalOutputOffset = strlen($data);

        return $latest;
    }

    /**
     * Clears the process output.
     *
     * @return Symfony_Process_Process
     */
    public function clearOutput()
    {
        $this->stdout                  = '';
        $this->incrementalOutputOffset = 0;

        return $this;
    }

    /**
     * Returns the current error output of the process (STDERR).
     *
     * @return string The process error output
     *
     * @throws LogicException in case the output has been disabled
     * @throws LogicException In case the process is not started
     *
     * @api
     */
    public function getErrorOutput()
    {
        if ($this->outputDisabled) {
            throw new Symfony_Process_Exception_LogicException('Output has been disabled.');
        }

        $this->requireProcessIsStarted(__FUNCTION__);

        $this->readPipes(false, Symfony_Process_ProcessUtils::isWindows() ? !$this->processInformation['running'] : true);

        return $this->stderr;
    }

    /**
     * Returns the errorOutput incrementally.
     *
     * In comparison with the getErrorOutput method which always return the
     * whole error output, this one returns the new error output since the last
     * call.
     *
     * @throws LogicException in case the output has been disabled
     * @throws LogicException In case the process is not started
     *
     * @return string The process error output since the last call
     */
    public function getIncrementalErrorOutput()
    {
        $this->requireProcessIsStarted(__FUNCTION__);

        $data = $this->getErrorOutput();

        $latest = substr($data, $this->incrementalErrorOutputOffset);

        if (false === $latest) {
            return '';
        }

        $this->incrementalErrorOutputOffset = strlen($data);

        return $latest;
    }

    /**
     * Clears the process output.
     *
     * @return Symfony_Process_Process
     */
    public function clearErrorOutput()
    {
        $this->stderr                       = '';
        $this->incrementalErrorOutputOffset = 0;

        return $this;
    }

    /**
     * Returns the exit code returned by the process.
     *
     * @return null|int The exit status code, null if the Process is not terminated
     *
     * @throws RuntimeException In case --enable-sigchild is activated and the sigchild compatibility mode is disabled
     *
     * @api
     */
    public function getExitCode()
    {
        if ($this->isSigchildEnabled() && !$this->enhanceSigchildCompatibility) {
            throw new Symfony_Process_Exception_RuntimeException('This PHP has been compiled with --enable-sigchild. You must use setEnhanceSigchildCompatibility() to use this method.');
        }

        $this->updateStatus(false);

        return $this->exitcode;
    }

    /**
     * Returns a string representation for the exit code returned by the process.
     *
     * This method relies on the Unix exit code status standardization
     * and might not be relevant for other operating systems.
     *
     * @return null|string A string representation for the exit status code, null if the Process is not terminated.
     *
     * @throws RuntimeException In case --enable-sigchild is activated and the sigchild compatibility mode is disabled
     *
     * @see http://tldp.org/LDP/abs/html/exitcodes.html
     * @see http://en.wikipedia.org/wiki/Unix_signal
     */
    public function getExitCodeText()
    {
        if (null === $exitcode = $this->getExitCode()) {
            return null;
        }

        return isset(self::$exitCodes[$exitcode]) ? self::$exitCodes[$exitcode] : 'Unknown error';
    }

    /**
     * Checks if the process ended successfully.
     *
     * @return bool true if the process ended successfully, false otherwise
     *
     * @api
     */
    public function isSuccessful()
    {
        return 0 === $this->getExitCode();
    }

    /**
     * Returns true if the child process has been terminated by an uncaught signal.
     *
     * It always returns false on Windows.
     *
     * @return bool
     *
     * @throws RuntimeException In case --enable-sigchild is activated
     * @throws LogicException   In case the process is not terminated
     *
     * @api
     */
    public function hasBeenSignaled()
    {
        $this->requireProcessIsTerminated(__FUNCTION__);

        if ($this->isSigchildEnabled()) {
            throw new Symfony_Process_Exception_RuntimeException('This PHP has been compiled with --enable-sigchild. Term signal can not be retrieved.');
        }

        $this->updateStatus(false);

        return $this->processInformation['signaled'];
    }

    /**
     * Returns the number of the signal that caused the child process to terminate its execution.
     *
     * It is only meaningful if hasBeenSignaled() returns true.
     *
     * @return int
     *
     * @throws RuntimeException In case --enable-sigchild is activated
     * @throws LogicException   In case the process is not terminated
     *
     * @api
     */
    public function getTermSignal()
    {
        $this->requireProcessIsTerminated(__FUNCTION__);

        if ($this->isSigchildEnabled()) {
            throw new Symfony_Process_Exception_RuntimeException('This PHP has been compiled with --enable-sigchild. Term signal can not be retrieved.');
        }

        $this->updateStatus(false);

        return $this->processInformation['termsig'];
    }

    /**
     * Returns true if the child process has been stopped by a signal.
     *
     * It always returns false on Windows.
     *
     * @return bool
     *
     * @throws LogicException In case the process is not terminated
     *
     * @api
     */
    public function hasBeenStopped()
    {
        $this->requireProcessIsTerminated(__FUNCTION__);

        $this->updateStatus(false);

        return $this->processInformation['stopped'];
    }

    /**
     * Returns the number of the signal that caused the child process to stop its execution.
     *
     * It is only meaningful if hasBeenStopped() returns true.
     *
     * @return int
     *
     * @throws LogicException In case the process is not terminated
     *
     * @api
     */
    public function getStopSignal()
    {
        $this->requireProcessIsTerminated(__FUNCTION__);

        $this->updateStatus(false);

        return $this->processInformation['stopsig'];
    }

    /**
     * Checks if the process is currently running.
     *
     * @return bool true if the process is currently running, false otherwise
     */
    public function isRunning()
    {
        if (self::STATUS_STARTED !== $this->status) {
            return false;
        }

        $this->updateStatus(false);

        return $this->processInformation['running'];
    }

    /**
     * Checks if the process has been started with no regard to the current state.
     *
     * @return bool true if status is ready, false otherwise
     */
    public function isStarted()
    {
        return $this->status != self::STATUS_READY;
    }

    /**
     * Checks if the process is terminated.
     *
     * @return bool true if process is terminated, false otherwise
     */
    public function isTerminated()
    {
        $this->updateStatus(false);

        return $this->status == self::STATUS_TERMINATED;
    }

    /**
     * Gets the process status.
     *
     * The status is one of: ready, started, terminated.
     *
     * @return string The current process status
     */
    public function getStatus()
    {
        $this->updateStatus(false);

        return $this->status;
    }

    /**
     * Stops the process.
     *
     * @param int|float $timeout The timeout in seconds
     * @param int       $signal  A POSIX signal to send in case the process has not stop at timeout, default is SIGKILL
     *
     * @return int The exit-code of the process
     *
     * @throws RuntimeException if the process got signaled
     */
    public function stop($timeout = 10, $signal = null)
    {
        $timeoutMicro = microtime(true) + $timeout;
        if ($this->isRunning()) {
            if (Symfony_Process_ProcessUtils::isWindows() && !$this->isSigchildEnabled()) {
                exec(sprintf('taskkill /F /T /PID %d 2>&1', $this->getPid()), $output, $exitCode);
                if ($exitCode > 0) {
                    throw new Symfony_Process_Exception_RuntimeException('Unable to kill the process');
                }
            }
            // given `SIGTERM` may not be defined and that `proc_terminate` uses the constant value and not the constant itself, we use the same here
            $this->doSignal(15, false);
            do {
                usleep(1000);
            } while ($this->isRunning() && microtime(true) < $timeoutMicro);

            if ($this->isRunning() && !$this->isSigchildEnabled()) {
                if (null !== $signal || defined('SIGKILL')) {
                    // avoid exception here :
                    // process is supposed to be running, but it might have stop
                    // just after this line.
                    // in any case, let's silently discard the error, we can not do anything
                    $this->doSignal($signal ? $signal : SIGKILL, false);
                }
            }
        }

        $this->updateStatus(false);
        if ($this->processInformation['running']) {
            $this->close();
        }

        return $this->exitcode;
    }

    /**
     * Adds a line to the STDOUT stream.
     *
     * @param string $line The line to append
     */
    public function addOutput($line)
    {
        $this->lastOutputTime = microtime(true);
        $this->stdout .= $line;
    }

    /**
     * Adds a line to the STDERR stream.
     *
     * @param string $line The line to append
     */
    public function addErrorOutput($line)
    {
        $this->lastOutputTime = microtime(true);
        $this->stderr .= $line;
    }

    /**
     * Gets the command line to be executed.
     *
     * @return string The command to execute
     */
    public function getCommandLine()
    {
        return $this->commandline;
    }

    /**
     * Sets the command line to be executed.
     *
     * @param string $commandline The command to execute
     *
     * @return self The current Process instance
     */
    public function setCommandLine($commandline)
    {
        $this->commandline = $commandline;

        return $this;
    }

    /**
     * Gets the process timeout (max. runtime).
     *
     * @return float|null The timeout in seconds or null if it's disabled
     */
    public function getTimeout()
    {
        return $this->timeout;
    }

    /**
     * Gets the process idle timeout (max. time since last output).
     *
     * @return float|null The timeout in seconds or null if it's disabled
     */
    public function getIdleTimeout()
    {
        return $this->idleTimeout;
    }

    /**
     * Sets the process timeout (max. runtime).
     *
     * To disable the timeout, set this value to null.
     *
     * @param int|float|null $timeout The timeout in seconds
     *
     * @return self The current Process instance
     *
     * @throws InvalidArgumentException if the timeout is negative
     */
    public function setTimeout($timeout)
    {
        $this->timeout = $this->validateTimeout($timeout);

        return $this;
    }

    /**
     * Sets the process idle timeout (max. time since last output).
     *
     * To disable the timeout, set this value to null.
     *
     * @param int|float|null $timeout The timeout in seconds
     *
     * @return self The current Process instance.
     *
     * @throws LogicException           if the output is disabled
     * @throws InvalidArgumentException if the timeout is negative
     */
    public function setIdleTimeout($timeout)
    {
        if (null !== $timeout && $this->outputDisabled) {
            throw new Symfony_Process_Exception_LogicException('Idle timeout can not be set while the output is disabled.');
        }

        $this->idleTimeout = $this->validateTimeout($timeout);

        return $this;
    }

    /**
     * Enables or disables the TTY mode.
     *
     * @param bool $tty True to enabled and false to disable
     *
     * @return self The current Process instance
     *
     * @throws RuntimeException In case the TTY mode is not supported
     */
    public function setTty($tty)
    {
        if (Symfony_Process_ProcessUtils::isWindows() && $tty) {
            throw new Symfony_Process_Exception_RuntimeException('TTY mode is not supported on Windows platform.');
        }
        if ($tty && (!file_exists('/dev/tty') || !is_readable('/dev/tty'))) {
            throw new Symfony_Process_Exception_RuntimeException('TTY mode requires /dev/tty to be readable.');
        }

        $this->tty = (bool) $tty;

        return $this;
    }

    /**
     * Checks if the TTY mode is enabled.
     *
     * @return bool true if the TTY mode is enabled, false otherwise
     */
    public function isTty()
    {
        return $this->tty;
    }

    /**
     * Sets PTY mode.
     *
     * @param bool $bool
     *
     * @return self
     */
    public function setPty($bool)
    {
        $this->pty = (bool) $bool;

        return $this;
    }

    /**
     * Returns PTY state.
     *
     * @return bool
     */
    public function isPty()
    {
        return $this->pty;
    }

    /**
     * Gets the working directory.
     *
     * @return string|null The current working directory or null on failure
     */
    public function getWorkingDirectory()
    {
        if (null === $this->cwd) {
            // getcwd() will return false if any one of the parent directories does not have
            // the readable or search mode set, even if the current directory does
            return getcwd() ? getcwd() : null;
        }

        return $this->cwd;
    }

    /**
     * Sets the current working directory.
     *
     * @param string $cwd The new working directory
     *
     * @return self The current Process instance
     */
    public function setWorkingDirectory($cwd)
    {
        $this->cwd = $cwd;

        return $this;
    }

    /**
     * Gets the environment variables.
     *
     * @return array The current environment variables
     */
    public function getEnv()
    {
        return $this->env;
    }

    /**
     * Sets the environment variables.
     *
     * An environment variable value should be a string.
     * If it is an array, the variable is ignored.
     *
     * That happens in PHP when 'argv' is registered into
     * the $_ENV array for instance.
     *
     * @param array $env The new environment variables
     *
     * @return self The current Process instance
     */
    public function setEnv(array $env)
    {
        // Process can not handle env values that are arrays
        $env = array_filter($env, 'is_scalar');

        $this->env = array();
        foreach ($env as $key => $value) {
            $this->env[(binary) $key] = (binary) $value;
        }

        return $this;
    }

    /**
     * Gets the Process input.
     *
     * @return null|string The Process input
     */
    public function getInput()
    {
        return $this->input;
    }

    /**
     * Sets the input.
     *
     * This content will be passed to the underlying process standard input.
     *
     * @param mixed $input The content
     *
     * @return self The current Process instance
     *
     * @throws LogicException In case the process is running
     */
    public function setInput($input)
    {
        if ($this->isRunning()) {
            throw new Symfony_Process_Exception_LogicException('Input can not be set while the process is running.');
        }

        $this->input = Symfony_Process_ProcessUtils::validateInput(sprintf('%s::%s', __CLASS__, __FUNCTION__), $input);

        return $this;
    }

    /**
     * Gets the options for proc_open.
     *
     * @return array The current options
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * Sets the options for proc_open.
     *
     * @param array $options The new options
     *
     * @return self The current Process instance
     */
    public function setOptions(array $options)
    {
        $this->options = $options;

        return $this;
    }

    /**
     * Gets whether or not Windows compatibility is enabled.
     *
     * This is true by default.
     *
     * @return bool
     */
    public function getEnhanceWindowsCompatibility()
    {
        return $this->enhanceWindowsCompatibility;
    }

    /**
     * Sets whether or not Windows compatibility is enabled.
     *
     * @param bool $enhance
     *
     * @return self The current Process instance
     */
    public function setEnhanceWindowsCompatibility($enhance)
    {
        $this->enhanceWindowsCompatibility = (bool) $enhance;

        return $this;
    }

    /**
     * Returns whether sigchild compatibility mode is activated or not.
     *
     * @return bool
     */
    public function getEnhanceSigchildCompatibility()
    {
        return $this->enhanceSigchildCompatibility;
    }

    /**
     * Activates sigchild compatibility mode.
     *
     * Sigchild compatibility mode is required to get the exit code and
     * determine the success of a process when PHP has been compiled with
     * the --enable-sigchild option
     *
     * @param bool $enhance
     *
     * @return self The current Process instance
     */
    public function setEnhanceSigchildCompatibility($enhance)
    {
        $this->enhanceSigchildCompatibility = (bool) $enhance;

        return $this;
    }

    /**
     * Performs a check between the timeout definition and the time the process started.
     *
     * In case you run a background process (with the start method), you should
     * trigger this method regularly to ensure the process timeout
     *
     * @throws Symfony_Process_Exception_ProcessTimedOutException In case the timeout was reached
     */
    public function checkTimeout()
    {
        if ($this->status !== self::STATUS_STARTED) {
            return;
        }

        if (null !== $this->timeout && $this->timeout < microtime(true) - $this->starttime) {
            $this->stop(0);

            throw new Symfony_Process_Exception_ProcessTimedOutException($this, Symfony_Process_Exception_ProcessTimedOutException::TYPE_GENERAL);
        }

        if (null !== $this->idleTimeout && $this->idleTimeout < microtime(true) - $this->lastOutputTime) {
            $this->stop(0);

            throw new Symfony_Process_Exception_ProcessTimedOutException($this, Symfony_Process_Exception_ProcessTimedOutException::TYPE_IDLE);
        }
    }

    /**
     * Returns whether PTY is supported on the current operating system.
     *
     * @return bool
     */
    public static function isPtySupported()
    {
        static $result;

        if (null !== $result) {
            return $result;
        }

        if (Symfony_Process_ProcessUtils::isWindows()) {
            return $result = false;
        }

        $proc = @proc_open('echo 1', array(array('pty'), array('pty'), array('pty')), $pipes);
        if (is_resource($proc)) {
            proc_close($proc);

            return $result = true;
        }

        return $result = false;
    }

    /**
     * Creates the descriptors needed by the proc_open.
     *
     * @return array
     */
    private function getDescriptors()
    {
        if (Symfony_Process_ProcessUtils::isWindows()) {
            $this->processPipes = Symfony_Process_Pipes_WindowsPipes::create($this, $this->input);
        } else {
            $this->processPipes = Symfony_Process_Pipes_UnixPipes::create($this, $this->input);
        }
        $descriptors = $this->processPipes->getDescriptors($this->outputDisabled);

        if (!$this->useFileHandles && $this->enhanceSigchildCompatibility && $this->isSigchildEnabled()) {
            // last exit code is output on the fourth pipe and caught to work around --enable-sigchild
            $descriptors = array_merge($descriptors, array(array('pipe', 'w')));

            $this->commandline = '('.$this->commandline.') 3>/dev/null; code=$?; echo $code >&3; exit $code';
        }

        return $descriptors;
    }

    /**
     * Builds up the callback used by wait().
     *
     * The callbacks adds all occurred output to the specific buffer and calls
     * the user callback (if present) with the received output.
     *
     * @param callable|null $callback The user defined PHP callback
     *
     * @return callable A PHP callable
     */
    protected function buildCallback($callback)
    {
        $processCallback = new Symfony_Process_Callback($this, self::OUT, $callback);

        return array($processCallback, 'callback');
    }

    /**
     * Updates the status of the process, reads pipes.
     *
     * @param bool $blocking Whether to use a blocking read call.
     */
    protected function updateStatus($blocking)
    {
        if (self::STATUS_STARTED !== $this->status) {
            return;
        }

        $this->processInformation = proc_get_status($this->process);
        $this->captureExitCode();

        $this->readPipes($blocking, Symfony_Process_ProcessUtils::isWindows() ? !$this->processInformation['running'] : true);

        if (!$this->processInformation['running']) {
            $this->close();
        }
    }

    /**
     * Returns whether PHP has been compiled with the '--enable-sigchild' option or not.
     *
     * @return bool
     */
    protected function isSigchildEnabled()
    {
        if (null !== self::$sigchild) {
            return self::$sigchild;
        }

        if (!function_exists('phpinfo')) {
            return self::$sigchild = false;
        }

        ob_start();
        phpinfo(INFO_GENERAL);

        return self::$sigchild = false !== strpos(ob_get_clean(), '--enable-sigchild');
    }

    /**
     * Validates and returns the filtered timeout.
     *
     * @param int|float|null $timeout
     *
     * @return float|null
     *
     * @throws InvalidArgumentException if the given timeout is a negative number
     */
    private function validateTimeout($timeout)
    {
        $timeout = (float) $timeout;

        if (0.0 === $timeout) {
            $timeout = null;
        } elseif ($timeout < 0) {
            throw new Symfony_Process_Exception_InvalidArgumentException('The timeout value must be a valid positive integer or float number.');
        }

        return $timeout;
    }

    /**
     * Reads pipes, executes callback.
     *
     * @param bool $blocking Whether to use blocking calls or not.
     * @param bool $close    Whether to close file handles or not.
     */
    private function readPipes($blocking, $close)
    {
        $result = $this->processPipes->readAndWrite($blocking, $close);

        $callback = $this->callback;
        foreach ($result as $type => $data) {
            if (3 == $type) {
                $this->fallbackExitcode = (int) $data;
            } else {
                call_user_func($callback, $type === self::STDOUT ? self::OUT : self::ERR, $data);
            }
        }
    }

    /**
     * Captures the exitcode if mentioned in the process information.
     */
    private function captureExitCode()
    {
        if (isset($this->processInformation['exitcode']) && -1 != $this->processInformation['exitcode']) {
            $this->exitcode = $this->processInformation['exitcode'];
        }
    }

    /**
     * Closes process resource, closes file handles, sets the exitcode.
     *
     * @return int The exitcode
     */
    private function close()
    {
        $this->processPipes->close();
        if (is_resource($this->process)) {
            $exitcode = proc_close($this->process);
        } else {
            $exitcode = -1;
        }

        $this->exitcode = -1 !== $exitcode ? $exitcode : (null !== $this->exitcode ? $this->exitcode : -1);
        $this->status   = self::STATUS_TERMINATED;

        if (-1 === $this->exitcode && null !== $this->fallbackExitcode) {
            $this->exitcode = $this->fallbackExitcode;
        } elseif (-1 === $this->exitcode && $this->processInformation['signaled'] && 0 < $this->processInformation['termsig']) {
            // if process has been signaled, no exitcode but a valid termsig, apply Unix convention
            $this->exitcode = 128 + $this->processInformation['termsig'];
        }

        return $this->exitcode;
    }

    /**
     * Resets data related to the latest run of the process.
     */
    private function resetProcessData()
    {
        $this->starttime                    = null;
        $this->callback                     = null;
        $this->exitcode                     = null;
        $this->fallbackExitcode             = null;
        $this->processInformation           = null;
        $this->stdout                       = null;
        $this->stderr                       = null;
        $this->process                      = null;
        $this->latestSignal                 = null;
        $this->status                       = self::STATUS_READY;
        $this->incrementalOutputOffset      = 0;
        $this->incrementalErrorOutputOffset = 0;
    }

    /**
     * Sends a POSIX signal to the process.
     *
     * @param int  $signal         A valid POSIX signal (see http://www.php.net/manual/en/pcntl.constants.php)
     * @param bool $throwException Whether to throw exception in case signal failed
     *
     * @return bool True if the signal was sent successfully, false otherwise
     *
     * @throws LogicException   In case the process is not running
     * @throws RuntimeException In case --enable-sigchild is activated
     * @throws RuntimeException In case of failure
     */
    private function doSignal($signal, $throwException)
    {
        if (!$this->isRunning()) {
            if ($throwException) {
                throw new Symfony_Process_Exception_LogicException('Can not send signal on a non running process.');
            }

            return false;
        }

        if ($this->isSigchildEnabled()) {
            if ($throwException) {
                throw new Symfony_Process_Exception_RuntimeException('This PHP has been compiled with --enable-sigchild. The process can not be signaled.');
            }

            return false;
        }

        if (true !== @proc_terminate($this->process, $signal)) {
            if ($throwException) {
                throw new Symfony_Process_Exception_RuntimeException(sprintf('Error while sending signal `%s`.', $signal));
            }

            return false;
        }

        $this->latestSignal = $signal;

        return true;
    }

    /**
     * Ensures the process is running or terminated, throws a LogicException if the process has a not started.
     *
     * @param string $functionName The function name that was called.
     *
     * @throws LogicException If the process has not run.
     */
    private function requireProcessIsStarted($functionName)
    {
        if (!$this->isStarted()) {
            throw new Symfony_Process_Exception_LogicException(sprintf('Process must be started before calling %s.', $functionName));
        }
    }

    /**
     * Ensures the process is terminated, throws a LogicException if the process has a status different than `terminated`.
     *
     * @param string $functionName The function name that was called.
     *
     * @throws LogicException If the process is not yet terminated.
     */
    private function requireProcessIsTerminated($functionName)
    {
        if (!$this->isTerminated()) {
            throw new Symfony_Process_Exception_LogicException(sprintf('Process must be terminated before calling %s.', $functionName));
        }
    }
}
