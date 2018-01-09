<?php
 
namespace Urbem\CoreBundle\Entity\Administracao;

/**
 * TipoElemento
 */
class TipoElemento
{
    /**
     * PK
     * @var integer
     */
    private $codTipo;

    /**
     * @var string
     */
    private $nomTipo;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Administracao\Elemento
     */
    private $fkAdministracaoElementos;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkAdministracaoElementos = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codTipo
     *
     * @param integer $codTipo
     * @return TipoElemento
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
     * Set nomTipo
     *
     * @param string $nomTipo
     * @return TipoElemento
     */
    public function setNomTipo($nomTipo)
    {
        $this->nomTipo = $nomTipo;
        return $this;
    }

    /**
     * Get nomTipo
     *
     * @return string
     */
    public function getNomTipo()
    {
        return $this->nomTipo;
    }

    /**
     * OneToMany (owning side)
     * Add AdministracaoElemento
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\Elemento $fkAdministracaoElemento
     * @return TipoElemento
     */
    public function addFkAdministracaoElementos(\Urbem\CoreBundle\Entity\Administracao\Elemento $fkAdministracaoElemento)
    {
        if (false === $this->fkAdministracaoElementos->contains($fkAdministracaoElemento)) {
            $fkAdministracaoElemento->setFkAdministracaoTipoElemento($this);
            $this->fkAdministracaoElementos->add($fkAdministracaoElemento);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove AdministracaoElemento
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\Elemento $fkAdministracaoElemento
     */
    public function removeFkAdministracaoElementos(\Urbem\CoreBundle\Entity\Administracao\Elemento $fkAdministracaoElemento)
    {
        $this->fkAdministracaoElementos->removeElement($fkAdministracaoElemento);
    }

    /**
     * OneToMany (owning side)
     * Get fkAdministracaoElementos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Administracao\Elemento
     */
    public function getFkAdministracaoElementos()
    {
        return $this->fkAdministracaoElementos;
    }
}
