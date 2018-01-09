<?php
 
namespace Urbem\CoreBundle\Entity\Stn;

/**
 * VinculoRecursoAcao
 */
class VinculoRecursoAcao
{
    /**
     * @var string
     */
    private $exercicio;

    /**
     * @var integer
     */
    private $codEntidade;

    /**
     * @var integer
     */
    private $numOrgao;

    /**
     * @var integer
     */
    private $numUnidade;

    /**
     * @var integer
     */
    private $codRecurso;

    /**
     * @var integer
     */
    private $codVinculo;

    /**
     * @var integer
     */
    private $codTipo;

    /**
     * @var integer
     */
    private $codAcao;

    /**
     * @var integer
     */
    private $codTipoEducacao;

    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return vinculoRecursoAcao
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
     * Set codEntidade
     *
     * @param integer $codEntidade
     * @return vinculoRecursoAcao
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
     * Set numOrgao
     *
     * @param integer $numOrgao
     * @return vinculoRecursoAcao
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
     * Set numUnidade
     *
     * @param integer $numUnidade
     * @return vinculoRecursoAcao
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
     * Set codRecurso
     *
     * @param integer $codRecurso
     * @return vinculoRecursoAcao
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
     * Set codVinculo
     *
     * @param integer $codVinculo
     * @return vinculoRecursoAcao
     */
    public function setCodVinculo($codVinculo)
    {
        $this->codVinculo = $codVinculo;
        return $this;
    }

    /**
     * Get codVinculo
     *
     * @return integer
     */
    public function getCodVinculo()
    {
        return $this->codVinculo;
    }

    /**
     * Set codTipo
     *
     * @param integer $codTipo
     * @return vinculoRecursoAcao
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
     * Set codAcao
     *
     * @param integer $codAcao
     * @return vinculoRecursoAcao
     */
    public function setCodAcao($codAcao)
    {
        $this->codAcao = $codAcao;
        return $this;
    }

    /**
     * Get codAcao
     *
     * @return integer
     */
    public function getCodAcao()
    {
        return $this->codAcao;
    }

    /**
     * Set codTipoEducacao
     *
     * @param integer $codTipoEducacao
     * @return vinculoRecursoAcao
     */
    public function setCodTipoEducacao($codTipoEducacao)
    {
        $this->codTipoEducacao = $codTipoEducacao;
        return $this;
    }

    /**
     * Get codTipoEducacao
     *
     * @return integer
     */
    public function getCodTipoEducacao()
    {
        return $this->codTipoEducacao;
    }
}
