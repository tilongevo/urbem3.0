<?php
 
namespace Urbem\CoreBundle\Entity\Tcepe;

/**
 * TipoResponsavel
 */
class TipoResponsavel
{
    /**
     * PK
     * @var integer
     */
    private $codTipo;

    /**
     * @var string
     */
    private $descricao;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcepe\ResponsavelTecnico
     */
    private $fkTcepeResponsavelTecnicos;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkTcepeResponsavelTecnicos = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codTipo
     *
     * @param integer $codTipo
     * @return TipoResponsavel
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
     * Set descricao
     *
     * @param string $descricao
     * @return TipoResponsavel
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
     * OneToMany (owning side)
     * Add TcepeResponsavelTecnico
     *
     * @param \Urbem\CoreBundle\Entity\Tcepe\ResponsavelTecnico $fkTcepeResponsavelTecnico
     * @return TipoResponsavel
     */
    public function addFkTcepeResponsavelTecnicos(\Urbem\CoreBundle\Entity\Tcepe\ResponsavelTecnico $fkTcepeResponsavelTecnico)
    {
        if (false === $this->fkTcepeResponsavelTecnicos->contains($fkTcepeResponsavelTecnico)) {
            $fkTcepeResponsavelTecnico->setFkTcepeTipoResponsavel($this);
            $this->fkTcepeResponsavelTecnicos->add($fkTcepeResponsavelTecnico);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcepeResponsavelTecnico
     *
     * @param \Urbem\CoreBundle\Entity\Tcepe\ResponsavelTecnico $fkTcepeResponsavelTecnico
     */
    public function removeFkTcepeResponsavelTecnicos(\Urbem\CoreBundle\Entity\Tcepe\ResponsavelTecnico $fkTcepeResponsavelTecnico)
    {
        $this->fkTcepeResponsavelTecnicos->removeElement($fkTcepeResponsavelTecnico);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcepeResponsavelTecnicos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcepe\ResponsavelTecnico
     */
    public function getFkTcepeResponsavelTecnicos()
    {
        return $this->fkTcepeResponsavelTecnicos;
    }
}
