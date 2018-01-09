<?php
 
namespace Urbem\CoreBundle\Entity\Imobiliario;

/**
 * AtributoCondominioValor
 */
class AtributoCondominioValor
{
    /**
     * PK
     * @var integer
     */
    private $codCondominio;

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
     * @var \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
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
     * @var \Urbem\CoreBundle\Entity\Imobiliario\Condominio
     */
    private $fkImobiliarioCondominio;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Administracao\AtributoDinamico
     */
    private $fkAdministracaoAtributoDinamico;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
    }

    /**
     * Set codCondominio
     *
     * @param integer $codCondominio
     * @return AtributoCondominioValor
     */
    public function setCodCondominio($codCondominio)
    {
        $this->codCondominio = $codCondominio;
        return $this;
    }

    /**
     * Get codCondominio
     *
     * @return integer
     */
    public function getCodCondominio()
    {
        return $this->codCondominio;
    }

    /**
     * Set codAtributo
     *
     * @param integer $codAtributo
     * @return AtributoCondominioValor
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
     * @return AtributoCondominioValor
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
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp
     * @return AtributoCondominioValor
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
     * Set codModulo
     *
     * @param integer $codModulo
     * @return AtributoCondominioValor
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
     * @return AtributoCondominioValor
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
     * Set fkImobiliarioCondominio
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\Condominio $fkImobiliarioCondominio
     * @return AtributoCondominioValor
     */
    public function setFkImobiliarioCondominio(\Urbem\CoreBundle\Entity\Imobiliario\Condominio $fkImobiliarioCondominio)
    {
        $this->codCondominio = $fkImobiliarioCondominio->getCodCondominio();
        $this->fkImobiliarioCondominio = $fkImobiliarioCondominio;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkImobiliarioCondominio
     *
     * @return \Urbem\CoreBundle\Entity\Imobiliario\Condominio
     */
    public function getFkImobiliarioCondominio()
    {
        return $this->fkImobiliarioCondominio;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkAdministracaoAtributoDinamico
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\AtributoDinamico $fkAdministracaoAtributoDinamico
     * @return AtributoCondominioValor
     */
    public function setFkAdministracaoAtributoDinamico(\Urbem\CoreBundle\Entity\Administracao\AtributoDinamico $fkAdministracaoAtributoDinamico)
    {
        $this->codModulo = $fkAdministracaoAtributoDinamico->getCodModulo();
        $this->codCadastro = $fkAdministracaoAtributoDinamico->getCodCadastro();
        $this->codAtributo = $fkAdministracaoAtributoDinamico->getCodAtributo();
        $this->fkAdministracaoAtributoDinamico = $fkAdministracaoAtributoDinamico;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkAdministracaoAtributoDinamico
     *
     * @return \Urbem\CoreBundle\Entity\Administracao\AtributoDinamico
     */
    public function getFkAdministracaoAtributoDinamico()
    {
        return $this->fkAdministracaoAtributoDinamico;
    }
}
