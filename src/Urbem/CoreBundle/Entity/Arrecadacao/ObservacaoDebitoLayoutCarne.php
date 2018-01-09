<?php
 
namespace Urbem\CoreBundle\Entity\Arrecadacao;

/**
 * ObservacaoDebitoLayoutCarne
 */
class ObservacaoDebitoLayoutCarne
{
    /**
     * PK
     * @var integer
     */
    private $codModelo;

    /**
     * @var string
     */
    private $observacaoDevedor;

    /**
     * @var string
     */
    private $observacaoNaoDevedor;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Arrecadacao\ModeloCarne
     */
    private $fkArrecadacaoModeloCarne;


    /**
     * Set codModelo
     *
     * @param integer $codModelo
     * @return ObservacaoDebitoLayoutCarne
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
     * Set observacaoDevedor
     *
     * @param string $observacaoDevedor
     * @return ObservacaoDebitoLayoutCarne
     */
    public function setObservacaoDevedor($observacaoDevedor)
    {
        $this->observacaoDevedor = $observacaoDevedor;
        return $this;
    }

    /**
     * Get observacaoDevedor
     *
     * @return string
     */
    public function getObservacaoDevedor()
    {
        return $this->observacaoDevedor;
    }

    /**
     * Set observacaoNaoDevedor
     *
     * @param string $observacaoNaoDevedor
     * @return ObservacaoDebitoLayoutCarne
     */
    public function setObservacaoNaoDevedor($observacaoNaoDevedor)
    {
        $this->observacaoNaoDevedor = $observacaoNaoDevedor;
        return $this;
    }

    /**
     * Get observacaoNaoDevedor
     *
     * @return string
     */
    public function getObservacaoNaoDevedor()
    {
        return $this->observacaoNaoDevedor;
    }

    /**
     * OneToOne (owning side)
     * Set ArrecadacaoModeloCarne
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\ModeloCarne $fkArrecadacaoModeloCarne
     * @return ObservacaoDebitoLayoutCarne
     */
    public function setFkArrecadacaoModeloCarne(\Urbem\CoreBundle\Entity\Arrecadacao\ModeloCarne $fkArrecadacaoModeloCarne)
    {
        $this->codModelo = $fkArrecadacaoModeloCarne->getCodModelo();
        $this->fkArrecadacaoModeloCarne = $fkArrecadacaoModeloCarne;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkArrecadacaoModeloCarne
     *
     * @return \Urbem\CoreBundle\Entity\Arrecadacao\ModeloCarne
     */
    public function getFkArrecadacaoModeloCarne()
    {
        return $this->fkArrecadacaoModeloCarne;
    }
}
