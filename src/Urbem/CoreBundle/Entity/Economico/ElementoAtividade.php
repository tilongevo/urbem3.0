<?php
 
namespace Urbem\CoreBundle\Entity\Economico;

/**
 * ElementoAtividade
 */
class ElementoAtividade
{
    /**
     * PK
     * @var integer
     */
    private $codAtividade;

    /**
     * PK
     * @var integer
     */
    private $codElemento;

    /**
     * @var boolean
     */
    private $ativo = true;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Economico\ElementoAtivCadEconomico
     */
    private $fkEconomicoElementoAtivCadEconomicos;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Economico\Atividade
     */
    private $fkEconomicoAtividade;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Economico\Elemento
     */
    private $fkEconomicoElemento;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkEconomicoElementoAtivCadEconomicos = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codAtividade
     *
     * @param integer $codAtividade
     * @return ElementoAtividade
     */
    public function setCodAtividade($codAtividade)
    {
        $this->codAtividade = $codAtividade;
        return $this;
    }

    /**
     * Get codAtividade
     *
     * @return integer
     */
    public function getCodAtividade()
    {
        return $this->codAtividade;
    }

    /**
     * Set codElemento
     *
     * @param integer $codElemento
     * @return ElementoAtividade
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
     * Set ativo
     *
     * @param boolean $ativo
     * @return ElementoAtividade
     */
    public function setAtivo($ativo)
    {
        $this->ativo = $ativo;
        return $this;
    }

    /**
     * Get ativo
     *
     * @return boolean
     */
    public function getAtivo()
    {
        return $this->ativo;
    }

    /**
     * OneToMany (owning side)
     * Add EconomicoElementoAtivCadEconomico
     *
     * @param \Urbem\CoreBundle\Entity\Economico\ElementoAtivCadEconomico $fkEconomicoElementoAtivCadEconomico
     * @return ElementoAtividade
     */
    public function addFkEconomicoElementoAtivCadEconomicos(\Urbem\CoreBundle\Entity\Economico\ElementoAtivCadEconomico $fkEconomicoElementoAtivCadEconomico)
    {
        if (false === $this->fkEconomicoElementoAtivCadEconomicos->contains($fkEconomicoElementoAtivCadEconomico)) {
            $fkEconomicoElementoAtivCadEconomico->setFkEconomicoElementoAtividade($this);
            $this->fkEconomicoElementoAtivCadEconomicos->add($fkEconomicoElementoAtivCadEconomico);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove EconomicoElementoAtivCadEconomico
     *
     * @param \Urbem\CoreBundle\Entity\Economico\ElementoAtivCadEconomico $fkEconomicoElementoAtivCadEconomico
     */
    public function removeFkEconomicoElementoAtivCadEconomicos(\Urbem\CoreBundle\Entity\Economico\ElementoAtivCadEconomico $fkEconomicoElementoAtivCadEconomico)
    {
        $this->fkEconomicoElementoAtivCadEconomicos->removeElement($fkEconomicoElementoAtivCadEconomico);
    }

    /**
     * OneToMany (owning side)
     * Get fkEconomicoElementoAtivCadEconomicos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Economico\ElementoAtivCadEconomico
     */
    public function getFkEconomicoElementoAtivCadEconomicos()
    {
        return $this->fkEconomicoElementoAtivCadEconomicos;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkEconomicoAtividade
     *
     * @param \Urbem\CoreBundle\Entity\Economico\Atividade $fkEconomicoAtividade
     * @return ElementoAtividade
     */
    public function setFkEconomicoAtividade(\Urbem\CoreBundle\Entity\Economico\Atividade $fkEconomicoAtividade)
    {
        $this->codAtividade = $fkEconomicoAtividade->getCodAtividade();
        $this->fkEconomicoAtividade = $fkEconomicoAtividade;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkEconomicoAtividade
     *
     * @return \Urbem\CoreBundle\Entity\Economico\Atividade
     */
    public function getFkEconomicoAtividade()
    {
        return $this->fkEconomicoAtividade;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkEconomicoElemento
     *
     * @param \Urbem\CoreBundle\Entity\Economico\Elemento $fkEconomicoElemento
     * @return ElementoAtividade
     */
    public function setFkEconomicoElemento(\Urbem\CoreBundle\Entity\Economico\Elemento $fkEconomicoElemento)
    {
        $this->codElemento = $fkEconomicoElemento->getCodElemento();
        $this->fkEconomicoElemento = $fkEconomicoElemento;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkEconomicoElemento
     *
     * @return \Urbem\CoreBundle\Entity\Economico\Elemento
     */
    public function getFkEconomicoElemento()
    {
        return $this->fkEconomicoElemento;
    }
}
