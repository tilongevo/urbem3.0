<?php
 
namespace Urbem\CoreBundle\Entity\Ponto;

/**
 * CompensacaoHoras
 */
class CompensacaoHoras
{
    /**
     * PK
     * @var integer
     */
    private $codCompensacao;

    /**
     * PK
     * @var integer
     */
    private $codContrato;

    /**
     * @var \DateTime
     */
    private $dtFalta;

    /**
     * @var \DateTime
     */
    private $dtCompensacao;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Ponto\CompensacaoHorasExclusao
     */
    private $fkPontoCompensacaoHorasExclusao;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Pessoal\Contrato
     */
    private $fkPessoalContrato;


    /**
     * Set codCompensacao
     *
     * @param integer $codCompensacao
     * @return CompensacaoHoras
     */
    public function setCodCompensacao($codCompensacao)
    {
        $this->codCompensacao = $codCompensacao;
        return $this;
    }

    /**
     * Get codCompensacao
     *
     * @return integer
     */
    public function getCodCompensacao()
    {
        return $this->codCompensacao;
    }

    /**
     * Set codContrato
     *
     * @param integer $codContrato
     * @return CompensacaoHoras
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
     * Set dtFalta
     *
     * @param \DateTime $dtFalta
     * @return CompensacaoHoras
     */
    public function setDtFalta(\DateTime $dtFalta)
    {
        $this->dtFalta = $dtFalta;
        return $this;
    }

    /**
     * Get dtFalta
     *
     * @return \DateTime
     */
    public function getDtFalta()
    {
        return $this->dtFalta;
    }

    /**
     * Set dtCompensacao
     *
     * @param \DateTime $dtCompensacao
     * @return CompensacaoHoras
     */
    public function setDtCompensacao(\DateTime $dtCompensacao)
    {
        $this->dtCompensacao = $dtCompensacao;
        return $this;
    }

    /**
     * Get dtCompensacao
     *
     * @return \DateTime
     */
    public function getDtCompensacao()
    {
        return $this->dtCompensacao;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkPessoalContrato
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\Contrato $fkPessoalContrato
     * @return CompensacaoHoras
     */
    public function setFkPessoalContrato(\Urbem\CoreBundle\Entity\Pessoal\Contrato $fkPessoalContrato)
    {
        $this->codContrato = $fkPessoalContrato->getCodContrato();
        $this->fkPessoalContrato = $fkPessoalContrato;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkPessoalContrato
     *
     * @return \Urbem\CoreBundle\Entity\Pessoal\Contrato
     */
    public function getFkPessoalContrato()
    {
        return $this->fkPessoalContrato;
    }

    /**
     * OneToOne (inverse side)
     * Set PontoCompensacaoHorasExclusao
     *
     * @param \Urbem\CoreBundle\Entity\Ponto\CompensacaoHorasExclusao $fkPontoCompensacaoHorasExclusao
     * @return CompensacaoHoras
     */
    public function setFkPontoCompensacaoHorasExclusao(\Urbem\CoreBundle\Entity\Ponto\CompensacaoHorasExclusao $fkPontoCompensacaoHorasExclusao)
    {
        $fkPontoCompensacaoHorasExclusao->setFkPontoCompensacaoHoras($this);
        $this->fkPontoCompensacaoHorasExclusao = $fkPontoCompensacaoHorasExclusao;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkPontoCompensacaoHorasExclusao
     *
     * @return \Urbem\CoreBundle\Entity\Ponto\CompensacaoHorasExclusao
     */
    public function getFkPontoCompensacaoHorasExclusao()
    {
        return $this->fkPontoCompensacaoHorasExclusao;
    }

    /**
     * PrePersist
     * @param \Doctrine\Common\Persistence\Event\LifecycleEventArgs $args
     */
    public function generatePkSequence(\Doctrine\Common\Persistence\Event\LifecycleEventArgs $args)
    {
        $this->codCompensacao = (new \Doctrine\ORM\Id\SequenceGenerator('ponto.seq_compensacao_horas', 1))->generate($args->getObjectManager(), $this);
    }
}
