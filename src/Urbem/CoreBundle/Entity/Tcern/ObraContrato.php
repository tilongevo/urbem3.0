<?php
 
namespace Urbem\CoreBundle\Entity\Tcern;

/**
 * ObraContrato
 */
class ObraContrato
{
    /**
     * PK
     * @var integer
     */
    private $id;

    /**
     * @var integer
     */
    private $codEntidade;

    /**
     * @var string
     */
    private $exercicio;

    /**
     * @var integer
     */
    private $numObra;

    /**
     * @var string
     */
    private $numContrato;

    /**
     * @var string
     */
    private $servico;

    /**
     * @var string
     */
    private $processoLicitacao;

    /**
     * @var integer
     */
    private $numcgm;

    /**
     * @var integer
     */
    private $valorContrato;

    /**
     * @var integer
     */
    private $valorExecutadoExercicio;

    /**
     * @var integer
     */
    private $valorAExercutar;

    /**
     * @var \DateTime
     */
    private $dtInicioContrato;

    /**
     * @var \DateTime
     */
    private $dtTerminoContrato;

    /**
     * @var integer
     */
    private $numArt;

    /**
     * @var integer
     */
    private $valorIss;

    /**
     * @var integer
     */
    private $numDcms;

    /**
     * @var integer
     */
    private $valorInss;

    /**
     * @var integer
     */
    private $numcgmFiscal;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcern\ObraAditivo
     */
    private $fkTcernObraAditivos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcern\ObraAcompanhamento
     */
    private $fkTcernObraAcompanhamentos;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Tcern\Obra
     */
    private $fkTcernObra;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\SwCgm
     */
    private $fkSwCgm;

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
        $this->fkTcernObraAditivos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTcernObraAcompanhamentos = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set id
     *
     * @param integer $id
     * @return ObraContrato
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set codEntidade
     *
     * @param integer $codEntidade
     * @return ObraContrato
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
     * @return ObraContrato
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
     * Set numObra
     *
     * @param integer $numObra
     * @return ObraContrato
     */
    public function setNumObra($numObra)
    {
        $this->numObra = $numObra;
        return $this;
    }

    /**
     * Get numObra
     *
     * @return integer
     */
    public function getNumObra()
    {
        return $this->numObra;
    }

    /**
     * Set numContrato
     *
     * @param string $numContrato
     * @return ObraContrato
     */
    public function setNumContrato($numContrato)
    {
        $this->numContrato = $numContrato;
        return $this;
    }

    /**
     * Get numContrato
     *
     * @return string
     */
    public function getNumContrato()
    {
        return $this->numContrato;
    }

    /**
     * Set servico
     *
     * @param string $servico
     * @return ObraContrato
     */
    public function setServico($servico)
    {
        $this->servico = $servico;
        return $this;
    }

    /**
     * Get servico
     *
     * @return string
     */
    public function getServico()
    {
        return $this->servico;
    }

    /**
     * Set processoLicitacao
     *
     * @param string $processoLicitacao
     * @return ObraContrato
     */
    public function setProcessoLicitacao($processoLicitacao)
    {
        $this->processoLicitacao = $processoLicitacao;
        return $this;
    }

    /**
     * Get processoLicitacao
     *
     * @return string
     */
    public function getProcessoLicitacao()
    {
        return $this->processoLicitacao;
    }

    /**
     * Set numcgm
     *
     * @param integer $numcgm
     * @return ObraContrato
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
     * Set valorContrato
     *
     * @param integer $valorContrato
     * @return ObraContrato
     */
    public function setValorContrato($valorContrato)
    {
        $this->valorContrato = $valorContrato;
        return $this;
    }

    /**
     * Get valorContrato
     *
     * @return integer
     */
    public function getValorContrato()
    {
        return $this->valorContrato;
    }

    /**
     * Set valorExecutadoExercicio
     *
     * @param integer $valorExecutadoExercicio
     * @return ObraContrato
     */
    public function setValorExecutadoExercicio($valorExecutadoExercicio)
    {
        $this->valorExecutadoExercicio = $valorExecutadoExercicio;
        return $this;
    }

    /**
     * Get valorExecutadoExercicio
     *
     * @return integer
     */
    public function getValorExecutadoExercicio()
    {
        return $this->valorExecutadoExercicio;
    }

    /**
     * Set valorAExercutar
     *
     * @param integer $valorAExercutar
     * @return ObraContrato
     */
    public function setValorAExercutar($valorAExercutar)
    {
        $this->valorAExercutar = $valorAExercutar;
        return $this;
    }

    /**
     * Get valorAExercutar
     *
     * @return integer
     */
    public function getValorAExercutar()
    {
        return $this->valorAExercutar;
    }

    /**
     * Set dtInicioContrato
     *
     * @param \DateTime $dtInicioContrato
     * @return ObraContrato
     */
    public function setDtInicioContrato(\DateTime $dtInicioContrato)
    {
        $this->dtInicioContrato = $dtInicioContrato;
        return $this;
    }

    /**
     * Get dtInicioContrato
     *
     * @return \DateTime
     */
    public function getDtInicioContrato()
    {
        return $this->dtInicioContrato;
    }

    /**
     * Set dtTerminoContrato
     *
     * @param \DateTime $dtTerminoContrato
     * @return ObraContrato
     */
    public function setDtTerminoContrato(\DateTime $dtTerminoContrato)
    {
        $this->dtTerminoContrato = $dtTerminoContrato;
        return $this;
    }

    /**
     * Get dtTerminoContrato
     *
     * @return \DateTime
     */
    public function getDtTerminoContrato()
    {
        return $this->dtTerminoContrato;
    }

