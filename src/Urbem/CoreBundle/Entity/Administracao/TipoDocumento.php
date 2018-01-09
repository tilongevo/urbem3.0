<?php
 
namespace Urbem\CoreBundle\Entity\Administracao;

/**
 * TipoDocumento
 */
class TipoDocumento
{
    /**
     * PK
     * @var integer
     */
    private $codTipoDocumento;

    /**
     * @var string
     */
    private $descricao;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Administracao\ModeloDocumento
     */
    private $fkAdministracaoModeloDocumentos;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkAdministracaoModeloDocumentos = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codTipoDocumento
     *
     * @param integer $codTipoDocumento
     * @return TipoDocumento
     */
    public function setCodTipoDocumento($codTipoDocumento)
    {
        $this->codTipoDocumento = $codTipoDocumento;
        return $this;
    }

    /**
     * Get codTipoDocumento
     *
     * @return integer
     */
    public function getCodTipoDocumento()
    {
        return $this->codTipoDocumento;
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
     * Add AdministracaoModeloDocumento
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\ModeloDocumento $fkAdministracaoModeloDocumento
     * @return TipoDocumento
     */
    public function addFkAdministracaoModeloDocumentos(\Urbem\CoreBundle\Entity\Administracao\ModeloDocumento $fkAdministracaoModeloDocumento)
    {
        if (false === $this->fkAdministracaoModeloDocumentos->contains($fkAdministracaoModeloDocumento)) {
            $fkAdministracaoModeloDocumento->setFkAdministracaoTipoDocumento($this);
            $this->fkAdministracaoModeloDocumentos->add($fkAdministracaoModeloDocumento);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove AdministracaoModeloDocumento
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\ModeloDocumento $fkAdministracaoModeloDocumento
     */
    public function removeFkAdministracaoModeloDocumentos(\Urbem\CoreBundle\Entity\Administracao\ModeloDocumento $fkAdministracaoModeloDocumento)
    {
        $this->fkAdministracaoModeloDocumentos->removeElement($fkAdministracaoModeloDocumento);
    }

    /**
     * OneToMany (owning side)
     * Get fkAdministracaoModeloDocumentos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Administracao\ModeloDocumento
     */
    public function getFkAdministracaoModeloDocumentos()
    {
        return $this->fkAdministracaoModeloDocumentos;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return sprintf('%s - %s', $this->getCodTipoDocumento(), $this->getDescricao());
    }
}
