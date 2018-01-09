<?php
 
namespace Urbem\CoreBundle\Entity\Pessoal;

/**
 * Aposentadoria
 */
class Aposentadoria
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
     * @var integer
     */
    private $codEnquadramento;

    /**
     * @var integer
     */
    private $codClassificacao;

    /**
     * @var \DateTime
     */
    private $dtRequirimento;

    /**
     * @var string
     */
    private $numProcessoTce;

    /**
     * @var \DateTime
     */
    private $dtConcessao;

    /**
     * @var integer
     */
    private $percentual;

    /**
     * @var \DateTime
     */
    private $dtPublicacao;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Pessoal\AposentadoriaEncerramento
     */
    private $fkPessoalAposentadoriaEncerramento;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Pessoal\AposentadoriaExcluida
     */
    private $fkPessoalAposentadoriaExcluida;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Pessoal\ContratoServidor
     */
    private $fkPessoalContratoServidor;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Pessoal\ClassificacaoEnquadramento
     */
    private $fkPessoalClassificacaoEnquadramento;

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
     * @return Aposentadoria
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
     * @return Aposentadoria
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
     * Set codEnquadramento
     *
     * @param integer $codEnquadramento
     * @return Aposentadoria
     */
    public function setCodEnquadramento($codEnquadramento)
    {
        $this->codEnquadramento = $codEnquadramento;
        return $this;
    }

    /**
     * Get codEnquadramento
     *
     * @return integer
     */
    public function getCodEnquadramento()
    {
        return $this->codEnquadramento;
    }

    /**
     * Set codClassificacao
     *
     * @param integer $codClassificacao
     * @return Aposentadoria
     */
    public function setCodClassificacao($codClassificacao)
    {
        $this->codClassificacao = $codClassificacao;
        return $this;
    }

    /**
     * Get codClassificacao
     *
     * @return integer
     */
    public function getCodClassificacao()
    {
        return $this->codClassificacao;
    }

    /**
     * Set dtRequirimento
     *
     * @param \DateTime $dtRequirimento
     * @return Aposentadoria
     */
    public function setDtRequirimento(\DateTime $dtRequirimento)
    {
        $this->dtRequirimento = $dtRequirimento;
        return $this;
    }

    /**
     * Get dtRequirimento
     *
     * @return \DateTime
     */
    public function getDtRequirimento()
    {
        return $this->dtRequirimento;
    }

    /**
     * Set numProcessoTce
     *
     * @param string $numProcessoTce
     * @return Aposentadoria
     */
    public function setNumProcessoTce($numProcessoTce)
    {
        $this->numProcessoTce = $numProcessoTce;
        return $this;
    }

    /**
     * Get numProcessoTce
     *
     * @return string
     */
    public function getNumProcessoTce()
    {
        return $this->numProcessoTce;
    }

    /**
     * Set dtConcessao
     *
     * @param \DateTime $dtConcessao
     * @return Aposentadoria
     */
    public function setDtConcessao(\DateTime $dtConcessao)
    {
        $this->dtConcessao = $dtConcessao;
        return $this;
    }

    /**
     * Get dtConcessao
     *
     * @return \DateTime
     */
    public function getDtConcessao()
    {
        return $this->dtConcessao;
    }

    /**
     * Set percentual
     *
     * @param integer $percentual
     * @return Aposentadoria
     */
    public function setPercentual($percentual)
    {
        $this->percentual = $percentual;
        return $this;
    }

    /**
     * Get percentual
     *
     * @return integer
     */
    public function getPercentual()
    {
        return $this->percentual;
    }

    /**
     * Set dtPublicacao
     *
     * @param \DateTime $dtPublicacao
     * @return Aposentadoria
     */
    public function setDtPublicacao(\DateTime $dtPublicacao)
    {
        $this->dtPublicacao = $dtPublicacao;
        return $this;
    }

    /**
     * Get dtPublicacao
     *
     * @return \DateTime
     */
    public function getDtPublicacao()
    {
        return $this->dtPublicacao;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkPessoalContratoServidor
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\ContratoServidor $fkPessoalContratoServidor
     * @return Aposentadoria
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
     * Set fkPessoalClassificacaoEnquadramento
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\ClassificacaoEnquadramento $fkPessoalClassificacaoEnquadramento
     * @return Aposentadoria
     */
    public function setFkPessoalClassificacaoEnquadramento(\Urbem\CoreBundle\Entity\Pessoal\ClassificacaoEnquadramento $fkPessoalClassificacaoEnquadramento)
    {
        $this->codClassificacao = $fkPessoalClassificacaoEnquadramento->getCodClassificacao();
        $this->codEnquadramento = $fkPessoalClassificacaoEnquadramento->getCodEnquadramento();
        $this->fkPessoalClassificacaoEnquadramento = $fkPessoalClassificacaoEnquadramento;

        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkPessoalClassificacaoEnquadramento
     *
     * @return \Urbem\CoreBundle\Entity\Pessoal\ClassificacaoEnquadramento
     */
    public function getFkPessoalClassificacaoEnquadramento()
    {
        return $this->fkPessoalClassificacaoEnquadramento;
    }

    /**
     * OneToOne (inverse side)
     * Set PessoalAposentadoriaEncerramento
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\AposentadoriaEncerramento $fkPessoalAposentadoriaEncerramento
     * @return Aposentadoria
     */
    public function setFkPessoalAposentadoriaEncerramento(\Urbem\CoreBundle\Entity\Pessoal\AposentadoriaEncerramento $fkPessoalAposentadoriaEncerramento)
    {
        $fkPessoalAposentadoriaEncerramento->setFkPessoalAposentadoria($this);
        $this->fkPessoalAposentadoriaEncerramento = $fkPessoalAposentadoriaEncerramento;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkPessoalAposentadoriaEncerramento
     *
     * @return \Urbem\CoreBundle\Entity\Pessoal\AposentadoriaEncerramento
     */
    public function getFkPessoalAposentadoriaEncerramento()
    {
        return $this->fkPessoalAposentadoriaEncerramento;
    }

    /**
     * OneToOne (inverse side)
     * Set PessoalAposentadoriaExcluida
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\AposentadoriaExcluida $fkPessoalAposentadoriaExcluida
     * @return Aposentadoria
     */
    public function setFkPessoalAposentadoriaExcluida(\Urbem\CoreBundle\Entity\Pessoal\AposentadoriaExcluida $fkPessoalAposentadoriaExcluida)
    {
        $fkPessoalAposentadoriaExcluida->setFkPessoalAposentadoria($this);
        $this->fkPessoalAposentadoriaExcluida = $fkPessoalAposentadoriaExcluida;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkPessoalAposentadoriaExcluida
     *
     * @return \Urbem\CoreBundle\Entity\Pessoal\AposentadoriaExcluida
     */
    public function getFkPessoalAposentadoriaExcluida()
    {
        return $this->fkPessoalAposentadoriaExcluida;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string) "Aposentadoria";
    }
}
