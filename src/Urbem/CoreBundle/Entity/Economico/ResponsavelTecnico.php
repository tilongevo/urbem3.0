<?php
 
namespace Urbem\CoreBundle\Entity\Economico;

/**
 * ResponsavelTecnico
 */
class ResponsavelTecnico
{
    /**
     * PK
     * @var integer
     */
    private $numcgm;

    /**
     * PK
     * @var integer
     */
    private $sequencia;

    /**
     * @var integer
     */
    private $codProfissao;

    /**
     * @var integer
     */
    private $codUf;

    /**
     * @var string
     */
    private $numRegistro;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Economico\ResponsavelEmpresa
     */
    private $fkEconomicoResponsavelEmpresas;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Orcamento\Entidade
     */
    private $fkOrcamentoEntidades;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\SwCgm
     */
    private $fkSwCgm;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Cse\Profissao
     */
    private $fkCseProfissao;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\SwUf
     */
    private $fkSwUf;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkEconomicoResponsavelEmpresas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkOrcamentoEntidades = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set numcgm
     *
     * @param integer $numcgm
     * @return ResponsavelTecnico
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
     * Set sequencia
     *
     * @param integer $sequencia
     * @return ResponsavelTecnico
     */
    public function setSequencia($sequencia)
    {
        $this->sequencia = $sequencia;
        return $this;
    }

    /**
     * Get sequencia
     *
     * @return integer
     */
    public function getSequencia()
    {
        return $this->sequencia;
    }

    /**
     * Set codProfissao
     *
     * @param integer $codProfissao
     * @return ResponsavelTecnico
     */
    public function setCodProfissao($codProfissao)
    {
        $this->codProfissao = $codProfissao;
        return $this;
    }

    /**
     * Get codProfissao
     *
     * @return integer
     */
    public function getCodProfissao()
    {
        return $this->codProfissao;
    }

    /**
     * Set codUf
     *
     * @param integer $codUf
     * @return ResponsavelTecnico
     */
    public function setCodUf($codUf)
    {
        $this->codUf = $codUf;
        return $this;
    }

    /**
     * Get codUf
     *
     * @return integer
     */
    public function getCodUf()
    {
        return $this->codUf;
    }

    /**
     * Set numRegistro
     *
     * @param string $numRegistro
     * @return ResponsavelTecnico
     */
    public function setNumRegistro($numRegistro = null)
    {
        $this->numRegistro = $numRegistro;
        return $this;
    }

    /**
     * Get numRegistro
     *
     * @return string
     */
    public function getNumRegistro()
    {
        return $this->numRegistro;
    }

    /**
     * OneToMany (owning side)
     * Add EconomicoResponsavelEmpresa
     *
     * @param \Urbem\CoreBundle\Entity\Economico\ResponsavelEmpresa $fkEconomicoResponsavelEmpresa
     * @return ResponsavelTecnico
     */
    public function addFkEconomicoResponsavelEmpresas(\Urbem\CoreBundle\Entity\Economico\ResponsavelEmpresa $fkEconomicoResponsavelEmpresa)
    {
        if (false === $this->fkEconomicoResponsavelEmpresas->contains($fkEconomicoResponsavelEmpresa)) {
            $fkEconomicoResponsavelEmpresa->setFkEconomicoResponsavelTecnico($this);
            $this->fkEconomicoResponsavelEmpresas->add($fkEconomicoResponsavelEmpresa);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove EconomicoResponsavelEmpresa
     *
     * @param \Urbem\CoreBundle\Entity\Economico\ResponsavelEmpresa $fkEconomicoResponsavelEmpresa
     */
    public function removeFkEconomicoResponsavelEmpresas(\Urbem\CoreBundle\Entity\Economico\ResponsavelEmpresa $fkEconomicoResponsavelEmpresa)
    {
        $this->fkEconomicoResponsavelEmpresas->removeElement($fkEconomicoResponsavelEmpresa);
    }

    /**
     * OneToMany (owning side)
     * Get fkEconomicoResponsavelEmpresas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Economico\ResponsavelEmpresa
     */
    public function getFkEconomicoResponsavelEmpresas()
    {
        return $this->fkEconomicoResponsavelEmpresas;
    }

    /**
     * OneToMany (owning side)
     * Add OrcamentoEntidade
     *
     * @param \Urbem\CoreBundle\Entity\Orcamento\Entidade $fkOrcamentoEntidade
     * @return ResponsavelTecnico
     */
    public function addFkOrcamentoEntidades(\Urbem\CoreBundle\Entity\Orcamento\Entidade $fkOrcamentoEntidade)
    {
        if (false === $this->fkOrcamentoEntidades->contains($fkOrcamentoEntidade)) {
            $fkOrcamentoEntidade->setFkEconomicoResponsavelTecnico($this);
            $this->fkOrcamentoEntidades->add($fkOrcamentoEntidade);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove OrcamentoEntidade
     *
     * @param \Urbem\CoreBundle\Entity\Orcamento\Entidade $fkOrcamentoEntidade
     */
    public function removeFkOrcamentoEntidades(\Urbem\CoreBundle\Entity\Orcamento\Entidade $fkOrcamentoEntidade)
    {
        $this->fkOrcamentoEntidades->removeElement($fkOrcamentoEntidade);
    }

    /**
     * OneToMany (owning side)
     * Get fkOrcamentoEntidades
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Orcamento\Entidade
     */
    public function getFkOrcamentoEntidades()
    {
        return $this->fkOrcamentoEntidades;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkSwCgm
     *
     * @param \Urbem\CoreBundle\Entity\SwCgm $fkSwCgm
     * @return ResponsavelTecnico
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
     * Set fkCseProfissao
     *
     * @param \Urbem\CoreBundle\Entity\Cse\Profissao $fkCseProfissao
     * @return ResponsavelTecnico
     */
    public function setFkCseProfissao(\Urbem\CoreBundle\Entity\Cse\Profissao $fkCseProfissao)
    {
        $this->codProfissao = $fkCseProfissao->getCodProfissao();
        $this->fkCseProfissao = $fkCseProfissao;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkCseProfissao
     *
     * @return \Urbem\CoreBundle\Entity\Cse\Profissao
     */
    public function getFkCseProfissao()
    {
        return $this->fkCseProfissao;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkSwUf
     *
     * @param \Urbem\CoreBundle\Entity\SwUf $fkSwUf
     * @return ResponsavelTecnico
     */
    public function setFkSwUf(\Urbem\CoreBundle\Entity\SwUf $fkSwUf)
    {
        $this->codUf = $fkSwUf->getCodUf();
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
     * @return string
     */
    public function __toString()
    {
        return (string) $this->fkSwCgm;
    }
}
