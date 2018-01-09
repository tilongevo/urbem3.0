<?php
 
namespace Urbem\CoreBundle\Entity\Documentodinamico;

/**
 * Documento
 */
class Documento
{
    /**
     * PK
     * @var integer
     */
    private $codDocumento;

    /**
     * @var integer
     */
    private $codModulo;

    /**
     * @var string
     */
    private $nomDocumento;

    /**
     * @var integer
     */
    private $margemEsq;

    /**
     * @var integer
     */
    private $margemDir;

    /**
     * @var integer
     */
    private $margemSup;

    /**
     * @var string
     */
    private $fonte;

    /**
     * @var integer
     */
    private $tamanhoFonte;

    /**
     * @var integer
     */
    private $alturaLinha;

    /**
     * @var integer
     */
    private $comprimentoLinha;

    /**
     * @var string
     */
    private $titulo;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Documentodinamico\TagBase
     */
    private $fkDocumentodinamicoTagBases;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Documentodinamico\DocumentoBlocoTexto
     */
    private $fkDocumentodinamicoDocumentoBlocoTextos;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Administracao\Modulo
     */
    private $fkAdministracaoModulo;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkDocumentodinamicoTagBases = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkDocumentodinamicoDocumentoBlocoTextos = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codDocumento
     *
     * @param integer $codDocumento
     * @return Documento
     */
    public function setCodDocumento($codDocumento)
    {
        $this->codDocumento = $codDocumento;
        return $this;
    }

    /**
     * Get codDocumento
     *
     * @return integer
     */
    public function getCodDocumento()
    {
        return $this->codDocumento;
    }

    /**
     * Set codModulo
     *
     * @param integer $codModulo
     * @return Documento
     */
    public function setCodModulo($codModulo)
    {
        $this->codModulo = $codModulo;
        return $this;
    }

    /**
     * Get codModulo
     *
     * @return integer
     */
    public function getCodModulo()
    {
        return $this->codModulo;
    }

    /**
     * Set nomDocumento
     *
     * @param string $nomDocumento
     * @return Documento
     */
    public function setNomDocumento($nomDocumento)
    {
        $this->nomDocumento = $nomDocumento;
        return $this;
    }

    /**
     * Get nomDocumento
     *
     * @return string
     */
    public function getNomDocumento()
    {
        return $this->nomDocumento;
    }

    /**
     * Set margemEsq
     *
     * @param integer $margemEsq
     * @return Documento
     */
    public function setMargemEsq($margemEsq)
    {
        $this->margemEsq = $margemEsq;
        return $this;
    }

    /**
     * Get margemEsq
     *
     * @return integer
     */
    public function getMargemEsq()
    {
        return $this->margemEsq;
    }

    /**
     * Set margemDir
     *
     * @param integer $margemDir
     * @return Documento
     */
    public function setMargemDir($margemDir)
    {
        $this->margemDir = $margemDir;
        return $this;
    }

    /**
     * Get margemDir
     *
     * @return integer
     */
    public function getMargemDir()
    {
        return $this->margemDir;
    }

    /**
     * Set margemSup
     *
     * @param integer $margemSup
     * @return Documento
     */
    public function setMargemSup($margemSup)
    {
        $this->margemSup = $margemSup;
        return $this;
    }

    /**
     * Get margemSup
     *
     * @return integer
     */
    public function getMargemSup()
    {
        return $this->margemSup;
    }

    /**
     * Set fonte
     *
     * @param string $fonte
     * @return Documento
     */
    public function setFonte($fonte)
    {
        $this->fonte = $fonte;
        return $this;
    }

    /**
     * Get fonte
     *
     * @return string
     */
    public function getFonte()
    {
        return $this->fonte;
    }

    /**
     * Set tamanhoFonte
     *
     * @param integer $tamanhoFonte
     * @return Documento
     */
    public function setTamanhoFonte($tamanhoFonte)
    {
        $this->tamanhoFonte = $tamanhoFonte;
        return $this;
    }

    /**
     * Get tamanhoFonte
     *
     * @return integer
     */
    public function getTamanhoFonte()
    {
        return $this->tamanhoFonte;
    }

    /**
     * Set alturaLinha
     *
     * @param integer $alturaLinha
     * @return Documento
     */
    public function setAlturaLinha($alturaLinha)
    {
        $this->alturaLinha = $alturaLinha;
        return $this;
    }

    /**
     * Get alturaLinha
     *
     * @return integer
     */
    public function getAlturaLinha()
    {
        return $this->alturaLinha;
    }

