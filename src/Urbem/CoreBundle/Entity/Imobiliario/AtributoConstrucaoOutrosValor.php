<?php
 
namespace Urbem\CoreBundle\Entity\Imobiliario;

/**
 * AtributoConstrucaoOutrosValor
 */
class AtributoConstrucaoOutrosValor
{
    /**
     * PK
     * @var integer
     */
    private $codConstrucao;

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
     * @var \Urbem\CoreBundle\Entity\Imobiliario\ConstrucaoOutros
     */
    private $fkImobiliarioConstrucaoOutros;

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
     * Set codConstrucao
     *
     * @param integer $codConstrucao
     * @return AtributoConstrucaoOutrosValor
     */
    public function setCodConstrucao($codConstrucao)
    {
        $this->codConstrucao = $codConstrucao;
        return $this;
    }

    /**
     * Get codConstrucao
     *
     * @return integer
     */
    public function getCodConstrucao()
    {
        return $this->codConstrucao;
    }

    /**
     * Set codCadastro
     *
     * @param integer $codCadastro
     * @return AtributoConstrucaoOutrosValor
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
     * @return AtributoConstrucaoOutrosValor
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
     * @return AtributoConstrucaoOutrosValor
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
     * @return AtributoConstrucaoOutrosValor
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
     * @return AtributoConstrucaoOutrosValor
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
     * Set fkImobiliarioConstrucaoOutros
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\ConstrucaoOutros $fkImobiliarioConstrucaoOutros
     * @return AtributoConstrucaoOutrosValor
     */
    public function setFkImobiliarioConstrucaoOutros(\Urbem\CoreBundle\Entity\Imobiliario\ConstrucaoOutros $fkImobiliarioConstrucaoOutros)
    {
        $this->codConstrucao = $fkImobiliarioConstrucaoOutros->getCodConstrucao();
        $this->fkImobiliarioConstrucaoOutros = $fkImobiliarioConstrucaoOutros;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkImobiliarioConstrucaoOutros
     *
     * @return \Urbem\CoreBundle\Entity\Imobiliario\ConstrucaoOutros
     */
    public function getFkImobiliarioConstrucaoOutros()
    {
        return $this->fkImobiliarioConstrucaoOutros;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkAdministracaoAtributoDinamico
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\AtributoDinamico $fkAdministracaoAtributoDinamico
     * @return AtributoConstrucaoOutrosValor
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
