<?php
 
namespace Urbem\CoreBundle\Entity\Pessoal;

/**
 * ContratoServidorPadrao
 */
class ContratoServidorPadrao
{
    /**
     * PK
     * @var integer
     */
    private $codContrato;

    /**
     * PK
     * @var integer
     */
    private $codPadrao;

    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    private $timestamp;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Pessoal\ContratoServidor
     */
    private $fkPessoalContratoServidor;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Folhapagamento\Padrao
     */
    private $fkFolhapagamentoPadrao;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
    }

    /**
     * Set codContrato
     *
     * @param integer $codContrato
     * @return ContratoServidorPadrao
     */
    public function setCodContrato($codContrato)
    {
        $this->codContrato = $codContrato;
        return $this;
    }

    /**
     * Get codContrato
     *
     * @return integer
     */
    public function getCodContrato()
    {
        return $this->codContrato;
    }

    /**
     * Set codPadrao
     *
     * @param integer $codPadrao
     * @return ContratoServidorPadrao
     */
    public function setCodPadrao($codPadrao)
    {
        $this->codPadrao = $codPadrao;
        return $this;
    }

    /**
     * Get codPadrao
     *
     * @return integer
     */
    public function getCodPadrao()
    {
        return $this->codPadrao;
    }

    /**
     * Set timestamp
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp
     * @return ContratoServidorPadrao
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
     * ManyToOne (inverse side)
     * Set fkPessoalContratoServidor
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\ContratoServidor $fkPessoalContratoServidor
     * @return ContratoServidorPadrao
     */
    public function setFkPessoalContratoServidor(\Urbem\CoreBundle\Entity\Pessoal\ContratoServidor $fkPessoalContratoServidor)
    {
        $this->codContrato = $fkPessoalContratoServidor->getCodContrato();
        $this->fkPessoalContratoServidor = $fkPessoalContratoServidor;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkPessoalContratoServidor
     *
     * @return \Urbem\CoreBundle\Entity\Pessoal\ContratoServidor
     */
    public function getFkPessoalContratoServidor()
    {
        return $this->fkPessoalContratoServidor;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkFolhapagamentoPadrao
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\Padrao $fkFolhapagamentoPadrao
     * @return ContratoServidorPadrao
     */
    public function setFkFolhapagamentoPadrao(\Urbem\CoreBundle\Entity\Folhapagamento\Padrao $fkFolhapagamentoPadrao)
    {
        $this->codPadrao = $fkFolhapagamentoPadrao->getCodPadrao();
        $this->fkFolhapagamentoPadrao = $fkFolhapagamentoPadrao;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkFolhapagamentoPadrao
     *
     * @return \Urbem\CoreBundle\Entity\Folhapagamento\Padrao
     */
    public function getFkFolhapagamentoPadrao()
    {
        return $this->fkFolhapagamentoPadrao;
    }
}
