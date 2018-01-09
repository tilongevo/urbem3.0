<?php
 
namespace Urbem\CoreBundle\Entity;

/**
 * SwAssunto
 */
class SwAssunto
{
    /**
     * PK
     * @var integer
     */
    private $codAssunto;

    /**
     * PK
     * @var integer
     */
    private $codClassificacao;

    /**
     * @var string
     */
    private $nomAssunto;

    /**
     * @var boolean
     */
    private $confidencial = false;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Protocolo\AssuntoAcao
     */
    private $fkProtocoloAssuntoAcoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Protocolo\ProcessoHistorico
     */
    private $fkProtocoloProcessoHistoricos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\SwDocumentoAssunto
     */
    private $fkSwDocumentoAssuntos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\SwProcesso
     */
    private $fkSwProcessos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\SwAndamentoPadrao
     */
    private $fkSwAndamentoPadroes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\SwAssuntoAtributo
     */
    private $fkSwAssuntoAtributos;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\SwClassificacao
     */
    private $fkSwClassificacao;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkProtocoloAssuntoAcoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkProtocoloProcessoHistoricos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkSwDocumentoAssuntos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkSwProcessos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkSwAndamentoPadroes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkSwAssuntoAtributos = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codAssunto
     *
     * @param integer $codAssunto
     * @return SwAssunto
     */
    public function setCodAssunto($codAssunto)
    {
        $this->codAssunto = $codAssunto;
        return $this;
    }

    /**
     * Get codAssunto
     *
     * @return integer
     */
    public function getCodAssunto()
    {
        return $this->codAssunto;
    }

    /**
     * Set codClassificacao
     *
     * @param integer $codClassificacao
     * @return SwAssunto
     */
    public function setCodClassificacao($codClassificacao)
    {
        $this->codClassificacao = $codClassificacao;
        return $this;
    }

    /**
     * Get codClassificacao
     *
     * @return integer
     */
    public function getCodClassificacao()
    {
        return $this->codClassificacao;
    }

    /**
     * Set nomAssunto
     *
     * @param string $nomAssunto
     * @return SwAssunto
     */
    public function setNomAssunto($nomAssunto)
    {
        $this->nomAssunto = $nomAssunto;
        return $this;
    }

    /**
     * Get nomAssunto
     *
     * @return string
     */
    public function getNomAssunto()
    {
        return $this->nomAssunto;
    }

    /**
     * Set confidencial
     *
     * @param boolean $confidencial
     * @return SwAssunto
     */
    public function setConfidencial($confidencial)
    {
        $this->confidencial = $confidencial;
        return $this;
    }

    /**
     * Get confidencial
     *
     * @return boolean
     */
    public function getConfidencial()
    {
        return $this->confidencial;
    }

