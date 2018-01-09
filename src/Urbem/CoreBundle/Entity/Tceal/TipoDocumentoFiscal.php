<?php
 
namespace Urbem\CoreBundle\Entity\Tceal;

/**
 * TipoDocumentoFiscal
 */
class TipoDocumentoFiscal
{
    /**
     * PK
     * @var integer
     */
    private $codTipoDocumentoFiscal;

    /**
     * @var string
     */
    private $descricao;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tceal\BemCompradoTipoDocumentoFiscal
     */
    private $fkTcealBemCompradoTipoDocumentoFiscais;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkTcealBemCompradoTipoDocumentoFiscais = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codTipoDocumentoFiscal
     *
     * @param integer $codTipoDocumentoFiscal
     * @return TipoDocumentoFiscal
     */
    public function setCodTipoDocumentoFiscal($codTipoDocumentoFiscal)
    {
        $this->codTipoDocumentoFiscal = $codTipoDocumentoFiscal;
        return $this;
    }

    /**
     * Get codTipoDocumentoFiscal
     *
     * @return integer
     */
    public function getCodTipoDocumentoFiscal()
    {
        return $this->codTipoDocumentoFiscal;
    }

    /**
     * Set descricao
     *
     * @param string $descricao
     * @return TipoDocumentoFiscal
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
     * Add TcealBemCompradoTipoDocumentoFiscal
     *
     * @param \Urbem\CoreBundle\Entity\Tceal\BemCompradoTipoDocumentoFiscal $fkTcealBemCompradoTipoDocumentoFiscal
     * @return TipoDocumentoFiscal
     */
    public function addFkTcealBemCompradoTipoDocumentoFiscais(\Urbem\CoreBundle\Entity\Tceal\BemCompradoTipoDocumentoFiscal $fkTcealBemCompradoTipoDocumentoFiscal)
    {
        if (false === $this->fkTcealBemCompradoTipoDocumentoFiscais->contains($fkTcealBemCompradoTipoDocumentoFiscal)) {
            $fkTcealBemCompradoTipoDocumentoFiscal->setFkTcealTipoDocumentoFiscal($this);
            $this->fkTcealBemCompradoTipoDocumentoFiscais->add($fkTcealBemCompradoTipoDocumentoFiscal);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcealBemCompradoTipoDocumentoFiscal
     *
     * @param \Urbem\CoreBundle\Entity\Tceal\BemCompradoTipoDocumentoFiscal $fkTcealBemCompradoTipoDocumentoFiscal
     */
    public function removeFkTcealBemCompradoTipoDocumentoFiscais(\Urbem\CoreBundle\Entity\Tceal\BemCompradoTipoDocumentoFiscal $fkTcealBemCompradoTipoDocumentoFiscal)
    {
        $this->fkTcealBemCompradoTipoDocumentoFiscais->removeElement($fkTcealBemCompradoTipoDocumentoFiscal);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcealBemCompradoTipoDocumentoFiscais
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tceal\BemCompradoTipoDocumentoFiscal
     */
    public function getFkTcealBemCompradoTipoDocumentoFiscais()
    {
        return $this->fkTcealBemCompradoTipoDocumentoFiscais;
    }
}
