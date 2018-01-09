<?php
 
namespace Urbem\CoreBundle\Entity\Tcemg;

/**
 * TipoLeiAlteracaoOrcamentaria
 */
class TipoLeiAlteracaoOrcamentaria
{
    /**
     * PK
     * @var integer
     */
    private $codTipoLei;

    /**
     * @var string
     */
    private $descricao;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcemg\NormaDetalhe
     */
    private $fkTcemgNormaDetalhes;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkTcemgNormaDetalhes = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codTipoLei
     *
     * @param integer $codTipoLei
     * @return TipoLeiAlteracaoOrcamentaria
     */
    public function setCodTipoLei($codTipoLei)
    {
        $this->codTipoLei = $codTipoLei;
        return $this;
    }

    /**
     * Get codTipoLei
     *
     * @return integer
     */
    public function getCodTipoLei()
    {
        return $this->codTipoLei;
    }

    /**
     * Set descricao
     *
     * @param string $descricao
     * @return TipoLeiAlteracaoOrcamentaria
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
     * Add TcemgNormaDetalhe
     *
     * @param \Urbem\CoreBundle\Entity\Tcemg\NormaDetalhe $fkTcemgNormaDetalhe
     * @return TipoLeiAlteracaoOrcamentaria
     */
    public function addFkTcemgNormaDetalhes(\Urbem\CoreBundle\Entity\Tcemg\NormaDetalhe $fkTcemgNormaDetalhe)
    {
        if (false === $this->fkTcemgNormaDetalhes->contains($fkTcemgNormaDetalhe)) {
            $fkTcemgNormaDetalhe->setFkTcemgTipoLeiAlteracaoOrcamentaria($this);
            $this->fkTcemgNormaDetalhes->add($fkTcemgNormaDetalhe);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcemgNormaDetalhe
     *
     * @param \Urbem\CoreBundle\Entity\Tcemg\NormaDetalhe $fkTcemgNormaDetalhe
     */
    public function removeFkTcemgNormaDetalhes(\Urbem\CoreBundle\Entity\Tcemg\NormaDetalhe $fkTcemgNormaDetalhe)
    {
        $this->fkTcemgNormaDetalhes->removeElement($fkTcemgNormaDetalhe);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcemgNormaDetalhes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcemg\NormaDetalhe
     */
    public function getFkTcemgNormaDetalhes()
    {
        return $this->fkTcemgNormaDetalhes;
    }
}
