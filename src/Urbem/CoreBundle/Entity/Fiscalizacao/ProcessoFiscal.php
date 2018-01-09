<?php
 
namespace Urbem\CoreBundle\Entity\Fiscalizacao;

/**
 * ProcessoFiscal
 */
class ProcessoFiscal
{
    /**
     * PK
     * @var integer
     */
    private $codProcesso;

    /**
     * @var integer
     */
    private $codProcessoProtocolo;

    /**
     * @var string
     */
    private $anoExercicio;

    /**
     * @var integer
     */
    private $numcgm;

    /**
     * @var integer
     */
    private $codTipo;

    /**
     * @var integer
     */
    private $codNatureza;

    /**
     * @var \DateTime
     */
    private $periodoInicio;

    /**
     * @var \DateTime
     */
    private $periodoTermino;

    /**
     * @var \DateTime
     */
    private $previsaoInicio;

    /**
     * @var \DateTime
     */
    private $previsaoTermino;

    /**
     * @var string
     */
    private $observacao;

    /**
     * @var \DateTime
     */
    private $timestamp;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Fiscalizacao\InicioFiscalizacao
     */
    private $fkFiscalizacaoInicioFiscalizacao;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Fiscalizacao\ProcessoFiscalCancelado
     */
    private $fkFiscalizacaoProcessoFiscalCancelado;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Fiscalizacao\ProcessoFiscalEmpresa
     */
    private $fkFiscalizacaoProcessoFiscalEmpresa;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Fiscalizacao\TerminoFiscalizacao
     */
    private $fkFiscalizacaoTerminoFiscalizacao;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Fiscalizacao\ProcessoFiscalObras
     */
    private $fkFiscalizacaoProcessoFiscalObras;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Fiscalizacao\NotificacaoFiscalizacao
     */
    private $fkFiscalizacaoNotificacaoFiscalizacao;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Fiscalizacao\AutoFiscalizacao
     */
    private $fkFiscalizacaoAutoFiscalizacoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Fiscalizacao\NotificacaoTermo
     */
    private $fkFiscalizacaoNotificacaoTermos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Fiscalizacao\ProcessoFiscalCredito
     */
    private $fkFiscalizacaoProcessoFiscalCreditos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Fiscalizacao\ProcessoFiscalGrupo
     */
    private $fkFiscalizacaoProcessoFiscalGrupos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Fiscalizacao\FiscalProcessoFiscal
     */
    private $fkFiscalizacaoFiscalProcessoFiscais;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\SwProcesso
     */
    private $fkSwProcesso;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Administracao\Usuario
     */
    private $fkAdministracaoUsuario;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Fiscalizacao\TipoFiscalizacao
     */
    private $fkFiscalizacaoTipoFiscalizacao;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Fiscalizacao\NaturezaFiscalizacao
     */
    private $fkFiscalizacaoNaturezaFiscalizacao;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkFiscalizacaoAutoFiscalizacoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkFiscalizacaoNotificacaoTermos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkFiscalizacaoProcessoFiscalCreditos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkFiscalizacaoProcessoFiscalGrupos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkFiscalizacaoFiscalProcessoFiscais = new \Doctrine\Common\Collections\ArrayCollection();
        $this->timestamp = new \DateTime;
    }

    /**
     * Set codProcesso
     *
     * @param integer $codProcesso
     * @return ProcessoFiscal
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
     * Set codProcessoProtocolo
     *
     * @param integer $codProcessoProtocolo
     * @return ProcessoFiscal
     */
    public function setCodProcessoProtocolo($codProcessoProtocolo = null)
    {
        $this->codProcessoProtocolo = $codProcessoProtocolo;
        return $this;
    }

    /**
     * Get codProcessoProtocolo
     *
     * @return integer
     */
    public function getCodProcessoProtocolo()
    {
        return $this->codProcessoProtocolo;
    }

    /**
     * Set anoExercicio
     *
     * @param string $anoExercicio
     * @return ProcessoFiscal
     */
    public function setAnoExercicio($anoExercicio = null)
    {
        $this->anoExercicio = $anoExercicio;
        return $this;
    }

    /**
     * Get anoExercicio
     *
     * @return string
     */
    public function getAnoExercicio()
    {
        return $this->anoExercicio;
    }

    /**
     * Set numcgm
     *
     * @param integer $numcgm
     * @return ProcessoFiscal
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
     * Set codTipo
     *
     * @param integer $codTipo
     * @return ProcessoFiscal
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
     * Set codNatureza
     *
     * @param integer $codNatureza
     * @return ProcessoFiscal
     */
    public function setCodNatureza($codNatureza)
    {
        $this->codNatureza = $codNatureza;
        return $this;
    }

    /**
     * Get codNatureza
     *
     * @return integer
     */
    public function getCodNatureza()
    {
        return $this->codNatureza;
    }

    /**
     * Set periodoInicio
     *
     * @param \DateTime $periodoInicio
     * @return ProcessoFiscal
     */
    public function setPeriodoInicio(\DateTime $periodoInicio)
    {
        $this->periodoInicio = $periodoInicio;
        return $this;
    }

    /**
     * Get periodoInicio
     *
     * @return \DateTime
     */
    public function getPeriodoInicio()
    {
        return $this->periodoInicio;
    }

    /**
     * Set periodoTermino
     *
     * @param \DateTime $periodoTermino
     * @return ProcessoFiscal
     */
    public function setPeriodoTermino(\DateTime $periodoTermino)
    {
        $this->periodoTermino = $periodoTermino;
        return $this;
    }

    /**
     * Get periodoTermino
     *
     * @return \DateTime
     */
    public function getPeriodoTermino()
    {
        return $this->periodoTermino;
    }

    /**
     * Set previsaoInicio
     *
     * @param \DateTime $previsaoInicio
     * @return ProcessoFiscal
     */
    public function setPrevisaoInicio(\DateTime $previsaoInicio)
    {
        $this->previsaoInicio = $previsaoInicio;
        return $this;
    }

    /**
     * Get previsaoInicio
     *
     * @return \DateTime
     */
    public function getPrevisaoInicio()
    {
        return $this->previsaoInicio;
    }

    /**
     * Set previsaoTermino
     *
     * @param \DateTime $previsaoTermino
     * @return ProcessoFiscal
     */
    public function setPrevisaoTermino(\DateTime $previsaoTermino)
    {
        $this->previsaoTermino = $previsaoTermino;
        return $this;
    }

    /**
     * Get previsaoTermino
     *
     * @return \DateTime
     */
    public function getPrevisaoTermino()
    {
        return $this->previsaoTermino;
    }

    /**
     * Set observacao
     *
     * @param string $observacao
     * @return ProcessoFiscal
     */
    public function setObservacao($observacao)
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
     * @return ProcessoFiscal
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
     * Add FiscalizacaoAutoFiscalizacao
     *
     * @param \Urbem\CoreBundle\Entity\Fiscalizacao\AutoFiscalizacao $fkFiscalizacaoAutoFiscalizacao
     * @return ProcessoFiscal
     */
    public function addFkFiscalizacaoAutoFiscalizacoes(\Urbem\CoreBundle\Entity\Fiscalizacao\AutoFiscalizacao $fkFiscalizacaoAutoFiscalizacao)
    {
        if (false === $this->fkFiscalizacaoAutoFiscalizacoes->contains($fkFiscalizacaoAutoFiscalizacao)) {
            $fkFiscalizacaoAutoFiscalizacao->setFkFiscalizacaoProcessoFiscal($this);
            $this->fkFiscalizacaoAutoFiscalizacoes->add($fkFiscalizacaoAutoFiscalizacao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FiscalizacaoAutoFiscalizacao
     *
     * @param \Urbem\CoreBundle\Entity\Fiscalizacao\AutoFiscalizacao $fkFiscalizacaoAutoFiscalizacao
     */
    public function removeFkFiscalizacaoAutoFiscalizacoes(\Urbem\CoreBundle\Entity\Fiscalizacao\AutoFiscalizacao $fkFiscalizacaoAutoFiscalizacao)
    {
        $this->fkFiscalizacaoAutoFiscalizacoes->removeElement($fkFiscalizacaoAutoFiscalizacao);
    }

    /**
     * OneToMany (owning side)
     * Get fkFiscalizacaoAutoFiscalizacoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Fiscalizacao\AutoFiscalizacao
     */
    public function getFkFiscalizacaoAutoFiscalizacoes()
    {
        return $this->fkFiscalizacaoAutoFiscalizacoes;
    }

    /**
     * OneToMany (owning side)
     * Add FiscalizacaoNotificacaoTermo
     *
     * @param \Urbem\CoreBundle\Entity\Fiscalizacao\NotificacaoTermo $fkFiscalizacaoNotificacaoTermo
     * @return ProcessoFiscal
     */
    public function addFkFiscalizacaoNotificacaoTermos(\Urbem\CoreBundle\Entity\Fiscalizacao\NotificacaoTermo $fkFiscalizacaoNotificacaoTermo)
    {
        if (false === $this->fkFiscalizacaoNotificacaoTermos->contains($fkFiscalizacaoNotificacaoTermo)) {
            $fkFiscalizacaoNotificacaoTermo->setFkFiscalizacaoProcessoFiscal($this);
            $this->fkFiscalizacaoNotificacaoTermos->add($fkFiscalizacaoNotificacaoTermo);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FiscalizacaoNotificacaoTermo
     *
     * @param \Urbem\CoreBundle\Entity\Fiscalizacao\NotificacaoTermo $fkFiscalizacaoNotificacaoTermo
     */
    public function removeFkFiscalizacaoNotificacaoTermos(\Urbem\CoreBundle\Entity\Fiscalizacao\NotificacaoTermo $fkFiscalizacaoNotificacaoTermo)
    {
        $this->fkFiscalizacaoNotificacaoTermos->removeElement($fkFiscalizacaoNotificacaoTermo);
    }

    /**
     * OneToMany (owning side)
     * Get fkFiscalizacaoNotificacaoTermos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Fiscalizacao\NotificacaoTermo
     */
    public function getFkFiscalizacaoNotificacaoTermos()
    {
        return $this->fkFiscalizacaoNotificacaoTermos;
    }

    /**
     * OneToMany (owning side)
     * Add FiscalizacaoProcessoFiscalCredito
     *
     * @param \Urbem\CoreBundle\Entity\Fiscalizacao\ProcessoFiscalCredito $fkFiscalizacaoProcessoFiscalCredito
     * @return ProcessoFiscal
     */
    public function addFkFiscalizacaoProcessoFiscalCreditos(\Urbem\CoreBundle\Entity\Fiscalizacao\ProcessoFiscalCredito $fkFiscalizacaoProcessoFiscalCredito)
    {
        if (false === $this->fkFiscalizacaoProcessoFiscalCreditos->contains($fkFiscalizacaoProcessoFiscalCredito)) {
            $fkFiscalizacaoProcessoFiscalCredito->setFkFiscalizacaoProcessoFiscal($this);
            $this->fkFiscalizacaoProcessoFiscalCreditos->add($fkFiscalizacaoProcessoFiscalCredito);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FiscalizacaoProcessoFiscalCredito
     *
     * @param \Urbem\CoreBundle\Entity\Fiscalizacao\ProcessoFiscalCredito $fkFiscalizacaoProcessoFiscalCredito
     */
    public function removeFkFiscalizacaoProcessoFiscalCreditos(\Urbem\CoreBundle\Entity\Fiscalizacao\ProcessoFiscalCredito $fkFiscalizacaoProcessoFiscalCredito)
    {
        $this->fkFiscalizacaoProcessoFiscalCreditos->removeElement($fkFiscalizacaoProcessoFiscalCredito);
    }

    /**
     * OneToMany (owning side)
     * Get fkFiscalizacaoProcessoFiscalCreditos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Fiscalizacao\ProcessoFiscalCredito
     */
    public function getFkFiscalizacaoProcessoFiscalCreditos()
    {
        return $this->fkFiscalizacaoProcessoFiscalCreditos;
    }

    /**
     * OneToMany (owning side)
     * Add FiscalizacaoProcessoFiscalGrupo
     *
     * @param \Urbem\CoreBundle\Entity\Fiscalizacao\ProcessoFiscalGrupo $fkFiscalizacaoProcessoFiscalGrupo
     * @return ProcessoFiscal
     */
    public function addFkFiscalizacaoProcessoFiscalGrupos(\Urbem\CoreBundle\Entity\Fiscalizacao\ProcessoFiscalGrupo $fkFiscalizacaoProcessoFiscalGrupo)
    {
        if (false === $this->fkFiscalizacaoProcessoFiscalGrupos->contains($fkFiscalizacaoProcessoFiscalGrupo)) {
            $fkFiscalizacaoProcessoFiscalGrupo->setFkFiscalizacaoProcessoFiscal($this);
            $this->fkFiscalizacaoProcessoFiscalGrupos->add($fkFiscalizacaoProcessoFiscalGrupo);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FiscalizacaoProcessoFiscalGrupo
     *
     * @param \Urbem\CoreBundle\Entity\Fiscalizacao\ProcessoFiscalGrupo $fkFiscalizacaoProcessoFiscalGrupo
     */
    public function removeFkFiscalizacaoProcessoFiscalGrupos(\Urbem\CoreBundle\Entity\Fiscalizacao\ProcessoFiscalGrupo $fkFiscalizacaoProcessoFiscalGrupo)
    {
        $this->fkFiscalizacaoProcessoFiscalGrupos->removeElement($fkFiscalizacaoProcessoFiscalGrupo);
    }

    /**
     * OneToMany (owning side)
     * Get fkFiscalizacaoProcessoFiscalGrupos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Fiscalizacao\ProcessoFiscalGrupo
     */
    public function getFkFiscalizacaoProcessoFiscalGrupos()
    {
        return $this->fkFiscalizacaoProcessoFiscalGrupos;
    }

    /**
     * OneToMany (owning side)
     * Add FiscalizacaoFiscalProcessoFiscal
     *
     * @param \Urbem\CoreBundle\Entity\Fiscalizacao\FiscalProcessoFiscal $fkFiscalizacaoFiscalProcessoFiscal
     * @return ProcessoFiscal
     */
    public function addFkFiscalizacaoFiscalProcessoFiscais(\Urbem\CoreBundle\Entity\Fiscalizacao\FiscalProcessoFiscal $fkFiscalizacaoFiscalProcessoFiscal)
    {
        if (false === $this->fkFiscalizacaoFiscalProcessoFiscais->contains($fkFiscalizacaoFiscalProcessoFiscal)) {
            $fkFiscalizacaoFiscalProcessoFiscal->setFkFiscalizacaoProcessoFiscal($this);
            $this->fkFiscalizacaoFiscalProcessoFiscais->add($fkFiscalizacaoFiscalProcessoFiscal);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FiscalizacaoFiscalProcessoFiscal
     *
     * @param \Urbem\CoreBundle\Entity\Fiscalizacao\FiscalProcessoFiscal $fkFiscalizacaoFiscalProcessoFiscal
     */
    public function removeFkFiscalizacaoFiscalProcessoFiscais(\Urbem\CoreBundle\Entity\Fiscalizacao\FiscalProcessoFiscal $fkFiscalizacaoFiscalProcessoFiscal)
    {
        $this->fkFiscalizacaoFiscalProcessoFiscais->removeElement($fkFiscalizacaoFiscalProcessoFiscal);
    }

    /**
     * OneToMany (owning side)
     * Get fkFiscalizacaoFiscalProcessoFiscais
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Fiscalizacao\FiscalProcessoFiscal
     */
    public function getFkFiscalizacaoFiscalProcessoFiscais()
    {
        return $this->fkFiscalizacaoFiscalProcessoFiscais;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkSwProcesso
     *
     * @param \Urbem\CoreBundle\Entity\SwProcesso $fkSwProcesso
     * @return ProcessoFiscal
     */
    public function setFkSwProcesso(\Urbem\CoreBundle\Entity\SwProcesso $fkSwProcesso)
    {
        $this->codProcessoProtocolo = $fkSwProcesso->getCodProcesso();
        $this->anoExercicio = $fkSwProcesso->getAnoExercicio();
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
     * Set fkAdministracaoUsuario
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\Usuario $fkAdministracaoUsuario
     * @return ProcessoFiscal
     */
    public function setFkAdministracaoUsuario(\Urbem\CoreBundle\Entity\Administracao\Usuario $fkAdministracaoUsuario)
    {
        $this->numcgm = $fkAdministracaoUsuario->getNumcgm();
        $this->fkAdministracaoUsuario = $fkAdministracaoUsuario;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkAdministracaoUsuario
     *
     * @return \Urbem\CoreBundle\Entity\Administracao\Usuario
     */
    public function getFkAdministracaoUsuario()
    {
        return $this->fkAdministracaoUsuario;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkFiscalizacaoTipoFiscalizacao
     *
     * @param \Urbem\CoreBundle\Entity\Fiscalizacao\TipoFiscalizacao $fkFiscalizacaoTipoFiscalizacao
     * @return ProcessoFiscal
     */
    public function setFkFiscalizacaoTipoFiscalizacao(\Urbem\CoreBundle\Entity\Fiscalizacao\TipoFiscalizacao $fkFiscalizacaoTipoFiscalizacao)
    {
        $this->codTipo = $fkFiscalizacaoTipoFiscalizacao->getCodTipo();
        $this->fkFiscalizacaoTipoFiscalizacao = $fkFiscalizacaoTipoFiscalizacao;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkFiscalizacaoTipoFiscalizacao
     *
     * @return \Urbem\CoreBundle\Entity\Fiscalizacao\TipoFiscalizacao
     */
    public function getFkFiscalizacaoTipoFiscalizacao()
    {
        return $this->fkFiscalizacaoTipoFiscalizacao;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkFiscalizacaoNaturezaFiscalizacao
     *
     * @param \Urbem\CoreBundle\Entity\Fiscalizacao\NaturezaFiscalizacao $fkFiscalizacaoNaturezaFiscalizacao
     * @return ProcessoFiscal
     */
    public function setFkFiscalizacaoNaturezaFiscalizacao(\Urbem\CoreBundle\Entity\Fiscalizacao\NaturezaFiscalizacao $fkFiscalizacaoNaturezaFiscalizacao)
    {
        $this->codNatureza = $fkFiscalizacaoNaturezaFiscalizacao->getCodNatureza();
        $this->fkFiscalizacaoNaturezaFiscalizacao = $fkFiscalizacaoNaturezaFiscalizacao;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkFiscalizacaoNaturezaFiscalizacao
     *
     * @return \Urbem\CoreBundle\Entity\Fiscalizacao\NaturezaFiscalizacao
     */
    public function getFkFiscalizacaoNaturezaFiscalizacao()
    {
        return $this->fkFiscalizacaoNaturezaFiscalizacao;
    }

    /**
     * OneToOne (inverse side)
     * Set FiscalizacaoInicioFiscalizacao
     *
     * @param \Urbem\CoreBundle\Entity\Fiscalizacao\InicioFiscalizacao $fkFiscalizacaoInicioFiscalizacao
     * @return ProcessoFiscal
     */
    public function setFkFiscalizacaoInicioFiscalizacao(\Urbem\CoreBundle\Entity\Fiscalizacao\InicioFiscalizacao $fkFiscalizacaoInicioFiscalizacao)
    {
        $fkFiscalizacaoInicioFiscalizacao->setFkFiscalizacaoProcessoFiscal($this);
        $this->fkFiscalizacaoInicioFiscalizacao = $fkFiscalizacaoInicioFiscalizacao;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkFiscalizacaoInicioFiscalizacao
     *
     * @return \Urbem\CoreBundle\Entity\Fiscalizacao\InicioFiscalizacao
     */
    public function getFkFiscalizacaoInicioFiscalizacao()
    {
        return $this->fkFiscalizacaoInicioFiscalizacao;
    }

    /**
     * OneToOne (inverse side)
     * Set FiscalizacaoProcessoFiscalCancelado
     *
     * @param \Urbem\CoreBundle\Entity\Fiscalizacao\ProcessoFiscalCancelado $fkFiscalizacaoProcessoFiscalCancelado
     * @return ProcessoFiscal
     */
    public function setFkFiscalizacaoProcessoFiscalCancelado(\Urbem\CoreBundle\Entity\Fiscalizacao\ProcessoFiscalCancelado $fkFiscalizacaoProcessoFiscalCancelado)
    {
        $fkFiscalizacaoProcessoFiscalCancelado->setFkFiscalizacaoProcessoFiscal($this);
        $this->fkFiscalizacaoProcessoFiscalCancelado = $fkFiscalizacaoProcessoFiscalCancelado;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkFiscalizacaoProcessoFiscalCancelado
     *
     * @return \Urbem\CoreBundle\Entity\Fiscalizacao\ProcessoFiscalCancelado
     */
    public function getFkFiscalizacaoProcessoFiscalCancelado()
    {
        return $this->fkFiscalizacaoProcessoFiscalCancelado;
    }

    /**
     * OneToOne (inverse side)
     * Set FiscalizacaoProcessoFiscalEmpresa
     *
     * @param \Urbem\CoreBundle\Entity\Fiscalizacao\ProcessoFiscalEmpresa $fkFiscalizacaoProcessoFiscalEmpresa
     * @return ProcessoFiscal
     */
    public function setFkFiscalizacaoProcessoFiscalEmpresa(\Urbem\CoreBundle\Entity\Fiscalizacao\ProcessoFiscalEmpresa $fkFiscalizacaoProcessoFiscalEmpresa)
    {
        $fkFiscalizacaoProcessoFiscalEmpresa->setFkFiscalizacaoProcessoFiscal($this);
        $this->fkFiscalizacaoProcessoFiscalEmpresa = $fkFiscalizacaoProcessoFiscalEmpresa;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkFiscalizacaoProcessoFiscalEmpresa
     *
     * @return \Urbem\CoreBundle\Entity\Fiscalizacao\ProcessoFiscalEmpresa
     */
    public function getFkFiscalizacaoProcessoFiscalEmpresa()
    {
        return $this->fkFiscalizacaoProcessoFiscalEmpresa;
    }

    /**
     * OneToOne (inverse side)
     * Set FiscalizacaoTerminoFiscalizacao
     *
     * @param \Urbem\CoreBundle\Entity\Fiscalizacao\TerminoFiscalizacao $fkFiscalizacaoTerminoFiscalizacao
     * @return ProcessoFiscal
     */
    public function setFkFiscalizacaoTerminoFiscalizacao(\Urbem\CoreBundle\Entity\Fiscalizacao\TerminoFiscalizacao $fkFiscalizacaoTerminoFiscalizacao)
    {
        $fkFiscalizacaoTerminoFiscalizacao->setFkFiscalizacaoProcessoFiscal($this);
        $this->fkFiscalizacaoTerminoFiscalizacao = $fkFiscalizacaoTerminoFiscalizacao;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkFiscalizacaoTerminoFiscalizacao
     *
     * @return \Urbem\CoreBundle\Entity\Fiscalizacao\TerminoFiscalizacao
     */
    public function getFkFiscalizacaoTerminoFiscalizacao()
    {
        return $this->fkFiscalizacaoTerminoFiscalizacao;
    }

    /**
     * OneToOne (inverse side)
     * Set FiscalizacaoProcessoFiscalObras
     *
     * @param \Urbem\CoreBundle\Entity\Fiscalizacao\ProcessoFiscalObras $fkFiscalizacaoProcessoFiscalObras
     * @return ProcessoFiscal
     */
    public function setFkFiscalizacaoProcessoFiscalObras(\Urbem\CoreBundle\Entity\Fiscalizacao\ProcessoFiscalObras $fkFiscalizacaoProcessoFiscalObras)
    {
        $fkFiscalizacaoProcessoFiscalObras->setFkFiscalizacaoProcessoFiscal($this);
        $this->fkFiscalizacaoProcessoFiscalObras = $fkFiscalizacaoProcessoFiscalObras;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkFiscalizacaoProcessoFiscalObras
     *
     * @return \Urbem\CoreBundle\Entity\Fiscalizacao\ProcessoFiscalObras
     */
    public function getFkFiscalizacaoProcessoFiscalObras()
    {
        return $this->fkFiscalizacaoProcessoFiscalObras;
    }

    /**
     * OneToOne (inverse side)
     * Set FiscalizacaoNotificacaoFiscalizacao
     *
     * @param \Urbem\CoreBundle\Entity\Fiscalizacao\NotificacaoFiscalizacao $fkFiscalizacaoNotificacaoFiscalizacao
     * @return ProcessoFiscal
     */
    public function setFkFiscalizacaoNotificacaoFiscalizacao(\Urbem\CoreBundle\Entity\Fiscalizacao\NotificacaoFiscalizacao $fkFiscalizacaoNotificacaoFiscalizacao)
    {
        $fkFiscalizacaoNotificacaoFiscalizacao->setFkFiscalizacaoProcessoFiscal($this);
        $this->fkFiscalizacaoNotificacaoFiscalizacao = $fkFiscalizacaoNotificacaoFiscalizacao;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkFiscalizacaoNotificacaoFiscalizacao
     *
     * @return \Urbem\CoreBundle\Entity\Fiscalizacao\NotificacaoFiscalizacao
     */
    public function getFkFiscalizacaoNotificacaoFiscalizacao()
    {
        return $this->fkFiscalizacaoNotificacaoFiscalizacao;
    }
}
