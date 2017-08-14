<?php
/**
 * Created by PhpStorm.
 * User: tiago.alves
 * Date: 28/01/2016
 * Time: 19:06
 */

namespace crm\V1\Rest\DbLogger;

use Zend\Log\Writer\Stream;
use Zend\Log\Logger;

/**
 * Classe abstrata para Logs
 *
 * @package    LosLos\Log
 * @author     Leandro Silva <leandro@leandrosilva.info>
 */
abstract class AbstractLogger extends Logger
{
    /**
     * Direct�rio onde o log ser� salvo
     *
     * @var string
     */
    private $_logDir;

    /**
     * Nome do arquivo de log
     *
     * @var string
     */
    private $_logFile;

    /**
     * Construtor
     *
     * Define o logDir e logFile e cria o writter. Se o logDir for nulo
     * ir� usar o diret�rio tempor�rio do sistema
     *
     * @param string $logFile
     * @param string $logDir
     */
    public function __construct($logFile, $logDir = null)
    {
        parent::__construct();

        if (null == $logDir) {
            $logDir = sys_get_temp_dir();
        }
        $this->setLogDir($logDir);
        $this->setLogFile($logFile);

        $writer = new Stream($logDir . DIRECTORY_SEPARATOR . $logFile);
        $this->addWriter($writer);
    }

    /**
     * Retorna o logDir
     *
     * @return string
     */
    public function getLogDir()
    {
        return $this->_logDir;
    }

    /**
     * Define o logDir
     *
     * @param string $logDir
     * @throws \InvalidArgumentException
     */
    public function setLogDir($logDir)
    {
        $logDir = trim($logDir);
        if (!file_exists($logDir) || !is_writable($logDir)) {
            throw new \InvalidArgumentException("Diret�rio inv�lido!");
        }

        $this->_logDir = $logDir;
    }
    /**
     * @return the $_logFile
     */
    public function getLogFile()
    {
        return $this->_logFile;
    }

    /**
     * @param string $_logFile
     */
    public function setLogFile($logFile)
    {
        $logFile = trim($logFile);
        if (null === $logFile || '' == $logFile) {
            throw new \InvalidArgumentException("Arquivo inv�lido!");
        }
        $this->_logFile = $logFile;
    }
}