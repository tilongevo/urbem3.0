<?php
 
namespace Urbem\CoreBundle\Entity\Economico;

/**
 * NivelServicoValor
 */
class NivelServicoValor
{
    /**
     * PK
     * @var integer
     */
    private $codNivel;

    /**
     * PK
     * @var integer
     */
    private $codVigencia;

    /**
     * PK
     * @var integer
     */
    private $codServico;

    /**
     * @var string
     */
    private $valor;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Economico\NivelServico
     */
    private $fkEconomicoNivelServico;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Economico\Servico
     */
    private $fkEconomicoServico;


    /**
     * Set codNivel
     *
     * @param integer $codNivel
     * @return NivelServicoValor
     */
    public function setCodNivel($codNivel)
    {
        $this->codNivel = $codNivel;
        return $this;
    }

    /**
     * Get codNivel
     *
     * @return integer
     */
    public function getCodNivel()
    {
        return $this->codNivel;
    }

    /**
     * Set codVigencia
     *
     * @param integer $codVigencia
     * @return NivelServicoValor
     */
    public function setCodVigencia($codVigencia)
    {
        $this->codVigencia = $codVigencia;
        return $this;
    }

    /**
     * Get codVigencia
     *
     * @return integer
     */
    public function getCodVigencia()
    {
        return $this->codVigencia;
    }

    /**
     * Set codServico
     *
     * @param integer $codServico
     * @return NivelServicoValor
     */
    public function setCodServico($codServico)
    {
        $this->codServico = $codServico;
        return $this;
    }

    /**
     * Get codServico
     *
     * @return integer
     */
    public function getCodServico()
    {
        return $this->codServico;
    }

    /**
     * Set valor
     *
     * @param string $valor
     * @return NivelServicoValor
     */
    public function setValor($valor)
    {
        $this->valor = $valor;
        return $this;
    }

    /**
     * Get valor
     *
     * @return string
     */
    public function getValor()
    {
        return $this->valor;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkEconomicoNivelServico
     *
     * @param \Urbem\CoreBundle\Entity\Economico\NivelServico $fkEconomicoNivelServico
     * @return NivelServicoValor
     */
    public function setFkEconomicoNivelServico(\Urbem\CoreBundle\Entity\Economico\NivelServico $fkEconomicoNivelServico)
    {
        $this->codVigencia = $fkEconomicoNivelServico->getCodVigencia();
        $this->codNivel = $fkEconomicoNivelServico->getCodNivel();
        $this->fkEconomicoNivelServico = $fkEconomicoNivelServico;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkEconomicoNivelServico
     *
     * @return \Urbem\CoreBundle\Entity\Economico\NivelServico
     */
    public function getFkEconomicoNivelServico()
    {
        return $this->fkEconomicoNivelServico;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkEconomicoServico
     *
     * @param \Urbem\CoreBundle\Entity\Economico\Servico $fkEconomicoServico
     * @return NivelServicoValor
     */
    public function setFkEconomicoServico(\Urbem\CoreBundle\Entity\Economico\Servico $fkEconomicoServico)
    {
        $this->codServico = $fkEconomicoServico->getCodServico();
        $this->fkEconomicoServico = $fkEconomicoServico;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkEconomicoServico
     *
     * @return \Urbem\CoreBundle\Entity\Economico\Servico
     */
    public function getFkEconomicoServico()
    {
        return $this->fkEconomicoServico;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return sprintf('%s - %s', $this->getFkEconomicoNivelServico()->getCodNivel(), $this->getFkEconomicoNivelServico()->getNomNivel());
    }
}
