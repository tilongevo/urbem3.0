<?php
 
namespace Urbem\CoreBundle\Entity\Folhapagamento;

/**
 * AtributoPadraoValor
 */
class AtributoPadraoValor
{
    /**
     * PK
     * @var integer
     */
    private $codPadrao;

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
     * @var \Urbem\CoreBundle\Helper\DateTimePK
     */
    private $timestampPadrao;

    /**
     * @var \DateTime
     */
    private $timestamp;

    /**
     * @var string
     */
    private $valor;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Folhapagamento\PadraoPadrao
     */
    private $fkFolhapagamentoPadraoPadrao;

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
        $this->timestampPadrao = new \Urbem\CoreBundle\Helper\DateTimePK;
        $this->timestamp = new \DateTime;
    }

    /**
     * Set codPadrao
     *
     * @param integer $codPadrao
     * @return AtributoPadraoValor
     */
    public function setCodPadrao($codPadrao)
    {
        $this->codPadrao = $codPadrao;
        return $this;
    }

    /**
     * Get codPadrao
     *
     * @return integer
     */
    public function getCodPadrao()
    {
        return $this->codPadrao;
    }

    /**
     * Set codModulo
     *
     * @param integer $codModulo
     * @return AtributoPadraoValor
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
     * @return AtributoPadraoValor
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
     * @return AtributoPadraoValor
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
     * Set timestampPadrao
     *
     * @param \Urbem\CoreBundle\Helper\DateTimePK $timestampPadrao
     * @return AtributoPadraoValor
     */
    public function setTimestampPadrao(\Urbem\CoreBundle\Helper\DateTimePK $timestampPadrao)
    {
        $this->timestampPadrao = $timestampPadrao;
        return $this;
    }

    /**
     * Get timestampPadrao
     *
     * @return \Urbem\CoreBundle\Helper\DateTimePK
     */
    public function getTimestampPadrao()
    {
        return $this->timestampPadrao;
    }

    /**
     * Set timestamp
     *
     * @param \DateTime $timestamp
     * @return AtributoPadraoValor
     */
    public function setTimestamp(\DateTime $timestamp)
    {
        $this->timestamp = $timestamp;
        return $this;
    }

    /**
     * Get timestamp
     *
     * @return \DateTime
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }

    /**
     * Set valor
     *
     * @param string $valor
     * @return AtributoPadraoValor
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
     * Set fkFolhapagamentoPadraoPadrao
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\PadraoPadrao $fkFolhapagamentoPadraoPadrao
     * @return AtributoPadraoValor
     */
    public function setFkFolhapagamentoPadraoPadrao(\Urbem\CoreBundle\Entity\Folhapagamento\PadraoPadrao $fkFolhapagamentoPadraoPadrao)
    {
        $this->codPadrao = $fkFolhapagamentoPadraoPadrao->getCodPadrao();
        $this->timestampPadrao = $fkFolhapagamentoPadraoPadrao->getTimestamp();
        $this->fkFolhapagamentoPadraoPadrao = $fkFolhapagamentoPadraoPadrao;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkFolhapagamentoPadraoPadrao
     *
     * @return \Urbem\CoreBundle\Entity\Folhapagamento\PadraoPadrao
     */
    public function getFkFolhapagamentoPadraoPadrao()
    {
        return $this->fkFolhapagamentoPadraoPadrao;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkAdministracaoAtributoDinamico
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\AtributoDinamico $fkAdministracaoAtributoDinamico
     * @return AtributoPadraoValor
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
