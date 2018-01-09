<?php
 
namespace Urbem\CoreBundle\Entity\Empenho;

/**
 * EmpenhoComplementar
 */
class EmpenhoComplementar
{
    /**
     * PK
     * @var integer
     */
    private $codEmpenho;

    /**
     * PK
     * @var integer
     */
    private $codEntidade;

    /**
     * PK
     * @var string
     */
    private $exercicio;

    /**
     * @var integer
     */
    private $codEmpenhoOriginal;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Empenho\Empenho
     */
    private $fkEmpenhoEmpenho;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Empenho\Empenho
     */
    private $fkEmpenhoEmpenho1;


    /**
     * Set codEmpenho
     *
     * @param integer $codEmpenho
     * @return EmpenhoComplementar
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
     * Set codEntidade
     *
     * @param integer $codEntidade
     * @return EmpenhoComplementar
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
     * Set exercicio
     *
     * @param string $exercicio
     * @return EmpenhoComplementar
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
     * Set codEmpenhoOriginal
     *
     * @param integer $codEmpenhoOriginal
     * @return EmpenhoComplementar
     */
    public function setCodEmpenhoOriginal($codEmpenhoOriginal)
    {
        $this->codEmpenhoOriginal = $codEmpenhoOriginal;
        return $this;
    }

    /**
     * Get codEmpenhoOriginal
     *
     * @return integer
     */
    public function getCodEmpenhoOriginal()
    {
        return $this->codEmpenhoOriginal;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkEmpenhoEmpenho1
     *
     * @param \Urbem\CoreBundle\Entity\Empenho\Empenho $fkEmpenhoEmpenho1
     * @return EmpenhoComplementar
     */
    public function setFkEmpenhoEmpenho1(\Urbem\CoreBundle\Entity\Empenho\Empenho $fkEmpenhoEmpenho1)
    {
        $this->codEmpenhoOriginal = $fkEmpenhoEmpenho1->getCodEmpenho();
        $this->exercicio = $fkEmpenhoEmpenho1->getExercicio();
        $this->codEntidade = $fkEmpenhoEmpenho1->getCodEntidade();
        $this->fkEmpenhoEmpenho1 = $fkEmpenhoEmpenho1;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkEmpenhoEmpenho1
     *
     * @return \Urbem\CoreBundle\Entity\Empenho\Empenho
     */
    public function getFkEmpenhoEmpenho1()
    {
        return $this->fkEmpenhoEmpenho1;
    }

    /**
     * OneToOne (owning side)
     * Set EmpenhoEmpenho
     *
     * @param \Urbem\CoreBundle\Entity\Empenho\Empenho $fkEmpenhoEmpenho
     * @return EmpenhoComplementar
     */
    public function setFkEmpenhoEmpenho(\Urbem\CoreBundle\Entity\Empenho\Empenho $fkEmpenhoEmpenho)
    {
        $this->codEmpenho = $fkEmpenhoEmpenho->getCodEmpenho();
        $this->exercicio = $fkEmpenhoEmpenho->getExercicio();
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
