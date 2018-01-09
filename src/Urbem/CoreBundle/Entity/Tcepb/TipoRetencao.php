<?php
 
namespace Urbem\CoreBundle\Entity\Tcepb;

/**
 * TipoRetencao
 */
class TipoRetencao
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
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcepb\PlanoAnaliticaTipoRetencao
     */
    private $fkTcepbPlanoAnaliticaTipoRetencoes;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkTcepbPlanoAnaliticaTipoRetencoes = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codTipo
     *
     * @param integer $codTipo
     * @return TipoRetencao
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
     * @return TipoRetencao
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
     * Add TcepbPlanoAnaliticaTipoRetencao
     *
     * @param \Urbem\CoreBundle\Entity\Tcepb\PlanoAnaliticaTipoRetencao $fkTcepbPlanoAnaliticaTipoRetencao
     * @return TipoRetencao
     */
    public function addFkTcepbPlanoAnaliticaTipoRetencoes(\Urbem\CoreBundle\Entity\Tcepb\PlanoAnaliticaTipoRetencao $fkTcepbPlanoAnaliticaTipoRetencao)
    {
        if (false === $this->fkTcepbPlanoAnaliticaTipoRetencoes->contains($fkTcepbPlanoAnaliticaTipoRetencao)) {
            $fkTcepbPlanoAnaliticaTipoRetencao->setFkTcepbTipoRetencao($this);
            $this->fkTcepbPlanoAnaliticaTipoRetencoes->add($fkTcepbPlanoAnaliticaTipoRetencao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcepbPlanoAnaliticaTipoRetencao
     *
     * @param \Urbem\CoreBundle\Entity\Tcepb\PlanoAnaliticaTipoRetencao $fkTcepbPlanoAnaliticaTipoRetencao
     */
    public function removeFkTcepbPlanoAnaliticaTipoRetencoes(\Urbem\CoreBundle\Entity\Tcepb\PlanoAnaliticaTipoRetencao $fkTcepbPlanoAnaliticaTipoRetencao)
    {
        $this->fkTcepbPlanoAnaliticaTipoRetencoes->removeElement($fkTcepbPlanoAnaliticaTipoRetencao);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcepbPlanoAnaliticaTipoRetencoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcepb\PlanoAnaliticaTipoRetencao
     */
    public function getFkTcepbPlanoAnaliticaTipoRetencoes()
    {
        return $this->fkTcepbPlanoAnaliticaTipoRetencoes;
    }
}
