<?php
 
namespace Urbem\CoreBundle\Entity\Tcmgo;

/**
 * ContratoEmpenho
 */
class ContratoEmpenho
{
    /**
     * PK
     * @var integer
     */
    private $codContrato;

    /**
     * PK
     * @var string
     */
    private $exercicio;

    /**
     * PK
     * @var string
     */
    private $exercicioEmpenho;

    /**
     * PK
     * @var integer
     */
    private $codEntidade;

    /**
     * PK
     * @var integer
     */
    private $codEmpenho;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Empenho\Empenho
     */
    private $fkEmpenhoEmpenho;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Tcmgo\Contrato
     */
    private $fkTcmgoContrato;


    /**
     * Set codContrato
     *
     * @param integer $codContrato
     * @return ContratoEmpenho
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
     * Set exercicio
     *
     * @param string $exercicio
     * @return ContratoEmpenho
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
     * Set exercicioEmpenho
     *
     * @param string $exercicioEmpenho
     * @return ContratoEmpenho
     */
    public function setExercicioEmpenho($exercicioEmpenho)
    {
        $this->exercicioEmpenho = $exercicioEmpenho;
        return $this;
    }

    /**
     * Get exercicioEmpenho
     *
     * @return string
     */
    public function getExercicioEmpenho()
    {
        return $this->exercicioEmpenho;
    }

    /**
     * Set codEntidade
     *
     * @param integer $codEntidade
     * @return ContratoEmpenho
     */
    public function setCodEntidade($codEntidade)
    {
        $this->codEntidade = $codEntidade;
        return $this;
    }

    /**
     * Get codEntidade
     *
     * @return integer
     */
    public function getCodEntidade()
    {
        return $this->codEntidade;
    }

    /**
     * Set codEmpenho
     *
     * @param integer $codEmpenho
     * @return ContratoEmpenho
     */
    public function setCodEmpenho($codEmpenho)
    {
        $this->codEmpenho = $codEmpenho;
        return $this;
    }

    /**
     * Get codEmpenho
     *
     * @return integer
     */
    public function getCodEmpenho()
    {
        return $this->codEmpenho;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkTcmgoContrato
     *
     * @param \Urbem\CoreBundle\Entity\Tcmgo\Contrato $fkTcmgoContrato
     * @return ContratoEmpenho
     */
    public function setFkTcmgoContrato(\Urbem\CoreBundle\Entity\Tcmgo\Contrato $fkTcmgoContrato)
    {
        $this->codContrato = $fkTcmgoContrato->getCodContrato();
        $this->exercicio = $fkTcmgoContrato->getExercicio();
        $this->codEntidade = $fkTcmgoContrato->getCodEntidade();
        $this->fkTcmgoContrato = $fkTcmgoContrato;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkTcmgoContrato
     *
     * @return \Urbem\CoreBundle\Entity\Tcmgo\Contrato
     */
    public function getFkTcmgoContrato()
    {
        return $this->fkTcmgoContrato;
    }

    /**
     * OneToOne (owning side)
     * Set EmpenhoEmpenho
     *
     * @param \Urbem\CoreBundle\Entity\Empenho\Empenho $fkEmpenhoEmpenho
     * @return ContratoEmpenho
     */
    public function setFkEmpenhoEmpenho(\Urbem\CoreBundle\Entity\Empenho\Empenho $fkEmpenhoEmpenho)
    {
        $this->codEmpenho = $fkEmpenhoEmpenho->getCodEmpenho();
        $this->exercicioEmpenho = $fkEmpenhoEmpenho->getExercicio();
        $this->codEntidade = $fkEmpenhoEmpenho->getCodEntidade();
        $this->fkEmpenhoEmpenho = $fkEmpenhoEmpenho;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkEmpenhoEmpenho
     *
     * @return \Urbem\CoreBundle\Entity\Empenho\Empenho
     */
    public function getFkEmpenhoEmpenho()
    {
        return $this->fkEmpenhoEmpenho;
    }
}
