<?php
 
namespace Urbem\CoreBundle\Entity\Tcemg;

/**
 * TipoNotaFiscal
 */
class TipoNotaFiscal
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
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcemg\NotaFiscal
     */
    private $fkTcemgNotaFiscais;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkTcemgNotaFiscais = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codTipo
     *
     * @param integer $codTipo
     * @return TipoNotaFiscal
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
     * @return TipoNotaFiscal
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
     * Add TcemgNotaFiscal
     *
     * @param \Urbem\CoreBundle\Entity\Tcemg\NotaFiscal $fkTcemgNotaFiscal
     * @return TipoNotaFiscal
     */
    public function addFkTcemgNotaFiscais(\Urbem\CoreBundle\Entity\Tcemg\NotaFiscal $fkTcemgNotaFiscal)
    {
        if (false === $this->fkTcemgNotaFiscais->contains($fkTcemgNotaFiscal)) {
            $fkTcemgNotaFiscal->setFkTcemgTipoNotaFiscal($this);
            $this->fkTcemgNotaFiscais->add($fkTcemgNotaFiscal);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcemgNotaFiscal
     *
     * @param \Urbem\CoreBundle\Entity\Tcemg\NotaFiscal $fkTcemgNotaFiscal
     */
    public function removeFkTcemgNotaFiscais(\Urbem\CoreBundle\Entity\Tcemg\NotaFiscal $fkTcemgNotaFiscal)
    {
        $this->fkTcemgNotaFiscais->removeElement($fkTcemgNotaFiscal);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcemgNotaFiscais
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcemg\NotaFiscal
     */
    public function getFkTcemgNotaFiscais()
    {
        return $this->fkTcemgNotaFiscais;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return sprintf('%s - %s', $this->codTipo, $this->descricao);
    }
}
