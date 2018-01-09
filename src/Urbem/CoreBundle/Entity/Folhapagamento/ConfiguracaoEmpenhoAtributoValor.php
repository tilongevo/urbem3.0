<?php
 
namespace Urbem\CoreBundle\Entity\Folhapagamento;

/**
 * ConfiguracaoEmpenhoAtributoValor
 */
class ConfiguracaoEmpenhoAtributoValor
{
    /**
     * PK
     * @var integer
     */
    private $codCadastro;

    /**
     * PK
     * @var integer
     */
    private $codModulo;

    /**
     * PK
     * @var integer
     */
    private $codAtributo;

    /**
     * PK
     * @var string
     */
    private $exercicio;

    /**
     * PK
     * @var integer
     */
    private $codConfiguracao;

    /**
     * PK
     * @var string
     */
    private $valor;

    /**
     * PK
     * @var integer
     */
    private $sequencia;

    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DateTimePK
     */
    private $timestamp;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEmpenhoAtributo
     */
    private $fkFolhapagamentoConfiguracaoEmpenhoAtributo;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimePK;
    }

    /**
     * Set codCadastro
     *
     * @param integer $codCadastro
     * @return ConfiguracaoEmpenhoAtributoValor
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
     * Set codModulo
     *
     * @param integer $codModulo
     * @return ConfiguracaoEmpenhoAtributoValor
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
     * Set codAtributo
     *
     * @param integer $codAtributo
     * @return ConfiguracaoEmpenhoAtributoValor
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
     * Set exercicio
     *
     * @param string $exercicio
     * @return ConfiguracaoEmpenhoAtributoValor
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
     * Set codConfiguracao
     *
     * @param integer $codConfiguracao
     * @return ConfiguracaoEmpenhoAtributoValor
     */
    public function setCodConfiguracao($codConfiguracao)
    {
        $this->codConfiguracao = $codConfiguracao;
        return $this;
    }

    /**
     * Get codConfiguracao
     *
     * @return integer
     */
    public function getCodConfiguracao()
    {
        return $this->codConfiguracao;
    }

    /**
     * Set valor
     *
     * @param string $valor
     * @return ConfiguracaoEmpenhoAtributoValor
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
     * Set sequencia
     *
     * @param integer $sequencia
     * @return ConfiguracaoEmpenhoAtributoValor
     */
    public function setSequencia($sequencia)
    {
        $this->sequencia = $sequencia;
        return $this;
    }

    /**
     * Get sequencia
     *
     * @return integer
     */
    public function getSequencia()
    {
        return $this->sequencia;
    }

    /**
     * Set timestamp
     *
     * @param \Urbem\CoreBundle\Helper\DateTimePK $timestamp
     * @return ConfiguracaoEmpenhoAtributoValor
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
     * ManyToOne (inverse side)
     * Set fkFolhapagamentoConfiguracaoEmpenhoAtributo
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEmpenhoAtributo $fkFolhapagamentoConfiguracaoEmpenhoAtributo
     * @return ConfiguracaoEmpenhoAtributoValor
     */
    public function setFkFolhapagamentoConfiguracaoEmpenhoAtributo(\Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEmpenhoAtributo $fkFolhapagamentoConfiguracaoEmpenhoAtributo)
    {
        $this->codConfiguracao = $fkFolhapagamentoConfiguracaoEmpenhoAtributo->getCodConfiguracao();
        $this->exercicio = $fkFolhapagamentoConfiguracaoEmpenhoAtributo->getExercicio();
        $this->codAtributo = $fkFolhapagamentoConfiguracaoEmpenhoAtributo->getCodAtributo();
        $this->codModulo = $fkFolhapagamentoConfiguracaoEmpenhoAtributo->getCodModulo();
        $this->codCadastro = $fkFolhapagamentoConfiguracaoEmpenhoAtributo->getCodCadastro();
        $this->sequencia = $fkFolhapagamentoConfiguracaoEmpenhoAtributo->getSequencia();
        $this->timestamp = $fkFolhapagamentoConfiguracaoEmpenhoAtributo->getTimestamp();
        $this->fkFolhapagamentoConfiguracaoEmpenhoAtributo = $fkFolhapagamentoConfiguracaoEmpenhoAtributo;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkFolhapagamentoConfiguracaoEmpenhoAtributo
     *
     * @return \Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEmpenhoAtributo
     */
    public function getFkFolhapagamentoConfiguracaoEmpenhoAtributo()
    {
        return $this->fkFolhapagamentoConfiguracaoEmpenhoAtributo;
    }
}