    /**
     * Set comprimentoLinha
     *
     * @param integer $comprimentoLinha
     * @return Documento
     */
    public function setComprimentoLinha($comprimentoLinha)
    {
        $this->comprimentoLinha = $comprimentoLinha;
        return $this;
    }

    /**
     * Get comprimentoLinha
     *
     * @return integer
     */
    public function getComprimentoLinha()
    {
        return $this->comprimentoLinha;
    }

    /**
     * Set titulo
     *
     * @param string $titulo
     * @return Documento
     */
    public function setTitulo($titulo)
    {
        $this->titulo = $titulo;
        return $this;
    }

    /**
     * Get titulo
     *
     * @return string
     */
    public function getTitulo()
    {
        return $this->titulo;
    }

    /**
     * OneToMany (owning side)
     * Add DocumentodinamicoTagBase
     *
     * @param \Urbem\CoreBundle\Entity\Documentodinamico\TagBase $fkDocumentodinamicoTagBase
     * @return Documento
     */
    public function addFkDocumentodinamicoTagBases(\Urbem\CoreBundle\Entity\Documentodinamico\TagBase $fkDocumentodinamicoTagBase)
    {
        if (false === $this->fkDocumentodinamicoTagBases->contains($fkDocumentodinamicoTagBase)) {
            $fkDocumentodinamicoTagBase->setFkDocumentodinamicoDocumento($this);
            $this->fkDocumentodinamicoTagBases->add($fkDocumentodinamicoTagBase);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove DocumentodinamicoTagBase
     *
     * @param \Urbem\CoreBundle\Entity\Documentodinamico\TagBase $fkDocumentodinamicoTagBase
     */
    public function removeFkDocumentodinamicoTagBases(\Urbem\CoreBundle\Entity\Documentodinamico\TagBase $fkDocumentodinamicoTagBase)
    {
        $this->fkDocumentodinamicoTagBases->removeElement($fkDocumentodinamicoTagBase);
    }

    /**
     * OneToMany (owning side)
     * Get fkDocumentodinamicoTagBases
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Documentodinamico\TagBase
     */
    public function getFkDocumentodinamicoTagBases()
    {
        return $this->fkDocumentodinamicoTagBases;
    }

    /**
     * OneToMany (owning side)
     * Add DocumentodinamicoDocumentoBlocoTexto
     *
     * @param \Urbem\CoreBundle\Entity\Documentodinamico\DocumentoBlocoTexto $fkDocumentodinamicoDocumentoBlocoTexto
     * @return Documento
     */
    public function addFkDocumentodinamicoDocumentoBlocoTextos(\Urbem\CoreBundle\Entity\Documentodinamico\DocumentoBlocoTexto $fkDocumentodinamicoDocumentoBlocoTexto)
    {
        if (false === $this->fkDocumentodinamicoDocumentoBlocoTextos->contains($fkDocumentodinamicoDocumentoBlocoTexto)) {
            $fkDocumentodinamicoDocumentoBlocoTexto->setFkDocumentodinamicoDocumento($this);
            $this->fkDocumentodinamicoDocumentoBlocoTextos->add($fkDocumentodinamicoDocumentoBlocoTexto);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove DocumentodinamicoDocumentoBlocoTexto
     *
     * @param \Urbem\CoreBundle\Entity\Documentodinamico\DocumentoBlocoTexto $fkDocumentodinamicoDocumentoBlocoTexto
     */
    public function removeFkDocumentodinamicoDocumentoBlocoTextos(\Urbem\CoreBundle\Entity\Documentodinamico\DocumentoBlocoTexto $fkDocumentodinamicoDocumentoBlocoTexto)
    {
        $this->fkDocumentodinamicoDocumentoBlocoTextos->removeElement($fkDocumentodinamicoDocumentoBlocoTexto);
    }

    /**
     * OneToMany (owning side)
     * Get fkDocumentodinamicoDocumentoBlocoTextos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Documentodinamico\DocumentoBlocoTexto
     */
    public function getFkDocumentodinamicoDocumentoBlocoTextos()
    {
        return $this->fkDocumentodinamicoDocumentoBlocoTextos;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkAdministracaoModulo
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\Modulo $fkAdministracaoModulo
     * @return Documento
     */
    public function setFkAdministracaoModulo(\Urbem\CoreBundle\Entity\Administracao\Modulo $fkAdministracaoModulo)
    {
        $this->codModulo = $fkAdministracaoModulo->getCodModulo();
        $this->fkAdministracaoModulo = $fkAdministracaoModulo;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkAdministracaoModulo
     *
     * @return \Urbem\CoreBundle\Entity\Administracao\Modulo
     */
    public function getFkAdministracaoModulo()
    {
        return $this->fkAdministracaoModulo;
    }
}
