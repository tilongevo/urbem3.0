<?php
 
namespace Urbem\CoreBundle\Entity\Tceam;

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
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tceam\Documento
     */
    private $fkTceamDocumentos;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkTceamDocumentos = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Add TceamDocumento
     *
     * @param \Urbem\CoreBundle\Entity\Tceam\Documento $fkTceamDocumento
     * @return TipoDocumento
     */
    public function addFkTceamDocumentos(\Urbem\CoreBundle\Entity\Tceam\Documento $fkTceamDocumento)
    {
        if (false === $this->fkTceamDocumentos->contains($fkTceamDocumento)) {
            $fkTceamDocumento->setFkTceamTipoDocumento($this);
            $this->fkTceamDocumentos->add($fkTceamDocumento);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TceamDocumento
     *
     * @param \Urbem\CoreBundle\Entity\Tceam\Documento $fkTceamDocumento
     */
    public function removeFkTceamDocumentos(\Urbem\CoreBundle\Entity\Tceam\Documento $fkTceamDocumento)
    {
        $this->fkTceamDocumentos->removeElement($fkTceamDocumento);
    }

    /**
     * OneToMany (owning side)
     * Get fkTceamDocumentos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tceam\Documento
     */
    public function getFkTceamDocumentos()
    {
        return $this->fkTceamDocumentos;
    }
}
