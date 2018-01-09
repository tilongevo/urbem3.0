<?php
 
namespace Urbem\CoreBundle\Entity\Ima;

/**
 * ConfiguracaoDirf
 */
class ConfiguracaoDirf
{
    /**
     * PK
     * @var string
     */
    private $exercicio;

    /**
     * @var integer
     */
    private $codNatureza;

    /**
     * @var integer
     */
    private $responsavelPrefeitura;

    /**
     * @var integer
     */
    private $responsavelEntrega;

    /**
     * @var string
     */
    private $telefone;

    /**
     * @var string
     */
    private $ramal;

    /**
     * @var string
     */
    private $fax;

    /**
     * @var string
     */
    private $email;

    /**
     * @var boolean
     */
    private $pagamentoMesCompetencia = true;

    /**
     * @var integer
     */
    private $codEventoMolestia;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ima\ConfiguracaoDirfIrrfContaReceita
     */
    private $fkImaConfiguracaoDirfIrrfContaReceitas;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ima\ConfiguracaoDirfPlano
     */
    private $fkImaConfiguracaoDirfPlanos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ima\ConfiguracaoDirfIrrfPlanoConta
     */
    private $fkImaConfiguracaoDirfIrrfPlanoContas;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ima\ConfiguracaoDirfPrestador
     */
    private $fkImaConfiguracaoDirfPrestadores;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ima\ConfiguracaoDirfInss
     */
    private $fkImaConfiguracaoDirfInss;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Ima\NaturezaEstabelecimento
     */
    private $fkImaNaturezaEstabelecimento;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\SwCgm
     */
    private $fkSwCgm;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Folhapagamento\Evento
     */
    private $fkFolhapagamentoEvento;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\SwCgm
     */
    private $fkSwCgm1;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkImaConfiguracaoDirfIrrfContaReceitas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkImaConfiguracaoDirfPlanos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkImaConfiguracaoDirfIrrfPlanoContas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkImaConfiguracaoDirfPrestadores = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkImaConfiguracaoDirfInss = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return ConfiguracaoDirf
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
     * Set codNatureza
     *
     * @param integer $codNatureza
     * @return ConfiguracaoDirf
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
     * Set responsavelPrefeitura
     *
     * @param integer $responsavelPrefeitura
     * @return ConfiguracaoDirf
     */
    public function setResponsavelPrefeitura($responsavelPrefeitura)
    {
        $this->responsavelPrefeitura = $responsavelPrefeitura;
        return $this;
    }

    /**
     * Get responsavelPrefeitura
     *
     * @return integer
     */
    public function getResponsavelPrefeitura()
    {
        return $this->responsavelPrefeitura;
    }

    /**
     * Set responsavelEntrega
     *
     * @param integer $responsavelEntrega
     * @return ConfiguracaoDirf
     */
    public function setResponsavelEntrega($responsavelEntrega)
    {
        $this->responsavelEntrega = $responsavelEntrega;
        return $this;
    }

    /**
     * Get responsavelEntrega
     *
     * @return integer
     */
    public function getResponsavelEntrega()
    {
        return $this->responsavelEntrega;
    }

    /**
     * Set telefone
     *
     * @param string $telefone
     * @return ConfiguracaoDirf
     */
    public function setTelefone($telefone)
    {
        $this->telefone = $telefone;
        return $this;
    }

    /**
     * Get telefone
     *
     * @return string
     */
    public function getTelefone()
    {
        return $this->telefone;
    }

    /**
     * Set ramal
     *
     * @param string $ramal
     * @return ConfiguracaoDirf
     */
    public function setRamal($ramal)
    {
        $this->ramal = $ramal;
        return $this;
    }

    /**
     * Get ramal
     *
     * @return string
     */
    public function getRamal()
    {
        return $this->ramal;
    }

    /**
     * Set fax
     *
     * @param string $fax
     * @return ConfiguracaoDirf
     */
    public function setFax($fax)
    {
        $this->fax = $fax;
        return $this;
    }

