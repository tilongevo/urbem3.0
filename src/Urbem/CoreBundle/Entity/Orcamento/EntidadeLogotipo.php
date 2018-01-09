<?php
 
namespace Urbem\CoreBundle\Entity\Orcamento;

/**
 * EntidadeLogotipo
 */
class EntidadeLogotipo
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
    private $codEntidade;

    /**
     * @var string
     */
    private $logotipo;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Orcamento\Entidade
     */
    private $fkOrcamentoEntidade;


    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return EntidadeLogotipo
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
     * @return EntidadeLogotipo
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
     * Set logotipo
     *
     * @param string $logotipo
     * @return EntidadeLogotipo
     */
    public function setLogotipo($logotipo)
    {
        $this->logotipo = $logotipo;
        return $this;
    }

    /**
     * Get logotipo
     *
     * @return string
     */
    public function getLogotipo()
    {
        return $this->logotipo;
    }

    /**
     * OneToOne (owning side)
     * Set OrcamentoEntidade
     *
     * @param \Urbem\CoreBundle\Entity\Orcamento\Entidade $fkOrcamentoEntidade
     * @return EntidadeLogotipo
     */
    public function setFkOrcamentoEntidade(\Urbem\CoreBundle\Entity\Orcamento\Entidade $fkOrcamentoEntidade)
    {
        $this->exercicio = $fkOrcamentoEntidade->getExercicio();
        $this->codEntidade = $fkOrcamentoEntidade->getCodEntidade();
        $this->fkOrcamentoEntidade = $fkOrcamentoEntidade;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkOrcamentoEntidade
     *
     * @return \Urbem\CoreBundle\Entity\Orcamento\Entidade
     */
    public function getFkOrcamentoEntidade()
    {
        return $this->fkOrcamentoEntidade;
    }
}
