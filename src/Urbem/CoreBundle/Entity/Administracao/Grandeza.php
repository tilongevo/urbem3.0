<?php
 
namespace Urbem\CoreBundle\Entity\Administracao;

/**
 * Grandeza
 */
class Grandeza
{
    /**
     * PK
     * @var integer
     */
    private $codGrandeza;

    /**
     * @var string
     */
    private $nomGrandeza;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Administracao\UnidadeMedida
     */
    private $fkAdministracaoUnidadeMedidas;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkAdministracaoUnidadeMedidas = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codGrandeza
     *
     * @param integer $codGrandeza
     * @return Grandeza
     */
    public function setCodGrandeza($codGrandeza)
    {
        $this->codGrandeza = $codGrandeza;
        return $this;
    }

    /**
     * Get codGrandeza
     *
     * @return integer
     */
    public function getCodGrandeza()
    {
        return $this->codGrandeza;
    }

    /**
     * Set nomGrandeza
     *
     * @param string $nomGrandeza
     * @return Grandeza
     */
    public function setNomGrandeza($nomGrandeza)
    {
        $this->nomGrandeza = $nomGrandeza;
        return $this;
    }

    /**
     * Get nomGrandeza
     *
     * @return string
     */
    public function getNomGrandeza()
    {
        return $this->nomGrandeza;
    }

    /**
     * OneToMany (owning side)
     * Add AdministracaoUnidadeMedida
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\UnidadeMedida $fkAdministracaoUnidadeMedida
     * @return Grandeza
     */
    public function addFkAdministracaoUnidadeMedidas(\Urbem\CoreBundle\Entity\Administracao\UnidadeMedida $fkAdministracaoUnidadeMedida)
    {
        if (false === $this->fkAdministracaoUnidadeMedidas->contains($fkAdministracaoUnidadeMedida)) {
            $fkAdministracaoUnidadeMedida->setFkAdministracaoGrandeza($this);
            $this->fkAdministracaoUnidadeMedidas->add($fkAdministracaoUnidadeMedida);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove AdministracaoUnidadeMedida
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\UnidadeMedida $fkAdministracaoUnidadeMedida
     */
    public function removeFkAdministracaoUnidadeMedidas(\Urbem\CoreBundle\Entity\Administracao\UnidadeMedida $fkAdministracaoUnidadeMedida)
    {
        $this->fkAdministracaoUnidadeMedidas->removeElement($fkAdministracaoUnidadeMedida);
    }

    /**
     * OneToMany (owning side)
     * Get fkAdministracaoUnidadeMedidas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Administracao\UnidadeMedida
     */
    public function getFkAdministracaoUnidadeMedidas()
    {
        return $this->fkAdministracaoUnidadeMedidas;
    }

    function __toString()
    {
        return $this->nomGrandeza;
    }


}
