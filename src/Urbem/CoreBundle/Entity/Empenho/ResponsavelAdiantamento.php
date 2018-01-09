<?php
 
namespace Urbem\CoreBundle\Entity\Empenho;

/**
 * ResponsavelAdiantamento
 */
class ResponsavelAdiantamento
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
    private $contaContrapartida;

    /**
     * PK
     * @var integer
     */
    private $numcgm;

    /**
     * @var integer
     */
    private $contaLancamento;

    /**
     * @var boolean
     */
    private $ativo;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Contabilidade\PlanoAnalitica
     */
    private $fkContabilidadePlanoAnalitica;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Empenho\ContrapartidaResponsavel
     */
    private $fkEmpenhoContrapartidaResponsavel;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\SwCgm
     */
    private $fkSwCgm;


    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return ResponsavelAdiantamento
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
     * Set contaContrapartida
     *
     * @param integer $contaContrapartida
     * @return ResponsavelAdiantamento
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
     * Set numcgm
     *
     * @param integer $numcgm
     * @return ResponsavelAdiantamento
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
     * Set contaLancamento
     *
     * @param integer $contaLancamento
     * @return ResponsavelAdiantamento
     */
    public function setContaLancamento($contaLancamento)
    {
        $this->contaLancamento = $contaLancamento;
        return $this;
    }

    /**
     * Get contaLancamento
     *
     * @return integer
     */
    public function getContaLancamento()
    {
        return $this->contaLancamento;
    }

    /**
     * Set ativo
     *
     * @param boolean $ativo
     * @return ResponsavelAdiantamento
     */
    public function setAtivo($ativo)
    {
        $this->ativo = $ativo;
        return $this;
    }

    /**
     * Get ativo
     *
     * @return boolean
     */
    public function getAtivo()
    {
        return $this->ativo;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkContabilidadePlanoAnalitica
     *
     * @param \Urbem\CoreBundle\Entity\Contabilidade\PlanoAnalitica $fkContabilidadePlanoAnalitica
     * @return ResponsavelAdiantamento
     */
    public function setFkContabilidadePlanoAnalitica(\Urbem\CoreBundle\Entity\Contabilidade\PlanoAnalitica $fkContabilidadePlanoAnalitica)
    {
        $this->contaLancamento = $fkContabilidadePlanoAnalitica->getCodPlano();
        $this->exercicio = $fkContabilidadePlanoAnalitica->getExercicio();
        $this->fkContabilidadePlanoAnalitica = $fkContabilidadePlanoAnalitica;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkContabilidadePlanoAnalitica
     *
     * @return \Urbem\CoreBundle\Entity\Contabilidade\PlanoAnalitica
     */
    public function getFkContabilidadePlanoAnalitica()
    {
        return $this->fkContabilidadePlanoAnalitica;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkEmpenhoContrapartidaResponsavel
     *
     * @param \Urbem\CoreBundle\Entity\Empenho\ContrapartidaResponsavel $fkEmpenhoContrapartidaResponsavel
     * @return ResponsavelAdiantamento
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
     * ManyToOne (inverse side)
     * Set fkSwCgm
     *
     * @param \Urbem\CoreBundle\Entity\SwCgm $fkSwCgm
     * @return ResponsavelAdiantamento
     */
    public function setFkSwCgm(\Urbem\CoreBundle\Entity\SwCgm $fkSwCgm)
    {
        $this->numcgm = $fkSwCgm->getNumcgm();
        $this->fkSwCgm = $fkSwCgm;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkSwCgm
     *
     * @return \Urbem\CoreBundle\Entity\SwCgm
     */
    public function getFkSwCgm()
    {
        return $this->fkSwCgm;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return sprintf('%s | %s', $this->fkSwCgm, $this->fkContabilidadePlanoAnalitica);
    }
}
