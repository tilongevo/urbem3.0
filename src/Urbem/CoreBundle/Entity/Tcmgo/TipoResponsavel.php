<?php
 
namespace Urbem\CoreBundle\Entity\Tcmgo;

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
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcmgo\UnidadeResponsavel
     */
    private $fkTcmgoUnidadeResponsaveis;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkTcmgoUnidadeResponsaveis = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Add TcmgoUnidadeResponsavel
     *
     * @param \Urbem\CoreBundle\Entity\Tcmgo\UnidadeResponsavel $fkTcmgoUnidadeResponsavel
     * @return TipoResponsavel
     */
    public function addFkTcmgoUnidadeResponsaveis(\Urbem\CoreBundle\Entity\Tcmgo\UnidadeResponsavel $fkTcmgoUnidadeResponsavel)
    {
        if (false === $this->fkTcmgoUnidadeResponsaveis->contains($fkTcmgoUnidadeResponsavel)) {
            $fkTcmgoUnidadeResponsavel->setFkTcmgoTipoResponsavel($this);
            $this->fkTcmgoUnidadeResponsaveis->add($fkTcmgoUnidadeResponsavel);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcmgoUnidadeResponsavel
     *
     * @param \Urbem\CoreBundle\Entity\Tcmgo\UnidadeResponsavel $fkTcmgoUnidadeResponsavel
     */
    public function removeFkTcmgoUnidadeResponsaveis(\Urbem\CoreBundle\Entity\Tcmgo\UnidadeResponsavel $fkTcmgoUnidadeResponsavel)
    {
        $this->fkTcmgoUnidadeResponsaveis->removeElement($fkTcmgoUnidadeResponsavel);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcmgoUnidadeResponsaveis
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcmgo\UnidadeResponsavel
     */
    public function getFkTcmgoUnidadeResponsaveis()
    {
        return $this->fkTcmgoUnidadeResponsaveis;
    }
}
