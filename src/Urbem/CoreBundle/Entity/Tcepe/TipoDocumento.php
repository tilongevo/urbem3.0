<?php
 
namespace Urbem\CoreBundle\Entity\Tcepe;

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
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcepe\Documento
     */
    private $fkTcepeDocumentos;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkTcepeDocumentos = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Add TcepeDocumento
     *
     * @param \Urbem\CoreBundle\Entity\Tcepe\Documento $fkTcepeDocumento
     * @return TipoDocumento
     */
    public function addFkTcepeDocumentos(\Urbem\CoreBundle\Entity\Tcepe\Documento $fkTcepeDocumento)
    {
        if (false === $this->fkTcepeDocumentos->contains($fkTcepeDocumento)) {
            $fkTcepeDocumento->setFkTcepeTipoDocumento($this);
            $this->fkTcepeDocumentos->add($fkTcepeDocumento);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcepeDocumento
     *
     * @param \Urbem\CoreBundle\Entity\Tcepe\Documento $fkTcepeDocumento
     */
    public function removeFkTcepeDocumentos(\Urbem\CoreBundle\Entity\Tcepe\Documento $fkTcepeDocumento)
    {
        $this->fkTcepeDocumentos->removeElement($fkTcepeDocumento);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcepeDocumentos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcepe\Documento
     */
    public function getFkTcepeDocumentos()
    {
        return $this->fkTcepeDocumentos;
    }
}
