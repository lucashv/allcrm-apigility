<?php
namespace crm\V1\Rest\DbLogger;

use crm\V1\Rest\DbLogger\AbstractLogger;
use Doctrine\DBAL\Logging\SQLLogger as LogInterface;


class SqlLogger extends AbstractLogger implements LogInterface
{
    /*
     * Executada sempre antes que um SQL for executado
     *
     * @see \Doctrine\DBAL\Logging\SQLLogger::startQuery()
     */
    public function startQuery ($sql, array $params = null, array $types = null)
    {
        $msg = 'SQL: ' . $sql;
        if ($params) {
            $msg .= PHP_EOL . "\tPARAMS: " . json_encode($params);
        }
        if ($types) {
            $msg .= PHP_EOL . "\tTIPOS: " . json_encode($types);
        }
        $this->debug($msg);
    }

    /*
     * (non-PHPdoc)
     * @see \Doctrine\DBAL\Logging\SQLLogger::stopQuery()
     */
    public function stopQuery ()
    {}
}