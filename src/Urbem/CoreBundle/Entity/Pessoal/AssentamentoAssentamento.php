<?php
 
namespace Urbem\CoreBundle\Entity\Pessoal;

/**
 * AssentamentoAssentamento
 */
class AssentamentoAssentamento
{
    /**
     * PK
     * @var integer
     */
    private $codAssentamento;

    /**
     * @var integer
     */
    private $codClassificacao;

    /**
     * @var integer
     */
    private $codNorma;

    /**
     * @var integer
     */
    private $codOperador;

    /**
     * @var string
     */
    private $descricao;

    /**
     * @var string
     */
    private $sigla;

    /**
     * @var integer
     */
    private $codRegimePrevidencia;

    /**
     * @var integer
     */
    private $codMotivo;

    /**
     * @var string
     */
    private $abreviacao;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\Assentamento
     */
    private $fkPessoalAssentamentos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\AssentamentoVinculado
     */
    private $fkPessoalAssentamentoVinculados;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\CondicaoAssentamento
     */
    private $fkPessoalCondicaoAssentamentos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tceal\OcorrenciaFuncionalAssentamento
     */
    private $fkTcealOcorrenciaFuncionalAssentamentos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\AssentamentoGerado
     */
    private $fkPessoalAssentamentoGerados;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\TcmbaAssentamentoAtoPessoal
     */
    private $fkPessoalTcmbaAssentamentoAtoPessoais;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcesc\MotivoLicencaEsfingeSw
     */
    private $fkTcescMotivoLicencaEsfingeSws;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Pessoal\ClassificacaoAssentamento
     */
    private $fkPessoalClassificacaoAssentamento;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Normas\Norma
     */
    private $fkNormasNorma;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Pessoal\AssentamentoOperador
     */
    private $fkPessoalAssentamentoOperador;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Folhapagamento\RegimePrevidencia
     */
    private $fkFolhapagamentoRegimePrevidencia;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Pessoal\AssentamentoMotivo
     */
    private $fkPessoalAssentamentoMotivo;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkPessoalAssentamentos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkPessoalAssentamentoVinculados = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkPessoalCondicaoAssentamentos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTcealOcorrenciaFuncionalAssentamentos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkPessoalAssentamentoGerados = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkPessoalTcmbaAssentamentoAtoPessoais = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTcescMotivoLicencaEsfingeSws = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codAssentamento
     *
     * @param integer $codAssentamento
     * @return AssentamentoAssentamento
     */
    public function setCodAssentamento($codAssentamento)
    {
        $this->codAssentamento = $codAssentamento;
        return $this;
    }

    /**
     * Get codAssentamento
     *
     * @return integer
     */
    public function getCodAssentamento()
    {
        return $this->codAssentamento;
    }

    /**
     * Set codClassificacao
     *
     * @param integer $codClassificacao
     * @return AssentamentoAssentamento
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
     * Set codNorma
     *
     * @param integer $codNorma
     * @return AssentamentoAssentamento
     */
    public function setCodNorma($codNorma)
    {
        $this->codNorma = $codNorma;
        return $this;
    }

    /**
     * Get codNorma
     *
     * @return integer
     */
    public function getCodNorma()
    {
        return $this->codNorma;
    }

    /**
     * Set codOperador
     *
     * @param integer $codOperador
     * @return AssentamentoAssentamento
     */
    public function setCodOperador($codOperador)
    {
        $this->codOperador = $codOperador;
        return $this;
    }

    /**
     * Get codOperador
     *
     * @return integer
     */
    public function getCodOperador()
    {
        return $this->codOperador;
    }

    /**
     * Set descricao
     *
     * @param string $descricao
     * @return AssentamentoAssentamento
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
     * Set sigla
     *
     * @param string $sigla
     * @return AssentamentoAssentamento
     */
    public function setSigla($sigla)
    {
        $this->sigla = $sigla;
        return $this;
    }

    /**
     * Get sigla
     *
     * @return string
     */
    public function getSigla()
    {
        return $this->sigla;
    }

