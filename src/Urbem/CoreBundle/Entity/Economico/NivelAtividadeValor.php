<?php
 
namespace Urbem\CoreBundle\Entity\Economico;

/**
 * NivelAtividadeValor
 */
class NivelAtividadeValor
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
    private $codAtividade;

    /**
     * @var string
     */
    private $valor;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Economico\NivelAtividade
     */
    private $fkEconomicoNivelAtividade;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Economico\Atividade
     */
    private $fkEconomicoAtividade;


    /**
     * Set codNivel
     *
     * @param integer $codNivel
     * @return NivelAtividadeValor
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
     * @return NivelAtividadeValor
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
     * Set codAtividade
     *
     * @param integer $codAtividade
     * @return NivelAtividadeValor
     */
    public function setCodAtividade($codAtividade)
    {
        $this->codAtividade = $codAtividade;
        return $this;
    }

    /**
     * Get codAtividade
     *
     * @return integer
     */
    public function getCodAtividade()
    {
        return $this->codAtividade;
    }

    /**
     * Set valor
     *
     * @param string $valor
     * @return NivelAtividadeValor
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
     * Set fkEconomicoNivelAtividade
     *
     * @param \Urbem\CoreBundle\Entity\Economico\NivelAtividade $fkEconomicoNivelAtividade
     * @return NivelAtividadeValor
     */
    public function setFkEconomicoNivelAtividade(\Urbem\CoreBundle\Entity\Economico\NivelAtividade $fkEconomicoNivelAtividade)
    {
        $this->codNivel = $fkEconomicoNivelAtividade->getCodNivel();
        $this->codVigencia = $fkEconomicoNivelAtividade->getCodVigencia();
        $this->fkEconomicoNivelAtividade = $fkEconomicoNivelAtividade;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkEconomicoNivelAtividade
     *
     * @return \Urbem\CoreBundle\Entity\Economico\NivelAtividade
     */
    public function getFkEconomicoNivelAtividade()
    {
        return $this->fkEconomicoNivelAtividade;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkEconomicoAtividade
     *
     * @param \Urbem\CoreBundle\Entity\Economico\Atividade $fkEconomicoAtividade
     * @return NivelAtividadeValor
     */
    public function setFkEconomicoAtividade(\Urbem\CoreBundle\Entity\Economico\Atividade $fkEconomicoAtividade)
    {
        $this->codAtividade = $fkEconomicoAtividade->getCodAtividade();
        $this->fkEconomicoAtividade = $fkEconomicoAtividade;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkEconomicoAtividade
     *
     * @return \Urbem\CoreBundle\Entity\Economico\Atividade
     */
    public function getFkEconomicoAtividade()
    {
        return $this->fkEconomicoAtividade;
    }
}
