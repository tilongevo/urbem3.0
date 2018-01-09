<?php
 
namespace Urbem\CoreBundle\Entity\Tceto;

/**
 * TipoDocumento
 */
class TipoDocumento
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
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tceto\NotaLiquidacaoDocumento
     */
    private $fkTcetoNotaLiquidacaoDocumentos;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkTcetoNotaLiquidacaoDocumentos = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codTipo
     *
     * @param integer $codTipo
     * @return TipoDocumento
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
     * @return TipoDocumento
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
     * Add TcetoNotaLiquidacaoDocumento
     *
     * @param \Urbem\CoreBundle\Entity\Tceto\NotaLiquidacaoDocumento $fkTcetoNotaLiquidacaoDocumento
     * @return TipoDocumento
     */
    public function addFkTcetoNotaLiquidacaoDocumentos(\Urbem\CoreBundle\Entity\Tceto\NotaLiquidacaoDocumento $fkTcetoNotaLiquidacaoDocumento)
    {
        if (false === $this->fkTcetoNotaLiquidacaoDocumentos->contains($fkTcetoNotaLiquidacaoDocumento)) {
            $fkTcetoNotaLiquidacaoDocumento->setFkTcetoTipoDocumento($this);
            $this->fkTcetoNotaLiquidacaoDocumentos->add($fkTcetoNotaLiquidacaoDocumento);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcetoNotaLiquidacaoDocumento
     *
     * @param \Urbem\CoreBundle\Entity\Tceto\NotaLiquidacaoDocumento $fkTcetoNotaLiquidacaoDocumento
     */
    public function removeFkTcetoNotaLiquidacaoDocumentos(\Urbem\CoreBundle\Entity\Tceto\NotaLiquidacaoDocumento $fkTcetoNotaLiquidacaoDocumento)
    {
        $this->fkTcetoNotaLiquidacaoDocumentos->removeElement($fkTcetoNotaLiquidacaoDocumento);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcetoNotaLiquidacaoDocumentos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tceto\NotaLiquidacaoDocumento
     */
    public function getFkTcetoNotaLiquidacaoDocumentos()
    {
        return $this->fkTcetoNotaLiquidacaoDocumentos;
    }
}