    /**
     * Set numArt
     *
     * @param integer $numArt
     * @return ObraContrato
     */
    public function setNumArt($numArt)
    {
        $this->numArt = $numArt;
        return $this;
    }

    /**
     * Get numArt
     *
     * @return integer
     */
    public function getNumArt()
    {
        return $this->numArt;
    }

    /**
     * Set valorIss
     *
     * @param integer $valorIss
     * @return ObraContrato
     */
    public function setValorIss($valorIss)
    {
        $this->valorIss = $valorIss;
        return $this;
    }

    /**
     * Get valorIss
     *
     * @return integer
     */
    public function getValorIss()
    {
        return $this->valorIss;
    }

    /**
     * Set numDcms
     *
     * @param integer $numDcms
     * @return ObraContrato
     */
    public function setNumDcms($numDcms)
    {
        $this->numDcms = $numDcms;
        return $this;
    }

    /**
     * Get numDcms
     *
     * @return integer
     */
    public function getNumDcms()
    {
        return $this->numDcms;
    }

    /**
     * Set valorInss
     *
     * @param integer $valorInss
     * @return ObraContrato
     */
    public function setValorInss($valorInss)
    {
        $this->valorInss = $valorInss;
        return $this;
    }

    /**
     * Get valorInss
     *
     * @return integer
     */
    public function getValorInss()
    {
        return $this->valorInss;
    }

    /**
     * Set numcgmFiscal
     *
     * @param integer $numcgmFiscal
     * @return ObraContrato
     */
    public function setNumcgmFiscal($numcgmFiscal)
    {
        $this->numcgmFiscal = $numcgmFiscal;
        return $this;
    }

    /**
     * Get numcgmFiscal
     *
     * @return integer
     */
    public function getNumcgmFiscal()
    {
        return $this->numcgmFiscal;
    }

    /**
     * OneToMany (owning side)
     * Add TcernObraAditivo
     *
     * @param \Urbem\CoreBundle\Entity\Tcern\ObraAditivo $fkTcernObraAditivo
     * @return ObraContrato
     */
    public function addFkTcernObraAditivos(\Urbem\CoreBundle\Entity\Tcern\ObraAditivo $fkTcernObraAditivo)
    {
        if (false === $this->fkTcernObraAditivos->contains($fkTcernObraAditivo)) {
            $fkTcernObraAditivo->setFkTcernObraContrato($this);
            $this->fkTcernObraAditivos->add($fkTcernObraAditivo);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcernObraAditivo
     *
     * @param \Urbem\CoreBundle\Entity\Tcern\ObraAditivo $fkTcernObraAditivo
     */
    public function removeFkTcernObraAditivos(\Urbem\CoreBundle\Entity\Tcern\ObraAditivo $fkTcernObraAditivo)
    {
        $this->fkTcernObraAditivos->removeElement($fkTcernObraAditivo);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcernObraAditivos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcern\ObraAditivo
     */
    public function getFkTcernObraAditivos()
    {
        return $this->fkTcernObraAditivos;
    }

    /**
     * OneToMany (owning side)
     * Add TcernObraAcompanhamento
     *
     * @param \Urbem\CoreBundle\Entity\Tcern\ObraAcompanhamento $fkTcernObraAcompanhamento
     * @return ObraContrato
     */
    public function addFkTcernObraAcompanhamentos(\Urbem\CoreBundle\Entity\Tcern\ObraAcompanhamento $fkTcernObraAcompanhamento)
    {
        if (false === $this->fkTcernObraAcompanhamentos->contains($fkTcernObraAcompanhamento)) {
            $fkTcernObraAcompanhamento->setFkTcernObraContrato($this);
            $this->fkTcernObraAcompanhamentos->add($fkTcernObraAcompanhamento);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcernObraAcompanhamento
     *
     * @param \Urbem\CoreBundle\Entity\Tcern\ObraAcompanhamento $fkTcernObraAcompanhamento
     */
    public function removeFkTcernObraAcompanhamentos(\Urbem\CoreBundle\Entity\Tcern\ObraAcompanhamento $fkTcernObraAcompanhamento)
    {
        $this->fkTcernObraAcompanhamentos->removeElement($fkTcernObraAcompanhamento);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcernObraAcompanhamentos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcern\ObraAcompanhamento
     */
    public function getFkTcernObraAcompanhamentos()
    {
        return $this->fkTcernObraAcompanhamentos;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkTcernObra
     *
     * @param \Urbem\CoreBundle\Entity\Tcern\Obra $fkTcernObra
     * @return ObraContrato
     */
    public function setFkTcernObra(\Urbem\CoreBundle\Entity\Tcern\Obra $fkTcernObra)
    {
        $this->codEntidade = $fkTcernObra->getCodEntidade();
        $this->exercicio = $fkTcernObra->getExercicio();
        $this->numObra = $fkTcernObra->getNumObra();
        $this->fkTcernObra = $fkTcernObra;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkTcernObra
     *
     * @return \Urbem\CoreBundle\Entity\Tcern\Obra
     */
    public function getFkTcernObra()
    {
        return $this->fkTcernObra;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkSwCgm
     *
     * @param \Urbem\CoreBundle\Entity\SwCgm $fkSwCgm
     * @return ObraContrato
     */
    public function setFkSwCgm(\Urbem\CoreBundle\Entity\SwCgm $fkSwCgm)
    {
        $this->numcgm = $fkSwCgm->getNumcgm();
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
     * Set fkSwCgm1
     *
     * @param \Urbem\CoreBundle\Entity\SwCgm $fkSwCgm1
     * @return ObraContrato
     */
    public function setFkSwCgm1(\Urbem\CoreBundle\Entity\SwCgm $fkSwCgm1)
    {
        $this->numcgmFiscal = $fkSwCgm1->getNumcgm();
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
