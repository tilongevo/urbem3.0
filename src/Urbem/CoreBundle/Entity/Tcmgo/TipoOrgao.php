<?php
 
namespace Urbem\CoreBundle\Entity\Tcmgo;

/**
 * TipoOrgao
 */
class TipoOrgao
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
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcmgo\Orgao
     */
    private $fkTcmgoOrgoes;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkTcmgoOrgoes = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codTipo
     *
     * @param integer $codTipo
     * @return TipoOrgao
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
     * @return TipoOrgao
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
     * Add TcmgoOrgao
     *
     * @param \Urbem\CoreBundle\Entity\Tcmgo\Orgao $fkTcmgoOrgao
     * @return TipoOrgao
     */
    public function addFkTcmgoOrgoes(\Urbem\CoreBundle\Entity\Tcmgo\Orgao $fkTcmgoOrgao)
    {
        if (false === $this->fkTcmgoOrgoes->contains($fkTcmgoOrgao)) {
            $fkTcmgoOrgao->setFkTcmgoTipoOrgao($this);
            $this->fkTcmgoOrgoes->add($fkTcmgoOrgao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcmgoOrgao
     *
     * @param \Urbem\CoreBundle\Entity\Tcmgo\Orgao $fkTcmgoOrgao
     */
    public function removeFkTcmgoOrgoes(\Urbem\CoreBundle\Entity\Tcmgo\Orgao $fkTcmgoOrgao)
    {
        $this->fkTcmgoOrgoes->removeElement($fkTcmgoOrgao);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcmgoOrgoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcmgo\Orgao
     */
    public function getFkTcmgoOrgoes()
    {
        return $this->fkTcmgoOrgoes;
    }
}
