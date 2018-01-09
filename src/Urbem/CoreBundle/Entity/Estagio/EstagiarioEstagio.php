<?php
 
namespace Urbem\CoreBundle\Entity\Estagio;

/**
 * EstagiarioEstagio
 */
class EstagiarioEstagio
{
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
    private $codCurso;

    /**
     * PK
     * @var integer
     */
    private $cgmInstituicaoEnsino;

    /**
     * @var integer
     */
    private $codOrgao;

    /**
     * @var integer
     */
    private $codGrade;

    /**
     * @var string
     */
    private $vinculoEstagio;

    /**
     * @var \DateTime
     */
    private $dtInicio;

    /**
     * @var \DateTime
     */
    private $dtFinal;

    /**
     * @var \DateTime
     */
    private $dtRenovacao;

    /**
     * @var string
     */
    private $funcao;

    /**
     * @var string
     */
    private $objetivos;

    /**
     * @var string
     */
    private $anoSemestre;

    /**
     * @var string
     */
    private $numeroEstagio;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Estagio\EstagiarioEstagioConta
     */
    private $fkEstagioEstagiarioEstagioConta;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Estagio\EstagiarioEstagioLocal
     */
    private $fkEstagioEstagiarioEstagioLocal;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Estagio\AtributoEstagiarioEstagio
     */
    private $fkEstagioAtributoEstagiarioEstagios;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Estagio\EstagiarioEstagioBolsa
     */
    private $fkEstagioEstagiarioEstagioBolsas;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Estagio\EntidadeIntermediadoraEstagio
     */
    private $fkEstagioEntidadeIntermediadoraEstagios;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Estagio\Estagiario
     */
    private $fkEstagioEstagiario;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Estagio\CursoInstituicaoEnsino
     */
    private $fkEstagioCursoInstituicaoEnsino;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Organograma\Orgao
     */
    private $fkOrganogramaOrgao;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Pessoal\GradeHorario
     */
    private $fkPessoalGradeHorario;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkEstagioAtributoEstagiarioEstagios = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkEstagioEstagiarioEstagioBolsas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkEstagioEntidadeIntermediadoraEstagios = new \Doctrine\Common\Collections\ArrayCollection();
        $this->dtInicio = new \DateTime;
    }

    /**
     * Set codEstagio
     *
     * @param integer $codEstagio
     * @return EstagiarioEstagio
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
     * @return EstagiarioEstagio
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
     * Set codCurso
     *
     * @param integer $codCurso
     * @return EstagiarioEstagio
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
     * Set cgmInstituicaoEnsino
     *
     * @param integer $cgmInstituicaoEnsino
     * @return EstagiarioEstagio
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
     * Set codOrgao
     *
     * @param integer $codOrgao
     * @return EstagiarioEstagio
     */
    public function setCodOrgao($codOrgao)
    {
        $this->codOrgao = $codOrgao;
        return $this;
    }

    /**
     * Get codOrgao
     *
     * @return integer
     */
    public function getCodOrgao()
    {
        return $this->codOrgao;
    }

    /**
     * Set codGrade
     *
     * @param integer $codGrade
     * @return EstagiarioEstagio
     */
    public function setCodGrade($codGrade)
    {
        $this->codGrade = $codGrade;
        return $this;
    }

    /**
     * Get codGrade
     *
     * @return integer
     */
    public function getCodGrade()
    {
        return $this->codGrade;
    }

    /**
     * Set vinculoEstagio
     *
     * @param string $vinculoEstagio
     * @return EstagiarioEstagio
     */
    public function setVinculoEstagio($vinculoEstagio)
    {
        $this->vinculoEstagio = $vinculoEstagio;
        return $this;
    }

    /**
     * Get vinculoEstagio
     *
     * @return string
     */
    public function getVinculoEstagio()
    {
        return $this->vinculoEstagio;
    }

    /**
     * Set dtInicio
     *
     * @param \DateTime $dtInicio
     * @return EstagiarioEstagio
     */
    public function setDtInicio(\DateTime $dtInicio)
    {
        $this->dtInicio = $dtInicio;
        return $this;
    }

    /**
     * Get dtInicio
     *
     * @return \DateTime
     */
    public function getDtInicio()
    {
        return $this->dtInicio;
    }

    /**
     * Set dtFinal
     *
     * @param \DateTime $dtFinal
     * @return EstagiarioEstagio
     */
    public function setDtFinal(\DateTime $dtFinal = null)
    {
        $this->dtFinal = $dtFinal;
        return $this;
    }

    /**
     * Get dtFinal
     *
     * @return \DateTime
     */
    public function getDtFinal()
    {
        return $this->dtFinal;
    }

    /**
     * Set dtRenovacao
     *
     * @param \DateTime $dtRenovacao
     * @return EstagiarioEstagio
     */
    public function setDtRenovacao(\DateTime $dtRenovacao = null)
    {
        $this->dtRenovacao = $dtRenovacao;
        return $this;
    }

    /**
     * Get dtRenovacao
     *
     * @return \DateTime
     */
    public function getDtRenovacao()
    {
        return $this->dtRenovacao;
    }

    /**
     * Set funcao
     *
     * @param string $funcao
     * @return EstagiarioEstagio
     */
    public function setFuncao($funcao)
    {
        $this->funcao = $funcao;
        return $this;
    }

    /**
     * Get funcao
     *
     * @return string
     */
    public function getFuncao()
    {
        return $this->funcao;
    }

    /**
     * Set objetivos
     *
     * @param string $objetivos
     * @return EstagiarioEstagio
     */
    public function setObjetivos($objetivos = null)
    {
        $this->objetivos = $objetivos;
        return $this;
    }

    /**
     * Get objetivos
     *
     * @return string
     */
    public function getObjetivos()
    {
        return $this->objetivos;
    }

    /**
     * Set anoSemestre
     *
     * @param string $anoSemestre
     * @return EstagiarioEstagio
     */
    public function setAnoSemestre($anoSemestre)
    {
        $this->anoSemestre = $anoSemestre;
        return $this;
    }

    /**
     * Get anoSemestre
     *
     * @return string
     */
    public function getAnoSemestre()
    {
        return $this->anoSemestre;
    }

    /**
     * Set numeroEstagio
     *
     * @param string $numeroEstagio
     * @return EstagiarioEstagio
     */
    public function setNumeroEstagio($numeroEstagio)
    {
        $this->numeroEstagio = $numeroEstagio;
        return $this;
    }

    /**
     * Get numeroEstagio
     *
     * @return string
     */
    public function getNumeroEstagio()
    {
        return $this->numeroEstagio;
    }

    /**
     * OneToMany (owning side)
     * Add EstagioAtributoEstagiarioEstagio
     *
     * @param \Urbem\CoreBundle\Entity\Estagio\AtributoEstagiarioEstagio $fkEstagioAtributoEstagiarioEstagio
     * @return EstagiarioEstagio
     */
    public function addFkEstagioAtributoEstagiarioEstagios(\Urbem\CoreBundle\Entity\Estagio\AtributoEstagiarioEstagio $fkEstagioAtributoEstagiarioEstagio)
    {
        if (false === $this->fkEstagioAtributoEstagiarioEstagios->contains($fkEstagioAtributoEstagiarioEstagio)) {
            $fkEstagioAtributoEstagiarioEstagio->setFkEstagioEstagiarioEstagio($this);
            $this->fkEstagioAtributoEstagiarioEstagios->add($fkEstagioAtributoEstagiarioEstagio);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove EstagioAtributoEstagiarioEstagio
     *
     * @param \Urbem\CoreBundle\Entity\Estagio\AtributoEstagiarioEstagio $fkEstagioAtributoEstagiarioEstagio
     */
    public function removeFkEstagioAtributoEstagiarioEstagios(\Urbem\CoreBundle\Entity\Estagio\AtributoEstagiarioEstagio $fkEstagioAtributoEstagiarioEstagio)
    {
        $this->fkEstagioAtributoEstagiarioEstagios->removeElement($fkEstagioAtributoEstagiarioEstagio);
    }

    /**
     * OneToMany (owning side)
     * Get fkEstagioAtributoEstagiarioEstagios
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Estagio\AtributoEstagiarioEstagio
     */
    public function getFkEstagioAtributoEstagiarioEstagios()
    {
        return $this->fkEstagioAtributoEstagiarioEstagios;
    }

    /**
     * OneToMany (owning side)
     * Add EstagioEstagiarioEstagioBolsa
     *
     * @param \Urbem\CoreBundle\Entity\Estagio\EstagiarioEstagioBolsa $fkEstagioEstagiarioEstagioBolsa
     * @return EstagiarioEstagio
     */
    public function addFkEstagioEstagiarioEstagioBolsas(\Urbem\CoreBundle\Entity\Estagio\EstagiarioEstagioBolsa $fkEstagioEstagiarioEstagioBolsa)
    {
        if (false === $this->fkEstagioEstagiarioEstagioBolsas->contains($fkEstagioEstagiarioEstagioBolsa)) {
            $fkEstagioEstagiarioEstagioBolsa->setFkEstagioEstagiarioEstagio($this);
            $this->fkEstagioEstagiarioEstagioBolsas->add($fkEstagioEstagiarioEstagioBolsa);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove EstagioEstagiarioEstagioBolsa
     *
     * @param \Urbem\CoreBundle\Entity\Estagio\EstagiarioEstagioBolsa $fkEstagioEstagiarioEstagioBolsa
     */
    public function removeFkEstagioEstagiarioEstagioBolsas(\Urbem\CoreBundle\Entity\Estagio\EstagiarioEstagioBolsa $fkEstagioEstagiarioEstagioBolsa)
    {
        $this->fkEstagioEstagiarioEstagioBolsas->removeElement($fkEstagioEstagiarioEstagioBolsa);
    }

    /**
     * OneToMany (owning side)
     * Get fkEstagioEstagiarioEstagioBolsas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Estagio\EstagiarioEstagioBolsa
     */
    public function getFkEstagioEstagiarioEstagioBolsas()
    {
        return $this->fkEstagioEstagiarioEstagioBolsas;
    }

    /**
     * OneToMany (owning side)
     * Add EstagioEntidadeIntermediadoraEstagio
     *
     * @param \Urbem\CoreBundle\Entity\Estagio\EntidadeIntermediadoraEstagio $fkEstagioEntidadeIntermediadoraEstagio
     * @return EstagiarioEstagio
     */
    public function addFkEstagioEntidadeIntermediadoraEstagios(\Urbem\CoreBundle\Entity\Estagio\EntidadeIntermediadoraEstagio $fkEstagioEntidadeIntermediadoraEstagio)
    {
        if (false === $this->fkEstagioEntidadeIntermediadoraEstagios->contains($fkEstagioEntidadeIntermediadoraEstagio)) {
            $fkEstagioEntidadeIntermediadoraEstagio->setFkEstagioEstagiarioEstagio($this);
            $this->fkEstagioEntidadeIntermediadoraEstagios->add($fkEstagioEntidadeIntermediadoraEstagio);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove EstagioEntidadeIntermediadoraEstagio
     *
     * @param \Urbem\CoreBundle\Entity\Estagio\EntidadeIntermediadoraEstagio $fkEstagioEntidadeIntermediadoraEstagio
     */
    public function removeFkEstagioEntidadeIntermediadoraEstagios(\Urbem\CoreBundle\Entity\Estagio\EntidadeIntermediadoraEstagio $fkEstagioEntidadeIntermediadoraEstagio)
    {
        $this->fkEstagioEntidadeIntermediadoraEstagios->removeElement($fkEstagioEntidadeIntermediadoraEstagio);
    }

    /**
     * OneToMany (owning side)
     * Get fkEstagioEntidadeIntermediadoraEstagios
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Estagio\EntidadeIntermediadoraEstagio
     */
    public function getFkEstagioEntidadeIntermediadoraEstagios()
    {
        return $this->fkEstagioEntidadeIntermediadoraEstagios;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkEstagioEstagiario
     *
     * @param \Urbem\CoreBundle\Entity\Estagio\Estagiario $fkEstagioEstagiario
     * @return EstagiarioEstagio
     */
    public function setFkEstagioEstagiario(\Urbem\CoreBundle\Entity\Estagio\Estagiario $fkEstagioEstagiario)
    {
        $this->cgmEstagiario = $fkEstagioEstagiario->getNumcgm();
        $this->fkEstagioEstagiario = $fkEstagioEstagiario;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkEstagioEstagiario
     *
     * @return \Urbem\CoreBundle\Entity\Estagio\Estagiario
     */
    public function getFkEstagioEstagiario()
    {
        return $this->fkEstagioEstagiario;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkEstagioCursoInstituicaoEnsino
     *
     * @param \Urbem\CoreBundle\Entity\Estagio\CursoInstituicaoEnsino $fkEstagioCursoInstituicaoEnsino
     * @return EstagiarioEstagio
     */
    public function setFkEstagioCursoInstituicaoEnsino(\Urbem\CoreBundle\Entity\Estagio\CursoInstituicaoEnsino $fkEstagioCursoInstituicaoEnsino)
    {
        $this->codCurso = $fkEstagioCursoInstituicaoEnsino->getCodCurso();
        $this->cgmInstituicaoEnsino = $fkEstagioCursoInstituicaoEnsino->getNumcgm();
        $this->fkEstagioCursoInstituicaoEnsino = $fkEstagioCursoInstituicaoEnsino;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkEstagioCursoInstituicaoEnsino
     *
     * @return \Urbem\CoreBundle\Entity\Estagio\CursoInstituicaoEnsino
     */
    public function getFkEstagioCursoInstituicaoEnsino()
    {
        return $this->fkEstagioCursoInstituicaoEnsino;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkOrganogramaOrgao
     *
     * @param \Urbem\CoreBundle\Entity\Organograma\Orgao $fkOrganogramaOrgao
     * @return EstagiarioEstagio
     */
    public function setFkOrganogramaOrgao(\Urbem\CoreBundle\Entity\Organograma\Orgao $fkOrganogramaOrgao)
    {
        $this->codOrgao = $fkOrganogramaOrgao->getCodOrgao();
        $this->fkOrganogramaOrgao = $fkOrganogramaOrgao;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkOrganogramaOrgao
     *
     * @return \Urbem\CoreBundle\Entity\Organograma\Orgao
     */
    public function getFkOrganogramaOrgao()
    {
        return $this->fkOrganogramaOrgao;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkPessoalGradeHorario
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\GradeHorario $fkPessoalGradeHorario
     * @return EstagiarioEstagio
     */
    public function setFkPessoalGradeHorario(\Urbem\CoreBundle\Entity\Pessoal\GradeHorario $fkPessoalGradeHorario)
    {
        $this->codGrade = $fkPessoalGradeHorario->getCodGrade();
        $this->fkPessoalGradeHorario = $fkPessoalGradeHorario;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkPessoalGradeHorario
     *
     * @return \Urbem\CoreBundle\Entity\Pessoal\GradeHorario
     */
    public function getFkPessoalGradeHorario()
    {
        return $this->fkPessoalGradeHorario;
    }

    /**
     * OneToOne (inverse side)
     * Set EstagioEstagiarioEstagioConta
     *
     * @param \Urbem\CoreBundle\Entity\Estagio\EstagiarioEstagioConta $fkEstagioEstagiarioEstagioConta
     * @return EstagiarioEstagio
     */
    public function setFkEstagioEstagiarioEstagioConta(\Urbem\CoreBundle\Entity\Estagio\EstagiarioEstagioConta $fkEstagioEstagiarioEstagioConta)
    {
        $fkEstagioEstagiarioEstagioConta->setFkEstagioEstagiarioEstagio($this);
        $this->fkEstagioEstagiarioEstagioConta = $fkEstagioEstagiarioEstagioConta;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkEstagioEstagiarioEstagioConta
     *
     * @return \Urbem\CoreBundle\Entity\Estagio\EstagiarioEstagioConta
     */
    public function getFkEstagioEstagiarioEstagioConta()
    {
        return $this->fkEstagioEstagiarioEstagioConta;
    }

    /**
     * OneToOne (inverse side)
     * Set EstagioEstagiarioEstagioLocal
     *
     * @param \Urbem\CoreBundle\Entity\Estagio\EstagiarioEstagioLocal $fkEstagioEstagiarioEstagioLocal
     * @return EstagiarioEstagio
     */
    public function setFkEstagioEstagiarioEstagioLocal(\Urbem\CoreBundle\Entity\Estagio\EstagiarioEstagioLocal $fkEstagioEstagiarioEstagioLocal)
    {
        $fkEstagioEstagiarioEstagioLocal->setFkEstagioEstagiarioEstagio($this);
        $this->fkEstagioEstagiarioEstagioLocal = $fkEstagioEstagiarioEstagioLocal;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkEstagioEstagiarioEstagioLocal
     *
     * @return \Urbem\CoreBundle\Entity\Estagio\EstagiarioEstagioLocal
     */
    public function getFkEstagioEstagiarioEstagioLocal()
    {
        return $this->fkEstagioEstagiarioEstagioLocal;
    }
}
