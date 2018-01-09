<?php
 
namespace Urbem\CoreBundle\Entity\Tcemg;

/**
 * TipoDocCredor
 */
class TipoDocCredor
{
    /**
     * PK
     * @var integer
     */
    private $codigo;

    /**
     * @var string
     */
    private $descricao;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcemg\DeParaDocumento
     */
    private $fkTcemgDeParaDocumentos;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkTcemgDeParaDocumentos = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codigo
     *
     * @param integer $codigo
     * @return TipoDocCredor
     */
    public function setCodigo($codigo)
    {
        $this->codigo = $codigo;
        return $this;
    }

    /**
     * Get codigo
     *
     * @return integer
     */
    public function getCodigo()
    {
        return $this->codigo;
    }

    /**
     * Set descricao
     *
     * @param string $descricao
     * @return TipoDocCredor
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
     * Add TcemgDeParaDocumento
     *
     * @param \Urbem\CoreBundle\Entity\Tcemg\DeParaDocumento $fkTcemgDeParaDocumento
     * @return TipoDocCredor
     */
    public function addFkTcemgDeParaDocumentos(\Urbem\CoreBundle\Entity\Tcemg\DeParaDocumento $fkTcemgDeParaDocumento)
    {
        if (false === $this->fkTcemgDeParaDocumentos->contains($fkTcemgDeParaDocumento)) {
            $fkTcemgDeParaDocumento->setFkTcemgTipoDocCredor($this);
            $this->fkTcemgDeParaDocumentos->add($fkTcemgDeParaDocumento);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcemgDeParaDocumento
     *
     * @param \Urbem\CoreBundle\Entity\Tcemg\DeParaDocumento $fkTcemgDeParaDocumento
     */
    public function removeFkTcemgDeParaDocumentos(\Urbem\CoreBundle\Entity\Tcemg\DeParaDocumento $fkTcemgDeParaDocumento)
    {
        $this->fkTcemgDeParaDocumentos->removeElement($fkTcemgDeParaDocumento);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcemgDeParaDocumentos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcemg\DeParaDocumento
     */
    public function getFkTcemgDeParaDocumentos()
    {
        return $this->fkTcemgDeParaDocumentos;
    }
}
