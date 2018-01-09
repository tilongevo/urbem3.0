<?php
 
namespace Urbem\CoreBundle\Entity\Arrecadacao;

/**
 * ObservacaoLayoutCarne
 */
class ObservacaoLayoutCarne
{
    /**
     * PK
     * @var integer
     */
    private $codModelo;

    /**
     * PK
     * @var boolean
     */
    private $capa;

    /**
     * @var string
     */
    private $observacao;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Arrecadacao\ModeloCarne
     */
    private $fkArrecadacaoModeloCarne;


    /**
     * Set codModelo
     *
     * @param integer $codModelo
     * @return ObservacaoLayoutCarne
     */
    public function setCodModelo($codModelo)
    {
        $this->codModelo = $codModelo;
        return $this;
    }

    /**
     * Get codModelo
     *
     * @return integer
     */
    public function getCodModelo()
    {
        return $this->codModelo;
    }

    /**
     * Set capa
     *
     * @param boolean $capa
     * @return ObservacaoLayoutCarne
     */
    public function setCapa($capa)
    {
        $this->capa = $capa;
        return $this;
    }

    /**
     * Get capa
     *
     * @return boolean
     */
    public function getCapa()
    {
        return $this->capa;
    }

    /**
     * Set observacao
     *
     * @param string $observacao
     * @return ObservacaoLayoutCarne
     */
    public function setObservacao($observacao = null)
    {
        $this->observacao = $observacao;
        return $this;
    }

    /**
     * Get observacao
     *
     * @return string
     */
    public function getObservacao()
    {
        return $this->observacao;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkArrecadacaoModeloCarne
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\ModeloCarne $fkArrecadacaoModeloCarne
     * @return ObservacaoLayoutCarne
     */
    public function setFkArrecadacaoModeloCarne(\Urbem\CoreBundle\Entity\Arrecadacao\ModeloCarne $fkArrecadacaoModeloCarne)
    {
        $this->codModelo = $fkArrecadacaoModeloCarne->getCodModelo();
        $this->fkArrecadacaoModeloCarne = $fkArrecadacaoModeloCarne;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkArrecadacaoModeloCarne
     *
     * @return \Urbem\CoreBundle\Entity\Arrecadacao\ModeloCarne
     */
    public function getFkArrecadacaoModeloCarne()
    {
        return $this->fkArrecadacaoModeloCarne;
    }
}
