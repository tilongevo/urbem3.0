<?php
 
namespace Urbem\CoreBundle\Entity\Administracao;

/**
 * FormulaElemento
 */
class FormulaElemento
{
    /**
     * PK
     * @var integer
     */
    private $codFormula;

    /**
     * PK
     * @var integer
     */
    private $codElemento;

    /**
     * PK
     * @var integer
     */
    private $codTipoElemento;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Administracao\Formula
     */
    private $fkAdministracaoFormula;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Administracao\Elemento
     */
    private $fkAdministracaoElemento;


    /**
     * Set codFormula
     *
     * @param integer $codFormula
     * @return FormulaElemento
     */
    public function setCodFormula($codFormula)
    {
        $this->codFormula = $codFormula;
        return $this;
    }

    /**
     * Get codFormula
     *
     * @return integer
     */
    public function getCodFormula()
    {
        return $this->codFormula;
    }

    /**
     * Set codElemento
     *
     * @param integer $codElemento
     * @return FormulaElemento
     */
    public function setCodElemento($codElemento)
    {
        $this->codElemento = $codElemento;
        return $this;
    }

    /**
     * Get codElemento
     *
     * @return integer
     */
    public function getCodElemento()
    {
        return $this->codElemento;
    }

    /**
     * Set codTipoElemento
     *
     * @param integer $codTipoElemento
     * @return FormulaElemento
     */
    public function setCodTipoElemento($codTipoElemento)
    {
        $this->codTipoElemento = $codTipoElemento;
        return $this;
    }

    /**
     * Get codTipoElemento
     *
     * @return integer
     */
    public function getCodTipoElemento()
    {
        return $this->codTipoElemento;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkAdministracaoFormula
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\Formula $fkAdministracaoFormula
     * @return FormulaElemento
     */
    public function setFkAdministracaoFormula(\Urbem\CoreBundle\Entity\Administracao\Formula $fkAdministracaoFormula)
    {
        $this->codFormula = $fkAdministracaoFormula->getCodFormula();
        $this->fkAdministracaoFormula = $fkAdministracaoFormula;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkAdministracaoFormula
     *
     * @return \Urbem\CoreBundle\Entity\Administracao\Formula
     */
    public function getFkAdministracaoFormula()
    {
        return $this->fkAdministracaoFormula;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkAdministracaoElemento
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\Elemento $fkAdministracaoElemento
     * @return FormulaElemento
     */
    public function setFkAdministracaoElemento(\Urbem\CoreBundle\Entity\Administracao\Elemento $fkAdministracaoElemento)
    {
        $this->codElemento = $fkAdministracaoElemento->getCodElemento();
        $this->codTipoElemento = $fkAdministracaoElemento->getCodTipo();
        $this->fkAdministracaoElemento = $fkAdministracaoElemento;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkAdministracaoElemento
     *
     * @return \Urbem\CoreBundle\Entity\Administracao\Elemento
     */
    public function getFkAdministracaoElemento()
    {
        return $this->fkAdministracaoElemento;
    }
}
