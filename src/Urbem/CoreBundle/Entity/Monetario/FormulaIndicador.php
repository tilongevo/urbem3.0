<?php
 
namespace Urbem\CoreBundle\Entity\Monetario;

/**
 * FormulaIndicador
 */
class FormulaIndicador
{
    /**
     * PK
     * @var integer
     */
    private $codIndicador;

    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DatePK
     */
    private $inicioVigencia;

    /**
     * @var integer
     */
    private $codFuncao;

    /**
     * @var integer
     */
    private $codModulo;

    /**
     * @var integer
     */
    private $codBiblioteca;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Monetario\IndicadorEconomico
     */
    private $fkMonetarioIndicadorEconomico;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Administracao\Funcao
     */
    private $fkAdministracaoFuncao;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->inicioVigencia = new \Urbem\CoreBundle\Helper\DatePK;
    }

    /**
     * Set codIndicador
     *
     * @param integer $codIndicador
     * @return FormulaIndicador
     */
    public function setCodIndicador($codIndicador)
    {
        $this->codIndicador = $codIndicador;
        return $this;
    }

    /**
     * Get codIndicador
     *
     * @return integer
     */
    public function getCodIndicador()
    {
        return $this->codIndicador;
    }

    /**
     * Set inicioVigencia
     *
     * @param \Urbem\CoreBundle\Helper\DatePK $inicioVigencia
     * @return FormulaIndicador
     */
    public function setInicioVigencia(\Urbem\CoreBundle\Helper\DatePK $inicioVigencia)
    {
        $this->inicioVigencia = $inicioVigencia;
        return $this;
    }

    /**
     * Get inicioVigencia
     *
     * @return \Urbem\CoreBundle\Helper\DatePK
     */
    public function getInicioVigencia()
    {
        return $this->inicioVigencia;
    }

    /**
     * Set codFuncao
     *
     * @param integer $codFuncao
     * @return FormulaIndicador
     */
    public function setCodFuncao($codFuncao)
    {
        $this->codFuncao = $codFuncao;
        return $this;
    }

    /**
     * Get codFuncao
     *
     * @return integer
     */
    public function getCodFuncao()
    {
        return $this->codFuncao;
    }

    /**
     * Set codModulo
     *
     * @param integer $codModulo
     * @return FormulaIndicador
     */
    public function setCodModulo($codModulo)
    {
        $this->codModulo = $codModulo;
        return $this;
    }

    /**
     * Get codModulo
     *
     * @return integer
     */
    public function getCodModulo()
    {
        return $this->codModulo;
    }

    /**
     * Set codBiblioteca
     *
     * @param integer $codBiblioteca
     * @return FormulaIndicador
     */
    public function setCodBiblioteca($codBiblioteca)
    {
        $this->codBiblioteca = $codBiblioteca;
        return $this;
    }

    /**
     * Get codBiblioteca
     *
     * @return integer
     */
    public function getCodBiblioteca()
    {
        return $this->codBiblioteca;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkMonetarioIndicadorEconomico
     *
     * @param \Urbem\CoreBundle\Entity\Monetario\IndicadorEconomico $fkMonetarioIndicadorEconomico
     * @return FormulaIndicador
     */
    public function setFkMonetarioIndicadorEconomico(\Urbem\CoreBundle\Entity\Monetario\IndicadorEconomico $fkMonetarioIndicadorEconomico)
    {
        $this->codIndicador = $fkMonetarioIndicadorEconomico->getCodIndicador();
        $this->fkMonetarioIndicadorEconomico = $fkMonetarioIndicadorEconomico;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkMonetarioIndicadorEconomico
     *
     * @return \Urbem\CoreBundle\Entity\Monetario\IndicadorEconomico
     */
    public function getFkMonetarioIndicadorEconomico()
    {
        return $this->fkMonetarioIndicadorEconomico;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkAdministracaoFuncao
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\Funcao $fkAdministracaoFuncao
     * @return FormulaIndicador
     */
    public function setFkAdministracaoFuncao(\Urbem\CoreBundle\Entity\Administracao\Funcao $fkAdministracaoFuncao)
    {
        $this->codModulo = $fkAdministracaoFuncao->getCodModulo();
        $this->codBiblioteca = $fkAdministracaoFuncao->getCodBiblioteca();
        $this->codFuncao = $fkAdministracaoFuncao->getCodFuncao();
        $this->fkAdministracaoFuncao = $fkAdministracaoFuncao;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkAdministracaoFuncao
     *
     * @return \Urbem\CoreBundle\Entity\Administracao\Funcao
     */
    public function getFkAdministracaoFuncao()
    {
        return $this->fkAdministracaoFuncao;
    }
}
