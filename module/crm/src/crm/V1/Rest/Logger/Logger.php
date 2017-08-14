<?php
namespace crm\V1\Rest\Logger;
use Zend\Log\Logger as ZendLoger;
use Zend\Log\Writer\Stream;

class Logger
{

    /**
     * \Zend\Log\Logger
     * @var ZendLoger
     */
    private $logger;
    private $write;


    public function __construct()
    {
        $this->logger = new ZendLoger();
    }


    public function log($arquivo, $message)
    {
       $this->write = new Stream('./../logs/'.$arquivo);
       $this->logger->addWriter($this->write);
       $this->logger->log(ZendLoger::INFO, $message);
    }

}