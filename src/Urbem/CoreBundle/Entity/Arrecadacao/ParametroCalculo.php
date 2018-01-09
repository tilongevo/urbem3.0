<?php
 
namespace Urbem\CoreBundle\Entity\Arrecadacao;

/**
 * ParametroCalculo
 */
class ParametroCalculo
{
    /**
     * PK
     * @var integer
     */
    private $codCredito;

    /**
     * PK
     * @var integer
     */
    private $codNatureza;

    /**
     * PK
     * @var integer
     */
    private $codGenero;

    /**
     * PK
     * @var integer
     */
    private $codEspecie;

    /**
     * PK
     * @var integer
     */
    private $ocorrenciaCredito;

    /**
     * @var integer
     */
    private $codFuncao;

    /**
     * @var \DateTime
     */
    private $timestamp;

    /**
     * @var integer
     */
    private $codModulo;

    /**
     * @var integer
     */
    private $codBiblioteca;

    /**
     * @var string
     */
    private $valorCorrespondente;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Monetario\Credito
     */
    private $fkMonetarioCredito;

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
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
    }

    /**
     * Set codCredito
     *
     * @param integer $codCredito
     * @return ParametroCalculo
     */
    public function setCodCredito($codCredito)
    {
        $this->codCredito = $codCredito;
        return $this;
    }

    /**
     * Get codCredito
     *
     * @return integer
     */
    public function getCodCredito()
    {
        return $this->codCredito;
    }

    /**
     * Set codNatureza
     *
     * @param integer $codNatureza
     * @return ParametroCalculo
     */
    public function setCodNatureza($codNatureza)
    {
        $this->codNatureza = $codNatureza;
        return $this;
    }

    /**
     * Get codNatureza
     *
     * @return integer
     */
    public function getCodNatureza()
    {
        return $this->codNatureza;
    }

    /**
     * Set codGenero
     *
     * @param integer $codGenero
     * @return ParametroCalculo
     */
    public function setCodGenero($codGenero)
    {
        $this->codGenero = $codGenero;
        return $this;
    }

    /**
     * Get codGenero
     *
     * @return integer
     */
    public function getCodGenero()
    {
        return $this->codGenero;
    }

    /**
     * Set codEspecie
     *
     * @param integer $codEspecie
     * @return ParametroCalculo
     */
    public function setCodEspecie($codEspecie)
    {
        $this->codEspecie = $codEspecie;
        return $this;
    }

    /**
     * Get codEspecie
     *
     * @return integer
     */
    public function getCodEspecie()
    {
        return $this->codEspecie;
    }

    /**
     * Set ocorrenciaCredito
     *
     * @param integer $ocorrenciaCredito
     * @return ParametroCalculo
     */
    public function setOcorrenciaCredito($ocorrenciaCredito)
    {
        $this->ocorrenciaCredito = $ocorrenciaCredito;
        return $this;
    }

    /**
     * Get ocorrenciaCredito
     *
     * @return integer
     */
    public function getOcorrenciaCredito()
    {
        return $this->ocorrenciaCredito;
    }

    /**
     * Set codFuncao
     *
     * @param integer $codFuncao
     * @return ParametroCalculo
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
     * Set timestamp
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp
     * @return ParametroCalculo
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
     * @return ParametroCalculo
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
     * @return ParametroCalculo
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
     * Set valorCorrespondente
     *
     * @param string $valorCorrespondente
     * @return ParametroCalculo
     */
    public function setValorCorrespondente($valorCorrespondente = null)
    {
        $this->valorCorrespondente = $valorCorrespondente;
        return $this;
    }

    /**
     * Get valorCorrespondente
     *
     * @return string
     */
    public function getValorCorrespondente()
    {
        return $this->valorCorrespondente;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkMonetarioCredito
     *
     * @param \Urbem\CoreBundle\Entity\Monetario\Credito $fkMonetarioCredito
     * @return ParametroCalculo
     */
    public function setFkMonetarioCredito(\Urbem\CoreBundle\Entity\Monetario\Credito $fkMonetarioCredito)
    {
        $this->codCredito = $fkMonetarioCredito->getCodCredito();
        $this->codNatureza = $fkMonetarioCredito->getCodNatureza();
        $this->codGenero = $fkMonetarioCredito->getCodGenero();
        $this->codEspecie = $fkMonetarioCredito->getCodEspecie();
        $this->fkMonetarioCredito = $fkMonetarioCredito;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkMonetarioCredito
     *
     * @return \Urbem\CoreBundle\Entity\Monetario\Credito
     */
    public function getFkMonetarioCredito()
    {
        return $this->fkMonetarioCredito;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkAdministracaoFuncao
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\Funcao $fkAdministracaoFuncao
     * @return ParametroCalculo
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
