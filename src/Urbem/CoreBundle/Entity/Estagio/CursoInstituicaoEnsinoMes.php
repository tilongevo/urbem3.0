<?php
 
namespace Urbem\CoreBundle\Entity\Estagio;

/**
 * CursoInstituicaoEnsinoMes
 */
class CursoInstituicaoEnsinoMes
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
    private $codCurso;

    /**
     * @var integer
     */
    private $codMes;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Estagio\CursoInstituicaoEnsino
     */
    private $fkEstagioCursoInstituicaoEnsino;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Administracao\Mes
     */
    private $fkAdministracaoMes;


    /**
     * Set numcgm
     *
     * @param integer $numcgm
     * @return CursoInstituicaoEnsinoMes
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
     * Set codCurso
     *
     * @param integer $codCurso
     * @return CursoInstituicaoEnsinoMes
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
     * Set codMes
     *
     * @param integer $codMes
     * @return CursoInstituicaoEnsinoMes
     */
    public function setCodMes($codMes)
    {
        $this->codMes = $codMes;
        return $this;
    }

    /**
     * Get codMes
     *
     * @return integer
     */
    public function getCodMes()
    {
        return $this->codMes;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkAdministracaoMes
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\Mes $fkAdministracaoMes
     * @return CursoInstituicaoEnsinoMes
     */
    public function setFkAdministracaoMes(\Urbem\CoreBundle\Entity\Administracao\Mes $fkAdministracaoMes)
    {
        $this->codMes = $fkAdministracaoMes->getCodMes();
        $this->fkAdministracaoMes = $fkAdministracaoMes;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkAdministracaoMes
     *
     * @return \Urbem\CoreBundle\Entity\Administracao\Mes
     */
    public function getFkAdministracaoMes()
    {
        return $this->fkAdministracaoMes;
    }

    /**
     * OneToOne (owning side)
     * Set EstagioCursoInstituicaoEnsino
     *
     * @param \Urbem\CoreBundle\Entity\Estagio\CursoInstituicaoEnsino $fkEstagioCursoInstituicaoEnsino
     * @return CursoInstituicaoEnsinoMes
     */
    public function setFkEstagioCursoInstituicaoEnsino(\Urbem\CoreBundle\Entity\Estagio\CursoInstituicaoEnsino $fkEstagioCursoInstituicaoEnsino)
    {
        $this->codCurso = $fkEstagioCursoInstituicaoEnsino->getCodCurso();
        $this->numcgm = $fkEstagioCursoInstituicaoEnsino->getNumcgm();
        $this->fkEstagioCursoInstituicaoEnsino = $fkEstagioCursoInstituicaoEnsino;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkEstagioCursoInstituicaoEnsino
     *
     * @return \Urbem\CoreBundle\Entity\Estagio\CursoInstituicaoEnsino
     */
    public function getFkEstagioCursoInstituicaoEnsino()
    {
        return $this->fkEstagioCursoInstituicaoEnsino;
    }
}
