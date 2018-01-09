<?php
 
namespace Urbem\CoreBundle\Entity\Empenho;

/**
 * RestosPreEmpenho
 */
class RestosPreEmpenho
{
    /**
     * PK
     * @var integer
     */
    private $codPreEmpenho;

    /**
     * PK
     * @var string
     */
    private $exercicio;

    /**
     * @var integer
     */
    private $numOrgao = 0;

    /**
     * @var integer
     */
    private $numUnidade = 0;

    /**
     * @var integer
     */
    private $codFuncao = 0;

    /**
     * @var integer
     */
    private $codSubfuncao = 0;

    /**
     * @var integer
     */
    private $codPrograma = 0;

    /**
     * @var integer
     */
    private $numPao = 0;

    /**
     * @var integer
     */
    private $recurso = 0;

    /**
     * @var string
     */
    private $codEstrutural;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Empenho\PreEmpenho
     */
    private $fkEmpenhoPreEmpenho;


    /**
     * Set codPreEmpenho
     *
     * @param integer $codPreEmpenho
     * @return RestosPreEmpenho
     */
    public function setCodPreEmpenho($codPreEmpenho)
    {
        $this->codPreEmpenho = $codPreEmpenho;
        return $this;
    }

    /**
     * Get codPreEmpenho
     *
     * @return integer
     */
    public function getCodPreEmpenho()
    {
        return $this->codPreEmpenho;
    }

    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return RestosPreEmpenho
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
     * Set numOrgao
     *
     * @param integer $numOrgao
     * @return RestosPreEmpenho
     */
    public function setNumOrgao($numOrgao = null)
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
     * @return RestosPreEmpenho
     */
    public function setNumUnidade($numUnidade = null)
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
     * Set codFuncao
     *
     * @param integer $codFuncao
     * @return RestosPreEmpenho
     */
    public function setCodFuncao($codFuncao = null)
    {
        $this->codFuncao = $codFuncao;
        return $this;
    }

    /**
     * Get codFuncao
     *
     * @return integer
     */
    public function getCodFuncao()
    {
        return $this->codFuncao;
    }

    /**
     * Set codSubfuncao
     *
     * @param integer $codSubfuncao
     * @return RestosPreEmpenho
     */
    public function setCodSubfuncao($codSubfuncao = null)
    {
        $this->codSubfuncao = $codSubfuncao;
        return $this;
    }

    /**
     * Get codSubfuncao
     *
     * @return integer
     */
    public function getCodSubfuncao()
    {
        return $this->codSubfuncao;
    }

    /**
     * Set codPrograma
     *
     * @param integer $codPrograma
     * @return RestosPreEmpenho
     */
    public function setCodPrograma($codPrograma = null)
    {
        $this->codPrograma = $codPrograma;
        return $this;
    }

    /**
     * Get codPrograma
     *
     * @return integer
     */
    public function getCodPrograma()
    {
        return $this->codPrograma;
    }

    /**
     * Set numPao
     *
     * @param integer $numPao
     * @return RestosPreEmpenho
     */
    public function setNumPao($numPao = null)
    {
        $this->numPao = $numPao;
        return $this;
    }

    /**
     * Get numPao
     *
     * @return integer
     */
    public function getNumPao()
    {
        return $this->numPao;
    }

    /**
     * Set recurso
     *
     * @param integer $recurso
     * @return RestosPreEmpenho
     */
    public function setRecurso($recurso = null)
    {
        $this->recurso = $recurso;
        return $this;
    }

    /**
     * Get recurso
     *
     * @return integer
     */
    public function getRecurso()
    {
        return $this->recurso;
    }

    /**
     * Set codEstrutural
     *
     * @param string $codEstrutural
     * @return RestosPreEmpenho
     */
    public function setCodEstrutural($codEstrutural = null)
    {
        $this->codEstrutural = $codEstrutural;
        return $this;
    }

    /**
     * Get codEstrutural
     *
     * @return string
     */
    public function getCodEstrutural()
    {
        return $this->codEstrutural;
    }

    /**
     * OneToOne (owning side)
     * Set EmpenhoPreEmpenho
     *
     * @param \Urbem\CoreBundle\Entity\Empenho\PreEmpenho $fkEmpenhoPreEmpenho
     * @return RestosPreEmpenho
     */
    public function setFkEmpenhoPreEmpenho(\Urbem\CoreBundle\Entity\Empenho\PreEmpenho $fkEmpenhoPreEmpenho)
    {
        $this->exercicio = $fkEmpenhoPreEmpenho->getExercicio();
        $this->codPreEmpenho = $fkEmpenhoPreEmpenho->getCodPreEmpenho();
        $this->fkEmpenhoPreEmpenho = $fkEmpenhoPreEmpenho;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkEmpenhoPreEmpenho
     *
     * @return \Urbem\CoreBundle\Entity\Empenho\PreEmpenho
     */
    public function getFkEmpenhoPreEmpenho()
    {
        return $this->fkEmpenhoPreEmpenho;
    }
}
