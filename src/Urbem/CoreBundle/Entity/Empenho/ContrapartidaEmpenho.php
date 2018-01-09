<?php
 
namespace Urbem\CoreBundle\Entity\Empenho;

/**
 * ContrapartidaEmpenho
 */
class ContrapartidaEmpenho
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
     * PK
     * @var integer
     */
    private $contaContrapartida;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Empenho\ContrapartidaResponsavel
     */
    private $fkEmpenhoContrapartidaResponsavel;


    /**
     * Set codEmpenho
     *
     * @param integer $codEmpenho
     * @return ContrapartidaEmpenho
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
     * @return ContrapartidaEmpenho
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
     * @return ContrapartidaEmpenho
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
     * Set contaContrapartida
     *
     * @param integer $contaContrapartida
     * @return ContrapartidaEmpenho
     */
    public function setContaContrapartida($contaContrapartida)
    {
        $this->contaContrapartida = $contaContrapartida;
        return $this;
    }

    /**
     * Get contaContrapartida
     *
     * @return integer
     */
    public function getContaContrapartida()
    {
        return $this->contaContrapartida;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkEmpenhoContrapartidaResponsavel
     *
     * @param \Urbem\CoreBundle\Entity\Empenho\ContrapartidaResponsavel $fkEmpenhoContrapartidaResponsavel
     * @return ContrapartidaEmpenho
     */
    public function setFkEmpenhoContrapartidaResponsavel(\Urbem\CoreBundle\Entity\Empenho\ContrapartidaResponsavel $fkEmpenhoContrapartidaResponsavel)
    {
        $this->exercicio = $fkEmpenhoContrapartidaResponsavel->getExercicio();
        $this->contaContrapartida = $fkEmpenhoContrapartidaResponsavel->getContaContrapartida();
        $this->fkEmpenhoContrapartidaResponsavel = $fkEmpenhoContrapartidaResponsavel;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkEmpenhoContrapartidaResponsavel
     *
     * @return \Urbem\CoreBundle\Entity\Empenho\ContrapartidaResponsavel
     */
    public function getFkEmpenhoContrapartidaResponsavel()
    {
        return $this->fkEmpenhoContrapartidaResponsavel;
    }
}
