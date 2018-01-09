<?php
 
namespace Urbem\CoreBundle\Entity\Tceam;

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
    private $codTipo;

    /**
     * @var string
     */
    private $exercicio;

    /**
     * @var integer
     */
    private $codEntidade;

    /**
     * @var integer
     */
    private $codNota;

    /**
     * @var integer
     */
    private $vlComprometido;

    /**
     * @var integer
     */
    private $vlTotal;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tceam\TipoDocumentoBilhete
     */
    private $fkTceamTipoDocumentoBilhetes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tceam\TipoDocumentoDiaria
     */
    private $fkTceamTipoDocumentoDiarias;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tceam\TipoDocumentoFolha
     */
    private $fkTceamTipoDocumentoFolhas;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tceam\TipoDocumentoNota
     */
    private $fkTceamTipoDocumentoNotas;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tceam\TipoDocumentoRecibo
     */
    private $fkTceamTipoDocumentoRecibos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tceam\TipoDocumentoDiverso
     */
    private $fkTceamTipoDocumentoDiversos;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Tceam\TipoDocumento
     */
    private $fkTceamTipoDocumento;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Empenho\NotaLiquidacao
     */
    private $fkEmpenhoNotaLiquidacao;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkTceamTipoDocumentoBilhetes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTceamTipoDocumentoDiarias = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTceamTipoDocumentoFolhas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTceamTipoDocumentoNotas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTceamTipoDocumentoRecibos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTceamTipoDocumentoDiversos = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set codTipo
     *
     * @param integer $codTipo
     * @return Documento
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
     * Set exercicio
     *
     * @param string $exercicio
     * @return Documento
     */
    public function setExercicio($exercicio)
    {
        $this->exercicio = $exercicio;
        return $this;
    }

    /**
     * Get exercicio
     *
     * @return string
     */
    public function getExercicio()
    {
        return $this->exercicio;
    }

    /**
     * Set codEntidade
     *
     * @param integer $codEntidade
     * @return Documento
     */
    public function setCodEntidade($codEntidade)
    {
        $this->codEntidade = $codEntidade;
        return $this;
    }

    /**
     * Get codEntidade
     *
     * @return integer
     */
    public function getCodEntidade()
    {
        return $this->codEntidade;
    }

    /**
     * Set codNota
     *
     * @param integer $codNota
     * @return Documento
     */
    public function setCodNota($codNota)
    {
        $this->codNota = $codNota;
        return $this;
    }

    /**
     * Get codNota
     *
     * @return integer
     */
    public function getCodNota()
    {
        return $this->codNota;
    }

    /**
     * Set vlComprometido
     *
     * @param integer $vlComprometido
     * @return Documento
     */
    public function setVlComprometido($vlComprometido = null)
    {
        $this->vlComprometido = $vlComprometido;
        return $this;
    }

    /**
     * Get vlComprometido
     *
     * @return integer
     */
    public function getVlComprometido()
    {
        return $this->vlComprometido;
    }

    /**
     * Set vlTotal
     *
     * @param integer $vlTotal
     * @return Documento
     */
    public function setVlTotal($vlTotal = null)
    {
        $this->vlTotal = $vlTotal;
        return $this;
    }

    /**
     * Get vlTotal
     *
     * @return integer
     */
    public function getVlTotal()
    {
        return $this->vlTotal;
    }

    /**
     * OneToMany (owning side)
     * Add TceamTipoDocumentoBilhete
     *
     * @param \Urbem\CoreBundle\Entity\Tceam\TipoDocumentoBilhete $fkTceamTipoDocumentoBilhete
     * @return Documento
     */
    public function addFkTceamTipoDocumentoBilhetes(\Urbem\CoreBundle\Entity\Tceam\TipoDocumentoBilhete $fkTceamTipoDocumentoBilhete)
    {
        if (false === $this->fkTceamTipoDocumentoBilhetes->contains($fkTceamTipoDocumentoBilhete)) {
            $fkTceamTipoDocumentoBilhete->setFkTceamDocumento($this);
            $this->fkTceamTipoDocumentoBilhetes->add($fkTceamTipoDocumentoBilhete);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TceamTipoDocumentoBilhete
     *
     * @param \Urbem\CoreBundle\Entity\Tceam\TipoDocumentoBilhete $fkTceamTipoDocumentoBilhete
     */
    public function removeFkTceamTipoDocumentoBilhetes(\Urbem\CoreBundle\Entity\Tceam\TipoDocumentoBilhete $fkTceamTipoDocumentoBilhete)
    {
        $this->fkTceamTipoDocumentoBilhetes->removeElement($fkTceamTipoDocumentoBilhete);
    }

    /**
     * OneToMany (owning side)
     * Get fkTceamTipoDocumentoBilhetes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tceam\TipoDocumentoBilhete
     */
    public function getFkTceamTipoDocumentoBilhetes()
    {
        return $this->fkTceamTipoDocumentoBilhetes;
    }

    /**
     * OneToMany (owning side)
     * Add TceamTipoDocumentoDiaria
     *
     * @param \Urbem\CoreBundle\Entity\Tceam\TipoDocumentoDiaria $fkTceamTipoDocumentoDiaria
     * @return Documento
     */
    public function addFkTceamTipoDocumentoDiarias(\Urbem\CoreBundle\Entity\Tceam\TipoDocumentoDiaria $fkTceamTipoDocumentoDiaria)
    {
        if (false === $this->fkTceamTipoDocumentoDiarias->contains($fkTceamTipoDocumentoDiaria)) {
            $fkTceamTipoDocumentoDiaria->setFkTceamDocumento($this);
            $this->fkTceamTipoDocumentoDiarias->add($fkTceamTipoDocumentoDiaria);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TceamTipoDocumentoDiaria
     *
     * @param \Urbem\CoreBundle\Entity\Tceam\TipoDocumentoDiaria $fkTceamTipoDocumentoDiaria
     */
    public function removeFkTceamTipoDocumentoDiarias(\Urbem\CoreBundle\Entity\Tceam\TipoDocumentoDiaria $fkTceamTipoDocumentoDiaria)
    {
        $this->fkTceamTipoDocumentoDiarias->removeElement($fkTceamTipoDocumentoDiaria);
    }

    /**
     * OneToMany (owning side)
     * Get fkTceamTipoDocumentoDiarias
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tceam\TipoDocumentoDiaria
     */
    public function getFkTceamTipoDocumentoDiarias()
    {
        return $this->fkTceamTipoDocumentoDiarias;
    }

    /**
     * OneToMany (owning side)
     * Add TceamTipoDocumentoFolha
     *
     * @param \Urbem\CoreBundle\Entity\Tceam\TipoDocumentoFolha $fkTceamTipoDocumentoFolha
     * @return Documento
     */
    public function addFkTceamTipoDocumentoFolhas(\Urbem\CoreBundle\Entity\Tceam\TipoDocumentoFolha $fkTceamTipoDocumentoFolha)
    {
        if (false === $this->fkTceamTipoDocumentoFolhas->contains($fkTceamTipoDocumentoFolha)) {
            $fkTceamTipoDocumentoFolha->setFkTceamDocumento($this);
            $this->fkTceamTipoDocumentoFolhas->add($fkTceamTipoDocumentoFolha);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TceamTipoDocumentoFolha
     *
     * @param \Urbem\CoreBundle\Entity\Tceam\TipoDocumentoFolha $fkTceamTipoDocumentoFolha
     */
    public function removeFkTceamTipoDocumentoFolhas(\Urbem\CoreBundle\Entity\Tceam\TipoDocumentoFolha $fkTceamTipoDocumentoFolha)
    {
        $this->fkTceamTipoDocumentoFolhas->removeElement($fkTceamTipoDocumentoFolha);
    }

    /**
     * OneToMany (owning side)
     * Get fkTceamTipoDocumentoFolhas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tceam\TipoDocumentoFolha
     */
    public function getFkTceamTipoDocumentoFolhas()
    {
        return $this->fkTceamTipoDocumentoFolhas;
    }

    /**
     * OneToMany (owning side)
     * Add TceamTipoDocumentoNota
     *
     * @param \Urbem\CoreBundle\Entity\Tceam\TipoDocumentoNota $fkTceamTipoDocumentoNota
     * @return Documento
     */
    public function addFkTceamTipoDocumentoNotas(\Urbem\CoreBundle\Entity\Tceam\TipoDocumentoNota $fkTceamTipoDocumentoNota)
    {
        if (false === $this->fkTceamTipoDocumentoNotas->contains($fkTceamTipoDocumentoNota)) {
            $fkTceamTipoDocumentoNota->setFkTceamDocumento($this);
            $this->fkTceamTipoDocumentoNotas->add($fkTceamTipoDocumentoNota);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TceamTipoDocumentoNota
     *
     * @param \Urbem\CoreBundle\Entity\Tceam\TipoDocumentoNota $fkTceamTipoDocumentoNota
     */
    public function removeFkTceamTipoDocumentoNotas(\Urbem\CoreBundle\Entity\Tceam\TipoDocumentoNota $fkTceamTipoDocumentoNota)
    {
        $this->fkTceamTipoDocumentoNotas->removeElement($fkTceamTipoDocumentoNota);
    }

    /**
     * OneToMany (owning side)
     * Get fkTceamTipoDocumentoNotas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tceam\TipoDocumentoNota
     */
    public function getFkTceamTipoDocumentoNotas()
    {
        return $this->fkTceamTipoDocumentoNotas;
    }

    /**
     * OneToMany (owning side)
     * Add TceamTipoDocumentoRecibo
     *
     * @param \Urbem\CoreBundle\Entity\Tceam\TipoDocumentoRecibo $fkTceamTipoDocumentoRecibo
     * @return Documento
     */
    public function addFkTceamTipoDocumentoRecibos(\Urbem\CoreBundle\Entity\Tceam\TipoDocumentoRecibo $fkTceamTipoDocumentoRecibo)
    {
        if (false === $this->fkTceamTipoDocumentoRecibos->contains($fkTceamTipoDocumentoRecibo)) {
            $fkTceamTipoDocumentoRecibo->setFkTceamDocumento($this);
            $this->fkTceamTipoDocumentoRecibos->add($fkTceamTipoDocumentoRecibo);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TceamTipoDocumentoRecibo
     *
     * @param \Urbem\CoreBundle\Entity\Tceam\TipoDocumentoRecibo $fkTceamTipoDocumentoRecibo
     */
    public function removeFkTceamTipoDocumentoRecibos(\Urbem\CoreBundle\Entity\Tceam\TipoDocumentoRecibo $fkTceamTipoDocumentoRecibo)
    {
        $this->fkTceamTipoDocumentoRecibos->removeElement($fkTceamTipoDocumentoRecibo);
    }

    /**
     * OneToMany (owning side)
     * Get fkTceamTipoDocumentoRecibos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tceam\TipoDocumentoRecibo
     */
    public function getFkTceamTipoDocumentoRecibos()
    {
        return $this->fkTceamTipoDocumentoRecibos;
    }

    /**
     * OneToMany (owning side)
     * Add TceamTipoDocumentoDiverso
     *
     * @param \Urbem\CoreBundle\Entity\Tceam\TipoDocumentoDiverso $fkTceamTipoDocumentoDiverso
     * @return Documento
     */
    public function addFkTceamTipoDocumentoDiversos(\Urbem\CoreBundle\Entity\Tceam\TipoDocumentoDiverso $fkTceamTipoDocumentoDiverso)
    {
        if (false === $this->fkTceamTipoDocumentoDiversos->contains($fkTceamTipoDocumentoDiverso)) {
            $fkTceamTipoDocumentoDiverso->setFkTceamDocumento($this);
            $this->fkTceamTipoDocumentoDiversos->add($fkTceamTipoDocumentoDiverso);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TceamTipoDocumentoDiverso
     *
     * @param \Urbem\CoreBundle\Entity\Tceam\TipoDocumentoDiverso $fkTceamTipoDocumentoDiverso
     */
    public function removeFkTceamTipoDocumentoDiversos(\Urbem\CoreBundle\Entity\Tceam\TipoDocumentoDiverso $fkTceamTipoDocumentoDiverso)
    {
        $this->fkTceamTipoDocumentoDiversos->removeElement($fkTceamTipoDocumentoDiverso);
    }

    /**
     * OneToMany (owning side)
     * Get fkTceamTipoDocumentoDiversos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tceam\TipoDocumentoDiverso
     */
    public function getFkTceamTipoDocumentoDiversos()
    {
        return $this->fkTceamTipoDocumentoDiversos;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkTceamTipoDocumento
     *
     * @param \Urbem\CoreBundle\Entity\Tceam\TipoDocumento $fkTceamTipoDocumento
     * @return Documento
     */
    public function setFkTceamTipoDocumento(\Urbem\CoreBundle\Entity\Tceam\TipoDocumento $fkTceamTipoDocumento)
    {
        $this->codTipo = $fkTceamTipoDocumento->getCodTipo();
        $this->fkTceamTipoDocumento = $fkTceamTipoDocumento;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkTceamTipoDocumento
     *
     * @return \Urbem\CoreBundle\Entity\Tceam\TipoDocumento
     */
    public function getFkTceamTipoDocumento()
    {
        return $this->fkTceamTipoDocumento;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkEmpenhoNotaLiquidacao
     *
     * @param \Urbem\CoreBundle\Entity\Empenho\NotaLiquidacao $fkEmpenhoNotaLiquidacao
     * @return Documento
     */
    public function setFkEmpenhoNotaLiquidacao(\Urbem\CoreBundle\Entity\Empenho\NotaLiquidacao $fkEmpenhoNotaLiquidacao)
    {
        $this->exercicio = $fkEmpenhoNotaLiquidacao->getExercicio();
        $this->codNota = $fkEmpenhoNotaLiquidacao->getCodNota();
        $this->codEntidade = $fkEmpenhoNotaLiquidacao->getCodEntidade();
        $this->fkEmpenhoNotaLiquidacao = $fkEmpenhoNotaLiquidacao;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkEmpenhoNotaLiquidacao
     *
     * @return \Urbem\CoreBundle\Entity\Empenho\NotaLiquidacao
     */
    public function getFkEmpenhoNotaLiquidacao()
    {
        return $this->fkEmpenhoNotaLiquidacao;
    }
}
