<?php
 
namespace Urbem\CoreBundle\Entity\Beneficio;

/**
 * GrupoConcessao
 */
class GrupoConcessao
{
    /**
     * PK
     * @var integer
     */
    private $codGrupo;

    /**
     * @var string
     */
    private $descricao;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Beneficio\ContratoServidorGrupoConcessaoValeTransporte
     */
    private $fkBeneficioContratoServidorGrupoConcessaoValeTransportes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Beneficio\GrupoConcessaoValeTransporte
     */
    private $fkBeneficioGrupoConcessaoValeTransportes;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkBeneficioContratoServidorGrupoConcessaoValeTransportes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkBeneficioGrupoConcessaoValeTransportes = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codGrupo
     *
     * @param integer $codGrupo
     * @return GrupoConcessao
     */
    public function setCodGrupo($codGrupo)
    {
        $this->codGrupo = $codGrupo;
        return $this;
    }

    /**
     * Get codGrupo
     *
     * @return integer
     */
    public function getCodGrupo()
    {
        return $this->codGrupo;
    }

    /**
     * Set descricao
     *
     * @param string $descricao
     * @return GrupoConcessao
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
     * Add BeneficioContratoServidorGrupoConcessaoValeTransporte
     *
     * @param \Urbem\CoreBundle\Entity\Beneficio\ContratoServidorGrupoConcessaoValeTransporte $fkBeneficioContratoServidorGrupoConcessaoValeTransporte
     * @return GrupoConcessao
     */
    public function addFkBeneficioContratoServidorGrupoConcessaoValeTransportes(\Urbem\CoreBundle\Entity\Beneficio\ContratoServidorGrupoConcessaoValeTransporte $fkBeneficioContratoServidorGrupoConcessaoValeTransporte)
    {
        if (false === $this->fkBeneficioContratoServidorGrupoConcessaoValeTransportes->contains($fkBeneficioContratoServidorGrupoConcessaoValeTransporte)) {
            $fkBeneficioContratoServidorGrupoConcessaoValeTransporte->setFkBeneficioGrupoConcessao($this);
            $this->fkBeneficioContratoServidorGrupoConcessaoValeTransportes->add($fkBeneficioContratoServidorGrupoConcessaoValeTransporte);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove BeneficioContratoServidorGrupoConcessaoValeTransporte
     *
     * @param \Urbem\CoreBundle\Entity\Beneficio\ContratoServidorGrupoConcessaoValeTransporte $fkBeneficioContratoServidorGrupoConcessaoValeTransporte
     */
    public function removeFkBeneficioContratoServidorGrupoConcessaoValeTransportes(\Urbem\CoreBundle\Entity\Beneficio\ContratoServidorGrupoConcessaoValeTransporte $fkBeneficioContratoServidorGrupoConcessaoValeTransporte)
    {
        $this->fkBeneficioContratoServidorGrupoConcessaoValeTransportes->removeElement($fkBeneficioContratoServidorGrupoConcessaoValeTransporte);
    }

    /**
     * OneToMany (owning side)
     * Get fkBeneficioContratoServidorGrupoConcessaoValeTransportes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Beneficio\ContratoServidorGrupoConcessaoValeTransporte
     */
    public function getFkBeneficioContratoServidorGrupoConcessaoValeTransportes()
    {
        return $this->fkBeneficioContratoServidorGrupoConcessaoValeTransportes;
    }

    /**
     * OneToMany (owning side)
     * Add BeneficioGrupoConcessaoValeTransporte
     *
     * @param \Urbem\CoreBundle\Entity\Beneficio\GrupoConcessaoValeTransporte $fkBeneficioGrupoConcessaoValeTransporte
     * @return GrupoConcessao
     */
    public function addFkBeneficioGrupoConcessaoValeTransportes(\Urbem\CoreBundle\Entity\Beneficio\GrupoConcessaoValeTransporte $fkBeneficioGrupoConcessaoValeTransporte)
    {
        if (false === $this->fkBeneficioGrupoConcessaoValeTransportes->contains($fkBeneficioGrupoConcessaoValeTransporte)) {
            $fkBeneficioGrupoConcessaoValeTransporte->setFkBeneficioGrupoConcessao($this);
            $this->fkBeneficioGrupoConcessaoValeTransportes->add($fkBeneficioGrupoConcessaoValeTransporte);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove BeneficioGrupoConcessaoValeTransporte
     *
     * @param \Urbem\CoreBundle\Entity\Beneficio\GrupoConcessaoValeTransporte $fkBeneficioGrupoConcessaoValeTransporte
     */
    public function removeFkBeneficioGrupoConcessaoValeTransportes(\Urbem\CoreBundle\Entity\Beneficio\GrupoConcessaoValeTransporte $fkBeneficioGrupoConcessaoValeTransporte)
    {
        $this->fkBeneficioGrupoConcessaoValeTransportes->removeElement($fkBeneficioGrupoConcessaoValeTransporte);
    }

    /**
     * OneToMany (owning side)
     * Get fkBeneficioGrupoConcessaoValeTransportes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Beneficio\GrupoConcessaoValeTransporte
     */
    public function getFkBeneficioGrupoConcessaoValeTransportes()
    {
        return $this->fkBeneficioGrupoConcessaoValeTransportes;
    }
}
