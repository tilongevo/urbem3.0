<?php
 
namespace Urbem\CoreBundle\Entity\Pessoal;

/**
 * ContratoServidorNomeacaoPosse
 */
class ContratoServidorNomeacaoPosse
{
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
     * @var \DateTime
     */
    private $dtNomeacao;

    /**
     * @var \DateTime
     */
    private $dtPosse;

    /**
     * @var \DateTime
     */
    private $dtAdmissao;

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
     * Set codContrato
     *
     * @param integer $codContrato
     * @return ContratoServidorNomeacaoPosse
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
     * @return ContratoServidorNomeacaoPosse
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
     * Set dtNomeacao
     *
     * @param \DateTime $dtNomeacao
     * @return ContratoServidorNomeacaoPosse
     */
    public function setDtNomeacao(\DateTime $dtNomeacao)
    {
        $this->dtNomeacao = $dtNomeacao;
        return $this;
    }

    /**
     * Get dtNomeacao
     *
     * @return \DateTime
     */
    public function getDtNomeacao()
    {
        return $this->dtNomeacao;
    }

    /**
     * Set dtPosse
     *
     * @param \DateTime $dtPosse
     * @return ContratoServidorNomeacaoPosse
     */
    public function setDtPosse(\DateTime $dtPosse)
    {
        $this->dtPosse = $dtPosse;
        return $this;
    }

    /**
     * Get dtPosse
     *
     * @return \DateTime
     */
    public function getDtPosse()
    {
        return $this->dtPosse;
    }

    /**
     * Set dtAdmissao
     *
     * @param \DateTime $dtAdmissao
     * @return ContratoServidorNomeacaoPosse
     */
    public function setDtAdmissao(\DateTime $dtAdmissao)
    {
        $this->dtAdmissao = $dtAdmissao;
        return $this;
    }

    /**
     * Get dtAdmissao
     *
     * @return \DateTime
     */
    public function getDtAdmissao()
    {
        return $this->dtAdmissao;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkPessoalContratoServidor
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\ContratoServidor $fkPessoalContratoServidor
     * @return ContratoServidorNomeacaoPosse
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
