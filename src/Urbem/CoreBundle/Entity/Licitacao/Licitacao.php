<?php
 
namespace Urbem\CoreBundle\Entity\Licitacao;

/**
 * Licitacao
 */
class Licitacao
{
    /**
     * PK
     * @var integer
     */
    private $codLicitacao;

    /**
     * PK
     * @var integer
     */
    private $codModalidade;

    /**
     * PK
     * @var integer
     */
    private $codEntidade;

    /**
     * PK
     * @var string
     */
    private $exercicio;

    /**
     * @var integer
     */
    private $codTipoObjeto;

    /**
     * @var integer
     */
    private $codObjeto;

    /**
     * @var integer
     */
    private $codCriterio;

    /**
     * @var integer
     */
    private $codTipoLicitacao;

    /**
     * @var integer
     */
    private $codMapa;

    /**
     * @var string
     */
    private $exercicioMapa;

    /**
     * @var integer
     */
    private $codProcesso;

    /**
     * @var string
     */
    private $exercicioProcesso;

    /**
     * @var integer
     */
    private $vlCotado;

    /**
     * @var \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    private $timestamp;

    /**
     * @var integer
     */
    private $numOrgao;

    /**
     * @var integer
     */
    private $numUnidade;

    /**
     * @var integer
     */
    private $codRegime;

    /**
     * @var integer
     */
    private $tipoChamadaPublica = 0;

    /**
     * @var boolean
     */
    private $registroPrecos = false;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Licitacao\LicitacaoAnulada
     */
    private $fkLicitacaoLicitacaoAnulada;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Licitacao\JustificativaRazao
     */
    private $fkLicitacaoJustificativaRazao;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Tcemg\Resplic
     */
    private $fkTcemgResplic;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Tcemg\LicitacaoTc
     */
    private $fkTcemgLicitacaoTc;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Tcmgo\ResponsavelLicitacao
     */
    private $fkTcmgoResponsavelLicitacao;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Tcmgo\ResponsavelLicitacaoDispensa
     */
    private $fkTcmgoResponsavelLicitacaoDispensa;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Licitacao\ContratoLicitacao
     */
    private $fkLicitacaoContratoLicitacoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Licitacao\Participante
     */
    private $fkLicitacaoParticipantes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Licitacao\MembroAdicional
     */
    private $fkLicitacaoMembroAdicionais;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Licitacao\ParticipanteCertificacaoLicitacao
     */
    private $fkLicitacaoParticipanteCertificacaoLicitacoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Licitacao\Edital
     */
    private $fkLicitacaoEditais;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcemg\RegistroPrecosLicitacao
     */
    private $fkTcemgRegistroPrecosLicitacoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcmba\Obra
     */
    private $fkTcmbaObras;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Licitacao\ComissaoLicitacao
     */
    private $fkLicitacaoComissaoLicitacoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Licitacao\CotacaoLicitacao
     */
    private $fkLicitacaoCotacaoLicitacoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Licitacao\LicitacaoDocumentos
     */
    private $fkLicitacaoLicitacaoDocumentos;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Compras\Modalidade
     */
    private $fkComprasModalidade;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Orcamento\Entidade
     */
    private $fkOrcamentoEntidade;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Orcamento\Unidade
     */
    private $fkOrcamentoUnidade;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Compras\TipoObjeto
     */
    private $fkComprasTipoObjeto;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Compras\Objeto
     */
    private $fkComprasObjeto;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Licitacao\CriterioJulgamento
     */
    private $fkLicitacaoCriterioJulgamento;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Compras\TipoLicitacao
     */
    private $fkComprasTipoLicitacao;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Compras\Mapa
     */
    private $fkComprasMapa;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\SwProcesso
     */
    private $fkSwProcesso;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Compras\RegimeExecucaoObras
     */
    private $fkComprasRegimeExecucaoObras;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Licitacao\TipoChamadaPublica
     */
    private $fkLicitacaoTipoChamadaPublica;

    /**
     * OneToOne
     * @var \Urbem\CoreBundle\Entity\Licitacao\Adjudicacao
     */
    private $fkLicitacaoAdjudicacao;

