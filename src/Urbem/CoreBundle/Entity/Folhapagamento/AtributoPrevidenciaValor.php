<?php
 
namespace Urbem\CoreBundle\Entity\Folhapagamento;

/**
 * AtributoPrevidenciaValor
 */
class AtributoPrevidenciaValor
{
    /**
     * PK
     * @var integer
     */
    private $codPrevidencia;

    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    private $timestampPrevidencia;

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
     * @var \DateTime
     */
    private $timestamp;

    /**
     * @var string
     */
    private $valor;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Folhapagamento\PrevidenciaPrevidencia
     */
    private $fkFolhapagamentoPrevidenciaPrevidencia;

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
        $this->timestampPrevidencia = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
        $this->timestamp = new \DateTime;
    }

    /**
     * Set codPrevidencia
     *
     * @param integer $codPrevidencia
     * @return AtributoPrevidenciaValor
     */
    public function setCodPrevidencia($codPrevidencia)
    {
        $this->codPrevidencia = $codPrevidencia;
        return $this;
    }

    /**
     * Get codPrevidencia
     *
     * @return integer
     */
    public function getCodPrevidencia()
    {
        return $this->codPrevidencia;
    }

    /**
     * Set timestampPrevidencia
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestampPrevidencia
     * @return AtributoPrevidenciaValor
     */
    public function setTimestampPrevidencia(\Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestampPrevidencia)
    {
        $this->timestampPrevidencia = $timestampPrevidencia;
        return $this;
    }

    /**
     * Get timestampPrevidencia
     *
     * @return \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    public function getTimestampPrevidencia()
    {
        return $this->timestampPrevidencia;
    }

    /**
     * Set codModulo
     *
     * @param integer $codModulo
     * @return AtributoPrevidenciaValor
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
     * @return AtributoPrevidenciaValor
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
     * @return AtributoPrevidenciaValor
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
     * @param \DateTime $timestamp
     * @return AtributoPrevidenciaValor
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
     * @return AtributoPrevidenciaValor
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
     * Set fkFolhapagamentoPrevidenciaPrevidencia
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\PrevidenciaPrevidencia $fkFolhapagamentoPrevidenciaPrevidencia
     * @return AtributoPrevidenciaValor
     */
    public function setFkFolhapagamentoPrevidenciaPrevidencia(\Urbem\CoreBundle\Entity\Folhapagamento\PrevidenciaPrevidencia $fkFolhapagamentoPrevidenciaPrevidencia)
    {
        $this->codPrevidencia = $fkFolhapagamentoPrevidenciaPrevidencia->getCodPrevidencia();
        $this->timestampPrevidencia = $fkFolhapagamentoPrevidenciaPrevidencia->getTimestamp();
        $this->fkFolhapagamentoPrevidenciaPrevidencia = $fkFolhapagamentoPrevidenciaPrevidencia;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkFolhapagamentoPrevidenciaPrevidencia
     *
     * @return \Urbem\CoreBundle\Entity\Folhapagamento\PrevidenciaPrevidencia
     */
    public function getFkFolhapagamentoPrevidenciaPrevidencia()
    {
        return $this->fkFolhapagamentoPrevidenciaPrevidencia;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkAdministracaoAtributoDinamico
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\AtributoDinamico $fkAdministracaoAtributoDinamico
     * @return AtributoPrevidenciaValor
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
