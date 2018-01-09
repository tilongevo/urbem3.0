<?php
 
namespace Urbem\CoreBundle\Entity\Tcern;

/**
 * UnidadeOrcamentaria
 */
class UnidadeOrcamentaria
{
    /**
     * PK
     * @var integer
     */
    private $id;

    /**
     * @var integer
     */
    private $codInstitucional;

    /**
     * @var integer
     */
    private $cgmUnidadeOrcamentaria;

    /**
     * @var integer
     */
    private $codNorma;

    /**
     * @var integer
     */
    private $idUnidadeGestora;

    /**
     * @var boolean
     */
    private $situacao;

    /**
     * @var string
     */
    private $exercicio;

    /**
     * @var integer
     */
    private $numUnidade;

    /**
     * @var integer
     */
    private $numOrgao;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcern\UnidadeOrcamentariaResponsavel
     */
    private $fkTcernUnidadeOrcamentariaResponsaveis;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\SwCgm
     */
    private $fkSwCgm;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Normas\Norma
     */
    private $fkNormasNorma;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Tcern\UnidadeGestora
     */
    private $fkTcernUnidadeGestora;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Orcamento\Unidade
     */
    private $fkOrcamentoUnidade;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkTcernUnidadeOrcamentariaResponsaveis = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set id
     *
     * @param integer $id
     * @return UnidadeOrcamentaria
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
     * Set codInstitucional
     *
     * @param integer $codInstitucional
     * @return UnidadeOrcamentaria
     */
    public function setCodInstitucional($codInstitucional)
    {
        $this->codInstitucional = $codInstitucional;
        return $this;
    }

    /**
     * Get codInstitucional
     *
     * @return integer
     */
    public function getCodInstitucional()
    {
        return $this->codInstitucional;
    }

    /**
     * Set cgmUnidadeOrcamentaria
     *
     * @param integer $cgmUnidadeOrcamentaria
     * @return UnidadeOrcamentaria
     */
    public function setCgmUnidadeOrcamentaria($cgmUnidadeOrcamentaria)
    {
        $this->cgmUnidadeOrcamentaria = $cgmUnidadeOrcamentaria;
        return $this;
    }

    /**
     * Get cgmUnidadeOrcamentaria
     *
     * @return integer
     */
    public function getCgmUnidadeOrcamentaria()
    {
        return $this->cgmUnidadeOrcamentaria;
    }

    /**
     * Set codNorma
     *
     * @param integer $codNorma
     * @return UnidadeOrcamentaria
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
     * Set idUnidadeGestora
     *
     * @param integer $idUnidadeGestora
     * @return UnidadeOrcamentaria
     */
    public function setIdUnidadeGestora($idUnidadeGestora)
    {
        $this->idUnidadeGestora = $idUnidadeGestora;
        return $this;
    }

    /**
     * Get idUnidadeGestora
     *
     * @return integer
     */
    public function getIdUnidadeGestora()
    {
        return $this->idUnidadeGestora;
    }

    /**
     * Set situacao
     *
     * @param boolean $situacao
     * @return UnidadeOrcamentaria
     */
    public function setSituacao($situacao)
    {
        $this->situacao = $situacao;
        return $this;
    }

    /**
     * Get situacao
     *
     * @return boolean
     */
    public function getSituacao()
    {
        return $this->situacao;
    }

    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return UnidadeOrcamentaria
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
     * @return UnidadeOrcamentaria
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
     * @return UnidadeOrcamentaria
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
     * OneToMany (owning side)
     * Add TcernUnidadeOrcamentariaResponsavel
     *
     * @param \Urbem\CoreBundle\Entity\Tcern\UnidadeOrcamentariaResponsavel $fkTcernUnidadeOrcamentariaResponsavel
     * @return UnidadeOrcamentaria
     */
    public function addFkTcernUnidadeOrcamentariaResponsaveis(\Urbem\CoreBundle\Entity\Tcern\UnidadeOrcamentariaResponsavel $fkTcernUnidadeOrcamentariaResponsavel)
    {
        if (false === $this->fkTcernUnidadeOrcamentariaResponsaveis->contains($fkTcernUnidadeOrcamentariaResponsavel)) {
            $fkTcernUnidadeOrcamentariaResponsavel->setFkTcernUnidadeOrcamentaria($this);
            $this->fkTcernUnidadeOrcamentariaResponsaveis->add($fkTcernUnidadeOrcamentariaResponsavel);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcernUnidadeOrcamentariaResponsavel
     *
     * @param \Urbem\CoreBundle\Entity\Tcern\UnidadeOrcamentariaResponsavel $fkTcernUnidadeOrcamentariaResponsavel
     */
    public function removeFkTcernUnidadeOrcamentariaResponsaveis(\Urbem\CoreBundle\Entity\Tcern\UnidadeOrcamentariaResponsavel $fkTcernUnidadeOrcamentariaResponsavel)
    {
        $this->fkTcernUnidadeOrcamentariaResponsaveis->removeElement($fkTcernUnidadeOrcamentariaResponsavel);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcernUnidadeOrcamentariaResponsaveis
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcern\UnidadeOrcamentariaResponsavel
     */
    public function getFkTcernUnidadeOrcamentariaResponsaveis()
    {
        return $this->fkTcernUnidadeOrcamentariaResponsaveis;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkSwCgm
     *
     * @param \Urbem\CoreBundle\Entity\SwCgm $fkSwCgm
     * @return UnidadeOrcamentaria
     */
    public function setFkSwCgm(\Urbem\CoreBundle\Entity\SwCgm $fkSwCgm)
    {
        $this->cgmUnidadeOrcamentaria = $fkSwCgm->getNumcgm();
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
     * Set fkNormasNorma
     *
     * @param \Urbem\CoreBundle\Entity\Normas\Norma $fkNormasNorma
     * @return UnidadeOrcamentaria
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
     * Set fkTcernUnidadeGestora
     *
     * @param \Urbem\CoreBundle\Entity\Tcern\UnidadeGestora $fkTcernUnidadeGestora
     * @return UnidadeOrcamentaria
     */
    public function setFkTcernUnidadeGestora(\Urbem\CoreBundle\Entity\Tcern\UnidadeGestora $fkTcernUnidadeGestora)
    {
        $this->idUnidadeGestora = $fkTcernUnidadeGestora->getId();
        $this->fkTcernUnidadeGestora = $fkTcernUnidadeGestora;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkTcernUnidadeGestora
     *
     * @return \Urbem\CoreBundle\Entity\Tcern\UnidadeGestora
     */
    public function getFkTcernUnidadeGestora()
    {
        return $this->fkTcernUnidadeGestora;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkOrcamentoUnidade
     *
     * @param \Urbem\CoreBundle\Entity\Orcamento\Unidade $fkOrcamentoUnidade
     * @return UnidadeOrcamentaria
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
}