    /**
     * OneToMany (owning side)
     * Add ProtocoloAssuntoAcao
     *
     * @param \Urbem\CoreBundle\Entity\Protocolo\AssuntoAcao $fkProtocoloAssuntoAcao
     * @return SwAssunto
     */
    public function addFkProtocoloAssuntoAcoes(\Urbem\CoreBundle\Entity\Protocolo\AssuntoAcao $fkProtocoloAssuntoAcao)
    {
        if (false === $this->fkProtocoloAssuntoAcoes->contains($fkProtocoloAssuntoAcao)) {
            $fkProtocoloAssuntoAcao->setFkSwAssunto($this);
            $this->fkProtocoloAssuntoAcoes->add($fkProtocoloAssuntoAcao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ProtocoloAssuntoAcao
     *
     * @param \Urbem\CoreBundle\Entity\Protocolo\AssuntoAcao $fkProtocoloAssuntoAcao
     */
    public function removeFkProtocoloAssuntoAcoes(\Urbem\CoreBundle\Entity\Protocolo\AssuntoAcao $fkProtocoloAssuntoAcao)
    {
        $this->fkProtocoloAssuntoAcoes->removeElement($fkProtocoloAssuntoAcao);
    }

    /**
     * OneToMany (owning side)
     * Get fkProtocoloAssuntoAcoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Protocolo\AssuntoAcao
     */
    public function getFkProtocoloAssuntoAcoes()
    {
        return $this->fkProtocoloAssuntoAcoes;
    }

    /**
     * OneToMany (owning side)
     * Add ProtocoloProcessoHistorico
     *
     * @param \Urbem\CoreBundle\Entity\Protocolo\ProcessoHistorico $fkProtocoloProcessoHistorico
     * @return SwAssunto
     */
    public function addFkProtocoloProcessoHistoricos(\Urbem\CoreBundle\Entity\Protocolo\ProcessoHistorico $fkProtocoloProcessoHistorico)
    {
        if (false === $this->fkProtocoloProcessoHistoricos->contains($fkProtocoloProcessoHistorico)) {
            $fkProtocoloProcessoHistorico->setFkSwAssunto($this);
            $this->fkProtocoloProcessoHistoricos->add($fkProtocoloProcessoHistorico);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ProtocoloProcessoHistorico
     *
     * @param \Urbem\CoreBundle\Entity\Protocolo\ProcessoHistorico $fkProtocoloProcessoHistorico
     */
    public function removeFkProtocoloProcessoHistoricos(\Urbem\CoreBundle\Entity\Protocolo\ProcessoHistorico $fkProtocoloProcessoHistorico)
    {
        $this->fkProtocoloProcessoHistoricos->removeElement($fkProtocoloProcessoHistorico);
    }

    /**
     * OneToMany (owning side)
     * Get fkProtocoloProcessoHistoricos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Protocolo\ProcessoHistorico
     */
    public function getFkProtocoloProcessoHistoricos()
    {
        return $this->fkProtocoloProcessoHistoricos;
    }

    /**
     * OneToMany (owning side)
     * Add SwDocumentoAssunto
     *
     * @param \Urbem\CoreBundle\Entity\SwDocumentoAssunto $fkSwDocumentoAssunto
     * @return SwAssunto
     */
    public function addFkSwDocumentoAssuntos(\Urbem\CoreBundle\Entity\SwDocumentoAssunto $fkSwDocumentoAssunto)
    {
        if (false === $this->fkSwDocumentoAssuntos->contains($fkSwDocumentoAssunto)) {
            $fkSwDocumentoAssunto->setFkSwAssunto($this);
            $this->fkSwDocumentoAssuntos->add($fkSwDocumentoAssunto);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove SwDocumentoAssunto
     *
     * @param \Urbem\CoreBundle\Entity\SwDocumentoAssunto $fkSwDocumentoAssunto
     */
    public function removeFkSwDocumentoAssuntos(\Urbem\CoreBundle\Entity\SwDocumentoAssunto $fkSwDocumentoAssunto)
    {
        $this->fkSwDocumentoAssuntos->removeElement($fkSwDocumentoAssunto);
    }

    /**
     * OneToMany (owning side)
     * Get fkSwDocumentoAssuntos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\SwDocumentoAssunto
     */
    public function getFkSwDocumentoAssuntos()
    {
        return $this->fkSwDocumentoAssuntos;
    }

    /**
     * OneToMany (owning side)
     * Add SwProcesso
     *
     * @param \Urbem\CoreBundle\Entity\SwProcesso $fkSwProcesso
     * @return SwAssunto
     */
    public function addFkSwProcessos(\Urbem\CoreBundle\Entity\SwProcesso $fkSwProcesso)
    {
        if (false === $this->fkSwProcessos->contains($fkSwProcesso)) {
            $fkSwProcesso->setFkSwAssunto($this);
            $this->fkSwProcessos->add($fkSwProcesso);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove SwProcesso
     *
     * @param \Urbem\CoreBundle\Entity\SwProcesso $fkSwProcesso
     */
    public function removeFkSwProcessos(\Urbem\CoreBundle\Entity\SwProcesso $fkSwProcesso)
    {
        $this->fkSwProcessos->removeElement($fkSwProcesso);
    }

    /**
     * OneToMany (owning side)
     * Get fkSwProcessos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\SwProcesso
     */
    public function getFkSwProcessos()
    {
        return $this->fkSwProcessos;
    }

    /**
     * OneToMany (owning side)
     * Add SwAndamentoPadrao
     *
     * @param \Urbem\CoreBundle\Entity\SwAndamentoPadrao $fkSwAndamentoPadrao
     * @return SwAssunto
     */
    public function addFkSwAndamentoPadroes(\Urbem\CoreBundle\Entity\SwAndamentoPadrao $fkSwAndamentoPadrao)
    {
        if (false === $this->fkSwAndamentoPadroes->contains($fkSwAndamentoPadrao)) {
            $fkSwAndamentoPadrao->setFkSwAssunto($this);
            $this->fkSwAndamentoPadroes->add($fkSwAndamentoPadrao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove SwAndamentoPadrao
     *
     * @param \Urbem\CoreBundle\Entity\SwAndamentoPadrao $fkSwAndamentoPadrao
     */
    public function removeFkSwAndamentoPadroes(\Urbem\CoreBundle\Entity\SwAndamentoPadrao $fkSwAndamentoPadrao)
    {
        $this->fkSwAndamentoPadroes->removeElement($fkSwAndamentoPadrao);
    }

    /**
     * OneToMany (owning side)
     * Get fkSwAndamentoPadroes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\SwAndamentoPadrao
     */
    public function getFkSwAndamentoPadroes()
    {
        return $this->fkSwAndamentoPadroes;
    }

    /**
     * OneToMany (owning side)
     * Add SwAssuntoAtributo
     *
     * @param \Urbem\CoreBundle\Entity\SwAssuntoAtributo $fkSwAssuntoAtributo
     * @return SwAssunto
     */
    public function addFkSwAssuntoAtributos(\Urbem\CoreBundle\Entity\SwAssuntoAtributo $fkSwAssuntoAtributo)
    {
        if (false === $this->fkSwAssuntoAtributos->contains($fkSwAssuntoAtributo)) {
            $fkSwAssuntoAtributo->setFkSwAssunto($this);
            $this->fkSwAssuntoAtributos->add($fkSwAssuntoAtributo);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove SwAssuntoAtributo
     *
     * @param \Urbem\CoreBundle\Entity\SwAssuntoAtributo $fkSwAssuntoAtributo
     */
    public function removeFkSwAssuntoAtributos(\Urbem\CoreBundle\Entity\SwAssuntoAtributo $fkSwAssuntoAtributo)
    {
        $this->fkSwAssuntoAtributos->removeElement($fkSwAssuntoAtributo);
    }

    /**
     * OneToMany (owning side)
     * Get fkSwAssuntoAtributos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\SwAssuntoAtributo
     */
    public function getFkSwAssuntoAtributos()
    {
        return $this->fkSwAssuntoAtributos;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkSwClassificacao
     *
     * @param \Urbem\CoreBundle\Entity\SwClassificacao $fkSwClassificacao
     * @return SwAssunto
     */
    public function setFkSwClassificacao(\Urbem\CoreBundle\Entity\SwClassificacao $fkSwClassificacao)
    {
        $this->codClassificacao = $fkSwClassificacao->getCodClassificacao();
        $this->fkSwClassificacao = $fkSwClassificacao;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkSwClassificacao
     *
     * @return \Urbem\CoreBundle\Entity\SwClassificacao
     */
    public function getFkSwClassificacao()
    {
        return $this->fkSwClassificacao;
    }

    /**
     * @return string
     */
    public function getCodComposto()
    {
        return sprintf('%s~%s', $this->codAssunto, $this->codClassificacao);
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return sprintf(
            '%03s - %s',
            $this->codAssunto,
            $this->nomAssunto
        );
    }
}
