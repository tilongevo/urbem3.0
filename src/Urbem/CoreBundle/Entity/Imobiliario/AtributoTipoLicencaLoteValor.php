<?php
 
namespace Urbem\CoreBundle\Entity\Imobiliario;

/**
 * AtributoTipoLicencaLoteValor
 */
class AtributoTipoLicencaLoteValor
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
    private $codLote;

    /**
     * PK
     * @var integer
     */
    private $codTipo;

    /**
     * PK
     * @var integer
     */
    private $codModulo;

    /**
     * PK
     * @var integer
     */
    private $codCadastro;

    /**
     * PK
     * @var integer
     */
    private $codAtributo;

    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    private $timestamp;

    /**
     * @var string
     */
    private $valor;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Imobiliario\LicencaLote
     */
    private $fkImobiliarioLicencaLote;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Imobiliario\AtributoTipoLicenca
     */
    private $fkImobiliarioAtributoTipoLicenca;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
    }

    /**
     * Set codLicenca
     *
     * @param integer $codLicenca
     * @return AtributoTipoLicencaLoteValor
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
     * @return AtributoTipoLicencaLoteValor
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
     * Set codLote
     *
     * @param integer $codLote
     * @return AtributoTipoLicencaLoteValor
     */
    public function setCodLote($codLote)
    {
        $this->codLote = $codLote;
        return $this;
    }

    /**
     * Get codLote
     *
     * @return integer
     */
    public function getCodLote()
    {
        return $this->codLote;
    }

    /**
     * Set codTipo
     *
     * @param integer $codTipo
     * @return AtributoTipoLicencaLoteValor
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
     * Set codModulo
     *
     * @param integer $codModulo
     * @return AtributoTipoLicencaLoteValor
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
     * Set codCadastro
     *
     * @param integer $codCadastro
     * @return AtributoTipoLicencaLoteValor
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
     * Set codAtributo
     *
     * @param integer $codAtributo
     * @return AtributoTipoLicencaLoteValor
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
     * Set timestamp
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp
     * @return AtributoTipoLicencaLoteValor
     */
    public function setTimestamp(\Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp)
    {
        $this->timestamp = $timestamp;
        return $this;
    }

    /**
     * Get timestamp
     *
     * @return \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }

    /**
     * Set valor
     *
     * @param string $valor
     * @return AtributoTipoLicencaLoteValor
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
     * Set fkImobiliarioLicencaLote
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\LicencaLote $fkImobiliarioLicencaLote
     * @return AtributoTipoLicencaLoteValor
     */
    public function setFkImobiliarioLicencaLote(\Urbem\CoreBundle\Entity\Imobiliario\LicencaLote $fkImobiliarioLicencaLote)
    {
        $this->codLicenca = $fkImobiliarioLicencaLote->getCodLicenca();
        $this->exercicio = $fkImobiliarioLicencaLote->getExercicio();
        $this->codLote = $fkImobiliarioLicencaLote->getCodLote();
        $this->fkImobiliarioLicencaLote = $fkImobiliarioLicencaLote;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkImobiliarioLicencaLote
     *
     * @return \Urbem\CoreBundle\Entity\Imobiliario\LicencaLote
     */
    public function getFkImobiliarioLicencaLote()
    {
        return $this->fkImobiliarioLicencaLote;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkImobiliarioAtributoTipoLicenca
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\AtributoTipoLicenca $fkImobiliarioAtributoTipoLicenca
     * @return AtributoTipoLicencaLoteValor
     */
    public function setFkImobiliarioAtributoTipoLicenca(\Urbem\CoreBundle\Entity\Imobiliario\AtributoTipoLicenca $fkImobiliarioAtributoTipoLicenca)
    {
        $this->codTipo = $fkImobiliarioAtributoTipoLicenca->getCodTipo();
        $this->codAtributo = $fkImobiliarioAtributoTipoLicenca->getCodAtributo();
        $this->codCadastro = $fkImobiliarioAtributoTipoLicenca->getCodCadastro();
        $this->codModulo = $fkImobiliarioAtributoTipoLicenca->getCodModulo();
        $this->fkImobiliarioAtributoTipoLicenca = $fkImobiliarioAtributoTipoLicenca;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkImobiliarioAtributoTipoLicenca
     *
     * @return \Urbem\CoreBundle\Entity\Imobiliario\AtributoTipoLicenca
     */
    public function getFkImobiliarioAtributoTipoLicenca()
    {
        return $this->fkImobiliarioAtributoTipoLicenca;
    }
}
