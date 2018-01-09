<?php
 
namespace Urbem\CoreBundle\Entity\Estagio;

/**
 * EntidadeIntermediadoraEstagio
 */
class EntidadeIntermediadoraEstagio
{
    /**
     * PK
     * @var integer
     */
    private $codCurso;

    /**
     * PK
     * @var integer
     */
    private $codEstagio;

    /**
     * PK
     * @var integer
     */
    private $cgmEstagiario;

    /**
     * PK
     * @var integer
     */
    private $cgmEntidade;

    /**
     * PK
     * @var integer
     */
    private $cgmInstituicaoEnsino;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Estagio\EstagiarioEstagio
     */
    private $fkEstagioEstagiarioEstagio;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Estagio\EntidadeIntermediadora
     */
    private $fkEstagioEntidadeIntermediadora;


    /**
     * Set codCurso
     *
     * @param integer $codCurso
     * @return EntidadeIntermediadoraEstagio
     */
    public function setCodCurso($codCurso)
    {
        $this->codCurso = $codCurso;
        return $this;
    }

    /**
     * Get codCurso
     *
     * @return integer
     */
    public function getCodCurso()
    {
        return $this->codCurso;
    }

    /**
     * Set codEstagio
     *
     * @param integer $codEstagio
     * @return EntidadeIntermediadoraEstagio
     */
    public function setCodEstagio($codEstagio)
    {
        $this->codEstagio = $codEstagio;
        return $this;
    }

    /**
     * Get codEstagio
     *
     * @return integer
     */
    public function getCodEstagio()
    {
        return $this->codEstagio;
    }

    /**
     * Set cgmEstagiario
     *
     * @param integer $cgmEstagiario
     * @return EntidadeIntermediadoraEstagio
     */
    public function setCgmEstagiario($cgmEstagiario)
    {
        $this->cgmEstagiario = $cgmEstagiario;
        return $this;
    }

    /**
     * Get cgmEstagiario
     *
     * @return integer
     */
    public function getCgmEstagiario()
    {
        return $this->cgmEstagiario;
    }

    /**
     * Set cgmEntidade
     *
     * @param integer $cgmEntidade
     * @return EntidadeIntermediadoraEstagio
     */
    public function setCgmEntidade($cgmEntidade)
    {
        $this->cgmEntidade = $cgmEntidade;
        return $this;
    }

    /**
     * Get cgmEntidade
     *
     * @return integer
     */
    public function getCgmEntidade()
    {
        return $this->cgmEntidade;
    }

    /**
     * Set cgmInstituicaoEnsino
     *
     * @param integer $cgmInstituicaoEnsino
     * @return EntidadeIntermediadoraEstagio
     */
    public function setCgmInstituicaoEnsino($cgmInstituicaoEnsino)
    {
        $this->cgmInstituicaoEnsino = $cgmInstituicaoEnsino;
        return $this;
    }

    /**
     * Get cgmInstituicaoEnsino
     *
     * @return integer
     */
    public function getCgmInstituicaoEnsino()
    {
        return $this->cgmInstituicaoEnsino;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkEstagioEstagiarioEstagio
     *
     * @param \Urbem\CoreBundle\Entity\Estagio\EstagiarioEstagio $fkEstagioEstagiarioEstagio
     * @return EntidadeIntermediadoraEstagio
     */
    public function setFkEstagioEstagiarioEstagio(\Urbem\CoreBundle\Entity\Estagio\EstagiarioEstagio $fkEstagioEstagiarioEstagio)
    {
        $this->codEstagio = $fkEstagioEstagiarioEstagio->getCodEstagio();
        $this->cgmEstagiario = $fkEstagioEstagiarioEstagio->getCgmEstagiario();
        $this->codCurso = $fkEstagioEstagiarioEstagio->getCodCurso();
        $this->cgmInstituicaoEnsino = $fkEstagioEstagiarioEstagio->getCgmInstituicaoEnsino();
        $this->fkEstagioEstagiarioEstagio = $fkEstagioEstagiarioEstagio;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkEstagioEstagiarioEstagio
     *
     * @return \Urbem\CoreBundle\Entity\Estagio\EstagiarioEstagio
     */
    public function getFkEstagioEstagiarioEstagio()
    {
        return $this->fkEstagioEstagiarioEstagio;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkEstagioEntidadeIntermediadora
     *
     * @param \Urbem\CoreBundle\Entity\Estagio\EntidadeIntermediadora $fkEstagioEntidadeIntermediadora
     * @return EntidadeIntermediadoraEstagio
     */
    public function setFkEstagioEntidadeIntermediadora(\Urbem\CoreBundle\Entity\Estagio\EntidadeIntermediadora $fkEstagioEntidadeIntermediadora)
    {
        $this->cgmEntidade = $fkEstagioEntidadeIntermediadora->getNumcgm();
        $this->fkEstagioEntidadeIntermediadora = $fkEstagioEntidadeIntermediadora;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkEstagioEntidadeIntermediadora
     *
     * @return \Urbem\CoreBundle\Entity\Estagio\EntidadeIntermediadora
     */
    public function getFkEstagioEntidadeIntermediadora()
    {
        return $this->fkEstagioEntidadeIntermediadora;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        $nom = $this->getFkEstagioEntidadeIntermediadora()->getNumcgm();
        $nom .= ' - '.$this->getFkEstagioEntidadeIntermediadora()->getFkSwCgmPessoaJuridica()->getNomFantasia();
        return (string) $nom;
    }
}
