<?php
 
namespace Urbem\CoreBundle\Entity\Empenho;

/**
 * ContrapartidaAutorizacao
 */
class ContrapartidaAutorizacao
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
     * PK
     * @var integer
     */
    private $codAutorizacao;

    /**
     * @var integer
     */
    private $contaContrapartida;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Empenho\AutorizacaoEmpenho
     */
    private $fkEmpenhoAutorizacaoEmpenho;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Empenho\ContrapartidaResponsavel
     */
    private $fkEmpenhoContrapartidaResponsavel;


    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return ContrapartidaAutorizacao
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
     * @return ContrapartidaAutorizacao
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
     * Set codAutorizacao
     *
     * @param integer $codAutorizacao
     * @return ContrapartidaAutorizacao
     */
    public function setCodAutorizacao($codAutorizacao)
    {
        $this->codAutorizacao = $codAutorizacao;
        return $this;
    }

    /**
     * Get codAutorizacao
     *
     * @return integer
     */
    public function getCodAutorizacao()
    {
        return $this->codAutorizacao;
    }

    /**
     * Set contaContrapartida
     *
     * @param integer $contaContrapartida
     * @return ContrapartidaAutorizacao
     */
    public function setContaContrapartida($contaContrapartida)
    {
        $this->contaContrapartida = $contaContrapartida;
        return $this;
    }

    /**
     * Get contaContrapartida
     *
     * @return integer
     */
    public function getContaContrapartida()
    {
        return $this->contaContrapartida;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkEmpenhoContrapartidaResponsavel
     *
     * @param \Urbem\CoreBundle\Entity\Empenho\ContrapartidaResponsavel $fkEmpenhoContrapartidaResponsavel
     * @return ContrapartidaAutorizacao
     */
    public function setFkEmpenhoContrapartidaResponsavel(\Urbem\CoreBundle\Entity\Empenho\ContrapartidaResponsavel $fkEmpenhoContrapartidaResponsavel)
    {
        $this->exercicio = $fkEmpenhoContrapartidaResponsavel->getExercicio();
        $this->contaContrapartida = $fkEmpenhoContrapartidaResponsavel->getContaContrapartida();
        $this->fkEmpenhoContrapartidaResponsavel = $fkEmpenhoContrapartidaResponsavel;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkEmpenhoContrapartidaResponsavel
     *
     * @return \Urbem\CoreBundle\Entity\Empenho\ContrapartidaResponsavel
     */
    public function getFkEmpenhoContrapartidaResponsavel()
    {
        return $this->fkEmpenhoContrapartidaResponsavel;
    }

    /**
     * OneToOne (owning side)
     * Set EmpenhoAutorizacaoEmpenho
     *
     * @param \Urbem\CoreBundle\Entity\Empenho\AutorizacaoEmpenho $fkEmpenhoAutorizacaoEmpenho
     * @return ContrapartidaAutorizacao
     */
    public function setFkEmpenhoAutorizacaoEmpenho(\Urbem\CoreBundle\Entity\Empenho\AutorizacaoEmpenho $fkEmpenhoAutorizacaoEmpenho)
    {
        $this->codAutorizacao = $fkEmpenhoAutorizacaoEmpenho->getCodAutorizacao();
        $this->exercicio = $fkEmpenhoAutorizacaoEmpenho->getExercicio();
        $this->codEntidade = $fkEmpenhoAutorizacaoEmpenho->getCodEntidade();
        $this->fkEmpenhoAutorizacaoEmpenho = $fkEmpenhoAutorizacaoEmpenho;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkEmpenhoAutorizacaoEmpenho
     *
     * @return \Urbem\CoreBundle\Entity\Empenho\AutorizacaoEmpenho
     */
    public function getFkEmpenhoAutorizacaoEmpenho()
    {
        return $this->fkEmpenhoAutorizacaoEmpenho;
    }
}
