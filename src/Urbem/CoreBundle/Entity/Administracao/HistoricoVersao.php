<?php
 
namespace Urbem\CoreBundle\Entity\Administracao;

/**
 * HistoricoVersao
 */
class HistoricoVersao
{
    /**
     * PK
     * @var integer
     */
    private $codGestao;

    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    private $timestamp;

    /**
     * @var string
     */
    private $versao;

    /**
     * @var integer
     */
    private $versaoDb;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Administracao\Gestao
     */
    private $fkAdministracaoGestao;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
    }

    /**
     * Set codGestao
     *
     * @param integer $codGestao
     * @return HistoricoVersao
     */
    public function setCodGestao($codGestao)
    {
        $this->codGestao = $codGestao;
        return $this;
    }

    /**
     * Get codGestao
     *
     * @return integer
     */
    public function getCodGestao()
    {
        return $this->codGestao;
    }

    /**
     * Set timestamp
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp
     * @return HistoricoVersao
     */
    public function setTimestamp(\Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp)
    {
        $this->timestamp = $timestamp;
        return $this;
    }

    /**
     * Get timestamp
     *
     * @return \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }

    /**
     * Set versao
     *
     * @param string $versao
     * @return HistoricoVersao
     */
    public function setVersao($versao)
    {
        $this->versao = $versao;
        return $this;
    }

    /**
     * Get versao
     *
     * @return string
     */
    public function getVersao()
    {
        return $this->versao;
    }

    /**
     * Set versaoDb
     *
     * @param integer $versaoDb
     * @return HistoricoVersao
     */
    public function setVersaoDb($versaoDb)
    {
        $this->versaoDb = $versaoDb;
        return $this;
    }

    /**
     * Get versaoDb
     *
     * @return integer
     */
    public function getVersaoDb()
    {
        return $this->versaoDb;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkAdministracaoGestao
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\Gestao $fkAdministracaoGestao
     * @return HistoricoVersao
     */
    public function setFkAdministracaoGestao(\Urbem\CoreBundle\Entity\Administracao\Gestao $fkAdministracaoGestao)
    {
        $this->codGestao = $fkAdministracaoGestao->getCodGestao();
        $this->fkAdministracaoGestao = $fkAdministracaoGestao;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkAdministracaoGestao
     *
     * @return \Urbem\CoreBundle\Entity\Administracao\Gestao
     */
    public function getFkAdministracaoGestao()
    {
        return $this->fkAdministracaoGestao;
    }
}
