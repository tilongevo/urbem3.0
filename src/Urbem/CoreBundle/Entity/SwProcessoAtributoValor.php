<?php
 
namespace Urbem\CoreBundle\Entity;

/**
 * SwProcessoAtributoValor
 */
class SwProcessoAtributoValor
{
    /**
     * PK
     * @var integer
     */
    private $codAtributo;

    /**
     * PK
     * @var integer
     */
    private $codProcesso;

    /**
     * PK
     * @var string
     */
    private $anoExercicio;

    /**
     * @var string
     */
    private $valor;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\SwAtributoProtocolo
     */
    private $fkSwAtributoProtocolo;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\SwProcesso
     */
    private $fkSwProcesso;


    /**
     * Set codAtributo
     *
     * @param integer $codAtributo
     * @return SwProcessoAtributoValor
     */
    public function setCodAtributo($codAtributo)
    {
        $this->codAtributo = $codAtributo;
        return $this;
    }

    /**
     * Get codAtributo
     *
     * @return integer
     */
    public function getCodAtributo()
    {
        return $this->codAtributo;
    }

    /**
     * Set codProcesso
     *
     * @param integer $codProcesso
     * @return SwProcessoAtributoValor
     */
    public function setCodProcesso($codProcesso)
    {
        $this->codProcesso = $codProcesso;
        return $this;
    }

    /**
     * Get codProcesso
     *
     * @return integer
     */
    public function getCodProcesso()
    {
        return $this->codProcesso;
    }

    /**
     * Set anoExercicio
     *
     * @param string $anoExercicio
     * @return SwProcessoAtributoValor
     */
    public function setAnoExercicio($anoExercicio)
    {
        $this->anoExercicio = $anoExercicio;
        return $this;
    }

    /**
     * Get anoExercicio
     *
     * @return string
     */
    public function getAnoExercicio()
    {
        return $this->anoExercicio;
    }

    /**
     * Set valor
     *
     * @param string $valor
     * @return SwProcessoAtributoValor
     */
    public function setValor($valor = null)
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
     * Set fkSwAtributoProtocolo
     *
     * @param \Urbem\CoreBundle\Entity\SwAtributoProtocolo $fkSwAtributoProtocolo
     * @return SwProcessoAtributoValor
     */
    public function setFkSwAtributoProtocolo(\Urbem\CoreBundle\Entity\SwAtributoProtocolo $fkSwAtributoProtocolo)
    {
        $this->codAtributo = $fkSwAtributoProtocolo->getCodAtributo();
        $this->fkSwAtributoProtocolo = $fkSwAtributoProtocolo;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkSwAtributoProtocolo
     *
     * @return \Urbem\CoreBundle\Entity\SwAtributoProtocolo
     */
    public function getFkSwAtributoProtocolo()
    {
        return $this->fkSwAtributoProtocolo;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkSwProcesso
     *
     * @param \Urbem\CoreBundle\Entity\SwProcesso $fkSwProcesso
     * @return SwProcessoAtributoValor
     */
    public function setFkSwProcesso(\Urbem\CoreBundle\Entity\SwProcesso $fkSwProcesso)
    {
        $this->codProcesso = $fkSwProcesso->getCodProcesso();
        $this->anoExercicio = $fkSwProcesso->getAnoExercicio();
        $this->fkSwProcesso = $fkSwProcesso;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkSwProcesso
     *
     * @return \Urbem\CoreBundle\Entity\SwProcesso
     */
    public function getFkSwProcesso()
    {
        return $this->fkSwProcesso;
    }
}
