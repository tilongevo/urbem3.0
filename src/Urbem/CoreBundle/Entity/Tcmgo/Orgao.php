<?php
 
namespace Urbem\CoreBundle\Entity\Tcmgo;

/**
 * Orgao
 */
class Orgao
{
    /**
     * PK
     * @var integer
     */
    private $numOrgao;

    /**
     * PK
     * @var string
     */
    private $exercicio;

    /**
     * @var integer
     */
    private $numcgmOrgao;

    /**
     * @var integer
     */
    private $numcgmContador;

    /**
     * @var integer
     */
    private $codTipo;

    /**
     * @var string
     */
    private $crcContador;

    /**
     * @var string
     */
    private $ufCrcContador;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Tcmgo\OrgaoRepresentante
     */
    private $fkTcmgoOrgaoRepresentante;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Tcmgo\OrgaoControleInterno
     */
    private $fkTcmgoOrgaoControleInterno;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Orcamento\Orgao
     */
    private $fkOrcamentoOrgao;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcmgo\OrgaoPlanoBanco
     */
    private $fkTcmgoOrgaoPlanoBancos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcmgo\OrgaoGestor
     */
    private $fkTcmgoOrgaoGestores;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\SwCgmPessoaJuridica
     */
    private $fkSwCgmPessoaJuridica;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\SwCgm
     */
    private $fkSwCgm;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Tcmgo\TipoOrgao
     */
    private $fkTcmgoTipoOrgao;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkTcmgoOrgaoPlanoBancos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTcmgoOrgaoGestores = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set numOrgao
     *
     * @param integer $numOrgao
     * @return Orgao
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
     * Set exercicio
     *
     * @param string $exercicio
     * @return Orgao
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
     * Set numcgmOrgao
     *
     * @param integer $numcgmOrgao
     * @return Orgao
     */
    public function setNumcgmOrgao($numcgmOrgao)
    {
        $this->numcgmOrgao = $numcgmOrgao;
        return $this;
    }

    /**
     * Get numcgmOrgao
     *
     * @return integer
     */
    public function getNumcgmOrgao()
    {
        return $this->numcgmOrgao;
    }

    /**
     * Set numcgmContador
     *
     * @param integer $numcgmContador
     * @return Orgao
     */
    public function setNumcgmContador($numcgmContador)
    {
        $this->numcgmContador = $numcgmContador;
        return $this;
    }

    /**
     * Get numcgmContador
     *
     * @return integer
     */
    public function getNumcgmContador()
    {
        return $this->numcgmContador;
    }

    /**
     * Set codTipo
     *
     * @param integer $codTipo
     * @return Orgao
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
     * Set crcContador
     *
     * @param string $crcContador
     * @return Orgao
     */
    public function setCrcContador($crcContador)
    {
        $this->crcContador = $crcContador;
        return $this;
    }

    /**
     * Get crcContador
     *
     * @return string
     */
    public function getCrcContador()
    {
        return $this->crcContador;
    }

    /**
     * Set ufCrcContador
     *
     * @param string $ufCrcContador
     * @return Orgao
     */
    public function setUfCrcContador($ufCrcContador)
    {
        $this->ufCrcContador = $ufCrcContador;
        return $this;
    }

    /**
     * Get ufCrcContador
     *
     * @return string
     */
    public function getUfCrcContador()
    {
        return $this->ufCrcContador;
    }

