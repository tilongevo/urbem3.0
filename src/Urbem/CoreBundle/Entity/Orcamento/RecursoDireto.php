<?php
 
namespace Urbem\CoreBundle\Entity\Orcamento;

/**
 * RecursoDireto
 */
class RecursoDireto
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
    private $codRecurso;

    /**
     * @var string
     */
    private $nomRecurso;

    /**
     * @var string
     */
    private $finalidade;

    /**
     * @var string
     */
    private $tipo = 'V';

    /**
     * @var integer
     */
    private $codFonte;

    /**
     * @var integer
     */
    private $codigoTc;

    /**
     * @var integer
     */
    private $codTipoEsfera;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Orcamento\Recurso
     */
    private $fkOrcamentoRecurso;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Orcamento\FonteRecurso
     */
    private $fkOrcamentoFonteRecurso;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Administracao\Esfera
     */
    private $fkAdministracaoEsfera;


    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return RecursoDireto
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
     * Set codRecurso
     *
     * @param integer $codRecurso
     * @return RecursoDireto
     */
    public function setCodRecurso($codRecurso)
    {
        $this->codRecurso = $codRecurso;
        return $this;
    }

    /**
     * Get codRecurso
     *
     * @return integer
     */
    public function getCodRecurso()
    {
        return $this->codRecurso;
    }

    /**
     * Set nomRecurso
     *
     * @param string $nomRecurso
     * @return RecursoDireto
     */
    public function setNomRecurso($nomRecurso)
    {
        $this->nomRecurso = $nomRecurso;
        return $this;
    }

    /**
     * Get nomRecurso
     *
     * @return string
     */
    public function getNomRecurso()
    {
        return $this->nomRecurso;
    }

    /**
     * Set finalidade
     *
     * @param string $finalidade
     * @return RecursoDireto
     */
    public function setFinalidade($finalidade)
    {
        $this->finalidade = $finalidade;
        return $this;
    }

    /**
     * Get finalidade
     *
     * @return string
     */
    public function getFinalidade()
    {
        return $this->finalidade;
    }

    /**
     * Set tipo
     *
     * @param string $tipo
     * @return RecursoDireto
     */
    public function setTipo($tipo)
    {
        $this->tipo = $tipo;
        return $this;
    }

    /**
     * Get tipo
     *
     * @return string
     */
    public function getTipo()
    {
        return $this->tipo;
    }

    /**
     * Set codFonte
     *
     * @param integer $codFonte
     * @return RecursoDireto
     */
    public function setCodFonte($codFonte)
    {
        $this->codFonte = $codFonte;
        return $this;
    }

    /**
     * Get codFonte
     *
     * @return integer
     */
    public function getCodFonte()
    {
        return $this->codFonte;
    }

    /**
     * Set codigoTc
     *
     * @param integer $codigoTc
     * @return RecursoDireto
     */
    public function setCodigoTc($codigoTc = null)
    {
        $this->codigoTc = $codigoTc;
        return $this;
    }

    /**
     * Get codigoTc
     *
     * @return integer
     */
    public function getCodigoTc()
    {
        return $this->codigoTc;
    }

    /**
     * Set codTipoEsfera
     *
     * @param integer $codTipoEsfera
     * @return RecursoDireto
     */
    public function setCodTipoEsfera($codTipoEsfera = null)
    {
        $this->codTipoEsfera = $codTipoEsfera;
        return $this;
    }

    /**
     * Get codTipoEsfera
     *
     * @return integer
     */
    public function getCodTipoEsfera()
    {
        return $this->codTipoEsfera;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkOrcamentoFonteRecurso
     *
     * @param \Urbem\CoreBundle\Entity\Orcamento\FonteRecurso $fkOrcamentoFonteRecurso
     * @return RecursoDireto
     */
    public function setFkOrcamentoFonteRecurso(\Urbem\CoreBundle\Entity\Orcamento\FonteRecurso $fkOrcamentoFonteRecurso)
    {
        $this->codFonte = $fkOrcamentoFonteRecurso->getCodFonte();
        $this->fkOrcamentoFonteRecurso = $fkOrcamentoFonteRecurso;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkOrcamentoFonteRecurso
     *
     * @return \Urbem\CoreBundle\Entity\Orcamento\FonteRecurso
     */
    public function getFkOrcamentoFonteRecurso()
    {
        return $this->fkOrcamentoFonteRecurso;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkAdministracaoEsfera
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\Esfera $fkAdministracaoEsfera
     * @return RecursoDireto
     */
    public function setFkAdministracaoEsfera(\Urbem\CoreBundle\Entity\Administracao\Esfera $fkAdministracaoEsfera = null)
    {
        $this->codTipoEsfera = ($fkAdministracaoEsfera) ? $fkAdministracaoEsfera->getCodEsfera() : null;
        $this->fkAdministracaoEsfera = $fkAdministracaoEsfera;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkAdministracaoEsfera
     *
     * @return \Urbem\CoreBundle\Entity\Administracao\Esfera
     */
    public function getFkAdministracaoEsfera()
    {
        return $this->fkAdministracaoEsfera;
    }

    /**
     * OneToOne (owning side)
     * Set OrcamentoRecurso
     *
     * @param \Urbem\CoreBundle\Entity\Orcamento\Recurso $fkOrcamentoRecurso
     * @return RecursoDireto
     */
    public function setFkOrcamentoRecurso(\Urbem\CoreBundle\Entity\Orcamento\Recurso $fkOrcamentoRecurso)
    {
        $this->exercicio = $fkOrcamentoRecurso->getExercicio();
        $this->codRecurso = $fkOrcamentoRecurso->getCodRecurso();
        $this->fkOrcamentoRecurso = $fkOrcamentoRecurso;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkOrcamentoRecurso
     *
     * @return \Urbem\CoreBundle\Entity\Orcamento\Recurso
     */
    public function getFkOrcamentoRecurso()
    {
        return $this->fkOrcamentoRecurso;
    }
}
