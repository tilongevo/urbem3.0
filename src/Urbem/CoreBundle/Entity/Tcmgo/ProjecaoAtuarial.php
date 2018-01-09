<?php
 
namespace Urbem\CoreBundle\Entity\Tcmgo;

/**
 * ProjecaoAtuarial
 */
class ProjecaoAtuarial
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
    private $numOrgao;

    /**
     * @var string
     */
    private $exercicioOrgao;

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
    private $vlSaldo;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Orcamento\Orgao
     */
    private $fkOrcamentoOrgao;


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
     * Set numOrgao
     *
     * @param integer $numOrgao
     * @return ProjecaoAtuarial
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
     * Set exercicioOrgao
     *
     * @param string $exercicioOrgao
     * @return ProjecaoAtuarial
     */
    public function setExercicioOrgao($exercicioOrgao)
    {
        $this->exercicioOrgao = $exercicioOrgao;
        return $this;
    }

    /**
     * Get exercicioOrgao
     *
     * @return string
     */
    public function getExercicioOrgao()
    {
        return $this->exercicioOrgao;
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
     * Set vlSaldo
     *
     * @param integer $vlSaldo
     * @return ProjecaoAtuarial
     */
    public function setVlSaldo($vlSaldo = null)
    {
        $this->vlSaldo = $vlSaldo;
        return $this;
    }

    /**
     * Get vlSaldo
     *
     * @return integer
     */
    public function getVlSaldo()
    {
        return $this->vlSaldo;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkOrcamentoOrgao
     *
     * @param \Urbem\CoreBundle\Entity\Orcamento\Orgao $fkOrcamentoOrgao
     * @return ProjecaoAtuarial
     */
    public function setFkOrcamentoOrgao(\Urbem\CoreBundle\Entity\Orcamento\Orgao $fkOrcamentoOrgao)
    {
        $this->exercicioOrgao = $fkOrcamentoOrgao->getExercicio();
        $this->numOrgao = $fkOrcamentoOrgao->getNumOrgao();
        $this->fkOrcamentoOrgao = $fkOrcamentoOrgao;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkOrcamentoOrgao
     *
     * @return \Urbem\CoreBundle\Entity\Orcamento\Orgao
     */
    public function getFkOrcamentoOrgao()
    {
        return $this->fkOrcamentoOrgao;
    }
}
