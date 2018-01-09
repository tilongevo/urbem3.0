<?php
 
namespace Urbem\CoreBundle\Entity\Fiscalizacao;

/**
 * BaixaAutorizacao
 */
class BaixaAutorizacao
{
    /**
     * PK
     * @var integer
     */
    private $codBaixa;

    /**
     * @var integer
     */
    private $codAutorizacao;

    /**
     * @var integer
     */
    private $numcgmUsuario;

    /**
     * @var string
     */
    private $observacao;

    /**
     * @var \DateTime
     */
    private $timestamp;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Fiscalizacao\BaixaNotas
     */
    private $fkFiscalizacaoBaixaNotas;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Fiscalizacao\BaixaDocumento
     */
    private $fkFiscalizacaoBaixaDocumentos;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Fiscalizacao\AutorizacaoNotas
     */
    private $fkFiscalizacaoAutorizacaoNotas;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\SwCgm
     */
    private $fkSwCgm;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkFiscalizacaoBaixaNotas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkFiscalizacaoBaixaDocumentos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->timestamp = new \DateTime;
    }

    /**
     * Set codBaixa
     *
     * @param integer $codBaixa
     * @return BaixaAutorizacao
     */
    public function setCodBaixa($codBaixa)
    {
        $this->codBaixa = $codBaixa;
        return $this;
    }

    /**
     * Get codBaixa
     *
     * @return integer
     */
    public function getCodBaixa()
    {
        return $this->codBaixa;
    }

    /**
     * Set codAutorizacao
     *
     * @param integer $codAutorizacao
     * @return BaixaAutorizacao
     */
    public function setCodAutorizacao($codAutorizacao)
    {
        $this->codAutorizacao = $codAutorizacao;
        return $this;
    }

    /**
     * Get codAutorizacao
     *
     * @return integer
     */
    public function getCodAutorizacao()
    {
        return $this->codAutorizacao;
    }

    /**
     * Set numcgmUsuario
     *
     * @param integer $numcgmUsuario
     * @return BaixaAutorizacao
     */
    public function setNumcgmUsuario($numcgmUsuario)
    {
        $this->numcgmUsuario = $numcgmUsuario;
        return $this;
    }

    /**
     * Get numcgmUsuario
     *
     * @return integer
     */
    public function getNumcgmUsuario()
    {
        return $this->numcgmUsuario;
    }

    /**
     * Set observacao
     *
     * @param string $observacao
     * @return BaixaAutorizacao
     */
    public function setObservacao($observacao = null)
    {
        $this->observacao = $observacao;
        return $this;
    }

    /**
     * Get observacao
     *
     * @return string
     */
    public function getObservacao()
    {
        return $this->observacao;
    }

    /**
     * Set timestamp
     *
     * @param \DateTime $timestamp
     * @return BaixaAutorizacao
     */
    public function setTimestamp(\DateTime $timestamp)
    {
        $this->timestamp = $timestamp;
        return $this;
    }

    /**
     * Get timestamp
     *
     * @return \DateTime
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }

    /**
     * OneToMany (owning side)
     * Add FiscalizacaoBaixaNotas
     *
     * @param \Urbem\CoreBundle\Entity\Fiscalizacao\BaixaNotas $fkFiscalizacaoBaixaNotas
     * @return BaixaAutorizacao
     */
    public function addFkFiscalizacaoBaixaNotas(\Urbem\CoreBundle\Entity\Fiscalizacao\BaixaNotas $fkFiscalizacaoBaixaNotas)
    {
        if (false === $this->fkFiscalizacaoBaixaNotas->contains($fkFiscalizacaoBaixaNotas)) {
            $fkFiscalizacaoBaixaNotas->setFkFiscalizacaoBaixaAutorizacao($this);
            $this->fkFiscalizacaoBaixaNotas->add($fkFiscalizacaoBaixaNotas);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FiscalizacaoBaixaNotas
     *
     * @param \Urbem\CoreBundle\Entity\Fiscalizacao\BaixaNotas $fkFiscalizacaoBaixaNotas
     */
    public function removeFkFiscalizacaoBaixaNotas(\Urbem\CoreBundle\Entity\Fiscalizacao\BaixaNotas $fkFiscalizacaoBaixaNotas)
    {
        $this->fkFiscalizacaoBaixaNotas->removeElement($fkFiscalizacaoBaixaNotas);
    }

    /**
     * OneToMany (owning side)
     * Get fkFiscalizacaoBaixaNotas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Fiscalizacao\BaixaNotas
     */
    public function getFkFiscalizacaoBaixaNotas()
    {
        return $this->fkFiscalizacaoBaixaNotas;
    }

    /**
     * OneToMany (owning side)
     * Add FiscalizacaoBaixaDocumento
     *
     * @param \Urbem\CoreBundle\Entity\Fiscalizacao\BaixaDocumento $fkFiscalizacaoBaixaDocumento
     * @return BaixaAutorizacao
     */
    public function addFkFiscalizacaoBaixaDocumentos(\Urbem\CoreBundle\Entity\Fiscalizacao\BaixaDocumento $fkFiscalizacaoBaixaDocumento)
    {
        if (false === $this->fkFiscalizacaoBaixaDocumentos->contains($fkFiscalizacaoBaixaDocumento)) {
            $fkFiscalizacaoBaixaDocumento->setFkFiscalizacaoBaixaAutorizacao($this);
            $this->fkFiscalizacaoBaixaDocumentos->add($fkFiscalizacaoBaixaDocumento);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FiscalizacaoBaixaDocumento
     *
     * @param \Urbem\CoreBundle\Entity\Fiscalizacao\BaixaDocumento $fkFiscalizacaoBaixaDocumento
     */
    public function removeFkFiscalizacaoBaixaDocumentos(\Urbem\CoreBundle\Entity\Fiscalizacao\BaixaDocumento $fkFiscalizacaoBaixaDocumento)
    {
        $this->fkFiscalizacaoBaixaDocumentos->removeElement($fkFiscalizacaoBaixaDocumento);
    }

    /**
     * OneToMany (owning side)
     * Get fkFiscalizacaoBaixaDocumentos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Fiscalizacao\BaixaDocumento
     */
    public function getFkFiscalizacaoBaixaDocumentos()
    {
        return $this->fkFiscalizacaoBaixaDocumentos;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkFiscalizacaoAutorizacaoNotas
     *
     * @param \Urbem\CoreBundle\Entity\Fiscalizacao\AutorizacaoNotas $fkFiscalizacaoAutorizacaoNotas
     * @return BaixaAutorizacao
     */
    public function setFkFiscalizacaoAutorizacaoNotas(\Urbem\CoreBundle\Entity\Fiscalizacao\AutorizacaoNotas $fkFiscalizacaoAutorizacaoNotas)
    {
        $this->codAutorizacao = $fkFiscalizacaoAutorizacaoNotas->getCodAutorizacao();
        $this->fkFiscalizacaoAutorizacaoNotas = $fkFiscalizacaoAutorizacaoNotas;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkFiscalizacaoAutorizacaoNotas
     *
     * @return \Urbem\CoreBundle\Entity\Fiscalizacao\AutorizacaoNotas
     */
    public function getFkFiscalizacaoAutorizacaoNotas()
    {
        return $this->fkFiscalizacaoAutorizacaoNotas;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkSwCgm
     *
     * @param \Urbem\CoreBundle\Entity\SwCgm $fkSwCgm
     * @return BaixaAutorizacao
     */
    public function setFkSwCgm(\Urbem\CoreBundle\Entity\SwCgm $fkSwCgm)
    {
        $this->numcgmUsuario = $fkSwCgm->getNumcgm();
        $this->fkSwCgm = $fkSwCgm;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkSwCgm
     *
     * @return \Urbem\CoreBundle\Entity\SwCgm
     */
    public function getFkSwCgm()
    {
        return $this->fkSwCgm;
    }
}
