<?php
 
namespace Urbem\CoreBundle\Entity;

/**
 * SwAssuntoAtributoValor
 */
class SwAssuntoAtributoValor
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
    private $codAssunto;

    /**
     * PK
     * @var integer
     */
    private $codClassificacao;

    /**
     * PK
     * @var integer
     */
    private $codProcesso;

    /**
     * PK
     * @var string
     */
    private $exercicio;

    /**
     * @var string
     */
    private $valor;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\SwAssuntoAtributo
     */
    private $fkSwAssuntoAtributo;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\SwProcesso
     */
    private $fkSwProcesso;


    /**
     * Set codAtributo
     *
     * @param integer $codAtributo
     * @return SwAssuntoAtributoValor
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
     * Set codAssunto
     *
     * @param integer $codAssunto
     * @return SwAssuntoAtributoValor
     */
    public function setCodAssunto($codAssunto)
    {
        $this->codAssunto = $codAssunto;
        return $this;
    }

    /**
     * Get codAssunto
     *
     * @return integer
     */
    public function getCodAssunto()
    {
        return $this->codAssunto;
    }

    /**
     * Set codClassificacao
     *
     * @param integer $codClassificacao
     * @return SwAssuntoAtributoValor
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
     * Set codProcesso
     *
     * @param integer $codProcesso
     * @return SwAssuntoAtributoValor
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
     * Set exercicio
     *
     * @param string $exercicio
     * @return SwAssuntoAtributoValor
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
     * Set valor
     *
     * @param string $valor
     * @return SwAssuntoAtributoValor
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
     * Set fkSwAssuntoAtributo
     *
     * @param \Urbem\CoreBundle\Entity\SwAssuntoAtributo $fkSwAssuntoAtributo
     * @return SwAssuntoAtributoValor
     */
    public function setFkSwAssuntoAtributo(\Urbem\CoreBundle\Entity\SwAssuntoAtributo $fkSwAssuntoAtributo)
    {
        $this->codAtributo = $fkSwAssuntoAtributo->getCodAtributo();
        $this->codAssunto = $fkSwAssuntoAtributo->getCodAssunto();
        $this->codClassificacao = $fkSwAssuntoAtributo->getCodClassificacao();
        $this->fkSwAssuntoAtributo = $fkSwAssuntoAtributo;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkSwAssuntoAtributo
     *
     * @return \Urbem\CoreBundle\Entity\SwAssuntoAtributo
     */
    public function getFkSwAssuntoAtributo()
    {
        return $this->fkSwAssuntoAtributo;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkSwProcesso
     *
     * @param \Urbem\CoreBundle\Entity\SwProcesso $fkSwProcesso
     * @return SwAssuntoAtributoValor
     */
    public function setFkSwProcesso(\Urbem\CoreBundle\Entity\SwProcesso $fkSwProcesso)
    {
        $this->codProcesso = $fkSwProcesso->getCodProcesso();
        $this->exercicio = $fkSwProcesso->getAnoExercicio();
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
