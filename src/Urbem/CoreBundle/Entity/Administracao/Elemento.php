<?php
 
namespace Urbem\CoreBundle\Entity\Administracao;

/**
 * Elemento
 */
class Elemento
{
    /**
     * PK
     * @var integer
     */
    private $codElemento;

    /**
     * PK
     * @var integer
     */
    private $codTipo;

    /**
     * @var string
     */
    private $nomElemento;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Administracao\FormulaElemento
     */
    private $fkAdministracaoFormulaElementos;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Administracao\TipoElemento
     */
    private $fkAdministracaoTipoElemento;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkAdministracaoFormulaElementos = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codElemento
     *
     * @param integer $codElemento
     * @return Elemento
     */
    public function setCodElemento($codElemento)
    {
        $this->codElemento = $codElemento;
        return $this;
    }

    /**
     * Get codElemento
     *
     * @return integer
     */
    public function getCodElemento()
    {
        return $this->codElemento;
    }

    /**
     * Set codTipo
     *
     * @param integer $codTipo
     * @return Elemento
     */
    public function setCodTipo($codTipo)
    {
        $this->codTipo = $codTipo;
        return $this;
    }

    /**
     * Get codTipo
     *
     * @return integer
     */
    public function getCodTipo()
    {
        return $this->codTipo;
    }

    /**
     * Set nomElemento
     *
     * @param string $nomElemento
     * @return Elemento
     */
    public function setNomElemento($nomElemento)
    {
        $this->nomElemento = $nomElemento;
        return $this;
    }

    /**
     * Get nomElemento
     *
     * @return string
     */
    public function getNomElemento()
    {
        return $this->nomElemento;
    }

    /**
     * OneToMany (owning side)
     * Add AdministracaoFormulaElemento
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\FormulaElemento $fkAdministracaoFormulaElemento
     * @return Elemento
     */
    public function addFkAdministracaoFormulaElementos(\Urbem\CoreBundle\Entity\Administracao\FormulaElemento $fkAdministracaoFormulaElemento)
    {
        if (false === $this->fkAdministracaoFormulaElementos->contains($fkAdministracaoFormulaElemento)) {
            $fkAdministracaoFormulaElemento->setFkAdministracaoElemento($this);
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

    /**
     * ManyToOne (inverse side)
     * Set fkAdministracaoTipoElemento
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\TipoElemento $fkAdministracaoTipoElemento
     * @return Elemento
     */
    public function setFkAdministracaoTipoElemento(\Urbem\CoreBundle\Entity\Administracao\TipoElemento $fkAdministracaoTipoElemento)
    {
        $this->codTipo = $fkAdministracaoTipoElemento->getCodTipo();
        $this->fkAdministracaoTipoElemento = $fkAdministracaoTipoElemento;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkAdministracaoTipoElemento
     *
     * @return \Urbem\CoreBundle\Entity\Administracao\TipoElemento
     */
    public function getFkAdministracaoTipoElemento()
    {
        return $this->fkAdministracaoTipoElemento;
    }
}
