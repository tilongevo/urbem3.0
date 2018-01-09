<?php
 
namespace Urbem\CoreBundle\Entity\Tcepb;

/**
 * Uniorcam
 */
class Uniorcam
{
    /**
     * PK
     * @var string
     */
    private $exercicio;

    /**
     * PK
     * @var integer
     */
    private $numUnidade;

    /**
     * PK
     * @var integer
     */
    private $numOrgao;

    /**
     * @var integer
     */
    private $cgmOrdenador;

    /**
     * @var integer
     */
    private $naturezaJuridica;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\SwCgm
     */
    private $fkSwCgm;


    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return Uniorcam
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
     * Set numUnidade
     *
     * @param integer $numUnidade
     * @return Uniorcam
     */
    public function setNumUnidade($numUnidade)
    {
        $this->numUnidade = $numUnidade;
        return $this;
    }

    /**
     * Get numUnidade
     *
     * @return integer
     */
    public function getNumUnidade()
    {
        return $this->numUnidade;
    }

    /**
     * Set numOrgao
     *
     * @param integer $numOrgao
     * @return Uniorcam
     */
    public function setNumOrgao($numOrgao)
    {
        $this->numOrgao = $numOrgao;
        return $this;
    }

    /**
     * Get numOrgao
     *
     * @return integer
     */
    public function getNumOrgao()
    {
        return $this->numOrgao;
    }

    /**
     * Set cgmOrdenador
     *
     * @param integer $cgmOrdenador
     * @return Uniorcam
     */
    public function setCgmOrdenador($cgmOrdenador = null)
    {
        $this->cgmOrdenador = $cgmOrdenador;
        return $this;
    }

    /**
     * Get cgmOrdenador
     *
     * @return integer
     */
    public function getCgmOrdenador()
    {
        return $this->cgmOrdenador;
    }

    /**
     * Set naturezaJuridica
     *
     * @param integer $naturezaJuridica
     * @return Uniorcam
     */
    public function setNaturezaJuridica($naturezaJuridica = null)
    {
        $this->naturezaJuridica = $naturezaJuridica;
        return $this;
    }

    /**
     * Get naturezaJuridica
     *
     * @return integer
     */
    public function getNaturezaJuridica()
    {
        return $this->naturezaJuridica;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkSwCgm
     *
     * @param \Urbem\CoreBundle\Entity\SwCgm $fkSwCgm
     * @return Uniorcam
     */
    public function setFkSwCgm(\Urbem\CoreBundle\Entity\SwCgm $fkSwCgm)
    {
        $this->cgmOrdenador = $fkSwCgm->getNumcgm();
        $this->fkSwCgm = $fkSwCgm;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkSwCgm
     *
     * @return \Urbem\CoreBundle\Entity\SwCgm
     */
    public function getFkSwCgm()
    {
        return $this->fkSwCgm;
    }
}
