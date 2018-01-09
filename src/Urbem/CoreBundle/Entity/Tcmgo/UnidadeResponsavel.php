<?php
 
namespace Urbem\CoreBundle\Entity\Tcmgo;

/**
 * UnidadeResponsavel
 */
class UnidadeResponsavel
{
    /**
     * PK
     * @var string
     */
    private $exercicio;

    /**
     * PK
     * @var integer
     */
    private $numUnidade;

    /**
     * PK
     * @var integer
     */
    private $numOrgao;

    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DateTimePK
     */
    private $timestamp;

    /**
     * @var integer
     */
    private $cgmGestor;

    /**
     * @var \DateTime
     */
    private $gestorDtInicio;

    /**
     * @var \DateTime
     */
    private $gestorDtFim;

    /**
     * @var integer
     */
    private $tipoResponsavel;

    /**
     * @var string
     */
    private $gestorCargo;

    /**
     * @var integer
     */
    private $cgmContador;

    /**
     * @var \DateTime
     */
    private $contadorDtInicio;

    /**
     * @var \DateTime
     */
    private $contadorDtFim;

    /**
     * @var string
     */
    private $contadorCrc;

    /**
     * @var integer
     */
    private $ufCrc;

    /**
     * @var integer
     */
    private $codProvimentoContabil;

    /**
     * @var integer
     */
    private $cgmControleInterno;

    /**
     * @var \DateTime
     */
    private $controleInternoDtInicio;

    /**
     * @var \DateTime
     */
    private $controleInternoDtFim;

    /**
     * @var integer
     */
    private $cgmJuridico;

    /**
     * @var \DateTime
     */
    private $juridicoDtInicio;

    /**
     * @var \DateTime
     */
    private $juridicoDtFim;

    /**
     * @var integer
     */
    private $juridicoOab;

    /**
     * @var integer
     */
    private $ufOab;

