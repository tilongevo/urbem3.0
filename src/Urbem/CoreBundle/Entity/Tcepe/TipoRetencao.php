<?php
 
namespace Urbem\CoreBundle\Entity\Tcepe;

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
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcepe\PlanoAnaliticaTipoRetencao
     */
    private $fkTcepePlanoAnaliticaTipoRetencoes;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkTcepePlanoAnaliticaTipoRetencoes = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Add TcepePlanoAnaliticaTipoRetencao
     *
     * @param \Urbem\CoreBundle\Entity\Tcepe\PlanoAnaliticaTipoRetencao $fkTcepePlanoAnaliticaTipoRetencao
     * @return TipoRetencao
     */
    public function addFkTcepePlanoAnaliticaTipoRetencoes(\Urbem\CoreBundle\Entity\Tcepe\PlanoAnaliticaTipoRetencao $fkTcepePlanoAnaliticaTipoRetencao)
    {
        if (false === $this->fkTcepePlanoAnaliticaTipoRetencoes->contains($fkTcepePlanoAnaliticaTipoRetencao)) {
            $fkTcepePlanoAnaliticaTipoRetencao->setFkTcepeTipoRetencao($this);
            $this->fkTcepePlanoAnaliticaTipoRetencoes->add($fkTcepePlanoAnaliticaTipoRetencao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcepePlanoAnaliticaTipoRetencao
     *
     * @param \Urbem\CoreBundle\Entity\Tcepe\PlanoAnaliticaTipoRetencao $fkTcepePlanoAnaliticaTipoRetencao
     */
    public function removeFkTcepePlanoAnaliticaTipoRetencoes(\Urbem\CoreBundle\Entity\Tcepe\PlanoAnaliticaTipoRetencao $fkTcepePlanoAnaliticaTipoRetencao)
    {
        $this->fkTcepePlanoAnaliticaTipoRetencoes->removeElement($fkTcepePlanoAnaliticaTipoRetencao);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcepePlanoAnaliticaTipoRetencoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcepe\PlanoAnaliticaTipoRetencao
     */
    public function getFkTcepePlanoAnaliticaTipoRetencoes()
    {
        return $this->fkTcepePlanoAnaliticaTipoRetencoes;
    }
}
