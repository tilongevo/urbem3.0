<?php
 
namespace Urbem\CoreBundle\Entity\Economico;

/**
 * AtributoElemLicenDiversaValor
 */
class AtributoElemLicenDiversaValor
{
    /**
     * PK
     * @var integer
     */
    private $codElemento;

    /**
     * PK
     * @var integer
     */
    private $codTipo;

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
    private $ocorrencia;

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
     * @var \Urbem\CoreBundle\Entity\Economico\ElementoLicencaDiversa
     */
    private $fkEconomicoElementoLicencaDiversa;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Economico\AtributoElemento
     */
    private $fkEconomicoAtributoElemento;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimePK;
    }

    /**
     * Set codElemento
     *
     * @param integer $codElemento
     * @return AtributoElemLicenDiversaValor
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
     * Set codTipo
     *
     * @param integer $codTipo
     * @return AtributoElemLicenDiversaValor
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
     * Set codLicenca
     *
     * @param integer $codLicenca
     * @return AtributoElemLicenDiversaValor
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
     * @return AtributoElemLicenDiversaValor
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
     * Set ocorrencia
     *
     * @param integer $ocorrencia
     * @return AtributoElemLicenDiversaValor
     */
    public function setOcorrencia($ocorrencia)
    {
        $this->ocorrencia = $ocorrencia;
        return $this;
    }

    /**
     * Get ocorrencia
     *
     * @return integer
     */
    public function getOcorrencia()
    {
        return $this->ocorrencia;
    }

    /**
     * Set codAtributo
     *
     * @param integer $codAtributo
     * @return AtributoElemLicenDiversaValor
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
     * @return AtributoElemLicenDiversaValor
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
     * @return AtributoElemLicenDiversaValor
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
     * @return AtributoElemLicenDiversaValor
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
     * @return AtributoElemLicenDiversaValor
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
     * Set fkEconomicoElementoLicencaDiversa
     *
     * @param \Urbem\CoreBundle\Entity\Economico\ElementoLicencaDiversa $fkEconomicoElementoLicencaDiversa
     * @return AtributoElemLicenDiversaValor
     */
    public function setFkEconomicoElementoLicencaDiversa(\Urbem\CoreBundle\Entity\Economico\ElementoLicencaDiversa $fkEconomicoElementoLicencaDiversa)
    {
        $this->codElemento = $fkEconomicoElementoLicencaDiversa->getCodElemento();
        $this->codTipo = $fkEconomicoElementoLicencaDiversa->getCodTipo();
        $this->codLicenca = $fkEconomicoElementoLicencaDiversa->getCodLicenca();
        $this->exercicio = $fkEconomicoElementoLicencaDiversa->getExercicio();
        $this->ocorrencia = $fkEconomicoElementoLicencaDiversa->getOcorrencia();
        $this->fkEconomicoElementoLicencaDiversa = $fkEconomicoElementoLicencaDiversa;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkEconomicoElementoLicencaDiversa
     *
     * @return \Urbem\CoreBundle\Entity\Economico\ElementoLicencaDiversa
     */
    public function getFkEconomicoElementoLicencaDiversa()
    {
        return $this->fkEconomicoElementoLicencaDiversa;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkEconomicoAtributoElemento
     *
     * @param \Urbem\CoreBundle\Entity\Economico\AtributoElemento $fkEconomicoAtributoElemento
     * @return AtributoElemLicenDiversaValor
     */
    public function setFkEconomicoAtributoElemento(\Urbem\CoreBundle\Entity\Economico\AtributoElemento $fkEconomicoAtributoElemento)
    {
        $this->codAtributo = $fkEconomicoAtributoElemento->getCodAtributo();
        $this->codCadastro = $fkEconomicoAtributoElemento->getCodCadastro();
        $this->codElemento = $fkEconomicoAtributoElemento->getCodElemento();
        $this->codModulo = $fkEconomicoAtributoElemento->getCodModulo();
        $this->fkEconomicoAtributoElemento = $fkEconomicoAtributoElemento;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkEconomicoAtributoElemento
     *
     * @return \Urbem\CoreBundle\Entity\Economico\AtributoElemento
     */
    public function getFkEconomicoAtributoElemento()
    {
        return $this->fkEconomicoAtributoElemento;
    }
}