    /**
     * OneToMany (owning side)
     * Add TcmgoOrgaoPlanoBanco
     *
     * @param \Urbem\CoreBundle\Entity\Tcmgo\OrgaoPlanoBanco $fkTcmgoOrgaoPlanoBanco
     * @return Orgao
     */
    public function addFkTcmgoOrgaoPlanoBancos(\Urbem\CoreBundle\Entity\Tcmgo\OrgaoPlanoBanco $fkTcmgoOrgaoPlanoBanco)
    {
        if (false === $this->fkTcmgoOrgaoPlanoBancos->contains($fkTcmgoOrgaoPlanoBanco)) {
            $fkTcmgoOrgaoPlanoBanco->setFkTcmgoOrgao($this);
            $this->fkTcmgoOrgaoPlanoBancos->add($fkTcmgoOrgaoPlanoBanco);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcmgoOrgaoPlanoBanco
     *
     * @param \Urbem\CoreBundle\Entity\Tcmgo\OrgaoPlanoBanco $fkTcmgoOrgaoPlanoBanco
     */
    public function removeFkTcmgoOrgaoPlanoBancos(\Urbem\CoreBundle\Entity\Tcmgo\OrgaoPlanoBanco $fkTcmgoOrgaoPlanoBanco)
    {
        $this->fkTcmgoOrgaoPlanoBancos->removeElement($fkTcmgoOrgaoPlanoBanco);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcmgoOrgaoPlanoBancos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcmgo\OrgaoPlanoBanco
     */
    public function getFkTcmgoOrgaoPlanoBancos()
    {
        return $this->fkTcmgoOrgaoPlanoBancos;
    }

    /**
     * OneToMany (owning side)
     * Add TcmgoOrgaoGestor
     *
     * @param \Urbem\CoreBundle\Entity\Tcmgo\OrgaoGestor $fkTcmgoOrgaoGestor
     * @return Orgao
     */
    public function addFkTcmgoOrgaoGestores(\Urbem\CoreBundle\Entity\Tcmgo\OrgaoGestor $fkTcmgoOrgaoGestor)
    {
        if (false === $this->fkTcmgoOrgaoGestores->contains($fkTcmgoOrgaoGestor)) {
            $fkTcmgoOrgaoGestor->setFkTcmgoOrgao($this);
            $this->fkTcmgoOrgaoGestores->add($fkTcmgoOrgaoGestor);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcmgoOrgaoGestor
     *
     * @param \Urbem\CoreBundle\Entity\Tcmgo\OrgaoGestor $fkTcmgoOrgaoGestor
     */
    public function removeFkTcmgoOrgaoGestores(\Urbem\CoreBundle\Entity\Tcmgo\OrgaoGestor $fkTcmgoOrgaoGestor)
    {
        $this->fkTcmgoOrgaoGestores->removeElement($fkTcmgoOrgaoGestor);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcmgoOrgaoGestores
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcmgo\OrgaoGestor
     */
    public function getFkTcmgoOrgaoGestores()
    {
        return $this->fkTcmgoOrgaoGestores;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkSwCgmPessoaJuridica
     *
     * @param \Urbem\CoreBundle\Entity\SwCgmPessoaJuridica $fkSwCgmPessoaJuridica
     * @return Orgao
     */
    public function setFkSwCgmPessoaJuridica(\Urbem\CoreBundle\Entity\SwCgmPessoaJuridica $fkSwCgmPessoaJuridica)
    {
        $this->numcgmOrgao = $fkSwCgmPessoaJuridica->getNumcgm();
        $this->fkSwCgmPessoaJuridica = $fkSwCgmPessoaJuridica;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkSwCgmPessoaJuridica
     *
     * @return \Urbem\CoreBundle\Entity\SwCgmPessoaJuridica
     */
    public function getFkSwCgmPessoaJuridica()
    {
        return $this->fkSwCgmPessoaJuridica;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkSwCgm
     *
     * @param \Urbem\CoreBundle\Entity\SwCgm $fkSwCgm
     * @return Orgao
     */
    public function setFkSwCgm(\Urbem\CoreBundle\Entity\SwCgm $fkSwCgm)
    {
        $this->numcgmContador = $fkSwCgm->getNumcgm();
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
     * Set fkTcmgoTipoOrgao
     *
     * @param \Urbem\CoreBundle\Entity\Tcmgo\TipoOrgao $fkTcmgoTipoOrgao
     * @return Orgao
     */
    public function setFkTcmgoTipoOrgao(\Urbem\CoreBundle\Entity\Tcmgo\TipoOrgao $fkTcmgoTipoOrgao)
    {
        $this->codTipo = $fkTcmgoTipoOrgao->getCodTipo();
        $this->fkTcmgoTipoOrgao = $fkTcmgoTipoOrgao;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkTcmgoTipoOrgao
     *
     * @return \Urbem\CoreBundle\Entity\Tcmgo\TipoOrgao
     */
    public function getFkTcmgoTipoOrgao()
    {
        return $this->fkTcmgoTipoOrgao;
    }

    /**
     * OneToOne (inverse side)
     * Set TcmgoOrgaoRepresentante
     *
     * @param \Urbem\CoreBundle\Entity\Tcmgo\OrgaoRepresentante $fkTcmgoOrgaoRepresentante
     * @return Orgao
     */
    public function setFkTcmgoOrgaoRepresentante(\Urbem\CoreBundle\Entity\Tcmgo\OrgaoRepresentante $fkTcmgoOrgaoRepresentante)
    {
        $fkTcmgoOrgaoRepresentante->setFkTcmgoOrgao($this);
        $this->fkTcmgoOrgaoRepresentante = $fkTcmgoOrgaoRepresentante;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkTcmgoOrgaoRepresentante
     *
     * @return \Urbem\CoreBundle\Entity\Tcmgo\OrgaoRepresentante
     */
    public function getFkTcmgoOrgaoRepresentante()
    {
        return $this->fkTcmgoOrgaoRepresentante;
    }

    /**
     * OneToOne (inverse side)
     * Set TcmgoOrgaoControleInterno
     *
     * @param \Urbem\CoreBundle\Entity\Tcmgo\OrgaoControleInterno $fkTcmgoOrgaoControleInterno
     * @return Orgao
     */
    public function setFkTcmgoOrgaoControleInterno(\Urbem\CoreBundle\Entity\Tcmgo\OrgaoControleInterno $fkTcmgoOrgaoControleInterno)
    {
        $fkTcmgoOrgaoControleInterno->setFkTcmgoOrgao($this);
        $this->fkTcmgoOrgaoControleInterno = $fkTcmgoOrgaoControleInterno;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkTcmgoOrgaoControleInterno
     *
     * @return \Urbem\CoreBundle\Entity\Tcmgo\OrgaoControleInterno
     */
    public function getFkTcmgoOrgaoControleInterno()
    {
        return $this->fkTcmgoOrgaoControleInterno;
    }

    /**
     * OneToOne (owning side)
     * Set OrcamentoOrgao
     *
     * @param \Urbem\CoreBundle\Entity\Orcamento\Orgao $fkOrcamentoOrgao
     * @return Orgao
     */
    public function setFkOrcamentoOrgao(\Urbem\CoreBundle\Entity\Orcamento\Orgao $fkOrcamentoOrgao)
    {
        $this->exercicio = $fkOrcamentoOrgao->getExercicio();
        $this->numOrgao = $fkOrcamentoOrgao->getNumOrgao();
        $this->fkOrcamentoOrgao = $fkOrcamentoOrgao;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkOrcamentoOrgao
     *
     * @return \Urbem\CoreBundle\Entity\Orcamento\Orgao
     */
    public function getFkOrcamentoOrgao()
    {
        return $this->fkOrcamentoOrgao;
    }
}
