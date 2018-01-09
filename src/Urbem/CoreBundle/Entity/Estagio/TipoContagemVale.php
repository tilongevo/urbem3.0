<?php
 
namespace Urbem\CoreBundle\Entity\Estagio;

/**
 * TipoContagemVale
 */
class TipoContagemVale
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
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Estagio\EstagiarioValeTransporte
     */
    private $fkEstagioEstagiarioValeTransportes;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkEstagioEstagiarioValeTransportes = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codTipo
     *
     * @param integer $codTipo
     * @return TipoContagemVale
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
     * @return TipoContagemVale
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
     * Add EstagioEstagiarioValeTransporte
     *
     * @param \Urbem\CoreBundle\Entity\Estagio\EstagiarioValeTransporte $fkEstagioEstagiarioValeTransporte
     * @return TipoContagemVale
     */
    public function addFkEstagioEstagiarioValeTransportes(\Urbem\CoreBundle\Entity\Estagio\EstagiarioValeTransporte $fkEstagioEstagiarioValeTransporte)
    {
        if (false === $this->fkEstagioEstagiarioValeTransportes->contains($fkEstagioEstagiarioValeTransporte)) {
            $fkEstagioEstagiarioValeTransporte->setFkEstagioTipoContagemVale($this);
            $this->fkEstagioEstagiarioValeTransportes->add($fkEstagioEstagiarioValeTransporte);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove EstagioEstagiarioValeTransporte
     *
     * @param \Urbem\CoreBundle\Entity\Estagio\EstagiarioValeTransporte $fkEstagioEstagiarioValeTransporte
     */
    public function removeFkEstagioEstagiarioValeTransportes(\Urbem\CoreBundle\Entity\Estagio\EstagiarioValeTransporte $fkEstagioEstagiarioValeTransporte)
    {
        $this->fkEstagioEstagiarioValeTransportes->removeElement($fkEstagioEstagiarioValeTransporte);
    }

    /**
     * OneToMany (owning side)
     * Get fkEstagioEstagiarioValeTransportes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Estagio\EstagiarioValeTransporte
     */
    public function getFkEstagioEstagiarioValeTransportes()
    {
        return $this->fkEstagioEstagiarioValeTransportes;
    }
}
