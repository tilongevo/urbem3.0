<?php
 
namespace Urbem\CoreBundle\Entity\Fiscalizacao;

/**
 * AutorizacaoNotas
 */
class AutorizacaoNotas
{
    /**
     * PK
     * @var integer
     */
    private $codAutorizacao;

    /**
     * @var integer
     */
    private $numcgm;

    /**
     * @var integer
     */
    private $inscricaoEconomica;

    /**
     * @var integer
     */
    private $numcgmUsuario;

    /**
     * @var string
     */
    private $serie;

    /**
     * @var integer
     */
    private $qtdTaloes;

    /**
     * @var integer
     */
    private $notaInicial;

    /**
     * @var integer
     */
    private $notaFinal;

    /**
     * @var integer
     */
    private $qtdVias;

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
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Fiscalizacao\BaixaAutorizacao
     */
    private $fkFiscalizacaoBaixaAutorizacoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Fiscalizacao\AutorizacaoDocumento
     */
    private $fkFiscalizacaoAutorizacaoDocumentos;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Fiscalizacao\Grafica
     */
    private $fkFiscalizacaoGrafica;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Economico\CadastroEconomico
     */
    private $fkEconomicoCadastroEconomico;

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
        $this->fkFiscalizacaoBaixaAutorizacoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkFiscalizacaoAutorizacaoDocumentos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->timestamp = new \DateTime;
    }

    /**
     * Set codAutorizacao
     *
     * @param integer $codAutorizacao
     * @return AutorizacaoNotas
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
     * Set numcgm
     *
     * @param integer $numcgm
     * @return AutorizacaoNotas
     */
    public function setNumcgm($numcgm)
    {
        $this->numcgm = $numcgm;
        return $this;
    }

    /**
     * Get numcgm
     *
     * @return integer
     */
    public function getNumcgm()
    {
        return $this->numcgm;
    }

    /**
     * Set inscricaoEconomica
     *
     * @param integer $inscricaoEconomica
     * @return AutorizacaoNotas
     */
    public function setInscricaoEconomica($inscricaoEconomica)
    {
        $this->inscricaoEconomica = $inscricaoEconomica;
        return $this;
    }

    /**
     * Get inscricaoEconomica
     *
     * @return integer
     */
    public function getInscricaoEconomica()
    {
        return $this->inscricaoEconomica;
    }

    /**
     * Set numcgmUsuario
     *
     * @param integer $numcgmUsuario
     * @return AutorizacaoNotas
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
     * Set serie
     *
     * @param string $serie
     * @return AutorizacaoNotas
     */
    public function setSerie($serie)
    {
        $this->serie = $serie;
        return $this;
    }

    /**
     * Get serie
     *
     * @return string
     */
    public function getSerie()
    {
        return $this->serie;
    }

    /**
     * Set qtdTaloes
     *
     * @param integer $qtdTaloes
     * @return AutorizacaoNotas
     */
    public function setQtdTaloes($qtdTaloes)
    {
        $this->qtdTaloes = $qtdTaloes;
        return $this;
    }

    /**
     * Get qtdTaloes
     *
     * @return integer
     */
    public function getQtdTaloes()
    {
        return $this->qtdTaloes;
    }

    /**
     * Set notaInicial
     *
     * @param integer $notaInicial
     * @return AutorizacaoNotas
     */
    public function setNotaInicial($notaInicial)
    {
        $this->notaInicial = $notaInicial;
        return $this;
    }

    /**
     * Get notaInicial
     *
     * @return integer
     */
    public function getNotaInicial()
    {
        return $this->notaInicial;
    }

    /**
     * Set notaFinal
     *
     * @param integer $notaFinal
     * @return AutorizacaoNotas
     */
    public function setNotaFinal($notaFinal)
    {
        $this->notaFinal = $notaFinal;
        return $this;
    }

    /**
     * Get notaFinal
     *
     * @return integer
     */
    public function getNotaFinal()
    {
        return $this->notaFinal;
    }

    /**
     * Set qtdVias
     *
     * @param integer $qtdVias
     * @return AutorizacaoNotas
     */
    public function setQtdVias($qtdVias)
    {
        $this->qtdVias = $qtdVias;
        return $this;
    }

    /**
     * Get qtdVias
     *
     * @return integer
     */
    public function getQtdVias()
    {
        return $this->qtdVias;
    }

    /**
     * Set observacao
     *
     * @param string $observacao
     * @return AutorizacaoNotas
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
     * @return AutorizacaoNotas
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
     * Add FiscalizacaoBaixaAutorizacao
     *
     * @param \Urbem\CoreBundle\Entity\Fiscalizacao\BaixaAutorizacao $fkFiscalizacaoBaixaAutorizacao
     * @return AutorizacaoNotas
     */
    public function addFkFiscalizacaoBaixaAutorizacoes(\Urbem\CoreBundle\Entity\Fiscalizacao\BaixaAutorizacao $fkFiscalizacaoBaixaAutorizacao)
    {
        if (false === $this->fkFiscalizacaoBaixaAutorizacoes->contains($fkFiscalizacaoBaixaAutorizacao)) {
            $fkFiscalizacaoBaixaAutorizacao->setFkFiscalizacaoAutorizacaoNotas($this);
            $this->fkFiscalizacaoBaixaAutorizacoes->add($fkFiscalizacaoBaixaAutorizacao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FiscalizacaoBaixaAutorizacao
     *
     * @param \Urbem\CoreBundle\Entity\Fiscalizacao\BaixaAutorizacao $fkFiscalizacaoBaixaAutorizacao
     */
    public function removeFkFiscalizacaoBaixaAutorizacoes(\Urbem\CoreBundle\Entity\Fiscalizacao\BaixaAutorizacao $fkFiscalizacaoBaixaAutorizacao)
    {
        $this->fkFiscalizacaoBaixaAutorizacoes->removeElement($fkFiscalizacaoBaixaAutorizacao);
    }

    /**
     * OneToMany (owning side)
     * Get fkFiscalizacaoBaixaAutorizacoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Fiscalizacao\BaixaAutorizacao
     */
    public function getFkFiscalizacaoBaixaAutorizacoes()
    {
        return $this->fkFiscalizacaoBaixaAutorizacoes;
    }

    /**
     * OneToMany (owning side)
     * Add FiscalizacaoAutorizacaoDocumento
     *
     * @param \Urbem\CoreBundle\Entity\Fiscalizacao\AutorizacaoDocumento $fkFiscalizacaoAutorizacaoDocumento
     * @return AutorizacaoNotas
     */
    public function addFkFiscalizacaoAutorizacaoDocumentos(\Urbem\CoreBundle\Entity\Fiscalizacao\AutorizacaoDocumento $fkFiscalizacaoAutorizacaoDocumento)
    {
        if (false === $this->fkFiscalizacaoAutorizacaoDocumentos->contains($fkFiscalizacaoAutorizacaoDocumento)) {
            $fkFiscalizacaoAutorizacaoDocumento->setFkFiscalizacaoAutorizacaoNotas($this);
            $this->fkFiscalizacaoAutorizacaoDocumentos->add($fkFiscalizacaoAutorizacaoDocumento);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FiscalizacaoAutorizacaoDocumento
     *
     * @param \Urbem\CoreBundle\Entity\Fiscalizacao\AutorizacaoDocumento $fkFiscalizacaoAutorizacaoDocumento
     */
    public function removeFkFiscalizacaoAutorizacaoDocumentos(\Urbem\CoreBundle\Entity\Fiscalizacao\AutorizacaoDocumento $fkFiscalizacaoAutorizacaoDocumento)
    {
        $this->fkFiscalizacaoAutorizacaoDocumentos->removeElement($fkFiscalizacaoAutorizacaoDocumento);
    }

    /**
     * OneToMany (owning side)
     * Get fkFiscalizacaoAutorizacaoDocumentos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Fiscalizacao\AutorizacaoDocumento
     */
    public function getFkFiscalizacaoAutorizacaoDocumentos()
    {
        return $this->fkFiscalizacaoAutorizacaoDocumentos;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkFiscalizacaoGrafica
     *
     * @param \Urbem\CoreBundle\Entity\Fiscalizacao\Grafica $fkFiscalizacaoGrafica
     * @return AutorizacaoNotas
     */
    public function setFkFiscalizacaoGrafica(\Urbem\CoreBundle\Entity\Fiscalizacao\Grafica $fkFiscalizacaoGrafica)
    {
        $this->numcgm = $fkFiscalizacaoGrafica->getNumcgm();
        $this->fkFiscalizacaoGrafica = $fkFiscalizacaoGrafica;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkFiscalizacaoGrafica
     *
     * @return \Urbem\CoreBundle\Entity\Fiscalizacao\Grafica
     */
    public function getFkFiscalizacaoGrafica()
    {
        return $this->fkFiscalizacaoGrafica;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkEconomicoCadastroEconomico
     *
     * @param \Urbem\CoreBundle\Entity\Economico\CadastroEconomico $fkEconomicoCadastroEconomico
     * @return AutorizacaoNotas
     */
    public function setFkEconomicoCadastroEconomico(\Urbem\CoreBundle\Entity\Economico\CadastroEconomico $fkEconomicoCadastroEconomico)
    {
        $this->inscricaoEconomica = $fkEconomicoCadastroEconomico->getInscricaoEconomica();
        $this->fkEconomicoCadastroEconomico = $fkEconomicoCadastroEconomico;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkEconomicoCadastroEconomico
     *
     * @return \Urbem\CoreBundle\Entity\Economico\CadastroEconomico
     */
    public function getFkEconomicoCadastroEconomico()
    {
        return $this->fkEconomicoCadastroEconomico;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkSwCgm
     *
     * @param \Urbem\CoreBundle\Entity\SwCgm $fkSwCgm
     * @return AutorizacaoNotas
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
