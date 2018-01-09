<?php
 
namespace Urbem\CoreBundle\Entity\Fiscalizacao;

/**
 * AutoInfracaoOutros
 */
class AutoInfracaoOutros
{
    /**
     * PK
     * @var integer
     */
    private $codProcesso;

    /**
     * PK
     * @var integer
     */
    private $codAutoFiscalizacao;

    /**
     * PK
     * @var integer
     */
    private $codInfracao;

    /**
     * PK
     * @var integer
     */
    private $codPenalidade;

    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DateTimePK
     */
    private $timestamp;

    /**
     * @var \DateTime
     */
    private $dtOcorrencia;

    /**
     * @var string
     */
    private $observacao;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Fiscalizacao\AutoInfracao
     */
    private $fkFiscalizacaoAutoInfracao;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimePK;
    }

    /**
     * Set codProcesso
     *
     * @param integer $codProcesso
     * @return AutoInfracaoOutros
     */
    public function setCodProcesso($codProcesso)
    {
        $this->codProcesso = $codProcesso;
        return $this;
    }

    /**
     * Get codProcesso
     *
     * @return integer
     */
    public function getCodProcesso()
    {
        return $this->codProcesso;
    }

    /**
     * Set codAutoFiscalizacao
     *
     * @param integer $codAutoFiscalizacao
     * @return AutoInfracaoOutros
     */
    public function setCodAutoFiscalizacao($codAutoFiscalizacao)
    {
        $this->codAutoFiscalizacao = $codAutoFiscalizacao;
        return $this;
    }

    /**
     * Get codAutoFiscalizacao
     *
     * @return integer
     */
    public function getCodAutoFiscalizacao()
    {
        return $this->codAutoFiscalizacao;
    }

    /**
     * Set codInfracao
     *
     * @param integer $codInfracao
     * @return AutoInfracaoOutros
     */
    public function setCodInfracao($codInfracao)
    {
        $this->codInfracao = $codInfracao;
        return $this;
    }

    /**
     * Get codInfracao
     *
     * @return integer
     */
    public function getCodInfracao()
    {
        return $this->codInfracao;
    }

    /**
     * Set codPenalidade
     *
     * @param integer $codPenalidade
     * @return AutoInfracaoOutros
     */
    public function setCodPenalidade($codPenalidade)
    {
        $this->codPenalidade = $codPenalidade;
        return $this;
    }

    /**
     * Get codPenalidade
     *
     * @return integer
     */
    public function getCodPenalidade()
    {
        return $this->codPenalidade;
    }

    /**
     * Set timestamp
     *
     * @param \Urbem\CoreBundle\Helper\DateTimePK $timestamp
     * @return AutoInfracaoOutros
     */
    public function setTimestamp(\Urbem\CoreBundle\Helper\DateTimePK $timestamp)
    {
        $this->timestamp = $timestamp;
        return $this;
    }

    /**
     * Get timestamp
     *
     * @return \Urbem\CoreBundle\Helper\DateTimePK
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }

    /**
     * Set dtOcorrencia
     *
     * @param \DateTime $dtOcorrencia
     * @return AutoInfracaoOutros
     */
    public function setDtOcorrencia(\DateTime $dtOcorrencia)
    {
        $this->dtOcorrencia = $dtOcorrencia;
        return $this;
    }

    /**
     * Get dtOcorrencia
     *
     * @return \DateTime
     */
    public function getDtOcorrencia()
    {
        return $this->dtOcorrencia;
    }

    /**
     * Set observacao
     *
     * @param string $observacao
     * @return AutoInfracaoOutros
     */
    public function setObservacao($observacao = null)
    {
        $this->observacao = $observacao;
        return $this;
    }

    /**
     * Get observacao
     *
     * @return string
     */
    public function getObservacao()
    {
        return $this->observacao;
    }

    /**
     * OneToOne (owning side)
     * Set FiscalizacaoAutoInfracao
     *
     * @param \Urbem\CoreBundle\Entity\Fiscalizacao\AutoInfracao $fkFiscalizacaoAutoInfracao
     * @return AutoInfracaoOutros
     */
    public function setFkFiscalizacaoAutoInfracao(\Urbem\CoreBundle\Entity\Fiscalizacao\AutoInfracao $fkFiscalizacaoAutoInfracao)
    {
        $this->codProcesso = $fkFiscalizacaoAutoInfracao->getCodProcesso();
        $this->codAutoFiscalizacao = $fkFiscalizacaoAutoInfracao->getCodAutoFiscalizacao();
        $this->codPenalidade = $fkFiscalizacaoAutoInfracao->getCodPenalidade();
        $this->codInfracao = $fkFiscalizacaoAutoInfracao->getCodInfracao();
        $this->timestamp = $fkFiscalizacaoAutoInfracao->getTimestamp();
        $this->fkFiscalizacaoAutoInfracao = $fkFiscalizacaoAutoInfracao;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkFiscalizacaoAutoInfracao
     *
     * @return \Urbem\CoreBundle\Entity\Fiscalizacao\AutoInfracao
     */
    public function getFkFiscalizacaoAutoInfracao()
    {
        return $this->fkFiscalizacaoAutoInfracao;
    }
}
