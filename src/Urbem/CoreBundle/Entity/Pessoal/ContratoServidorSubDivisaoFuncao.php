<?php
 
namespace Urbem\CoreBundle\Entity\Pessoal;

/**
 * ContratoServidorSubDivisaoFuncao
 */
class ContratoServidorSubDivisaoFuncao
{
    /**
     * PK
     * @var integer
     */
    private $codSubDivisao;

    /**
     * PK
     * @var integer
     */
    private $codContrato;

    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    private $timestamp;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Pessoal\SubDivisao
     */
    private $fkPessoalSubDivisao;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Pessoal\ContratoServidor
     */
    private $fkPessoalContratoServidor;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
    }

    /**
     * Set codSubDivisao
     *
     * @param integer $codSubDivisao
     * @return ContratoServidorSubDivisaoFuncao
     */
    public function setCodSubDivisao($codSubDivisao)
    {
        $this->codSubDivisao = $codSubDivisao;
        return $this;
    }

    /**
     * Get codSubDivisao
     *
     * @return integer
     */
    public function getCodSubDivisao()
    {
        return $this->codSubDivisao;
    }

    /**
     * Set codContrato
     *
     * @param integer $codContrato
     * @return ContratoServidorSubDivisaoFuncao
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
     * Set timestamp
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp
     * @return ContratoServidorSubDivisaoFuncao
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
     * Set fkPessoalSubDivisao
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\SubDivisao $fkPessoalSubDivisao
     * @return ContratoServidorSubDivisaoFuncao
     */
    public function setFkPessoalSubDivisao(\Urbem\CoreBundle\Entity\Pessoal\SubDivisao $fkPessoalSubDivisao)
    {
        $this->codSubDivisao = $fkPessoalSubDivisao->getCodSubDivisao();
        $this->fkPessoalSubDivisao = $fkPessoalSubDivisao;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkPessoalSubDivisao
     *
     * @return \Urbem\CoreBundle\Entity\Pessoal\SubDivisao
     */
    public function getFkPessoalSubDivisao()
    {
        return $this->fkPessoalSubDivisao;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkPessoalContratoServidor
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\ContratoServidor $fkPessoalContratoServidor
     * @return ContratoServidorSubDivisaoFuncao
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
}
