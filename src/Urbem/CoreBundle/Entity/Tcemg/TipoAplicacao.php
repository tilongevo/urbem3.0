<?php
 
namespace Urbem\CoreBundle\Entity\Tcemg;

/**
 * TipoAplicacao
 */
class TipoAplicacao
{
    /**
     * PK
     * @var integer
     */
    private $codTipoAplicacao;

    /**
     * @var string
     */
    private $descricao;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcemg\ContaBancaria
     */
    private $fkTcemgContaBancarias;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkTcemgContaBancarias = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codTipoAplicacao
     *
     * @param integer $codTipoAplicacao
     * @return TipoAplicacao
     */
    public function setCodTipoAplicacao($codTipoAplicacao)
    {
        $this->codTipoAplicacao = $codTipoAplicacao;
        return $this;
    }

    /**
     * Get codTipoAplicacao
     *
     * @return integer
     */
    public function getCodTipoAplicacao()
    {
        return $this->codTipoAplicacao;
    }

    /**
     * Set descricao
     *
     * @param string $descricao
     * @return TipoAplicacao
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
     * Add TcemgContaBancaria
     *
     * @param \Urbem\CoreBundle\Entity\Tcemg\ContaBancaria $fkTcemgContaBancaria
     * @return TipoAplicacao
     */
    public function addFkTcemgContaBancarias(\Urbem\CoreBundle\Entity\Tcemg\ContaBancaria $fkTcemgContaBancaria)
    {
        if (false === $this->fkTcemgContaBancarias->contains($fkTcemgContaBancaria)) {
            $fkTcemgContaBancaria->setFkTcemgTipoAplicacao($this);
            $this->fkTcemgContaBancarias->add($fkTcemgContaBancaria);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcemgContaBancaria
     *
     * @param \Urbem\CoreBundle\Entity\Tcemg\ContaBancaria $fkTcemgContaBancaria
     */
    public function removeFkTcemgContaBancarias(\Urbem\CoreBundle\Entity\Tcemg\ContaBancaria $fkTcemgContaBancaria)
    {
        $this->fkTcemgContaBancarias->removeElement($fkTcemgContaBancaria);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcemgContaBancarias
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcemg\ContaBancaria
     */
    public function getFkTcemgContaBancarias()
    {
        return $this->fkTcemgContaBancarias;
    }
}