    private $codLicitacaoExercicio;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkLicitacaoContratoLicitacoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkLicitacaoParticipantes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkLicitacaoMembroAdicionais = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkLicitacaoParticipanteCertificacaoLicitacoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkLicitacaoEditais = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTcemgRegistroPrecosLicitacoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTcmbaObras = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkLicitacaoComissaoLicitacoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkLicitacaoCotacaoLicitacoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkLicitacaoLicitacaoDocumentos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
    }

    /**
     * Set codLicitacao
     *
     * @param integer $codLicitacao
     * @return Licitacao
     */
    public function setCodLicitacao($codLicitacao)
    {
        $this->codLicitacao = $codLicitacao;
        return $this;
    }

    /**
     * Get codLicitacao
     *
     * @return integer
     */
    public function getCodLicitacao()
    {
        return $this->codLicitacao;
    }

    /**
     * Set codModalidade
     *
     * @param integer $codModalidade
     * @return Licitacao
     */
    public function setCodModalidade($codModalidade)
    {
        $this->codModalidade = $codModalidade;
        return $this;
    }

    /**
     * Get codModalidade
     *
     * @return integer
     */
    public function getCodModalidade()
    {
        return $this->codModalidade;
    }

    /**
     * Set codEntidade
     *
     * @param integer $codEntidade
     * @return Licitacao
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
     * Set exercicio
     *
     * @param string $exercicio
     * @return Licitacao
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
     * Set codTipoObjeto
     *
     * @param integer $codTipoObjeto
     * @return Licitacao
     */
    public function setCodTipoObjeto($codTipoObjeto)
    {
        $this->codTipoObjeto = $codTipoObjeto;
        return $this;
    }

    /**
     * Get codTipoObjeto
     *
     * @return integer
     */
    public function getCodTipoObjeto()
    {
        return $this->codTipoObjeto;
    }

    /**
     * Set codObjeto
     *
     * @param integer $codObjeto
     * @return Licitacao
     */
    public function setCodObjeto($codObjeto)
    {
        $this->codObjeto = $codObjeto;
        return $this;
    }

    /**
     * Get codObjeto
     *
     * @return integer
     */
    public function getCodObjeto()
    {
        return $this->codObjeto;
    }

    /**
     * Set codCriterio
     *
     * @param integer $codCriterio
     * @return Licitacao
     */
    public function setCodCriterio($codCriterio)
    {
        $this->codCriterio = $codCriterio;
        return $this;
    }

    /**
     * Get codCriterio
     *
     * @return integer
     */
    public function getCodCriterio()
    {
        return $this->codCriterio;
    }

    /**
     * Set codTipoLicitacao
     *
     * @param integer $codTipoLicitacao
     * @return Licitacao
     */
    public function setCodTipoLicitacao($codTipoLicitacao)
    {
        $this->codTipoLicitacao = $codTipoLicitacao;
        return $this;
    }

    /**
     * Get codTipoLicitacao
     *
     * @return integer
     */
    public function getCodTipoLicitacao()
    {
        return $this->codTipoLicitacao;
    }

    /**
     * Set codMapa
     *
     * @param integer $codMapa
     * @return Licitacao
     */
    public function setCodMapa($codMapa)
    {
        $this->codMapa = $codMapa;
        return $this;
    }

    /**
     * Get codMapa
     *
     * @return integer
     */
    public function getCodMapa()
    {
        return $this->codMapa;
    }

    /**
     * Set exercicioMapa
     *
     * @param string $exercicioMapa
     * @return Licitacao
     */
    public function setExercicioMapa($exercicioMapa)
    {
        $this->exercicioMapa = $exercicioMapa;
        return $this;
    }

    /**
     * Get exercicioMapa
     *
     * @return string
     */
    public function getExercicioMapa()
    {
        return $this->exercicioMapa;
    }

    /**
     * Set codProcesso
     *
     * @param integer $codProcesso
     * @return Licitacao
     */
    public function setCodProcesso($codProcesso)
    {
        $this->codProcesso = $codProcesso;
        return $this;
    }

    /**
     * Get codProcesso
     *
     * @return integer
     */
    public function getCodProcesso()
    {
        return $this->codProcesso;
    }

    /**
     * Set exercicioProcesso
     *
     * @param string $exercicioProcesso
     * @return Licitacao
     */
    public function setExercicioProcesso($exercicioProcesso)
    {
        $this->exercicioProcesso = $exercicioProcesso;
        return $this;
    }

    /**
     * Get exercicioProcesso
     *
     * @return string
     */
    public function getExercicioProcesso()
    {
        return $this->exercicioProcesso;
    }

    /**
     * Set vlCotado
     *
     * @param integer $vlCotado
     * @return Licitacao
     */
    public function setVlCotado($vlCotado)
    {
        $this->vlCotado = $vlCotado;
        return $this;
    }

    /**
     * Get vlCotado
     *
     * @return integer
     */
    public function getVlCotado()
    {
        return $this->vlCotado;
    }

    /**
     * Set timestamp
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp
     * @return Licitacao
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
     * Set numOrgao
     *
     * @param integer $numOrgao
     * @return Licitacao
     */
    public function setNumOrgao($numOrgao = null)
    {
        $this->numOrgao = $numOrgao;
        return $this;
    }

    /**
     * Get numOrgao
     *
     * @return integer
     */
    public function getNumOrgao()
    {
        return $this->numOrgao;
    }

    /**
     * Set numUnidade
     *
     * @param integer $numUnidade
     * @return Licitacao
     */
    public function setNumUnidade($numUnidade = null)
    {
        $this->numUnidade = $numUnidade;
        return $this;
    }

    /**
     * Get numUnidade
     *
     * @return integer
     */
    public function getNumUnidade()
    {
        return $this->numUnidade;
    }

    /**
     * Set codRegime
     *
     * @param integer $codRegime
     * @return Licitacao
     */
    public function setCodRegime($codRegime = null)
    {
        $this->codRegime = $codRegime;
        return $this;
    }

    /**
     * Get codRegime
     *
     * @return integer
     */
    public function getCodRegime()
    {
        return $this->codRegime;
    }

    /**
     * Set tipoChamadaPublica
     *
     * @param integer $tipoChamadaPublica
     * @return Licitacao
     */
    public function setTipoChamadaPublica($tipoChamadaPublica)
    {
        $this->tipoChamadaPublica = $tipoChamadaPublica;
        return $this;
    }

    /**
     * Get tipoChamadaPublica
     *
     * @return integer
     */
    public function getTipoChamadaPublica()
    {
        return $this->tipoChamadaPublica;
    }

    /**
     * Set registroPrecos
     *
     * @param boolean $registroPrecos
     * @return Licitacao
     */
    public function setRegistroPrecos($registroPrecos)
    {
        $this->registroPrecos = $registroPrecos;
        return $this;
    }

    /**
     * Get registroPrecos
     *
     * @return boolean
     */
    public function getRegistroPrecos()
    {
        return $this->registroPrecos;
    }

    /**
     * OneToMany (owning side)
     * Add LicitacaoContratoLicitacao
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\ContratoLicitacao $fkLicitacaoContratoLicitacao
     * @return Licitacao
     */
    public function addFkLicitacaoContratoLicitacoes(\Urbem\CoreBundle\Entity\Licitacao\ContratoLicitacao $fkLicitacaoContratoLicitacao)
    {
        if (false === $this->fkLicitacaoContratoLicitacoes->contains($fkLicitacaoContratoLicitacao)) {
            $fkLicitacaoContratoLicitacao->setFkLicitacaoLicitacao($this);
            $this->fkLicitacaoContratoLicitacoes->add($fkLicitacaoContratoLicitacao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove LicitacaoContratoLicitacao
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\ContratoLicitacao $fkLicitacaoContratoLicitacao
     */
    public function removeFkLicitacaoContratoLicitacoes(\Urbem\CoreBundle\Entity\Licitacao\ContratoLicitacao $fkLicitacaoContratoLicitacao)
    {
        $this->fkLicitacaoContratoLicitacoes->removeElement($fkLicitacaoContratoLicitacao);
    }

    /**
     * OneToMany (owning side)
     * Get fkLicitacaoContratoLicitacoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Licitacao\ContratoLicitacao
     */
    public function getFkLicitacaoContratoLicitacoes()
    {
        return $this->fkLicitacaoContratoLicitacoes;
    }

    /**
     * OneToMany (owning side)
     * Add LicitacaoParticipante
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\Participante $fkLicitacaoParticipante
     * @return Licitacao
     */
    public function addFkLicitacaoParticipantes(\Urbem\CoreBundle\Entity\Licitacao\Participante $fkLicitacaoParticipante)
    {
        if (false === $this->fkLicitacaoParticipantes->contains($fkLicitacaoParticipante)) {
            $fkLicitacaoParticipante->setFkLicitacaoLicitacao($this);
            $this->fkLicitacaoParticipantes->add($fkLicitacaoParticipante);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove LicitacaoParticipante
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\Participante $fkLicitacaoParticipante
     */
    public function removeFkLicitacaoParticipantes(\Urbem\CoreBundle\Entity\Licitacao\Participante $fkLicitacaoParticipante)
    {
        $this->fkLicitacaoParticipantes->removeElement($fkLicitacaoParticipante);
    }

    /**
     * OneToMany (owning side)
     * Get fkLicitacaoParticipantes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Licitacao\Participante
     */
    public function getFkLicitacaoParticipantes()
    {
        return $this->fkLicitacaoParticipantes;
    }

    /**
     * OneToMany (owning side)
     * Add LicitacaoMembroAdicional
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\MembroAdicional $fkLicitacaoMembroAdicional
     * @return Licitacao
     */
    public function addFkLicitacaoMembroAdicionais(\Urbem\CoreBundle\Entity\Licitacao\MembroAdicional $fkLicitacaoMembroAdicional)
    {
        if (false === $this->fkLicitacaoMembroAdicionais->contains($fkLicitacaoMembroAdicional)) {
            $fkLicitacaoMembroAdicional->setFkLicitacaoLicitacao($this);
            $this->fkLicitacaoMembroAdicionais->add($fkLicitacaoMembroAdicional);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove LicitacaoMembroAdicional
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\MembroAdicional $fkLicitacaoMembroAdicional
     */
    public function removeFkLicitacaoMembroAdicionais(\Urbem\CoreBundle\Entity\Licitacao\MembroAdicional $fkLicitacaoMembroAdicional)
    {
        $this->fkLicitacaoMembroAdicionais->removeElement($fkLicitacaoMembroAdicional);
    }

    /**
     * OneToMany (owning side)
     * Get fkLicitacaoMembroAdicionais
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Licitacao\MembroAdicional
     */
    public function getFkLicitacaoMembroAdicionais()
    {
        return $this->fkLicitacaoMembroAdicionais;
    }

    /**
     * OneToMany (owning side)
     * Add LicitacaoParticipanteCertificacaoLicitacao
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\ParticipanteCertificacaoLicitacao $fkLicitacaoParticipanteCertificacaoLicitacao
     * @return Licitacao
     */
    public function addFkLicitacaoParticipanteCertificacaoLicitacoes(\Urbem\CoreBundle\Entity\Licitacao\ParticipanteCertificacaoLicitacao $fkLicitacaoParticipanteCertificacaoLicitacao)
    {
        if (false === $this->fkLicitacaoParticipanteCertificacaoLicitacoes->contains($fkLicitacaoParticipanteCertificacaoLicitacao)) {
            $fkLicitacaoParticipanteCertificacaoLicitacao->setFkLicitacaoLicitacao($this);
            $this->fkLicitacaoParticipanteCertificacaoLicitacoes->add($fkLicitacaoParticipanteCertificacaoLicitacao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove LicitacaoParticipanteCertificacaoLicitacao
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\ParticipanteCertificacaoLicitacao $fkLicitacaoParticipanteCertificacaoLicitacao
     */
    public function removeFkLicitacaoParticipanteCertificacaoLicitacoes(\Urbem\CoreBundle\Entity\Licitacao\ParticipanteCertificacaoLicitacao $fkLicitacaoParticipanteCertificacaoLicitacao)
    {
        $this->fkLicitacaoParticipanteCertificacaoLicitacoes->removeElement($fkLicitacaoParticipanteCertificacaoLicitacao);
    }

    /**
     * OneToMany (owning side)
     * Get fkLicitacaoParticipanteCertificacaoLicitacoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Licitacao\ParticipanteCertificacaoLicitacao
     */
    public function getFkLicitacaoParticipanteCertificacaoLicitacoes()
    {
        return $this->fkLicitacaoParticipanteCertificacaoLicitacoes;
    }

    /**
     * OneToMany (owning side)
     * Add LicitacaoEdital
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\Edital $fkLicitacaoEdital
     * @return Licitacao
     */
    public function addFkLicitacaoEditais(\Urbem\CoreBundle\Entity\Licitacao\Edital $fkLicitacaoEdital)
    {
        if (false === $this->fkLicitacaoEditais->contains($fkLicitacaoEdital)) {
            $fkLicitacaoEdital->setFkLicitacaoLicitacao($this);
            $this->fkLicitacaoEditais->add($fkLicitacaoEdital);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove LicitacaoEdital
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\Edital $fkLicitacaoEdital
     */
    public function removeFkLicitacaoEditais(\Urbem\CoreBundle\Entity\Licitacao\Edital $fkLicitacaoEdital)
    {
        $this->fkLicitacaoEditais->removeElement($fkLicitacaoEdital);
    }

    /**
     * OneToMany (owning side)
     * Get fkLicitacaoEditais
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Licitacao\Edital
     */
    public function getFkLicitacaoEditais()
    {
        return $this->fkLicitacaoEditais;
    }

    /**
     * OneToMany (owning side)
     * Add TcemgRegistroPrecosLicitacao
     *
     * @param \Urbem\CoreBundle\Entity\Tcemg\RegistroPrecosLicitacao $fkTcemgRegistroPrecosLicitacao
     * @return Licitacao
     */
    public function addFkTcemgRegistroPrecosLicitacoes(\Urbem\CoreBundle\Entity\Tcemg\RegistroPrecosLicitacao $fkTcemgRegistroPrecosLicitacao)
    {
        if (false === $this->fkTcemgRegistroPrecosLicitacoes->contains($fkTcemgRegistroPrecosLicitacao)) {
            $fkTcemgRegistroPrecosLicitacao->setFkLicitacaoLicitacao($this);
            $this->fkTcemgRegistroPrecosLicitacoes->add($fkTcemgRegistroPrecosLicitacao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcemgRegistroPrecosLicitacao
     *
     * @param \Urbem\CoreBundle\Entity\Tcemg\RegistroPrecosLicitacao $fkTcemgRegistroPrecosLicitacao
     */
    public function removeFkTcemgRegistroPrecosLicitacoes(\Urbem\CoreBundle\Entity\Tcemg\RegistroPrecosLicitacao $fkTcemgRegistroPrecosLicitacao)
    {
        $this->fkTcemgRegistroPrecosLicitacoes->removeElement($fkTcemgRegistroPrecosLicitacao);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcemgRegistroPrecosLicitacoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcemg\RegistroPrecosLicitacao
     */
    public function getFkTcemgRegistroPrecosLicitacoes()
    {
        return $this->fkTcemgRegistroPrecosLicitacoes;
    }

    /**
     * OneToMany (owning side)
     * Add TcmbaObra
     *
     * @param \Urbem\CoreBundle\Entity\Tcmba\Obra $fkTcmbaObra
     * @return Licitacao
     */
    public function addFkTcmbaObras(\Urbem\CoreBundle\Entity\Tcmba\Obra $fkTcmbaObra)
    {
        if (false === $this->fkTcmbaObras->contains($fkTcmbaObra)) {
            $fkTcmbaObra->setFkLicitacaoLicitacao($this);
            $this->fkTcmbaObras->add($fkTcmbaObra);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcmbaObra
     *
     * @param \Urbem\CoreBundle\Entity\Tcmba\Obra $fkTcmbaObra
     */
    public function removeFkTcmbaObras(\Urbem\CoreBundle\Entity\Tcmba\Obra $fkTcmbaObra)
    {
        $this->fkTcmbaObras->removeElement($fkTcmbaObra);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcmbaObras
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcmba\Obra
     */
    public function getFkTcmbaObras()
    {
        return $this->fkTcmbaObras;
    }

    /**
     * OneToMany (owning side)
     * Add LicitacaoComissaoLicitacao
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\ComissaoLicitacao $fkLicitacaoComissaoLicitacao
     * @return Licitacao
     */
    public function addFkLicitacaoComissaoLicitacoes(\Urbem\CoreBundle\Entity\Licitacao\ComissaoLicitacao $fkLicitacaoComissaoLicitacao)
    {
        if (false === $this->fkLicitacaoComissaoLicitacoes->contains($fkLicitacaoComissaoLicitacao)) {
            $fkLicitacaoComissaoLicitacao->setFkLicitacaoLicitacao($this);
            $this->fkLicitacaoComissaoLicitacoes->add($fkLicitacaoComissaoLicitacao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove LicitacaoComissaoLicitacao
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\ComissaoLicitacao $fkLicitacaoComissaoLicitacao
     */
    public function removeFkLicitacaoComissaoLicitacoes(\Urbem\CoreBundle\Entity\Licitacao\ComissaoLicitacao $fkLicitacaoComissaoLicitacao)
    {
        $this->fkLicitacaoComissaoLicitacoes->removeElement($fkLicitacaoComissaoLicitacao);
    }

    /**
     * OneToMany (owning side)
     * Get fkLicitacaoComissaoLicitacoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Licitacao\ComissaoLicitacao
     */
    public function getFkLicitacaoComissaoLicitacoes()
    {
        return $this->fkLicitacaoComissaoLicitacoes;
    }

    /**
     * OneToMany (owning side)
     * Add LicitacaoCotacaoLicitacao
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\CotacaoLicitacao $fkLicitacaoCotacaoLicitacao
     * @return Licitacao
     */
    public function addFkLicitacaoCotacaoLicitacoes(\Urbem\CoreBundle\Entity\Licitacao\CotacaoLicitacao $fkLicitacaoCotacaoLicitacao)
    {
        if (false === $this->fkLicitacaoCotacaoLicitacoes->contains($fkLicitacaoCotacaoLicitacao)) {
            $fkLicitacaoCotacaoLicitacao->setFkLicitacaoLicitacao($this);
            $this->fkLicitacaoCotacaoLicitacoes->add($fkLicitacaoCotacaoLicitacao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove LicitacaoCotacaoLicitacao
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\CotacaoLicitacao $fkLicitacaoCotacaoLicitacao
     */
    public function removeFkLicitacaoCotacaoLicitacoes(\Urbem\CoreBundle\Entity\Licitacao\CotacaoLicitacao $fkLicitacaoCotacaoLicitacao)
    {
        $this->fkLicitacaoCotacaoLicitacoes->removeElement($fkLicitacaoCotacaoLicitacao);
    }

    /**
     * OneToMany (owning side)
     * Get fkLicitacaoCotacaoLicitacoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Licitacao\CotacaoLicitacao
     */
    public function getFkLicitacaoCotacaoLicitacoes()
    {
        return $this->fkLicitacaoCotacaoLicitacoes;
    }

    /**
     * OneToMany (owning side)
     * Add LicitacaoLicitacaoDocumentos
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\LicitacaoDocumentos $fkLicitacaoLicitacaoDocumentos
     * @return Licitacao
     */
    public function addFkLicitacaoLicitacaoDocumentos(\Urbem\CoreBundle\Entity\Licitacao\LicitacaoDocumentos $fkLicitacaoLicitacaoDocumentos)
    {
        if (false === $this->fkLicitacaoLicitacaoDocumentos->contains($fkLicitacaoLicitacaoDocumentos)) {
            $fkLicitacaoLicitacaoDocumentos->setFkLicitacaoLicitacao($this);
            $this->fkLicitacaoLicitacaoDocumentos->add($fkLicitacaoLicitacaoDocumentos);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove LicitacaoLicitacaoDocumentos
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\LicitacaoDocumentos $fkLicitacaoLicitacaoDocumentos
     */
    public function removeFkLicitacaoLicitacaoDocumentos(\Urbem\CoreBundle\Entity\Licitacao\LicitacaoDocumentos $fkLicitacaoLicitacaoDocumentos)
    {
        $this->fkLicitacaoLicitacaoDocumentos->removeElement($fkLicitacaoLicitacaoDocumentos);
    }

    /**
     * @param \Doctrine\Common\Collections\Collection|LicitacaoDocumentos $fkLicitacaoLicitacaoDocumentos
     *
     * @return Licitacao
     */
    public function setFkLicitacaoLicitacaoDocumentos($fkLicitacaoLicitacaoDocumentos)
    {
        if ($fkLicitacaoLicitacaoDocumentos instanceof LicitacaoDocumentos) {
            return $this->addFkLicitacaoLicitacaoDocumentos($fkLicitacaoLicitacaoDocumentos);
        }

        $this->fkLicitacaoLicitacaoDocumentos = $fkLicitacaoLicitacaoDocumentos;

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Get fkLicitacaoLicitacaoDocumentos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Licitacao\LicitacaoDocumentos
     */
    public function getFkLicitacaoLicitacaoDocumentos()
    {
        return $this->fkLicitacaoLicitacaoDocumentos;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkComprasModalidade
     *
     * @param \Urbem\CoreBundle\Entity\Compras\Modalidade $fkComprasModalidade
     * @return Licitacao
     */
    public function setFkComprasModalidade(\Urbem\CoreBundle\Entity\Compras\Modalidade $fkComprasModalidade)
    {
        $this->codModalidade = $fkComprasModalidade->getCodModalidade();
        $this->fkComprasModalidade = $fkComprasModalidade;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkComprasModalidade
     *
     * @return \Urbem\CoreBundle\Entity\Compras\Modalidade
     */
    public function getFkComprasModalidade()
    {
        return $this->fkComprasModalidade;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkOrcamentoEntidade
     *
     * @param \Urbem\CoreBundle\Entity\Orcamento\Entidade $fkOrcamentoEntidade
     * @return Licitacao
     */
    public function setFkOrcamentoEntidade(\Urbem\CoreBundle\Entity\Orcamento\Entidade $fkOrcamentoEntidade)
    {
        $this->exercicio = $fkOrcamentoEntidade->getExercicio();
        $this->codEntidade = $fkOrcamentoEntidade->getCodEntidade();
        $this->fkOrcamentoEntidade = $fkOrcamentoEntidade;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkOrcamentoEntidade
     *
     * @return \Urbem\CoreBundle\Entity\Orcamento\Entidade
     */
    public function getFkOrcamentoEntidade()
    {
        return $this->fkOrcamentoEntidade;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkOrcamentoUnidade
     *
     * @param \Urbem\CoreBundle\Entity\Orcamento\Unidade $fkOrcamentoUnidade
     * @return Licitacao
     */
    public function setFkOrcamentoUnidade(\Urbem\CoreBundle\Entity\Orcamento\Unidade $fkOrcamentoUnidade)
    {
        $this->exercicio = $fkOrcamentoUnidade->getExercicio();
        $this->numUnidade = $fkOrcamentoUnidade->getNumUnidade();
        $this->numOrgao = $fkOrcamentoUnidade->getNumOrgao();
        $this->fkOrcamentoUnidade = $fkOrcamentoUnidade;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkOrcamentoUnidade
     *
     * @return \Urbem\CoreBundle\Entity\Orcamento\Unidade
     */
    public function getFkOrcamentoUnidade()
    {
        return $this->fkOrcamentoUnidade;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkComprasTipoObjeto
     *
     * @param \Urbem\CoreBundle\Entity\Compras\TipoObjeto $fkComprasTipoObjeto
     * @return Licitacao
     */
    public function setFkComprasTipoObjeto(\Urbem\CoreBundle\Entity\Compras\TipoObjeto $fkComprasTipoObjeto)
    {
        $this->codTipoObjeto = $fkComprasTipoObjeto->getCodTipoObjeto();
        $this->fkComprasTipoObjeto = $fkComprasTipoObjeto;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkComprasTipoObjeto
     *
     * @return \Urbem\CoreBundle\Entity\Compras\TipoObjeto
     */
    public function getFkComprasTipoObjeto()
    {
        return $this->fkComprasTipoObjeto;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkComprasObjeto
     *
     * @param \Urbem\CoreBundle\Entity\Compras\Objeto $fkComprasObjeto
     * @return Licitacao
     */
    public function setFkComprasObjeto(\Urbem\CoreBundle\Entity\Compras\Objeto $fkComprasObjeto)
    {
        $this->codObjeto = $fkComprasObjeto->getCodObjeto();
        $this->fkComprasObjeto = $fkComprasObjeto;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkComprasObjeto
     *
     * @return \Urbem\CoreBundle\Entity\Compras\Objeto
     */
    public function getFkComprasObjeto()
    {
        return $this->fkComprasObjeto;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkLicitacaoCriterioJulgamento
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\CriterioJulgamento $fkLicitacaoCriterioJulgamento
     * @return Licitacao
     */
    public function setFkLicitacaoCriterioJulgamento(\Urbem\CoreBundle\Entity\Licitacao\CriterioJulgamento $fkLicitacaoCriterioJulgamento)
    {
        $this->codCriterio = $fkLicitacaoCriterioJulgamento->getCodCriterio();
        $this->fkLicitacaoCriterioJulgamento = $fkLicitacaoCriterioJulgamento;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkLicitacaoCriterioJulgamento
     *
     * @return \Urbem\CoreBundle\Entity\Licitacao\CriterioJulgamento
     */
    public function getFkLicitacaoCriterioJulgamento()
    {
        return $this->fkLicitacaoCriterioJulgamento;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkComprasTipoLicitacao
     *
     * @param \Urbem\CoreBundle\Entity\Compras\TipoLicitacao $fkComprasTipoLicitacao
     * @return Licitacao
     */
    public function setFkComprasTipoLicitacao(\Urbem\CoreBundle\Entity\Compras\TipoLicitacao $fkComprasTipoLicitacao)
    {
        $this->codTipoLicitacao = $fkComprasTipoLicitacao->getCodTipoLicitacao();
        $this->fkComprasTipoLicitacao = $fkComprasTipoLicitacao;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkComprasTipoLicitacao
     *
     * @return \Urbem\CoreBundle\Entity\Compras\TipoLicitacao
     */
    public function getFkComprasTipoLicitacao()
    {
        return $this->fkComprasTipoLicitacao;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkComprasMapa
     *
     * @param \Urbem\CoreBundle\Entity\Compras\Mapa $fkComprasMapa
     * @return Licitacao
     */
    public function setFkComprasMapa(\Urbem\CoreBundle\Entity\Compras\Mapa $fkComprasMapa)
    {
        $this->exercicioMapa = $fkComprasMapa->getExercicio();
        $this->codMapa = $fkComprasMapa->getCodMapa();
        $this->fkComprasMapa = $fkComprasMapa;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkComprasMapa
     *
     * @return \Urbem\CoreBundle\Entity\Compras\Mapa
     */
    public function getFkComprasMapa()
    {
        return $this->fkComprasMapa;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkSwProcesso
     *
     * @param \Urbem\CoreBundle\Entity\SwProcesso $fkSwProcesso
     * @return Licitacao
     */
    public function setFkSwProcesso(\Urbem\CoreBundle\Entity\SwProcesso $fkSwProcesso)
    {
        $this->codProcesso = $fkSwProcesso->getCodProcesso();
        $this->exercicioProcesso = $fkSwProcesso->getAnoExercicio();
        $this->fkSwProcesso = $fkSwProcesso;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkSwProcesso
     *
     * @return \Urbem\CoreBundle\Entity\SwProcesso
     */
    public function getFkSwProcesso()
    {
        return $this->fkSwProcesso;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkComprasRegimeExecucaoObras
     *
     * @param \Urbem\CoreBundle\Entity\Compras\RegimeExecucaoObras $fkComprasRegimeExecucaoObras
     * @return Licitacao
     */
    public function setFkComprasRegimeExecucaoObras(\Urbem\CoreBundle\Entity\Compras\RegimeExecucaoObras $fkComprasRegimeExecucaoObras)
    {
        $this->codRegime = $fkComprasRegimeExecucaoObras->getCodRegime();
        $this->fkComprasRegimeExecucaoObras = $fkComprasRegimeExecucaoObras;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkComprasRegimeExecucaoObras
     *
     * @return \Urbem\CoreBundle\Entity\Compras\RegimeExecucaoObras
     */
    public function getFkComprasRegimeExecucaoObras()
    {
        return $this->fkComprasRegimeExecucaoObras;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkLicitacaoTipoChamadaPublica
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\TipoChamadaPublica $fkLicitacaoTipoChamadaPublica
     * @return Licitacao
     */
    public function setFkLicitacaoTipoChamadaPublica(\Urbem\CoreBundle\Entity\Licitacao\TipoChamadaPublica $fkLicitacaoTipoChamadaPublica)
    {
        $this->tipoChamadaPublica = $fkLicitacaoTipoChamadaPublica->getCodTipo();
        $this->fkLicitacaoTipoChamadaPublica = $fkLicitacaoTipoChamadaPublica;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkLicitacaoTipoChamadaPublica
     *
     * @return \Urbem\CoreBundle\Entity\Licitacao\TipoChamadaPublica
     */
    public function getFkLicitacaoTipoChamadaPublica()
    {
        return $this->fkLicitacaoTipoChamadaPublica;
    }

    /**
     * OneToOne (inverse side)
     * Set LicitacaoLicitacaoAnulada
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\LicitacaoAnulada $fkLicitacaoLicitacaoAnulada
     * @return Licitacao
     */
    public function setFkLicitacaoLicitacaoAnulada(\Urbem\CoreBundle\Entity\Licitacao\LicitacaoAnulada $fkLicitacaoLicitacaoAnulada)
    {
        $fkLicitacaoLicitacaoAnulada->setFkLicitacaoLicitacao($this);
        $this->fkLicitacaoLicitacaoAnulada = $fkLicitacaoLicitacaoAnulada;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkLicitacaoLicitacaoAnulada
     *
     * @return \Urbem\CoreBundle\Entity\Licitacao\LicitacaoAnulada
     */
    public function getFkLicitacaoLicitacaoAnulada()
    {
        return $this->fkLicitacaoLicitacaoAnulada;
    }

    /**
     * OneToOne (inverse side)
     * Set LicitacaoJustificativaRazao
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\JustificativaRazao $fkLicitacaoJustificativaRazao
     * @return Licitacao
     */
    public function setFkLicitacaoJustificativaRazao(\Urbem\CoreBundle\Entity\Licitacao\JustificativaRazao $fkLicitacaoJustificativaRazao)
    {
        $fkLicitacaoJustificativaRazao->setFkLicitacaoLicitacao($this);
        $this->fkLicitacaoJustificativaRazao = $fkLicitacaoJustificativaRazao;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkLicitacaoJustificativaRazao
     *
     * @return \Urbem\CoreBundle\Entity\Licitacao\JustificativaRazao
     */
    public function getFkLicitacaoJustificativaRazao()
    {
        return $this->fkLicitacaoJustificativaRazao;
    }

    /**
     * OneToOne (inverse side)
     * Set TcemgResplic
     *
     * @param \Urbem\CoreBundle\Entity\Tcemg\Resplic $fkTcemgResplic
     * @return Licitacao
     */
    public function setFkTcemgResplic(\Urbem\CoreBundle\Entity\Tcemg\Resplic $fkTcemgResplic)
    {
        $fkTcemgResplic->setFkLicitacaoLicitacao($this);
        $this->fkTcemgResplic = $fkTcemgResplic;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkTcemgResplic
     *
     * @return \Urbem\CoreBundle\Entity\Tcemg\Resplic
     */
    public function getFkTcemgResplic()
    {
        return $this->fkTcemgResplic;
    }

    /**
     * OneToOne (inverse side)
     * Set TcemgLicitacaoTc
     *
     * @param \Urbem\CoreBundle\Entity\Tcemg\LicitacaoTc $fkTcemgLicitacaoTc
     * @return Licitacao
     */
    public function setFkTcemgLicitacaoTc(\Urbem\CoreBundle\Entity\Tcemg\LicitacaoTc $fkTcemgLicitacaoTc)
    {
        $fkTcemgLicitacaoTc->setFkLicitacaoLicitacao($this);
        $this->fkTcemgLicitacaoTc = $fkTcemgLicitacaoTc;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkTcemgLicitacaoTc
     *
     * @return \Urbem\CoreBundle\Entity\Tcemg\LicitacaoTc
     */
    public function getFkTcemgLicitacaoTc()
    {
        return $this->fkTcemgLicitacaoTc;
    }

    /**
     * OneToOne (inverse side)
     * Set TcmgoResponsavelLicitacao
     *
     * @param \Urbem\CoreBundle\Entity\Tcmgo\ResponsavelLicitacao $fkTcmgoResponsavelLicitacao
     * @return Licitacao
     */
    public function setFkTcmgoResponsavelLicitacao(\Urbem\CoreBundle\Entity\Tcmgo\ResponsavelLicitacao $fkTcmgoResponsavelLicitacao)
    {
        $fkTcmgoResponsavelLicitacao->setFkLicitacaoLicitacao($this);
        $this->fkTcmgoResponsavelLicitacao = $fkTcmgoResponsavelLicitacao;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkTcmgoResponsavelLicitacao
     *
     * @return \Urbem\CoreBundle\Entity\Tcmgo\ResponsavelLicitacao
     */
    public function getFkTcmgoResponsavelLicitacao()
    {
        return $this->fkTcmgoResponsavelLicitacao;
    }

    /**
     * OneToOne (inverse side)
     * Set TcmgoResponsavelLicitacaoDispensa
     *
     * @param \Urbem\CoreBundle\Entity\Tcmgo\ResponsavelLicitacaoDispensa $fkTcmgoResponsavelLicitacaoDispensa
     * @return Licitacao
     */
    public function setFkTcmgoResponsavelLicitacaoDispensa(\Urbem\CoreBundle\Entity\Tcmgo\ResponsavelLicitacaoDispensa $fkTcmgoResponsavelLicitacaoDispensa)
    {
        $fkTcmgoResponsavelLicitacaoDispensa->setFkLicitacaoLicitacao($this);
        $this->fkTcmgoResponsavelLicitacaoDispensa = $fkTcmgoResponsavelLicitacaoDispensa;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkTcmgoResponsavelLicitacaoDispensa
     *
     * @return \Urbem\CoreBundle\Entity\Tcmgo\ResponsavelLicitacaoDispensa
     */
    public function getFkTcmgoResponsavelLicitacaoDispensa()
    {
        return $this->fkTcmgoResponsavelLicitacaoDispensa;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return sprintf('%s/%s', $this->codLicitacao, $this->exercicio);
    }

    /**
     * @return Adjudicacao
     */
    public function getFkLicitacaoAdjudicacao()
    {
        return $this->fkLicitacaoAdjudicacao;
    }

    /**
     * @param Adjudicacao $fkLicitacaoAdjudicacao
     */
    public function setFkLicitacaoAdjudicacao($fkLicitacaoAdjudicacao)
    {
        $this->fkLicitacaoAdjudicacao = $fkLicitacaoAdjudicacao;
    }

    /**
     * @return string
     */
    public function getCodLicitacaoExercicio()
    {
        return $this->codLicitacao.'/'.$this->exercicio;
    }
}
