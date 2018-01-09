<?php
 
namespace Urbem\CoreBundle\Entity\Tceal;

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
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tceal\Documento
     */
    private $fkTcealDocumentos;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkTcealDocumentos = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Add TcealDocumento
     *
     * @param \Urbem\CoreBundle\Entity\Tceal\Documento $fkTcealDocumento
     * @return TipoDocumento
     */
    public function addFkTcealDocumentos(\Urbem\CoreBundle\Entity\Tceal\Documento $fkTcealDocumento)
    {
        if (false === $this->fkTcealDocumentos->contains($fkTcealDocumento)) {
            $fkTcealDocumento->setFkTcealTipoDocumento($this);
            $this->fkTcealDocumentos->add($fkTcealDocumento);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcealDocumento
     *
     * @param \Urbem\CoreBundle\Entity\Tceal\Documento $fkTcealDocumento
     */
    public function removeFkTcealDocumentos(\Urbem\CoreBundle\Entity\Tceal\Documento $fkTcealDocumento)
    {
        $this->fkTcealDocumentos->removeElement($fkTcealDocumento);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcealDocumentos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tceal\Documento
     */
    public function getFkTcealDocumentos()
    {
        return $this->fkTcealDocumentos;
    }
}