    /**
     * Set codRegimePrevidencia
     *
     * @param integer $codRegimePrevidencia
     * @return AssentamentoAssentamento
     */
    public function setCodRegimePrevidencia($codRegimePrevidencia)
    {
        $this->codRegimePrevidencia = $codRegimePrevidencia;
        return $this;
    }

    /**
     * Get codRegimePrevidencia
     *
     * @return integer
     */
    public function getCodRegimePrevidencia()
    {
        return $this->codRegimePrevidencia;
    }

    /**
     * Set codMotivo
     *
     * @param integer $codMotivo
     * @return AssentamentoAssentamento
     */
    public function setCodMotivo($codMotivo)
    {
        $this->codMotivo = $codMotivo;
        return $this;
    }

    /**
     * Get codMotivo
     *
     * @return integer
     */
    public function getCodMotivo()
    {
        return $this->codMotivo;
    }

    /**
     * Set abreviacao
     *
     * @param string $abreviacao
     * @return AssentamentoAssentamento
     */
    public function setAbreviacao($abreviacao = null)
    {
        $this->abreviacao = $abreviacao;
        return $this;
    }

    /**
     * Get abreviacao
     *
     * @return string
     */
    public function getAbreviacao()
    {
        return $this->abreviacao;
    }

    /**
     * OneToMany (owning side)
     * Add PessoalAssentamento
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\Assentamento $fkPessoalAssentamento
     * @return AssentamentoAssentamento
     */
    public function addFkPessoalAssentamentos(\Urbem\CoreBundle\Entity\Pessoal\Assentamento $fkPessoalAssentamento)
    {
        if (false === $this->fkPessoalAssentamentos->contains($fkPessoalAssentamento)) {
            $fkPessoalAssentamento->setFkPessoalAssentamentoAssentamento($this);
            $this->fkPessoalAssentamentos->add($fkPessoalAssentamento);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PessoalAssentamento
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\Assentamento $fkPessoalAssentamento
     */
    public function removeFkPessoalAssentamentos(\Urbem\CoreBundle\Entity\Pessoal\Assentamento $fkPessoalAssentamento)
    {
        $this->fkPessoalAssentamentos->removeElement($fkPessoalAssentamento);
    }

    /**
     * OneToMany (owning side)
     * Get fkPessoalAssentamentos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\Assentamento
     */
    public function getFkPessoalAssentamentos()
    {
        return $this->fkPessoalAssentamentos;
    }

    /**
     * OneToMany (owning side)
     * Add PessoalAssentamentoVinculado
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\AssentamentoVinculado $fkPessoalAssentamentoVinculado
     * @return AssentamentoAssentamento
     */
    public function addFkPessoalAssentamentoVinculados(\Urbem\CoreBundle\Entity\Pessoal\AssentamentoVinculado $fkPessoalAssentamentoVinculado)
    {
        if (false === $this->fkPessoalAssentamentoVinculados->contains($fkPessoalAssentamentoVinculado)) {
            $fkPessoalAssentamentoVinculado->setFkPessoalAssentamentoAssentamento($this);
            $this->fkPessoalAssentamentoVinculados->add($fkPessoalAssentamentoVinculado);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PessoalAssentamentoVinculado
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\AssentamentoVinculado $fkPessoalAssentamentoVinculado
     */
    public function removeFkPessoalAssentamentoVinculados(\Urbem\CoreBundle\Entity\Pessoal\AssentamentoVinculado $fkPessoalAssentamentoVinculado)
    {
        $this->fkPessoalAssentamentoVinculados->removeElement($fkPessoalAssentamentoVinculado);
    }

    /**
     * OneToMany (owning side)
     * Get fkPessoalAssentamentoVinculados
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\AssentamentoVinculado
     */
    public function getFkPessoalAssentamentoVinculados()
    {
        return $this->fkPessoalAssentamentoVinculados;
    }

    /**
     * OneToMany (owning side)
     * Add PessoalCondicaoAssentamento
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\CondicaoAssentamento $fkPessoalCondicaoAssentamento
     * @return AssentamentoAssentamento
     */
    public function addFkPessoalCondicaoAssentamentos(\Urbem\CoreBundle\Entity\Pessoal\CondicaoAssentamento $fkPessoalCondicaoAssentamento)
    {
        if (false === $this->fkPessoalCondicaoAssentamentos->contains($fkPessoalCondicaoAssentamento)) {
            $fkPessoalCondicaoAssentamento->setFkPessoalAssentamentoAssentamento($this);
            $this->fkPessoalCondicaoAssentamentos->add($fkPessoalCondicaoAssentamento);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PessoalCondicaoAssentamento
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\CondicaoAssentamento $fkPessoalCondicaoAssentamento
     */
    public function removeFkPessoalCondicaoAssentamentos(\Urbem\CoreBundle\Entity\Pessoal\CondicaoAssentamento $fkPessoalCondicaoAssentamento)
    {
        $this->fkPessoalCondicaoAssentamentos->removeElement($fkPessoalCondicaoAssentamento);
    }

    /**
     * OneToMany (owning side)
     * Get fkPessoalCondicaoAssentamentos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\CondicaoAssentamento
     */
    public function getFkPessoalCondicaoAssentamentos()
    {
        return $this->fkPessoalCondicaoAssentamentos;
    }

    /**
     * OneToMany (owning side)
     * Add TcealOcorrenciaFuncionalAssentamento
     *
     * @param \Urbem\CoreBundle\Entity\Tceal\OcorrenciaFuncionalAssentamento $fkTcealOcorrenciaFuncionalAssentamento
     * @return AssentamentoAssentamento
     */
    public function addFkTcealOcorrenciaFuncionalAssentamentos(\Urbem\CoreBundle\Entity\Tceal\OcorrenciaFuncionalAssentamento $fkTcealOcorrenciaFuncionalAssentamento)
    {
        if (false === $this->fkTcealOcorrenciaFuncionalAssentamentos->contains($fkTcealOcorrenciaFuncionalAssentamento)) {
            $fkTcealOcorrenciaFuncionalAssentamento->setFkPessoalAssentamentoAssentamento($this);
            $this->fkTcealOcorrenciaFuncionalAssentamentos->add($fkTcealOcorrenciaFuncionalAssentamento);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcealOcorrenciaFuncionalAssentamento
     *
     * @param \Urbem\CoreBundle\Entity\Tceal\OcorrenciaFuncionalAssentamento $fkTcealOcorrenciaFuncionalAssentamento
     */
    public function removeFkTcealOcorrenciaFuncionalAssentamentos(\Urbem\CoreBundle\Entity\Tceal\OcorrenciaFuncionalAssentamento $fkTcealOcorrenciaFuncionalAssentamento)
    {
        $this->fkTcealOcorrenciaFuncionalAssentamentos->removeElement($fkTcealOcorrenciaFuncionalAssentamento);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcealOcorrenciaFuncionalAssentamentos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tceal\OcorrenciaFuncionalAssentamento
     */
    public function getFkTcealOcorrenciaFuncionalAssentamentos()
    {
        return $this->fkTcealOcorrenciaFuncionalAssentamentos;
    }

    /**
     * OneToMany (owning side)
     * Add PessoalAssentamentoGerado
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\AssentamentoGerado $fkPessoalAssentamentoGerado
     * @return AssentamentoAssentamento
     */
    public function addFkPessoalAssentamentoGerados(\Urbem\CoreBundle\Entity\Pessoal\AssentamentoGerado $fkPessoalAssentamentoGerado)
    {
        if (false === $this->fkPessoalAssentamentoGerados->contains($fkPessoalAssentamentoGerado)) {
            $fkPessoalAssentamentoGerado->setFkPessoalAssentamentoAssentamento($this);
            $this->fkPessoalAssentamentoGerados->add($fkPessoalAssentamentoGerado);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PessoalAssentamentoGerado
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\AssentamentoGerado $fkPessoalAssentamentoGerado
     */
    public function removeFkPessoalAssentamentoGerados(\Urbem\CoreBundle\Entity\Pessoal\AssentamentoGerado $fkPessoalAssentamentoGerado)
    {
        $this->fkPessoalAssentamentoGerados->removeElement($fkPessoalAssentamentoGerado);
    }

    /**
     * OneToMany (owning side)
     * Get fkPessoalAssentamentoGerados
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\AssentamentoGerado
     */
    public function getFkPessoalAssentamentoGerados()
    {
        return $this->fkPessoalAssentamentoGerados;
    }

    /**
     * OneToMany (owning side)
     * Add PessoalTcmbaAssentamentoAtoPessoal
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\TcmbaAssentamentoAtoPessoal $fkPessoalTcmbaAssentamentoAtoPessoal
     * @return AssentamentoAssentamento
     */
    public function addFkPessoalTcmbaAssentamentoAtoPessoais(\Urbem\CoreBundle\Entity\Pessoal\TcmbaAssentamentoAtoPessoal $fkPessoalTcmbaAssentamentoAtoPessoal)
    {
        if (false === $this->fkPessoalTcmbaAssentamentoAtoPessoais->contains($fkPessoalTcmbaAssentamentoAtoPessoal)) {
            $fkPessoalTcmbaAssentamentoAtoPessoal->setFkPessoalAssentamentoAssentamento($this);
            $this->fkPessoalTcmbaAssentamentoAtoPessoais->add($fkPessoalTcmbaAssentamentoAtoPessoal);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PessoalTcmbaAssentamentoAtoPessoal
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\TcmbaAssentamentoAtoPessoal $fkPessoalTcmbaAssentamentoAtoPessoal
     */
    public function removeFkPessoalTcmbaAssentamentoAtoPessoais(\Urbem\CoreBundle\Entity\Pessoal\TcmbaAssentamentoAtoPessoal $fkPessoalTcmbaAssentamentoAtoPessoal)
    {
        $this->fkPessoalTcmbaAssentamentoAtoPessoais->removeElement($fkPessoalTcmbaAssentamentoAtoPessoal);
    }

    /**
     * OneToMany (owning side)
     * Get fkPessoalTcmbaAssentamentoAtoPessoais
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\TcmbaAssentamentoAtoPessoal
     */
    public function getFkPessoalTcmbaAssentamentoAtoPessoais()
    {
        return $this->fkPessoalTcmbaAssentamentoAtoPessoais;
    }

    /**
     * OneToMany (owning side)
     * Add TcescMotivoLicencaEsfingeSw
     *
     * @param \Urbem\CoreBundle\Entity\Tcesc\MotivoLicencaEsfingeSw $fkTcescMotivoLicencaEsfingeSw
     * @return AssentamentoAssentamento
     */
    public function addFkTcescMotivoLicencaEsfingeSws(\Urbem\CoreBundle\Entity\Tcesc\MotivoLicencaEsfingeSw $fkTcescMotivoLicencaEsfingeSw)
    {
        if (false === $this->fkTcescMotivoLicencaEsfingeSws->contains($fkTcescMotivoLicencaEsfingeSw)) {
            $fkTcescMotivoLicencaEsfingeSw->setFkPessoalAssentamentoAssentamento($this);
            $this->fkTcescMotivoLicencaEsfingeSws->add($fkTcescMotivoLicencaEsfingeSw);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcescMotivoLicencaEsfingeSw
     *
     * @param \Urbem\CoreBundle\Entity\Tcesc\MotivoLicencaEsfingeSw $fkTcescMotivoLicencaEsfingeSw
     */
    public function removeFkTcescMotivoLicencaEsfingeSws(\Urbem\CoreBundle\Entity\Tcesc\MotivoLicencaEsfingeSw $fkTcescMotivoLicencaEsfingeSw)
    {
        $this->fkTcescMotivoLicencaEsfingeSws->removeElement($fkTcescMotivoLicencaEsfingeSw);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcescMotivoLicencaEsfingeSws
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcesc\MotivoLicencaEsfingeSw
     */
    public function getFkTcescMotivoLicencaEsfingeSws()
    {
        return $this->fkTcescMotivoLicencaEsfingeSws;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkPessoalClassificacaoAssentamento
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\ClassificacaoAssentamento $fkPessoalClassificacaoAssentamento
     * @return AssentamentoAssentamento
     */
    public function setFkPessoalClassificacaoAssentamento(\Urbem\CoreBundle\Entity\Pessoal\ClassificacaoAssentamento $fkPessoalClassificacaoAssentamento)
    {
        $this->codClassificacao = $fkPessoalClassificacaoAssentamento->getCodClassificacao();
        $this->fkPessoalClassificacaoAssentamento = $fkPessoalClassificacaoAssentamento;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkPessoalClassificacaoAssentamento
     *
     * @return \Urbem\CoreBundle\Entity\Pessoal\ClassificacaoAssentamento
     */
    public function getFkPessoalClassificacaoAssentamento()
    {
        return $this->fkPessoalClassificacaoAssentamento;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkNormasNorma
     *
     * @param \Urbem\CoreBundle\Entity\Normas\Norma $fkNormasNorma
     * @return AssentamentoAssentamento
     */
    public function setFkNormasNorma(\Urbem\CoreBundle\Entity\Normas\Norma $fkNormasNorma)
    {
        $this->codNorma = $fkNormasNorma->getCodNorma();
        $this->fkNormasNorma = $fkNormasNorma;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkNormasNorma
     *
     * @return \Urbem\CoreBundle\Entity\Normas\Norma
     */
    public function getFkNormasNorma()
    {
        return $this->fkNormasNorma;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkPessoalAssentamentoOperador
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\AssentamentoOperador $fkPessoalAssentamentoOperador
     * @return AssentamentoAssentamento
     */
    public function setFkPessoalAssentamentoOperador(\Urbem\CoreBundle\Entity\Pessoal\AssentamentoOperador $fkPessoalAssentamentoOperador)
    {
        $this->codOperador = $fkPessoalAssentamentoOperador->getCodOperador();
        $this->fkPessoalAssentamentoOperador = $fkPessoalAssentamentoOperador;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkPessoalAssentamentoOperador
     *
     * @return \Urbem\CoreBundle\Entity\Pessoal\AssentamentoOperador
     */
    public function getFkPessoalAssentamentoOperador()
    {
        return $this->fkPessoalAssentamentoOperador;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkFolhapagamentoRegimePrevidencia
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\RegimePrevidencia $fkFolhapagamentoRegimePrevidencia
     * @return AssentamentoAssentamento
     */
    public function setFkFolhapagamentoRegimePrevidencia(\Urbem\CoreBundle\Entity\Folhapagamento\RegimePrevidencia $fkFolhapagamentoRegimePrevidencia)
    {
        $this->codRegimePrevidencia = $fkFolhapagamentoRegimePrevidencia->getCodRegimePrevidencia();
        $this->fkFolhapagamentoRegimePrevidencia = $fkFolhapagamentoRegimePrevidencia;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkFolhapagamentoRegimePrevidencia
     *
     * @return \Urbem\CoreBundle\Entity\Folhapagamento\RegimePrevidencia
     */
    public function getFkFolhapagamentoRegimePrevidencia()
    {
        return $this->fkFolhapagamentoRegimePrevidencia;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkPessoalAssentamentoMotivo
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\AssentamentoMotivo $fkPessoalAssentamentoMotivo
     * @return AssentamentoAssentamento
     */
    public function setFkPessoalAssentamentoMotivo(\Urbem\CoreBundle\Entity\Pessoal\AssentamentoMotivo $fkPessoalAssentamentoMotivo)
    {
        $this->codMotivo = $fkPessoalAssentamentoMotivo->getCodMotivo();
        $this->fkPessoalAssentamentoMotivo = $fkPessoalAssentamentoMotivo;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkPessoalAssentamentoMotivo
     *
     * @return \Urbem\CoreBundle\Entity\Pessoal\AssentamentoMotivo
     */
    public function getFkPessoalAssentamentoMotivo()
    {
        return $this->fkPessoalAssentamentoMotivo;
    }
    
    /**
     * Retorna o codAssentamento
     * @return string
     */
    public function __toString()
    {
        if (null != $this->codAssentamento) {
            return sprintf('%s - %s', $this->codAssentamento, $this->descricao);
        } else {
            return "Assentamento";
        }
    }
}
