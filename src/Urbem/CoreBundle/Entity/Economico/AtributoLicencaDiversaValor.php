<?php
 
namespace Urbem\CoreBundle\Entity\Economico;

/**
 * AtributoLicencaDiversaValor
 */
class AtributoLicencaDiversaValor
{
    /**
     * PK
     * @var integer
     */
    private $codLicenca;

    /**
     * PK
     * @var string
     */
    private $exercicio;

    /**
     * PK
     * @var integer
     */
    private $codTipo;

    /**
     * PK
     * @var integer
     */
    private $codAtributo;

    /**
     * PK
     * @var integer
     */
    private $codCadastro;

    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DateTimePK
     */
    private $timestamp;

    /**
     * PK
     * @var integer
     */
    private $codModulo;

    /**
     * @var string
     */
    private $valor;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Economico\LicencaDiversa
     */
    private $fkEconomicoLicencaDiversa;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Economico\AtributoTipoLicencaDiversa
     */
    private $fkEconomicoAtributoTipoLicencaDiversa;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimePK;
    }

    /**
     * Set codLicenca
     *
     * @param integer $codLicenca
     * @return AtributoLicencaDiversaValor
     */
    public function setCodLicenca($codLicenca)
    {
        $this->codLicenca = $codLicenca;
        return $this;
    }

    /**
     * Get codLicenca
     *
     * @return integer
     */
    public function getCodLicenca()
    {
        return $this->codLicenca;
    }

    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return AtributoLicencaDiversaValor
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
     * Set codTipo
     *
     * @param integer $codTipo
     * @return AtributoLicencaDiversaValor
     */
    public function setCodTipo($codTipo)
    {
        $this->codTipo = $codTipo;
        return $this;
    }

    /**
     * Get codTipo
     *
     * @return integer
     */
    public function getCodTipo()
    {
        return $this->codTipo;
    }

    /**
     * Set codAtributo
     *
     * @param integer $codAtributo
     * @return AtributoLicencaDiversaValor
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
     * Set codCadastro
     *
     * @param integer $codCadastro
     * @return AtributoLicencaDiversaValor
     */
    public function setCodCadastro($codCadastro)
    {
        $this->codCadastro = $codCadastro;
        return $this;
    }

    /**
     * Get codCadastro
     *
     * @return integer
     */
    public function getCodCadastro()
    {
        return $this->codCadastro;
    }

    /**
     * Set timestamp
     *
     * @param \Urbem\CoreBundle\Helper\DateTimePK $timestamp
     * @return AtributoLicencaDiversaValor
     */
    public function setTimestamp(\Urbem\CoreBundle\Helper\DateTimePK $timestamp)
    {
        $this->timestamp = $timestamp;
        return $this;
    }

    /**
     * Get timestamp
     *
     * @return \Urbem\CoreBundle\Helper\DateTimePK
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }

    /**
     * Set codModulo
     *
     * @param integer $codModulo
     * @return AtributoLicencaDiversaValor
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
     * Set valor
     *
     * @param string $valor
     * @return AtributoLicencaDiversaValor
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
     * Set fkEconomicoLicencaDiversa
     *
     * @param \Urbem\CoreBundle\Entity\Economico\LicencaDiversa $fkEconomicoLicencaDiversa
     * @return AtributoLicencaDiversaValor
     */
    public function setFkEconomicoLicencaDiversa(\Urbem\CoreBundle\Entity\Economico\LicencaDiversa $fkEconomicoLicencaDiversa)
    {
        $this->codLicenca = $fkEconomicoLicencaDiversa->getCodLicenca();
        $this->exercicio = $fkEconomicoLicencaDiversa->getExercicio();
        $this->fkEconomicoLicencaDiversa = $fkEconomicoLicencaDiversa;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkEconomicoLicencaDiversa
     *
     * @return \Urbem\CoreBundle\Entity\Economico\LicencaDiversa
     */
    public function getFkEconomicoLicencaDiversa()
    {
        return $this->fkEconomicoLicencaDiversa;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkEconomicoAtributoTipoLicencaDiversa
     *
     * @param \Urbem\CoreBundle\Entity\Economico\AtributoTipoLicencaDiversa $fkEconomicoAtributoTipoLicencaDiversa
     * @return AtributoLicencaDiversaValor
     */
    public function setFkEconomicoAtributoTipoLicencaDiversa(\Urbem\CoreBundle\Entity\Economico\AtributoTipoLicencaDiversa $fkEconomicoAtributoTipoLicencaDiversa)
    {
        $this->codTipo = $fkEconomicoAtributoTipoLicencaDiversa->getCodTipo();
        $this->codCadastro = $fkEconomicoAtributoTipoLicencaDiversa->getCodCadastro();
        $this->codAtributo = $fkEconomicoAtributoTipoLicencaDiversa->getCodAtributo();
        $this->codModulo = $fkEconomicoAtributoTipoLicencaDiversa->getCodModulo();
        $this->fkEconomicoAtributoTipoLicencaDiversa = $fkEconomicoAtributoTipoLicencaDiversa;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkEconomicoAtributoTipoLicencaDiversa
     *
     * @return \Urbem\CoreBundle\Entity\Economico\AtributoTipoLicencaDiversa
     */
    public function getFkEconomicoAtributoTipoLicencaDiversa()
    {
        return $this->fkEconomicoAtributoTipoLicencaDiversa;
    }
}
