<?php

namespace Urbem\CoreBundle\Entity;

/**
 * TransparenciaExportacao
 */
class TransparenciaExportacao
{
    const STATUS_GERANDO = 'GERANDO';
    const STATUS_GERADO = 'GERADO';
    const STATUS_FALHA_GERADO = 'FALHA_GERAÇAO';
    const STATUS_TRANSFERINDO = 'TRANSFERINDO';
    const STATUS_TRANSFERIDO = 'TRANSFERIDO';
    const STATUS_FALHA_TRANSFERIDO = 'FALHA_TRANSFERENCIA';
    const STATUS_FALHA_IMPORTACAO = 'FALHA_IMPORTACAO';
    const STATUS_IMPORTADO = 'IMPORTADO';

    /**
     * PK
     *
     * @var integer
     */
    private $id;

    /**
     * @var \DateTime
     */
    private $timestamp;

    /**
     * @var string
     */
    private $arquivo;

    /**
     * @var integer
     */
    private $status;

    /**
     * @var string
     */
    private $log;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->timestamp = new \DateTime;
    }

    /**
     * Set id
     *
     * @param integer $id
     *
     * @return TransparenciaExportacao
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set timestamp
     *
     * @param \DateTime $timestamp
     *
     * @return TransparenciaExportacao
     */
    public function setTimestamp(\DateTime $timestamp)
    {
        $this->timestamp = $timestamp;

        return $this;
    }

    /**
     * Get timestamp
     *
     * @return \DateTime
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }

    /**
     * Set arquivo
     *
     * @param string $arquivo
     *
     * @return TransparenciaExportacao
     */
    public function setArquivo($arquivo)
    {
        $this->arquivo = $arquivo;

        return $this;
    }

    /**
     * Get arquivo
     *
     * @return string
     */
    public function getArquivo()
    {
        return $this->arquivo;
    }

    /**
     * Set status
     *
     * @param integer $status
     *
     * @return TransparenciaExportacao
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return integer
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @return string
     */
    public function getLog()
    {
        return $this->log;
    }

    /**
     * @param $log
     */
    public function setLog($log)
    {
        $this->log = $log;
    }
}
