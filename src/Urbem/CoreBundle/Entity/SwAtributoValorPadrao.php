<?php
 
namespace Urbem\CoreBundle\Entity;

/**
 * SwAtributoValorPadrao
 */
class SwAtributoValorPadrao
{
    /**
     * PK
     * @var integer
     */
    private $codValor;

    /**
     * PK
     * @var integer
     */
    private $codAtributo;

    /**
     * @var boolean
     */
    private $ativo = true;

    /**
     * @var string
     */
    private $valorPadrao;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\SwAtributoDinamico
     */
    private $fkSwAtributoDinamico;


    /**
     * Set codValor
     *
     * @param integer $codValor
     * @return SwAtributoValorPadrao
     */
    public function setCodValor($codValor)
    {
        $this->codValor = $codValor;
        return $this;
    }

    /**
     * Get codValor
     *
     * @return integer
     */
    public function getCodValor()
    {
        return $this->codValor;
    }

    /**
     * Set codAtributo
     *
     * @param integer $codAtributo
     * @return SwAtributoValorPadrao
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
     * Set ativo
     *
     * @param boolean $ativo
     * @return SwAtributoValorPadrao
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
     * Set valorPadrao
     *
     * @param string $valorPadrao
     * @return SwAtributoValorPadrao
     */
    public function setValorPadrao($valorPadrao)
    {
        $this->valorPadrao = $valorPadrao;
        return $this;
    }

    /**
     * Get valorPadrao
     *
     * @return string
     */
    public function getValorPadrao()
    {
        return $this->valorPadrao;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkSwAtributoDinamico
     *
     * @param \Urbem\CoreBundle\Entity\SwAtributoDinamico $fkSwAtributoDinamico
     * @return SwAtributoValorPadrao
     */
    public function setFkSwAtributoDinamico(\Urbem\CoreBundle\Entity\SwAtributoDinamico $fkSwAtributoDinamico)
    {
        $this->codAtributo = $fkSwAtributoDinamico->getCodAtributo();
        $this->fkSwAtributoDinamico = $fkSwAtributoDinamico;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkSwAtributoDinamico
     *
     * @return \Urbem\CoreBundle\Entity\SwAtributoDinamico
     */
    public function getFkSwAtributoDinamico()
    {
        return $this->fkSwAtributoDinamico;
    }
}
