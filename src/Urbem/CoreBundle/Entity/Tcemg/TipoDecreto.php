<?php
 
namespace Urbem\CoreBundle\Entity\Tcemg;

/**
 * TipoDecreto
 */
class TipoDecreto
{
    /**
     * PK
     * @var integer
     */
    private $codTipoDecreto;

    /**
     * @var string
     */
    private $descricao;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcemg\TipoRegistroPreco
     */
    private $fkTcemgTipoRegistroPrecos;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkTcemgTipoRegistroPrecos = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codTipoDecreto
     *
     * @param integer $codTipoDecreto
     * @return TipoDecreto
     */
    public function setCodTipoDecreto($codTipoDecreto)
    {
        $this->codTipoDecreto = $codTipoDecreto;
        return $this;
    }

    /**
     * Get codTipoDecreto
     *
     * @return integer
     */
    public function getCodTipoDecreto()
    {
        return $this->codTipoDecreto;
    }

    /**
     * Set descricao
     *
     * @param string $descricao
     * @return TipoDecreto
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
     * Add TcemgTipoRegistroPreco
     *
     * @param \Urbem\CoreBundle\Entity\Tcemg\TipoRegistroPreco $fkTcemgTipoRegistroPreco
     * @return TipoDecreto
     */
    public function addFkTcemgTipoRegistroPrecos(\Urbem\CoreBundle\Entity\Tcemg\TipoRegistroPreco $fkTcemgTipoRegistroPreco)
    {
        if (false === $this->fkTcemgTipoRegistroPrecos->contains($fkTcemgTipoRegistroPreco)) {
            $fkTcemgTipoRegistroPreco->setFkTcemgTipoDecreto($this);
            $this->fkTcemgTipoRegistroPrecos->add($fkTcemgTipoRegistroPreco);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcemgTipoRegistroPreco
     *
     * @param \Urbem\CoreBundle\Entity\Tcemg\TipoRegistroPreco $fkTcemgTipoRegistroPreco
     */
    public function removeFkTcemgTipoRegistroPrecos(\Urbem\CoreBundle\Entity\Tcemg\TipoRegistroPreco $fkTcemgTipoRegistroPreco)
    {
        $this->fkTcemgTipoRegistroPrecos->removeElement($fkTcemgTipoRegistroPreco);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcemgTipoRegistroPrecos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcemg\TipoRegistroPreco
     */
    public function getFkTcemgTipoRegistroPrecos()
    {
        return $this->fkTcemgTipoRegistroPrecos;
    }
}