    /**
     * @var integer
     */
    private $codProvimentoJuridico;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcmgo\ContadorTerceirizado
     */
    private $fkTcmgoContadorTerceirizados;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcmgo\JuridicoTerceirizado
     */
    private $fkTcmgoJuridicoTerceirizados;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Orcamento\Unidade
     */
    private $fkOrcamentoUnidade;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\SwCgm
     */
    private $fkSwCgm;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Tcmgo\TipoResponsavel
     */
    private $fkTcmgoTipoResponsavel;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\SwUf
     */
    private $fkSwUf;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Tcmgo\ProvimentoContabil
     */
    private $fkTcmgoProvimentoContabil;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Tcmgo\ProvimentoJuridico
     */
    private $fkTcmgoProvimentoJuridico;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\SwCgm
     */
    private $fkSwCgm1;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\SwCgm
     */
    private $fkSwCgm2;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\SwCgm
     */
    private $fkSwCgm3;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\SwUf
     */
    private $fkSwUf1;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkTcmgoContadorTerceirizados = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTcmgoJuridicoTerceirizados = new \Doctrine\Common\Collections\ArrayCollection();
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimePK;
    }

    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return UnidadeResponsavel
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
     * Set numUnidade
     *
     * @param integer $numUnidade
     * @return UnidadeResponsavel
     */
    public function setNumUnidade($numUnidade)
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
     * Set numOrgao
     *
     * @param integer $numOrgao
     * @return UnidadeResponsavel
     */
    public function setNumOrgao($numOrgao)
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
     * Set timestamp
     *
     * @param \Urbem\CoreBundle\Helper\DateTimePK $timestamp
     * @return UnidadeResponsavel
     */
    public function setTimestamp(\Urbem\CoreBundle\Helper\DateTimePK $timestamp)
    {
        $this->timestamp = $timestamp;
        return $this;
    }

    /**
     * Get timestamp
     *
     * @return \Urbem\CoreBundle\Helper\DateTimePK
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }

    /**
     * Set cgmGestor
     *
     * @param integer $cgmGestor
     * @return UnidadeResponsavel
     */
    public function setCgmGestor($cgmGestor)
    {
        $this->cgmGestor = $cgmGestor;
        return $this;
    }

    /**
     * Get cgmGestor
     *
     * @return integer
     */
    public function getCgmGestor()
    {
        return $this->cgmGestor;
    }

    /**
     * Set gestorDtInicio
     *
     * @param \DateTime $gestorDtInicio
     * @return UnidadeResponsavel
     */
    public function setGestorDtInicio(\DateTime $gestorDtInicio)
    {
        $this->gestorDtInicio = $gestorDtInicio;
        return $this;
    }

    /**
     * Get gestorDtInicio
     *
     * @return \DateTime
     */
    public function getGestorDtInicio()
    {
        return $this->gestorDtInicio;
    }

    /**
     * Set gestorDtFim
     *
     * @param \DateTime $gestorDtFim
     * @return UnidadeResponsavel
     */
    public function setGestorDtFim(\DateTime $gestorDtFim = null)
    {
        $this->gestorDtFim = $gestorDtFim;
        return $this;
    }

    /**
     * Get gestorDtFim
     *
     * @return \DateTime
     */
    public function getGestorDtFim()
    {
        return $this->gestorDtFim;
    }

    /**
     * Set tipoResponsavel
     *
     * @param integer $tipoResponsavel
     * @return UnidadeResponsavel
     */
    public function setTipoResponsavel($tipoResponsavel)
    {
        $this->tipoResponsavel = $tipoResponsavel;
        return $this;
    }

    /**
     * Get tipoResponsavel
     *
     * @return integer
     */
    public function getTipoResponsavel()
    {
        return $this->tipoResponsavel;
    }

    /**
     * Set gestorCargo
     *
     * @param string $gestorCargo
     * @return UnidadeResponsavel
     */
    public function setGestorCargo($gestorCargo = null)
    {
        $this->gestorCargo = $gestorCargo;
        return $this;
    }

    /**
     * Get gestorCargo
     *
     * @return string
     */
    public function getGestorCargo()
    {
        return $this->gestorCargo;
    }

    /**
     * Set cgmContador
     *
     * @param integer $cgmContador
     * @return UnidadeResponsavel
     */
    public function setCgmContador($cgmContador)
    {
        $this->cgmContador = $cgmContador;
        return $this;
    }

    /**
     * Get cgmContador
     *
     * @return integer
     */
    public function getCgmContador()
    {
        return $this->cgmContador;
    }

    /**
     * Set contadorDtInicio
     *
     * @param \DateTime $contadorDtInicio
     * @return UnidadeResponsavel
     */
    public function setContadorDtInicio(\DateTime $contadorDtInicio)
    {
        $this->contadorDtInicio = $contadorDtInicio;
        return $this;
    }

    /**
     * Get contadorDtInicio
     *
     * @return \DateTime
     */
    public function getContadorDtInicio()
    {
        return $this->contadorDtInicio;
    }

    /**
     * Set contadorDtFim
     *
     * @param \DateTime $contadorDtFim
     * @return UnidadeResponsavel
     */
    public function setContadorDtFim(\DateTime $contadorDtFim = null)
    {
        $this->contadorDtFim = $contadorDtFim;
        return $this;
    }

    /**
     * Get contadorDtFim
     *
     * @return \DateTime
     */
    public function getContadorDtFim()
    {
        return $this->contadorDtFim;
    }

    /**
     * Set contadorCrc
     *
     * @param string $contadorCrc
     * @return UnidadeResponsavel
     */
    public function setContadorCrc($contadorCrc = null)
    {
        $this->contadorCrc = $contadorCrc;
        return $this;
    }

    /**
     * Get contadorCrc
     *
     * @return string
     */
    public function getContadorCrc()
    {
        return $this->contadorCrc;
    }

    /**
     * Set ufCrc
     *
     * @param integer $ufCrc
     * @return UnidadeResponsavel
     */
    public function setUfCrc($ufCrc = null)
    {
        $this->ufCrc = $ufCrc;
        return $this;
    }

    /**
     * Get ufCrc
     *
     * @return integer
     */
    public function getUfCrc()
    {
        return $this->ufCrc;
    }

    /**
     * Set codProvimentoContabil
     *
     * @param integer $codProvimentoContabil
     * @return UnidadeResponsavel
     */
    public function setCodProvimentoContabil($codProvimentoContabil = null)
    {
        $this->codProvimentoContabil = $codProvimentoContabil;
        return $this;
    }

    /**
     * Get codProvimentoContabil
     *
     * @return integer
     */
    public function getCodProvimentoContabil()
    {
        return $this->codProvimentoContabil;
    }

    /**
     * Set cgmControleInterno
     *
     * @param integer $cgmControleInterno
     * @return UnidadeResponsavel
     */
    public function setCgmControleInterno($cgmControleInterno)
    {
        $this->cgmControleInterno = $cgmControleInterno;
        return $this;
    }

    /**
     * Get cgmControleInterno
     *
     * @return integer
     */
    public function getCgmControleInterno()
    {
        return $this->cgmControleInterno;
    }

    /**
     * Set controleInternoDtInicio
     *
     * @param \DateTime $controleInternoDtInicio
     * @return UnidadeResponsavel
     */
    public function setControleInternoDtInicio(\DateTime $controleInternoDtInicio)
    {
        $this->controleInternoDtInicio = $controleInternoDtInicio;
        return $this;
    }

    /**
     * Get controleInternoDtInicio
     *
     * @return \DateTime
     */
    public function getControleInternoDtInicio()
    {
        return $this->controleInternoDtInicio;
    }

    /**
     * Set controleInternoDtFim
     *
     * @param \DateTime $controleInternoDtFim
     * @return UnidadeResponsavel
     */
    public function setControleInternoDtFim(\DateTime $controleInternoDtFim = null)
    {
        $this->controleInternoDtFim = $controleInternoDtFim;
        return $this;
    }

    /**
     * Get controleInternoDtFim
     *
     * @return \DateTime
     */
    public function getControleInternoDtFim()
    {
        return $this->controleInternoDtFim;
    }

    /**
     * Set cgmJuridico
     *
     * @param integer $cgmJuridico
     * @return UnidadeResponsavel
     */
    public function setCgmJuridico($cgmJuridico)
    {
        $this->cgmJuridico = $cgmJuridico;
        return $this;
    }

    /**
     * Get cgmJuridico
     *
     * @return integer
     */
    public function getCgmJuridico()
    {
        return $this->cgmJuridico;
    }

    /**
     * Set juridicoDtInicio
     *
     * @param \DateTime $juridicoDtInicio
     * @return UnidadeResponsavel
     */
    public function setJuridicoDtInicio(\DateTime $juridicoDtInicio)
    {
        $this->juridicoDtInicio = $juridicoDtInicio;
        return $this;
    }

    /**
     * Get juridicoDtInicio
     *
     * @return \DateTime
     */
    public function getJuridicoDtInicio()
    {
        return $this->juridicoDtInicio;
    }

    /**
     * Set juridicoDtFim
     *
     * @param \DateTime $juridicoDtFim
     * @return UnidadeResponsavel
     */
    public function setJuridicoDtFim(\DateTime $juridicoDtFim = null)
    {
        $this->juridicoDtFim = $juridicoDtFim;
        return $this;
    }

    /**
     * Get juridicoDtFim
     *
     * @return \DateTime
     */
    public function getJuridicoDtFim()
    {
        return $this->juridicoDtFim;
    }

    /**
     * Set juridicoOab
     *
     * @param integer $juridicoOab
     * @return UnidadeResponsavel
     */
    public function setJuridicoOab($juridicoOab = null)
    {
        $this->juridicoOab = $juridicoOab;
        return $this;
    }

    /**
     * Get juridicoOab
     *
     * @return integer
     */
    public function getJuridicoOab()
    {
        return $this->juridicoOab;
    }

    /**
     * Set ufOab
     *
     * @param integer $ufOab
     * @return UnidadeResponsavel
     */
    public function setUfOab($ufOab = null)
    {
        $this->ufOab = $ufOab;
        return $this;
    }

    /**
     * Get ufOab
     *
     * @return integer
     */
    public function getUfOab()
    {
        return $this->ufOab;
    }

    /**
     * Set codProvimentoJuridico
     *
     * @param integer $codProvimentoJuridico
     * @return UnidadeResponsavel
     */
    public function setCodProvimentoJuridico($codProvimentoJuridico = null)
    {
        $this->codProvimentoJuridico = $codProvimentoJuridico;
        return $this;
    }

    /**
     * Get codProvimentoJuridico
     *
     * @return integer
     */
    public function getCodProvimentoJuridico()
    {
        return $this->codProvimentoJuridico;
    }

    /**
     * OneToMany (owning side)
     * Add TcmgoContadorTerceirizado
     *
     * @param \Urbem\CoreBundle\Entity\Tcmgo\ContadorTerceirizado $fkTcmgoContadorTerceirizado
     * @return UnidadeResponsavel
     */
    public function addFkTcmgoContadorTerceirizados(\Urbem\CoreBundle\Entity\Tcmgo\ContadorTerceirizado $fkTcmgoContadorTerceirizado)
    {
        if (false === $this->fkTcmgoContadorTerceirizados->contains($fkTcmgoContadorTerceirizado)) {
            $fkTcmgoContadorTerceirizado->setFkTcmgoUnidadeResponsavel($this);
            $this->fkTcmgoContadorTerceirizados->add($fkTcmgoContadorTerceirizado);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcmgoContadorTerceirizado
     *
     * @param \Urbem\CoreBundle\Entity\Tcmgo\ContadorTerceirizado $fkTcmgoContadorTerceirizado
     */
    public function removeFkTcmgoContadorTerceirizados(\Urbem\CoreBundle\Entity\Tcmgo\ContadorTerceirizado $fkTcmgoContadorTerceirizado)
    {
        $this->fkTcmgoContadorTerceirizados->removeElement($fkTcmgoContadorTerceirizado);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcmgoContadorTerceirizados
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcmgo\ContadorTerceirizado
     */
    public function getFkTcmgoContadorTerceirizados()
    {
        return $this->fkTcmgoContadorTerceirizados;
    }

    /**
     * OneToMany (owning side)
     * Add TcmgoJuridicoTerceirizado
     *
     * @param \Urbem\CoreBundle\Entity\Tcmgo\JuridicoTerceirizado $fkTcmgoJuridicoTerceirizado
     * @return UnidadeResponsavel
     */
    public function addFkTcmgoJuridicoTerceirizados(\Urbem\CoreBundle\Entity\Tcmgo\JuridicoTerceirizado $fkTcmgoJuridicoTerceirizado)
    {
        if (false === $this->fkTcmgoJuridicoTerceirizados->contains($fkTcmgoJuridicoTerceirizado)) {
            $fkTcmgoJuridicoTerceirizado->setFkTcmgoUnidadeResponsavel($this);
            $this->fkTcmgoJuridicoTerceirizados->add($fkTcmgoJuridicoTerceirizado);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcmgoJuridicoTerceirizado
     *
     * @param \Urbem\CoreBundle\Entity\Tcmgo\JuridicoTerceirizado $fkTcmgoJuridicoTerceirizado
     */
    public function removeFkTcmgoJuridicoTerceirizados(\Urbem\CoreBundle\Entity\Tcmgo\JuridicoTerceirizado $fkTcmgoJuridicoTerceirizado)
    {
        $this->fkTcmgoJuridicoTerceirizados->removeElement($fkTcmgoJuridicoTerceirizado);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcmgoJuridicoTerceirizados
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcmgo\JuridicoTerceirizado
     */
    public function getFkTcmgoJuridicoTerceirizados()
    {
        return $this->fkTcmgoJuridicoTerceirizados;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkOrcamentoUnidade
     *
     * @param \Urbem\CoreBundle\Entity\Orcamento\Unidade $fkOrcamentoUnidade
     * @return UnidadeResponsavel
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
     * Set fkSwCgm
     *
     * @param \Urbem\CoreBundle\Entity\SwCgm $fkSwCgm
     * @return UnidadeResponsavel
     */
    public function setFkSwCgm(\Urbem\CoreBundle\Entity\SwCgm $fkSwCgm)
    {
        $this->cgmGestor = $fkSwCgm->getNumcgm();
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

    /**
     * ManyToOne (inverse side)
     * Set fkTcmgoTipoResponsavel
     *
     * @param \Urbem\CoreBundle\Entity\Tcmgo\TipoResponsavel $fkTcmgoTipoResponsavel
     * @return UnidadeResponsavel
     */
    public function setFkTcmgoTipoResponsavel(\Urbem\CoreBundle\Entity\Tcmgo\TipoResponsavel $fkTcmgoTipoResponsavel)
    {
        $this->tipoResponsavel = $fkTcmgoTipoResponsavel->getCodTipo();
        $this->fkTcmgoTipoResponsavel = $fkTcmgoTipoResponsavel;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkTcmgoTipoResponsavel
     *
     * @return \Urbem\CoreBundle\Entity\Tcmgo\TipoResponsavel
     */
    public function getFkTcmgoTipoResponsavel()
    {
        return $this->fkTcmgoTipoResponsavel;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkSwUf
     *
     * @param \Urbem\CoreBundle\Entity\SwUf $fkSwUf
     * @return UnidadeResponsavel
     */
    public function setFkSwUf(\Urbem\CoreBundle\Entity\SwUf $fkSwUf)
    {
        $this->ufCrc = $fkSwUf->getCodUf();
        $this->fkSwUf = $fkSwUf;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkSwUf
     *
     * @return \Urbem\CoreBundle\Entity\SwUf
     */
    public function getFkSwUf()
    {
        return $this->fkSwUf;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkTcmgoProvimentoContabil
     *
     * @param \Urbem\CoreBundle\Entity\Tcmgo\ProvimentoContabil $fkTcmgoProvimentoContabil
     * @return UnidadeResponsavel
     */
    public function setFkTcmgoProvimentoContabil(\Urbem\CoreBundle\Entity\Tcmgo\ProvimentoContabil $fkTcmgoProvimentoContabil)
    {
        $this->codProvimentoContabil = $fkTcmgoProvimentoContabil->getCodProvimento();
        $this->fkTcmgoProvimentoContabil = $fkTcmgoProvimentoContabil;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkTcmgoProvimentoContabil
     *
     * @return \Urbem\CoreBundle\Entity\Tcmgo\ProvimentoContabil
     */
    public function getFkTcmgoProvimentoContabil()
    {
        return $this->fkTcmgoProvimentoContabil;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkTcmgoProvimentoJuridico
     *
     * @param \Urbem\CoreBundle\Entity\Tcmgo\ProvimentoJuridico $fkTcmgoProvimentoJuridico
     * @return UnidadeResponsavel
     */
    public function setFkTcmgoProvimentoJuridico(\Urbem\CoreBundle\Entity\Tcmgo\ProvimentoJuridico $fkTcmgoProvimentoJuridico)
    {
        $this->codProvimentoJuridico = $fkTcmgoProvimentoJuridico->getCodProvimento();
        $this->fkTcmgoProvimentoJuridico = $fkTcmgoProvimentoJuridico;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkTcmgoProvimentoJuridico
     *
     * @return \Urbem\CoreBundle\Entity\Tcmgo\ProvimentoJuridico
     */
    public function getFkTcmgoProvimentoJuridico()
    {
        return $this->fkTcmgoProvimentoJuridico;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkSwCgm1
     *
     * @param \Urbem\CoreBundle\Entity\SwCgm $fkSwCgm1
     * @return UnidadeResponsavel
     */
    public function setFkSwCgm1(\Urbem\CoreBundle\Entity\SwCgm $fkSwCgm1)
    {
        $this->cgmContador = $fkSwCgm1->getNumcgm();
        $this->fkSwCgm1 = $fkSwCgm1;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkSwCgm1
     *
     * @return \Urbem\CoreBundle\Entity\SwCgm
     */
    public function getFkSwCgm1()
    {
        return $this->fkSwCgm1;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkSwCgm2
     *
     * @param \Urbem\CoreBundle\Entity\SwCgm $fkSwCgm2
     * @return UnidadeResponsavel
     */
    public function setFkSwCgm2(\Urbem\CoreBundle\Entity\SwCgm $fkSwCgm2)
    {
        $this->cgmControleInterno = $fkSwCgm2->getNumcgm();
        $this->fkSwCgm2 = $fkSwCgm2;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkSwCgm2
     *
     * @return \Urbem\CoreBundle\Entity\SwCgm
     */
    public function getFkSwCgm2()
    {
        return $this->fkSwCgm2;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkSwCgm3
     *
     * @param \Urbem\CoreBundle\Entity\SwCgm $fkSwCgm3
     * @return UnidadeResponsavel
     */
    public function setFkSwCgm3(\Urbem\CoreBundle\Entity\SwCgm $fkSwCgm3)
    {
        $this->cgmJuridico = $fkSwCgm3->getNumcgm();
        $this->fkSwCgm3 = $fkSwCgm3;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkSwCgm3
     *
     * @return \Urbem\CoreBundle\Entity\SwCgm
     */
    public function getFkSwCgm3()
    {
        return $this->fkSwCgm3;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkSwUf1
     *
     * @param \Urbem\CoreBundle\Entity\SwUf $fkSwUf1
     * @return UnidadeResponsavel
     */
    public function setFkSwUf1(\Urbem\CoreBundle\Entity\SwUf $fkSwUf1)
    {
        $this->ufOab = $fkSwUf1->getCodUf();
        $this->fkSwUf1 = $fkSwUf1;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkSwUf1
     *
     * @return \Urbem\CoreBundle\Entity\SwUf
     */
    public function getFkSwUf1()
    {
        return $this->fkSwUf1;
    }
}
