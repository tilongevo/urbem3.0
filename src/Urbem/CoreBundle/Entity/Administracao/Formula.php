<?php
 
namespace Urbem\CoreBundle\Entity\Administracao;

/**
 * Formula
 */
class Formula
{
    /**
     * PK
     * @var integer
     */
    private $codFormula;

    /**
     * @var string
     */
    private $nomFormula;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Administracao\FormulaElemento
     */
    private $fkAdministracaoFormulaElementos;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkAdministracaoFormulaElementos = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codFormula
     *
     * @param integer $codFormula
     * @return Formula
     */
    public function setCodFormula($codFormula)
    {
        $this->codFormula = $codFormula;
        return $this;
    }

    /**
     * Get codFormula
     *
     * @return integer
     */
    public function getCodFormula()
    {
        return $this->codFormula;
    }

    /**
     * Set nomFormula
     *
     * @param string $nomFormula
     * @return Formula
     */
    public function setNomFormula($nomFormula)
    {
        $this->nomFormula = $nomFormula;
        return $this;
    }

    /**
     * Get nomFormula
     *
     * @return string
     */
    public function getNomFormula()
    {
        return $this->nomFormula;
    }

    /**
     * OneToMany (owning side)
     * Add AdministracaoFormulaElemento
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\FormulaElemento $fkAdministracaoFormulaElemento
     * @return Formula
     */
    public function addFkAdministracaoFormulaElementos(\Urbem\CoreBundle\Entity\Administracao\FormulaElemento $fkAdministracaoFormulaElemento)
    {
        if (false === $this->fkAdministracaoFormulaElementos->contains($fkAdministracaoFormulaElemento)) {
            $fkAdministracaoFormulaElemento->setFkAdministracaoFormula($this);
            $this->fkAdministracaoFormulaElementos->add($fkAdministracaoFormulaElemento);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove AdministracaoFormulaElemento
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\FormulaElemento $fkAdministracaoFormulaElemento
     */
    public function removeFkAdministracaoFormulaElementos(\Urbem\CoreBundle\Entity\Administracao\FormulaElemento $fkAdministracaoFormulaElemento)
    {
        $this->fkAdministracaoFormulaElementos->removeElement($fkAdministracaoFormulaElemento);
    }

    /**
     * OneToMany (owning side)
     * Get fkAdministracaoFormulaElementos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Administracao\FormulaElemento
     */
    public function getFkAdministracaoFormulaElementos()
    {
        return $this->fkAdministracaoFormulaElementos;
    }
}
