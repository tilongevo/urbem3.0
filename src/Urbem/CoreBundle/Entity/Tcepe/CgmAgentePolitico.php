<?php
 
namespace Urbem\CoreBundle\Entity\Tcepe;

/**
 * CgmAgentePolitico
 */
class CgmAgentePolitico
{
    /**
     * PK
     * @var integer
     */
    private $numcgm;

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
    private $codAgentePolitico;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\SwCgmPessoaFisica
     */
    private $fkSwCgmPessoaFisica;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Orcamento\Entidade
     */
    private $fkOrcamentoEntidade;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Tcepe\AgentePolitico
     */
    private $fkTcepeAgentePolitico;


    /**
     * Set numcgm
     *
     * @param integer $numcgm
     * @return CgmAgentePolitico
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
     * Set exercicio
     *
     * @param string $exercicio
     * @return CgmAgentePolitico
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
     * @return CgmAgentePolitico
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
     * Set codAgentePolitico
     *
     * @param integer $codAgentePolitico
     * @return CgmAgentePolitico
     */
    public function setCodAgentePolitico($codAgentePolitico)
    {
        $this->codAgentePolitico = $codAgentePolitico;
        return $this;
    }

    /**
     * Get codAgentePolitico
     *
     * @return integer
     */
    public function getCodAgentePolitico()
    {
        return $this->codAgentePolitico;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkOrcamentoEntidade
     *
     * @param \Urbem\CoreBundle\Entity\Orcamento\Entidade $fkOrcamentoEntidade
     * @return CgmAgentePolitico
     */
    public function setFkOrcamentoEntidade(\Urbem\CoreBundle\Entity\Orcamento\Entidade $fkOrcamentoEntidade)
    {
        $this->exercicio = $fkOrcamentoEntidade->getExercicio();
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

    /**
     * ManyToOne (inverse side)
     * Set fkTcepeAgentePolitico
     *
     * @param \Urbem\CoreBundle\Entity\Tcepe\AgentePolitico $fkTcepeAgentePolitico
     * @return CgmAgentePolitico
     */
    public function setFkTcepeAgentePolitico(\Urbem\CoreBundle\Entity\Tcepe\AgentePolitico $fkTcepeAgentePolitico)
    {
        $this->codAgentePolitico = $fkTcepeAgentePolitico->getCodAgentePolitico();
        $this->fkTcepeAgentePolitico = $fkTcepeAgentePolitico;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkTcepeAgentePolitico
     *
     * @return \Urbem\CoreBundle\Entity\Tcepe\AgentePolitico
     */
    public function getFkTcepeAgentePolitico()
    {
        return $this->fkTcepeAgentePolitico;
    }

    /**
     * OneToOne (owning side)
     * Set SwCgmPessoaFisica
     *
     * @param \Urbem\CoreBundle\Entity\SwCgmPessoaFisica $fkSwCgmPessoaFisica
     * @return CgmAgentePolitico
     */
    public function setFkSwCgmPessoaFisica(\Urbem\CoreBundle\Entity\SwCgmPessoaFisica $fkSwCgmPessoaFisica)
    {
        $this->numcgm = $fkSwCgmPessoaFisica->getNumcgm();
        $this->fkSwCgmPessoaFisica = $fkSwCgmPessoaFisica;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkSwCgmPessoaFisica
     *
     * @return \Urbem\CoreBundle\Entity\SwCgmPessoaFisica
     */
    public function getFkSwCgmPessoaFisica()
    {
        return $this->fkSwCgmPessoaFisica;
    }
}