    /**
     * Get fax
     *
     * @return string
     */
    public function getFax()
    {
        return $this->fax;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return ConfiguracaoDirf
     */
    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set pagamentoMesCompetencia
     *
     * @param boolean $pagamentoMesCompetencia
     * @return ConfiguracaoDirf
     */
    public function setPagamentoMesCompetencia($pagamentoMesCompetencia)
    {
        $this->pagamentoMesCompetencia = $pagamentoMesCompetencia;
        return $this;
    }

    /**
     * Get pagamentoMesCompetencia
     *
     * @return boolean
     */
    public function getPagamentoMesCompetencia()
    {
        return $this->pagamentoMesCompetencia;
    }

    /**
     * Set codEventoMolestia
     *
     * @param integer $codEventoMolestia
     * @return ConfiguracaoDirf
     */
    public function setCodEventoMolestia($codEventoMolestia = null)
    {
        $this->codEventoMolestia = $codEventoMolestia;
        return $this;
    }

    /**
     * Get codEventoMolestia
     *
     * @return integer
     */
    public function getCodEventoMolestia()
    {
        return $this->codEventoMolestia;
    }

    /**
     * OneToMany (owning side)
     * Add ImaConfiguracaoDirfIrrfContaReceita
     *
     * @param \Urbem\CoreBundle\Entity\Ima\ConfiguracaoDirfIrrfContaReceita $fkImaConfiguracaoDirfIrrfContaReceita
     * @return ConfiguracaoDirf
     */
    public function addFkImaConfiguracaoDirfIrrfContaReceitas(\Urbem\CoreBundle\Entity\Ima\ConfiguracaoDirfIrrfContaReceita $fkImaConfiguracaoDirfIrrfContaReceita)
    {
        if (false === $this->fkImaConfiguracaoDirfIrrfContaReceitas->contains($fkImaConfiguracaoDirfIrrfContaReceita)) {
            $fkImaConfiguracaoDirfIrrfContaReceita->setFkImaConfiguracaoDirf($this);
            $this->fkImaConfiguracaoDirfIrrfContaReceitas->add($fkImaConfiguracaoDirfIrrfContaReceita);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ImaConfiguracaoDirfIrrfContaReceita
     *
     * @param \Urbem\CoreBundle\Entity\Ima\ConfiguracaoDirfIrrfContaReceita $fkImaConfiguracaoDirfIrrfContaReceita
     */
    public function removeFkImaConfiguracaoDirfIrrfContaReceitas(\Urbem\CoreBundle\Entity\Ima\ConfiguracaoDirfIrrfContaReceita $fkImaConfiguracaoDirfIrrfContaReceita)
    {
        $this->fkImaConfiguracaoDirfIrrfContaReceitas->removeElement($fkImaConfiguracaoDirfIrrfContaReceita);
    }

    /**
     * OneToMany (owning side)
     * Get fkImaConfiguracaoDirfIrrfContaReceitas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ima\ConfiguracaoDirfIrrfContaReceita
     */
    public function getFkImaConfiguracaoDirfIrrfContaReceitas()
    {
        return $this->fkImaConfiguracaoDirfIrrfContaReceitas;
    }

    /**
     * OneToMany (owning side)
     * Add ImaConfiguracaoDirfPlano
     *
     * @param \Urbem\CoreBundle\Entity\Ima\ConfiguracaoDirfPlano $fkImaConfiguracaoDirfPlano
     * @return ConfiguracaoDirf
     */
    public function addFkImaConfiguracaoDirfPlanos(\Urbem\CoreBundle\Entity\Ima\ConfiguracaoDirfPlano $fkImaConfiguracaoDirfPlano)
    {
        if (false === $this->fkImaConfiguracaoDirfPlanos->contains($fkImaConfiguracaoDirfPlano)) {
            $fkImaConfiguracaoDirfPlano->setFkImaConfiguracaoDirf($this);
            $this->fkImaConfiguracaoDirfPlanos->add($fkImaConfiguracaoDirfPlano);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ImaConfiguracaoDirfPlano
     *
     * @param \Urbem\CoreBundle\Entity\Ima\ConfiguracaoDirfPlano $fkImaConfiguracaoDirfPlano
     */
    public function removeFkImaConfiguracaoDirfPlanos(\Urbem\CoreBundle\Entity\Ima\ConfiguracaoDirfPlano $fkImaConfiguracaoDirfPlano)
    {
        $this->fkImaConfiguracaoDirfPlanos->removeElement($fkImaConfiguracaoDirfPlano);
    }

    /**
     * OneToMany (owning side)
     * Get fkImaConfiguracaoDirfPlanos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ima\ConfiguracaoDirfPlano
     */
    public function getFkImaConfiguracaoDirfPlanos()
    {
        return $this->fkImaConfiguracaoDirfPlanos;
    }

    /**
     * OneToMany (owning side)
     * Add ImaConfiguracaoDirfIrrfPlanoConta
     *
     * @param \Urbem\CoreBundle\Entity\Ima\ConfiguracaoDirfIrrfPlanoConta $fkImaConfiguracaoDirfIrrfPlanoConta
     * @return ConfiguracaoDirf
     */
    public function addFkImaConfiguracaoDirfIrrfPlanoContas(\Urbem\CoreBundle\Entity\Ima\ConfiguracaoDirfIrrfPlanoConta $fkImaConfiguracaoDirfIrrfPlanoConta)
    {
        if (false === $this->fkImaConfiguracaoDirfIrrfPlanoContas->contains($fkImaConfiguracaoDirfIrrfPlanoConta)) {
            $fkImaConfiguracaoDirfIrrfPlanoConta->setFkImaConfiguracaoDirf($this);
            $this->fkImaConfiguracaoDirfIrrfPlanoContas->add($fkImaConfiguracaoDirfIrrfPlanoConta);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ImaConfiguracaoDirfIrrfPlanoConta
     *
     * @param \Urbem\CoreBundle\Entity\Ima\ConfiguracaoDirfIrrfPlanoConta $fkImaConfiguracaoDirfIrrfPlanoConta
     */
    public function removeFkImaConfiguracaoDirfIrrfPlanoContas(\Urbem\CoreBundle\Entity\Ima\ConfiguracaoDirfIrrfPlanoConta $fkImaConfiguracaoDirfIrrfPlanoConta)
    {
        $this->fkImaConfiguracaoDirfIrrfPlanoContas->removeElement($fkImaConfiguracaoDirfIrrfPlanoConta);
    }

    /**
     * OneToMany (owning side)
     * Get fkImaConfiguracaoDirfIrrfPlanoContas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ima\ConfiguracaoDirfIrrfPlanoConta
     */
    public function getFkImaConfiguracaoDirfIrrfPlanoContas()
    {
        return $this->fkImaConfiguracaoDirfIrrfPlanoContas;
    }

    /**
     * OneToMany (owning side)
     * Add ImaConfiguracaoDirfPrestador
     *
     * @param \Urbem\CoreBundle\Entity\Ima\ConfiguracaoDirfPrestador $fkImaConfiguracaoDirfPrestador
     * @return ConfiguracaoDirf
     */
    public function addFkImaConfiguracaoDirfPrestadores(\Urbem\CoreBundle\Entity\Ima\ConfiguracaoDirfPrestador $fkImaConfiguracaoDirfPrestador)
    {
        if (false === $this->fkImaConfiguracaoDirfPrestadores->contains($fkImaConfiguracaoDirfPrestador)) {
            $fkImaConfiguracaoDirfPrestador->setFkImaConfiguracaoDirf($this);
            $this->fkImaConfiguracaoDirfPrestadores->add($fkImaConfiguracaoDirfPrestador);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ImaConfiguracaoDirfPrestador
     *
     * @param \Urbem\CoreBundle\Entity\Ima\ConfiguracaoDirfPrestador $fkImaConfiguracaoDirfPrestador
     */
    public function removeFkImaConfiguracaoDirfPrestadores(\Urbem\CoreBundle\Entity\Ima\ConfiguracaoDirfPrestador $fkImaConfiguracaoDirfPrestador)
    {
        $this->fkImaConfiguracaoDirfPrestadores->removeElement($fkImaConfiguracaoDirfPrestador);
    }

    /**
     * OneToMany (owning side)
     * Get fkImaConfiguracaoDirfPrestadores
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ima\ConfiguracaoDirfPrestador
     */
    public function getFkImaConfiguracaoDirfPrestadores()
    {
        return $this->fkImaConfiguracaoDirfPrestadores;
    }

    /**
     * OneToMany (owning side)
     * Add ImaConfiguracaoDirfInss
     *
     * @param \Urbem\CoreBundle\Entity\Ima\ConfiguracaoDirfInss $fkImaConfiguracaoDirfInss
     * @return ConfiguracaoDirf
     */
    public function addFkImaConfiguracaoDirfInss(\Urbem\CoreBundle\Entity\Ima\ConfiguracaoDirfInss $fkImaConfiguracaoDirfInss)
    {
        if (false === $this->fkImaConfiguracaoDirfInss->contains($fkImaConfiguracaoDirfInss)) {
            $fkImaConfiguracaoDirfInss->setFkImaConfiguracaoDirf($this);
            $this->fkImaConfiguracaoDirfInss->add($fkImaConfiguracaoDirfInss);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ImaConfiguracaoDirfInss
     *
     * @param \Urbem\CoreBundle\Entity\Ima\ConfiguracaoDirfInss $fkImaConfiguracaoDirfInss
     */
    public function removeFkImaConfiguracaoDirfInss(\Urbem\CoreBundle\Entity\Ima\ConfiguracaoDirfInss $fkImaConfiguracaoDirfInss)
    {
        $this->fkImaConfiguracaoDirfInss->removeElement($fkImaConfiguracaoDirfInss);
    }

    /**
     * OneToMany (owning side)
     * Get fkImaConfiguracaoDirfInss
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ima\ConfiguracaoDirfInss
     */
    public function getFkImaConfiguracaoDirfInss()
    {
        return $this->fkImaConfiguracaoDirfInss;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkImaNaturezaEstabelecimento
     *
     * @param \Urbem\CoreBundle\Entity\Ima\NaturezaEstabelecimento $fkImaNaturezaEstabelecimento
     * @return ConfiguracaoDirf
     */
    public function setFkImaNaturezaEstabelecimento(\Urbem\CoreBundle\Entity\Ima\NaturezaEstabelecimento $fkImaNaturezaEstabelecimento)
    {
        $this->codNatureza = $fkImaNaturezaEstabelecimento->getCodNatureza();
        $this->fkImaNaturezaEstabelecimento = $fkImaNaturezaEstabelecimento;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkImaNaturezaEstabelecimento
     *
     * @return \Urbem\CoreBundle\Entity\Ima\NaturezaEstabelecimento
     */
    public function getFkImaNaturezaEstabelecimento()
    {
        return $this->fkImaNaturezaEstabelecimento;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkSwCgm
     *
     * @param \Urbem\CoreBundle\Entity\SwCgm $fkSwCgm
     * @return ConfiguracaoDirf
     */
    public function setFkSwCgm(\Urbem\CoreBundle\Entity\SwCgm $fkSwCgm)
    {
        $this->responsavelPrefeitura = $fkSwCgm->getNumcgm();
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
     * Set fkFolhapagamentoEvento
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\Evento $fkFolhapagamentoEvento
     * @return ConfiguracaoDirf
     */
    public function setFkFolhapagamentoEvento(\Urbem\CoreBundle\Entity\Folhapagamento\Evento $fkFolhapagamentoEvento)
    {
        $this->codEventoMolestia = $fkFolhapagamentoEvento->getCodEvento();
        $this->fkFolhapagamentoEvento = $fkFolhapagamentoEvento;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkFolhapagamentoEvento
     *
     * @return \Urbem\CoreBundle\Entity\Folhapagamento\Evento
     */
    public function getFkFolhapagamentoEvento()
    {
        return $this->fkFolhapagamentoEvento;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkSwCgm1
     *
     * @param \Urbem\CoreBundle\Entity\SwCgm $fkSwCgm1
     * @return ConfiguracaoDirf
     */
    public function setFkSwCgm1(\Urbem\CoreBundle\Entity\SwCgm $fkSwCgm1)
    {
        $this->responsavelEntrega = $fkSwCgm1->getNumcgm();
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
}
