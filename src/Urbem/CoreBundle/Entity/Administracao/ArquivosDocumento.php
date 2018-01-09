<?php
 
namespace Urbem\CoreBundle\Entity\Administracao;

/**
 * ArquivosDocumento
 */
class ArquivosDocumento
{
    /**
     * PK
     * @var integer
     */
    private $codArquivo;

    /**
     * PK
     * @var boolean
     */
    private $sistema;

    /**
     * @var string
     */
    private $nomeArquivoSwx;

    /**
     * @var string
     */
    private $checksum;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Administracao\ModeloArquivosDocumento
     */
    private $fkAdministracaoModeloArquivosDocumentos;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkAdministracaoModeloArquivosDocumentos = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codArquivo
     *
     * @param integer $codArquivo
     * @return ArquivosDocumento
     */
    public function setCodArquivo($codArquivo)
    {
        $this->codArquivo = $codArquivo;
        return $this;
    }

    /**
     * Get codArquivo
     *
     * @return integer
     */
    public function getCodArquivo()
    {
        return $this->codArquivo;
    }

    /**
     * Set sistema
     *
     * @param boolean $sistema
     * @return ArquivosDocumento
     */
    public function setSistema($sistema)
    {
        $this->sistema = $sistema;
        return $this;
    }

    /**
     * Get sistema
     *
     * @return boolean
     */
    public function getSistema()
    {
        return $this->sistema;
    }

    /**
     * Set nomeArquivoSwx
     *
     * @param string $nomeArquivoSwx
     * @return ArquivosDocumento
     */
    public function setNomeArquivoSwx($nomeArquivoSwx)
    {
        $this->nomeArquivoSwx = $nomeArquivoSwx;
        return $this;
    }

    /**
     * Get nomeArquivoSwx
     *
     * @return string
     */
    public function getNomeArquivoSwx()
    {
        return $this->nomeArquivoSwx;
    }

    /**
     * Set checksum
     *
     * @param string $checksum
     * @return ArquivosDocumento
     */
    public function setChecksum($checksum)
    {
        $this->checksum = $checksum;
        return $this;
    }

    /**
     * Get checksum
     *
     * @return string
     */
    public function getChecksum()
    {
        return $this->checksum;
    }

    /**
     * OneToMany (owning side)
     * Add AdministracaoModeloArquivosDocumento
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\ModeloArquivosDocumento $fkAdministracaoModeloArquivosDocumento
     * @return ArquivosDocumento
     */
    public function addFkAdministracaoModeloArquivosDocumentos(\Urbem\CoreBundle\Entity\Administracao\ModeloArquivosDocumento $fkAdministracaoModeloArquivosDocumento)
    {
        if (false === $this->fkAdministracaoModeloArquivosDocumentos->contains($fkAdministracaoModeloArquivosDocumento)) {
            $fkAdministracaoModeloArquivosDocumento->setFkAdministracaoArquivosDocumento($this);
            $this->fkAdministracaoModeloArquivosDocumentos->add($fkAdministracaoModeloArquivosDocumento);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove AdministracaoModeloArquivosDocumento
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\ModeloArquivosDocumento $fkAdministracaoModeloArquivosDocumento
     */
    public function removeFkAdministracaoModeloArquivosDocumentos(\Urbem\CoreBundle\Entity\Administracao\ModeloArquivosDocumento $fkAdministracaoModeloArquivosDocumento)
    {
        $this->fkAdministracaoModeloArquivosDocumentos->removeElement($fkAdministracaoModeloArquivosDocumento);
    }

    /**
     * OneToMany (owning side)
     * Get fkAdministracaoModeloArquivosDocumentos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Administracao\ModeloArquivosDocumento
     */
    public function getFkAdministracaoModeloArquivosDocumentos()
    {
        return $this->fkAdministracaoModeloArquivosDocumentos;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return sprintf('%s - %s', $this->getCodArquivo(), $this->getNomeArquivoSwx());
    }
}
