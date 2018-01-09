<?php
 
namespace Urbem\CoreBundle\Entity\Pessoal;

/**
 * Assentamento
 */
class Assentamento
{
    /**
     * PK
     * @var integer
     */
    private $codAssentamento;

    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    private $timestamp;

    /**
     * @var boolean
     */
    private $gradeEfetividade;

    /**
     * @var boolean
     */
    private $relFuncaoGratificada;

    /**
     * @var boolean
     */
    private $eventoAutomatico;

    /**
     * @var integer
     */
    private $codEsfera;

    /**
     * @var boolean
     */
    private $assentamentoInicio;

    /**
     * @var boolean
     */
    private $assentamentoAutomatico;

    /**
     * @var integer
     */
    private $quantDiasOnusEmpregador;

    /**
     * @var integer
     */
    private $quantDiasLicencaPremio;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Pessoal\AssentamentoAfastamentoTemporario
     */
    private $fkPessoalAssentamentoAfastamentoTemporario;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Pessoal\AssentamentoVantagem
     */
    private $fkPessoalAssentamentoVantagem;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Pessoal\AssentamentoValidade
     */
    private $fkPessoalAssentamentoValidade;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\AssentamentoEventoProporcional
     */
    private $fkPessoalAssentamentoEventoProporcionais;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\AssentamentoEvento
     */
    private $fkPessoalAssentamentoEventos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\AssentamentoSubDivisao
     */
    private $fkPessoalAssentamentoSubDivisoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\TcepeConfiguracaoRelacionaHistorico
     */
    private $fkPessoalTcepeConfiguracaoRelacionaHistoricos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\AssentamentoCausaRescisao
     */
    private $fkPessoalAssentamentoCausaRescisoes;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Pessoal\AssentamentoAssentamento
     */
    private $fkPessoalAssentamentoAssentamento;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Pessoal\EsferaOrigem
     */
    private $fkPessoalEsferaOrigem;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkPessoalAssentamentoEventoProporcionais = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkPessoalAssentamentoEventos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkPessoalAssentamentoSubDivisoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkPessoalTcepeConfiguracaoRelacionaHistoricos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkPessoalAssentamentoCausaRescisoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
    }

    /**
     * Set codAssentamento
     *
     * @param integer $codAssentamento
     * @return Assentamento
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
     * Set timestamp
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp
     * @return Assentamento
     */
    public function setTimestamp(\Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp)
    {
        $this->timestamp = $timestamp;
        return $this;
    }

    /**
     * Get timestamp
     *
     * @return \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }

    /**
     * Set gradeEfetividade
     *
     * @param boolean $gradeEfetividade
     * @return Assentamento
     */
    public function setGradeEfetividade($gradeEfetividade)
    {
        $this->gradeEfetividade = $gradeEfetividade;
        return $this;
    }

    /**
     * Get gradeEfetividade
     *
     * @return boolean
     */
    public function getGradeEfetividade()
    {
        return $this->gradeEfetividade;
    }

    /**
     * Set relFuncaoGratificada
     *
     * @param boolean $relFuncaoGratificada
     * @return Assentamento
     */
    public function setRelFuncaoGratificada($relFuncaoGratificada)
    {
        $this->relFuncaoGratificada = $relFuncaoGratificada;
        return $this;
    }

    /**
     * Get relFuncaoGratificada
     *
     * @return boolean
     */
    public function getRelFuncaoGratificada()
    {
        return $this->relFuncaoGratificada;
    }

    /**
     * Set eventoAutomatico
     *
     * @param boolean $eventoAutomatico
     * @return Assentamento
     */
    public function setEventoAutomatico($eventoAutomatico)
    {
        $this->eventoAutomatico = $eventoAutomatico;
        return $this;
    }

    /**
     * Get eventoAutomatico
     *
     * @return boolean
     */
    public function getEventoAutomatico()
    {
        return $this->eventoAutomatico;
    }

    /**
     * Set codEsfera
     *
     * @param integer $codEsfera
     * @return Assentamento
     */
    public function setCodEsfera($codEsfera)
    {
        $this->codEsfera = $codEsfera;
        return $this;
    }

    /**
     * Get codEsfera
     *
     * @return integer
     */
    public function getCodEsfera()
    {
        return $this->codEsfera;
    }

    /**
     * Set assentamentoInicio
     *
     * @param boolean $assentamentoInicio
     * @return Assentamento
     */
    public function setAssentamentoInicio($assentamentoInicio = null)
    {
        $this->assentamentoInicio = $assentamentoInicio;
        return $this;
    }

    /**
     * Get assentamentoInicio
     *
     * @return boolean
     */
    public function getAssentamentoInicio()
    {
        return $this->assentamentoInicio;
    }

    /**
     * Set assentamentoAutomatico
     *
     * @param boolean $assentamentoAutomatico
     * @return Assentamento
     */
    public function setAssentamentoAutomatico($assentamentoAutomatico)
    {
        $this->assentamentoAutomatico = $assentamentoAutomatico;
        return $this;
    }

    /**
     * Get assentamentoAutomatico
     *
     * @return boolean
     */
    public function getAssentamentoAutomatico()
    {
        return $this->assentamentoAutomatico;
    }

    /**
     * Set quantDiasOnusEmpregador
     *
     * @param integer $quantDiasOnusEmpregador
     * @return Assentamento
     */
    public function setQuantDiasOnusEmpregador($quantDiasOnusEmpregador = null)
    {
        $this->quantDiasOnusEmpregador = $quantDiasOnusEmpregador;
        return $this;
    }

    /**
     * Get quantDiasOnusEmpregador
     *
     * @return integer
     */
    public function getQuantDiasOnusEmpregador()
    {
        return $this->quantDiasOnusEmpregador;
    }

    /**
     * Set quantDiasLicencaPremio
     *
     * @param integer $quantDiasLicencaPremio
     * @return Assentamento
     */
    public function setQuantDiasLicencaPremio($quantDiasLicencaPremio = null)
    {
        $this->quantDiasLicencaPremio = $quantDiasLicencaPremio;
        return $this;
    }

    /**
     * Get quantDiasLicencaPremio
     *
     * @return integer
     */
    public function getQuantDiasLicencaPremio()
    {
        return $this->quantDiasLicencaPremio;
    }

    /**
     * OneToMany (owning side)
     * Add PessoalAssentamentoEventoProporcional
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\AssentamentoEventoProporcional $fkPessoalAssentamentoEventoProporcional
     * @return Assentamento
     */
    public function addFkPessoalAssentamentoEventoProporcionais(\Urbem\CoreBundle\Entity\Pessoal\AssentamentoEventoProporcional $fkPessoalAssentamentoEventoProporcional)
    {
        if (false === $this->fkPessoalAssentamentoEventoProporcionais->contains($fkPessoalAssentamentoEventoProporcional)) {
            $fkPessoalAssentamentoEventoProporcional->setFkPessoalAssentamento($this);
            $this->fkPessoalAssentamentoEventoProporcionais->add($fkPessoalAssentamentoEventoProporcional);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PessoalAssentamentoEventoProporcional
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\AssentamentoEventoProporcional $fkPessoalAssentamentoEventoProporcional
     */
    public function removeFkPessoalAssentamentoEventoProporcionais(\Urbem\CoreBundle\Entity\Pessoal\AssentamentoEventoProporcional $fkPessoalAssentamentoEventoProporcional)
    {
        $this->fkPessoalAssentamentoEventoProporcionais->removeElement($fkPessoalAssentamentoEventoProporcional);
    }

    /**
     * OneToMany (owning side)
     * Get fkPessoalAssentamentoEventoProporcionais
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\AssentamentoEventoProporcional
     */
    public function getFkPessoalAssentamentoEventoProporcionais()
    {
        return $this->fkPessoalAssentamentoEventoProporcionais;
    }

    /**
     * OneToMany (owning side)
     * Add PessoalAssentamentoEvento
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\AssentamentoEvento $fkPessoalAssentamentoEvento
     * @return Assentamento
     */
    public function addFkPessoalAssentamentoEventos(\Urbem\CoreBundle\Entity\Pessoal\AssentamentoEvento $fkPessoalAssentamentoEvento)
    {
        if (false === $this->fkPessoalAssentamentoEventos->contains($fkPessoalAssentamentoEvento)) {
            $fkPessoalAssentamentoEvento->setFkPessoalAssentamento($this);
            $this->fkPessoalAssentamentoEventos->add($fkPessoalAssentamentoEvento);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PessoalAssentamentoEvento
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\AssentamentoEvento $fkPessoalAssentamentoEvento
     */
    public function removeFkPessoalAssentamentoEventos(\Urbem\CoreBundle\Entity\Pessoal\AssentamentoEvento $fkPessoalAssentamentoEvento)
    {
        $this->fkPessoalAssentamentoEventos->removeElement($fkPessoalAssentamentoEvento);
    }

    /**
     * OneToMany (owning side)
     * Get fkPessoalAssentamentoEventos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\AssentamentoEvento
     */
    public function getFkPessoalAssentamentoEventos()
    {
        return $this->fkPessoalAssentamentoEventos;
    }

    /**
     * OneToMany (owning side)
     * Add PessoalAssentamentoSubDivisao
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\AssentamentoSubDivisao $fkPessoalAssentamentoSubDivisao
     * @return Assentamento
     */
    public function addFkPessoalAssentamentoSubDivisoes(\Urbem\CoreBundle\Entity\Pessoal\AssentamentoSubDivisao $fkPessoalAssentamentoSubDivisao)
    {
        if (false === $this->fkPessoalAssentamentoSubDivisoes->contains($fkPessoalAssentamentoSubDivisao)) {
            $fkPessoalAssentamentoSubDivisao->setFkPessoalAssentamento($this);
            $this->fkPessoalAssentamentoSubDivisoes->add($fkPessoalAssentamentoSubDivisao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PessoalAssentamentoSubDivisao
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\AssentamentoSubDivisao $fkPessoalAssentamentoSubDivisao
     */
    public function removeFkPessoalAssentamentoSubDivisoes(\Urbem\CoreBundle\Entity\Pessoal\AssentamentoSubDivisao $fkPessoalAssentamentoSubDivisao)
    {
        $this->fkPessoalAssentamentoSubDivisoes->removeElement($fkPessoalAssentamentoSubDivisao);
    }

    /**
     * OneToMany (owning side)
     * Get fkPessoalAssentamentoSubDivisoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\AssentamentoSubDivisao
     */
    public function getFkPessoalAssentamentoSubDivisoes()
    {
        return $this->fkPessoalAssentamentoSubDivisoes;
    }

    /**
     * OneToMany (owning side)
     * Add PessoalTcepeConfiguracaoRelacionaHistorico
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\TcepeConfiguracaoRelacionaHistorico $fkPessoalTcepeConfiguracaoRelacionaHistorico
     * @return Assentamento
     */
    public function addFkPessoalTcepeConfiguracaoRelacionaHistoricos(\Urbem\CoreBundle\Entity\Pessoal\TcepeConfiguracaoRelacionaHistorico $fkPessoalTcepeConfiguracaoRelacionaHistorico)
    {
        if (false === $this->fkPessoalTcepeConfiguracaoRelacionaHistoricos->contains($fkPessoalTcepeConfiguracaoRelacionaHistorico)) {
            $fkPessoalTcepeConfiguracaoRelacionaHistorico->setFkPessoalAssentamento($this);
            $this->fkPessoalTcepeConfiguracaoRelacionaHistoricos->add($fkPessoalTcepeConfiguracaoRelacionaHistorico);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PessoalTcepeConfiguracaoRelacionaHistorico
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\TcepeConfiguracaoRelacionaHistorico $fkPessoalTcepeConfiguracaoRelacionaHistorico
     */
    public function removeFkPessoalTcepeConfiguracaoRelacionaHistoricos(\Urbem\CoreBundle\Entity\Pessoal\TcepeConfiguracaoRelacionaHistorico $fkPessoalTcepeConfiguracaoRelacionaHistorico)
    {
        $this->fkPessoalTcepeConfiguracaoRelacionaHistoricos->removeElement($fkPessoalTcepeConfiguracaoRelacionaHistorico);
    }

    /**
     * OneToMany (owning side)
     * Get fkPessoalTcepeConfiguracaoRelacionaHistoricos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\TcepeConfiguracaoRelacionaHistorico
     */
    public function getFkPessoalTcepeConfiguracaoRelacionaHistoricos()
    {
        return $this->fkPessoalTcepeConfiguracaoRelacionaHistoricos;
    }

    /**
     * OneToMany (owning side)
     * Add PessoalAssentamentoCausaRescisao
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\AssentamentoCausaRescisao $fkPessoalAssentamentoCausaRescisao
     * @return Assentamento
     */
    public function addFkPessoalAssentamentoCausaRescisoes(\Urbem\CoreBundle\Entity\Pessoal\AssentamentoCausaRescisao $fkPessoalAssentamentoCausaRescisao)
    {
        if (false === $this->fkPessoalAssentamentoCausaRescisoes->contains($fkPessoalAssentamentoCausaRescisao)) {
            $fkPessoalAssentamentoCausaRescisao->setFkPessoalAssentamento($this);
            $this->fkPessoalAssentamentoCausaRescisoes->add($fkPessoalAssentamentoCausaRescisao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PessoalAssentamentoCausaRescisao
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\AssentamentoCausaRescisao $fkPessoalAssentamentoCausaRescisao
     */
    public function removeFkPessoalAssentamentoCausaRescisoes(\Urbem\CoreBundle\Entity\Pessoal\AssentamentoCausaRescisao $fkPessoalAssentamentoCausaRescisao)
    {
        $this->fkPessoalAssentamentoCausaRescisoes->removeElement($fkPessoalAssentamentoCausaRescisao);
    }

    /**
     * OneToMany (owning side)
     * Get fkPessoalAssentamentoCausaRescisoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\AssentamentoCausaRescisao
     */
    public function getFkPessoalAssentamentoCausaRescisoes()
    {
        return $this->fkPessoalAssentamentoCausaRescisoes;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkPessoalAssentamentoAssentamento
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\AssentamentoAssentamento $fkPessoalAssentamentoAssentamento
     * @return Assentamento
     */
    public function setFkPessoalAssentamentoAssentamento(\Urbem\CoreBundle\Entity\Pessoal\AssentamentoAssentamento $fkPessoalAssentamentoAssentamento)
    {
        $this->codAssentamento = $fkPessoalAssentamentoAssentamento->getCodAssentamento();
        $this->fkPessoalAssentamentoAssentamento = $fkPessoalAssentamentoAssentamento;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkPessoalAssentamentoAssentamento
     *
     * @return \Urbem\CoreBundle\Entity\Pessoal\AssentamentoAssentamento
     */
    public function getFkPessoalAssentamentoAssentamento()
    {
        return $this->fkPessoalAssentamentoAssentamento;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkPessoalEsferaOrigem
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\EsferaOrigem $fkPessoalEsferaOrigem
     * @return Assentamento
     */
    public function setFkPessoalEsferaOrigem(\Urbem\CoreBundle\Entity\Pessoal\EsferaOrigem $fkPessoalEsferaOrigem)
    {
        $this->codEsfera = $fkPessoalEsferaOrigem->getCodEsfera();
        $this->fkPessoalEsferaOrigem = $fkPessoalEsferaOrigem;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkPessoalEsferaOrigem
     *
     * @return \Urbem\CoreBundle\Entity\Pessoal\EsferaOrigem
     */
    public function getFkPessoalEsferaOrigem()
    {
        return $this->fkPessoalEsferaOrigem;
    }

    /**
     * OneToOne (inverse side)
     * Set PessoalAssentamentoAfastamentoTemporario
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\AssentamentoAfastamentoTemporario $fkPessoalAssentamentoAfastamentoTemporario
     * @return Assentamento
     */
    public function setFkPessoalAssentamentoAfastamentoTemporario(\Urbem\CoreBundle\Entity\Pessoal\AssentamentoAfastamentoTemporario $fkPessoalAssentamentoAfastamentoTemporario)
    {
        $fkPessoalAssentamentoAfastamentoTemporario->setFkPessoalAssentamento($this);
        $this->fkPessoalAssentamentoAfastamentoTemporario = $fkPessoalAssentamentoAfastamentoTemporario;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkPessoalAssentamentoAfastamentoTemporario
     *
     * @return \Urbem\CoreBundle\Entity\Pessoal\AssentamentoAfastamentoTemporario
     */
    public function getFkPessoalAssentamentoAfastamentoTemporario()
    {
        return $this->fkPessoalAssentamentoAfastamentoTemporario;
    }

    /**
     * OneToOne (inverse side)
     * Set PessoalAssentamentoVantagem
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\AssentamentoVantagem $fkPessoalAssentamentoVantagem
     * @return Assentamento
     */
    public function setFkPessoalAssentamentoVantagem(\Urbem\CoreBundle\Entity\Pessoal\AssentamentoVantagem $fkPessoalAssentamentoVantagem)
    {
        $fkPessoalAssentamentoVantagem->setFkPessoalAssentamento($this);
        $this->fkPessoalAssentamentoVantagem = $fkPessoalAssentamentoVantagem;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkPessoalAssentamentoVantagem
     *
     * @return \Urbem\CoreBundle\Entity\Pessoal\AssentamentoVantagem
     */
    public function getFkPessoalAssentamentoVantagem()
    {
        return $this->fkPessoalAssentamentoVantagem;
    }

    /**
     * OneToOne (inverse side)
     * Set PessoalAssentamentoValidade
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\AssentamentoValidade $fkPessoalAssentamentoValidade
     * @return Assentamento
     */
    public function setFkPessoalAssentamentoValidade(\Urbem\CoreBundle\Entity\Pessoal\AssentamentoValidade $fkPessoalAssentamentoValidade)
    {
        $fkPessoalAssentamentoValidade->setFkPessoalAssentamento($this);
        $this->fkPessoalAssentamentoValidade = $fkPessoalAssentamentoValidade;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkPessoalAssentamentoValidade
     *
     * @return \Urbem\CoreBundle\Entity\Pessoal\AssentamentoValidade
     */
    public function getFkPessoalAssentamentoValidade()
    {
        return $this->fkPessoalAssentamentoValidade;
    }
    
    /**
     * Ao alterar os perfis de Configuração de Assentamento é necessário clonar
     * a entidade, porque no sistema legado, toda alteração gera um novo registro
     * no banco
     */
    public function __clone()
    {
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
    }
}
