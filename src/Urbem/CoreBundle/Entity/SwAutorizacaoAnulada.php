<?php
 
namespace Urbem\CoreBundle\Entity;

/**
 * SwAutorizacaoAnulada
 */
class SwAutorizacaoAnulada
{
    /**
     * PK
     * @var integer
     */
    private $codAutorizacao;

    /**
     * PK
     * @var string
     */
    private $exercicio;

    /**
     * PK
     * @var integer
     */
    private $codPreEmpenho;

    /**
     * @var \DateTime
     */
    private $dtAnulacao;

    /**
     * @var string
     */
    private $motivo;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\SwAutorizacaoEmpenho
     */
    private $fkSwAutorizacaoEmpenho;


    /**
     * Set codAutorizacao
     *
     * @param integer $codAutorizacao
     * @return SwAutorizacaoAnulada
     */
    public function setCodAutorizacao($codAutorizacao)
    {
        $this->codAutorizacao = $codAutorizacao;
        return $this;
    }

    /**
     * Get codAutorizacao
     *
     * @return integer
     */
    public function getCodAutorizacao()
    {
        return $this->codAutorizacao;
    }

    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return SwAutorizacaoAnulada
     */
    public function setExercicio($exercicio)
    {
        $this->exercicio = $exercicio;
        return $this;
    }

    /**
     * Get exercicio
     *
     * @return string
     */
    public function getExercicio()
    {
        return $this->exercicio;
    }

    /**
     * Set codPreEmpenho
     *
     * @param integer $codPreEmpenho
     * @return SwAutorizacaoAnulada
     */
    public function setCodPreEmpenho($codPreEmpenho)
    {
        $this->codPreEmpenho = $codPreEmpenho;
        return $this;
    }

    /**
     * Get codPreEmpenho
     *
     * @return integer
     */
    public function getCodPreEmpenho()
    {
        return $this->codPreEmpenho;
    }

    /**
     * Set dtAnulacao
     *
     * @param \DateTime $dtAnulacao
     * @return SwAutorizacaoAnulada
     */
    public function setDtAnulacao(\DateTime $dtAnulacao)
    {
        $this->dtAnulacao = $dtAnulacao;
        return $this;
    }

    /**
     * Get dtAnulacao
     *
     * @return \DateTime
     */
    public function getDtAnulacao()
    {
        return $this->dtAnulacao;
    }

    /**
     * Set motivo
     *
     * @param string $motivo
     * @return SwAutorizacaoAnulada
     */
    public function setMotivo($motivo = null)
    {
        $this->motivo = $motivo;
        return $this;
    }

    /**
     * Get motivo
     *
     * @return string
     */
    public function getMotivo()
    {
        return $this->motivo;
    }

    /**
     * OneToOne (owning side)
     * Set SwAutorizacaoEmpenho
     *
     * @param \Urbem\CoreBundle\Entity\SwAutorizacaoEmpenho $fkSwAutorizacaoEmpenho
     * @return SwAutorizacaoAnulada
     */
    public function setFkSwAutorizacaoEmpenho(\Urbem\CoreBundle\Entity\SwAutorizacaoEmpenho $fkSwAutorizacaoEmpenho)
    {
        $this->codPreEmpenho = $fkSwAutorizacaoEmpenho->getCodPreEmpenho();
        $this->exercicio = $fkSwAutorizacaoEmpenho->getExercicio();
        $this->codAutorizacao = $fkSwAutorizacaoEmpenho->getCodAutorizacao();
        $this->fkSwAutorizacaoEmpenho = $fkSwAutorizacaoEmpenho;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkSwAutorizacaoEmpenho
     *
     * @return \Urbem\CoreBundle\Entity\SwAutorizacaoEmpenho
     */
    public function getFkSwAutorizacaoEmpenho()
    {
        return $this->fkSwAutorizacaoEmpenho;
    }
}
