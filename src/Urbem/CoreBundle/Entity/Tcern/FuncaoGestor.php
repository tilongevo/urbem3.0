<?php
 
namespace Urbem\CoreBundle\Entity\Tcern;

/**
 * FuncaoGestor
 */
class FuncaoGestor
{
    /**
     * PK
     * @var integer
     */
    private $codFuncao;

    /**
     * @var string
     */
    private $descricao;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcern\UnidadeGestoraResponsavel
     */
    private $fkTcernUnidadeGestoraResponsaveis;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcern\UnidadeOrcamentariaResponsavel
     */
    private $fkTcernUnidadeOrcamentariaResponsaveis;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkTcernUnidadeGestoraResponsaveis = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTcernUnidadeOrcamentariaResponsaveis = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codFuncao
     *
     * @param integer $codFuncao
     * @return FuncaoGestor
     */
    public function setCodFuncao($codFuncao)
    {
        $this->codFuncao = $codFuncao;
        return $this;
    }

    /**
     * Get codFuncao
     *
     * @return integer
     */
    public function getCodFuncao()
    {
        return $this->codFuncao;
    }

    /**
     * Set descricao
     *
     * @param string $descricao
     * @return FuncaoGestor
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
     * Add TcernUnidadeGestoraResponsavel
     *
     * @param \Urbem\CoreBundle\Entity\Tcern\UnidadeGestoraResponsavel $fkTcernUnidadeGestoraResponsavel
     * @return FuncaoGestor
     */
    public function addFkTcernUnidadeGestoraResponsaveis(\Urbem\CoreBundle\Entity\Tcern\UnidadeGestoraResponsavel $fkTcernUnidadeGestoraResponsavel)
    {
        if (false === $this->fkTcernUnidadeGestoraResponsaveis->contains($fkTcernUnidadeGestoraResponsavel)) {
            $fkTcernUnidadeGestoraResponsavel->setFkTcernFuncaoGestor($this);
            $this->fkTcernUnidadeGestoraResponsaveis->add($fkTcernUnidadeGestoraResponsavel);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcernUnidadeGestoraResponsavel
     *
     * @param \Urbem\CoreBundle\Entity\Tcern\UnidadeGestoraResponsavel $fkTcernUnidadeGestoraResponsavel
     */
    public function removeFkTcernUnidadeGestoraResponsaveis(\Urbem\CoreBundle\Entity\Tcern\UnidadeGestoraResponsavel $fkTcernUnidadeGestoraResponsavel)
    {
        $this->fkTcernUnidadeGestoraResponsaveis->removeElement($fkTcernUnidadeGestoraResponsavel);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcernUnidadeGestoraResponsaveis
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcern\UnidadeGestoraResponsavel
     */
    public function getFkTcernUnidadeGestoraResponsaveis()
    {
        return $this->fkTcernUnidadeGestoraResponsaveis;
    }

    /**
     * OneToMany (owning side)
     * Add TcernUnidadeOrcamentariaResponsavel
     *
     * @param \Urbem\CoreBundle\Entity\Tcern\UnidadeOrcamentariaResponsavel $fkTcernUnidadeOrcamentariaResponsavel
     * @return FuncaoGestor
     */
    public function addFkTcernUnidadeOrcamentariaResponsaveis(\Urbem\CoreBundle\Entity\Tcern\UnidadeOrcamentariaResponsavel $fkTcernUnidadeOrcamentariaResponsavel)
    {
        if (false === $this->fkTcernUnidadeOrcamentariaResponsaveis->contains($fkTcernUnidadeOrcamentariaResponsavel)) {
            $fkTcernUnidadeOrcamentariaResponsavel->setFkTcernFuncaoGestor($this);
            $this->fkTcernUnidadeOrcamentariaResponsaveis->add($fkTcernUnidadeOrcamentariaResponsavel);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcernUnidadeOrcamentariaResponsavel
     *
     * @param \Urbem\CoreBundle\Entity\Tcern\UnidadeOrcamentariaResponsavel $fkTcernUnidadeOrcamentariaResponsavel
     */
    public function removeFkTcernUnidadeOrcamentariaResponsaveis(\Urbem\CoreBundle\Entity\Tcern\UnidadeOrcamentariaResponsavel $fkTcernUnidadeOrcamentariaResponsavel)
    {
        $this->fkTcernUnidadeOrcamentariaResponsaveis->removeElement($fkTcernUnidadeOrcamentariaResponsavel);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcernUnidadeOrcamentariaResponsaveis
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcern\UnidadeOrcamentariaResponsavel
     */
    public function getFkTcernUnidadeOrcamentariaResponsaveis()
    {
        return $this->fkTcernUnidadeOrcamentariaResponsaveis;
    }
}
