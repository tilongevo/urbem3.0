<?php
 
namespace Urbem\CoreBundle\Entity\Ppa;

/**
 * EstimativaOrcamentariaBase
 */
class EstimativaOrcamentariaBase
{
    /**
     * PK
     * @var integer
     */
    private $codReceita;

    /**
     * @var string
     */
    private $codEstrutural;

    /**
     * @var string
     */
    private $descricao;

    /**
     * @var string
     */
    private $tipo;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ppa\PpaEstimativaOrcamentariaBase
     */
    private $fkPpaPpaEstimativaOrcamentariaBases;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkPpaPpaEstimativaOrcamentariaBases = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codReceita
     *
     * @param integer $codReceita
     * @return EstimativaOrcamentariaBase
     */
    public function setCodReceita($codReceita)
    {
        $this->codReceita = $codReceita;
        return $this;
    }

    /**
     * Get codReceita
     *
     * @return integer
     */
    public function getCodReceita()
    {
        return $this->codReceita;
    }

    /**
     * Set codEstrutural
     *
     * @param string $codEstrutural
     * @return EstimativaOrcamentariaBase
     */
    public function setCodEstrutural($codEstrutural)
    {
        $this->codEstrutural = $codEstrutural;
        return $this;
    }

    /**
     * Get codEstrutural
     *
     * @return string
     */
    public function getCodEstrutural()
    {
        return $this->codEstrutural;
    }

    /**
     * Set descricao
     *
     * @param string $descricao
     * @return EstimativaOrcamentariaBase
     */
    public function setDescricao($descricao)
    {
        $this->descricao = $descricao;
        return $this;
    }

    /**
     * Get descricao
     *
     * @return string
     */
    public function getDescricao()
    {
        return $this->descricao;
    }

    /**
     * Set tipo
     *
     * @param string $tipo
     * @return EstimativaOrcamentariaBase
     */
    public function setTipo($tipo)
    {
        $this->tipo = $tipo;
        return $this;
    }

    /**
     * Get tipo
     *
     * @return string
     */
    public function getTipo()
    {
        return $this->tipo;
    }

    /**
     * OneToMany (owning side)
     * Add PpaPpaEstimativaOrcamentariaBase
     *
     * @param \Urbem\CoreBundle\Entity\Ppa\PpaEstimativaOrcamentariaBase $fkPpaPpaEstimativaOrcamentariaBase
     * @return EstimativaOrcamentariaBase
     */
    public function addFkPpaPpaEstimativaOrcamentariaBases(\Urbem\CoreBundle\Entity\Ppa\PpaEstimativaOrcamentariaBase $fkPpaPpaEstimativaOrcamentariaBase)
    {
        if (false === $this->fkPpaPpaEstimativaOrcamentariaBases->contains($fkPpaPpaEstimativaOrcamentariaBase)) {
            $fkPpaPpaEstimativaOrcamentariaBase->setFkPpaEstimativaOrcamentariaBase($this);
            $this->fkPpaPpaEstimativaOrcamentariaBases->add($fkPpaPpaEstimativaOrcamentariaBase);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PpaPpaEstimativaOrcamentariaBase
     *
     * @param \Urbem\CoreBundle\Entity\Ppa\PpaEstimativaOrcamentariaBase $fkPpaPpaEstimativaOrcamentariaBase
     */
    public function removeFkPpaPpaEstimativaOrcamentariaBases(\Urbem\CoreBundle\Entity\Ppa\PpaEstimativaOrcamentariaBase $fkPpaPpaEstimativaOrcamentariaBase)
    {
        $this->fkPpaPpaEstimativaOrcamentariaBases->removeElement($fkPpaPpaEstimativaOrcamentariaBase);
    }

    /**
     * OneToMany (owning side)
     * Get fkPpaPpaEstimativaOrcamentariaBases
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ppa\PpaEstimativaOrcamentariaBase
     */
    public function getFkPpaPpaEstimativaOrcamentariaBases()
    {
        return $this->fkPpaPpaEstimativaOrcamentariaBases;
    }
}
