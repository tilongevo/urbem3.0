<?php
 
namespace Urbem\CoreBundle\Entity\Tceto;

/**
 * PlanoAnaliticaClassificacao
 */
class PlanoAnaliticaClassificacao
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
    private $codPlano;

    /**
     * @var integer
     */
    private $codClassificacao;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Contabilidade\PlanoAnalitica
     */
    private $fkContabilidadePlanoAnalitica;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Tceto\ClassificacaoReceitaDespesa
     */
    private $fkTcetoClassificacaoReceitaDespesa;


    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return PlanoAnaliticaClassificacao
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
     * Set codPlano
     *
     * @param integer $codPlano
     * @return PlanoAnaliticaClassificacao
     */
    public function setCodPlano($codPlano)
    {
        $this->codPlano = $codPlano;
        return $this;
    }

    /**
     * Get codPlano
     *
     * @return integer
     */
    public function getCodPlano()
    {
        return $this->codPlano;
    }

    /**
     * Set codClassificacao
     *
     * @param integer $codClassificacao
     * @return PlanoAnaliticaClassificacao
     */
    public function setCodClassificacao($codClassificacao)
    {
        $this->codClassificacao = $codClassificacao;
        return $this;
    }

    /**
     * Get codClassificacao
     *
     * @return integer
     */
    public function getCodClassificacao()
    {
        return $this->codClassificacao;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkTcetoClassificacaoReceitaDespesa
     *
     * @param \Urbem\CoreBundle\Entity\Tceto\ClassificacaoReceitaDespesa $fkTcetoClassificacaoReceitaDespesa
     * @return PlanoAnaliticaClassificacao
     */
    public function setFkTcetoClassificacaoReceitaDespesa(\Urbem\CoreBundle\Entity\Tceto\ClassificacaoReceitaDespesa $fkTcetoClassificacaoReceitaDespesa)
    {
        $this->codClassificacao = $fkTcetoClassificacaoReceitaDespesa->getCodClassificacao();
        $this->fkTcetoClassificacaoReceitaDespesa = $fkTcetoClassificacaoReceitaDespesa;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkTcetoClassificacaoReceitaDespesa
     *
     * @return \Urbem\CoreBundle\Entity\Tceto\ClassificacaoReceitaDespesa
     */
    public function getFkTcetoClassificacaoReceitaDespesa()
    {
        return $this->fkTcetoClassificacaoReceitaDespesa;
    }

    /**
     * OneToOne (owning side)
     * Set ContabilidadePlanoAnalitica
     *
     * @param \Urbem\CoreBundle\Entity\Contabilidade\PlanoAnalitica $fkContabilidadePlanoAnalitica
     * @return PlanoAnaliticaClassificacao
     */
    public function setFkContabilidadePlanoAnalitica(\Urbem\CoreBundle\Entity\Contabilidade\PlanoAnalitica $fkContabilidadePlanoAnalitica)
    {
        $this->codPlano = $fkContabilidadePlanoAnalitica->getCodPlano();
        $this->exercicio = $fkContabilidadePlanoAnalitica->getExercicio();
        $this->fkContabilidadePlanoAnalitica = $fkContabilidadePlanoAnalitica;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkContabilidadePlanoAnalitica
     *
     * @return \Urbem\CoreBundle\Entity\Contabilidade\PlanoAnalitica
     */
    public function getFkContabilidadePlanoAnalitica()
    {
        return $this->fkContabilidadePlanoAnalitica;
    }
}
