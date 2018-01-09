<?php
 
namespace Urbem\CoreBundle\Entity\Tcemg;

/**
 * ProjecaoAtuarial
 */
class ProjecaoAtuarial
{
    const VL_PATRONAL = 'vlPatronal';
    const VL_RECEITA = 'vlReceita';
    const VL_DESPESA = 'vlDespesa';
    const VL_RPPS = 'vlRpps';
    const EXERCICIO = 'exercicio';
    const EXERCICIO_ENTIDADE= 'exercicioEntidade';
    const COD_ENTIDADE = 'codEntidade';

    /**
     * PK
     * @var string
     */
    private $exercicio;

    /**
     * PK
     * @var integer
     */
    private $codEntidade;

    /**
     * PK
     * @var string
     */
    private $exercicioEntidade;

    /**
     * @var integer
     */
    private $vlPatronal;

    /**
     * @var integer
     */
    private $vlReceita;

    /**
     * @var integer
     */
    private $vlDespesa;

    /**
     * @var integer
     */
    private $vlRpps;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Orcamento\Entidade
     */
    private $fkOrcamentoEntidade;


    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return ProjecaoAtuarial
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
     * @return ProjecaoAtuarial
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
     * Set exercicioEntidade
     *
     * @param string $exercicioEntidade
     * @return ProjecaoAtuarial
     */
    public function setExercicioEntidade($exercicioEntidade)
    {
        $this->exercicioEntidade = $exercicioEntidade;
        return $this;
    }

    /**
     * Get exercicioEntidade
     *
     * @return string
     */
    public function getExercicioEntidade()
    {
        return $this->exercicioEntidade;
    }

    /**
     * Set vlPatronal
     *
     * @param integer $vlPatronal
     * @return ProjecaoAtuarial
     */
    public function setVlPatronal($vlPatronal = null)
    {
        $this->vlPatronal = $vlPatronal;
        return $this;
    }

    /**
     * Get vlPatronal
     *
     * @return integer
     */
    public function getVlPatronal()
    {
        return $this->vlPatronal;
    }

    /**
     * Set vlReceita
     *
     * @param integer $vlReceita
     * @return ProjecaoAtuarial
     */
    public function setVlReceita($vlReceita = null)
    {
        $this->vlReceita = $vlReceita;
        return $this;
    }

    /**
     * Get vlReceita
     *
     * @return integer
     */
    public function getVlReceita()
    {
        return $this->vlReceita;
    }

    /**
     * Set vlDespesa
     *
     * @param integer $vlDespesa
     * @return ProjecaoAtuarial
     */
    public function setVlDespesa($vlDespesa = null)
    {
        $this->vlDespesa = $vlDespesa;
        return $this;
    }

    /**
     * Get vlDespesa
     *
     * @return integer
     */
    public function getVlDespesa()
    {
        return $this->vlDespesa;
    }

    /**
     * Set vlRpps
     *
     * @param integer $vlRpps
     * @return ProjecaoAtuarial
     */
    public function setVlRpps($vlRpps = null)
    {
        $this->vlRpps = $vlRpps;
        return $this;
    }

    /**
     * Get vlRpps
     *
     * @return integer
     */
    public function getVlRpps()
    {
        return $this->vlRpps;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkOrcamentoEntidade
     *
     * @param \Urbem\CoreBundle\Entity\Orcamento\Entidade $fkOrcamentoEntidade
     * @return ProjecaoAtuarial
     */
    public function setFkOrcamentoEntidade(\Urbem\CoreBundle\Entity\Orcamento\Entidade $fkOrcamentoEntidade)
    {
        $this->exercicioEntidade = $fkOrcamentoEntidade->getExercicio();
        $this->codEntidade = $fkOrcamentoEntidade->getCodEntidade();
        $this->fkOrcamentoEntidade = $fkOrcamentoEntidade;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkOrcamentoEntidade
     *
     * @return \Urbem\CoreBundle\Entity\Orcamento\Entidade
     */
    public function getFkOrcamentoEntidade()
    {
        return $this->fkOrcamentoEntidade;
    }
}
