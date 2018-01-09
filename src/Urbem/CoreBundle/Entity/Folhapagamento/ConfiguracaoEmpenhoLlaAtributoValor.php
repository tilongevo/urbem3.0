<?php
 
namespace Urbem\CoreBundle\Entity\Folhapagamento;

/**
 * ConfiguracaoEmpenhoLlaAtributoValor
 */
class ConfiguracaoEmpenhoLlaAtributoValor
{
    /**
     * PK
     * @var integer
     */
    private $numPao;

    /**
     * PK
     * @var string
     */
    private $exercicio;

    /**
     * PK
     * @var integer
     */
    private $codConfiguracaoLla;

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
    private $valor;

    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DateTimePK
     */
    private $timestamp;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Orcamento\Pao
     */
    private $fkOrcamentoPao;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEmpenhoLlaAtributo
     */
    private $fkFolhapagamentoConfiguracaoEmpenhoLlaAtributo;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimePK;
    }

    /**
     * Set numPao
     *
     * @param integer $numPao
     * @return ConfiguracaoEmpenhoLlaAtributoValor
     */
    public function setNumPao($numPao)
    {
        $this->numPao = $numPao;
        return $this;
    }

    /**
     * Get numPao
     *
     * @return integer
     */
    public function getNumPao()
    {
        return $this->numPao;
    }

    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return ConfiguracaoEmpenhoLlaAtributoValor
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
     * Set codConfiguracaoLla
     *
     * @param integer $codConfiguracaoLla
     * @return ConfiguracaoEmpenhoLlaAtributoValor
     */
    public function setCodConfiguracaoLla($codConfiguracaoLla)
    {
        $this->codConfiguracaoLla = $codConfiguracaoLla;
        return $this;
    }

    /**
     * Get codConfiguracaoLla
     *
     * @return integer
     */
    public function getCodConfiguracaoLla()
    {
        return $this->codConfiguracaoLla;
    }

    /**
     * Set codCadastro
     *
     * @param integer $codCadastro
     * @return ConfiguracaoEmpenhoLlaAtributoValor
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
     * @return ConfiguracaoEmpenhoLlaAtributoValor
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
     * @return ConfiguracaoEmpenhoLlaAtributoValor
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
     * Set valor
     *
     * @param string $valor
     * @return ConfiguracaoEmpenhoLlaAtributoValor
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
     * Set timestamp
     *
     * @param \Urbem\CoreBundle\Helper\DateTimePK $timestamp
     * @return ConfiguracaoEmpenhoLlaAtributoValor
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
     * Set fkOrcamentoPao
     *
     * @param \Urbem\CoreBundle\Entity\Orcamento\Pao $fkOrcamentoPao
     * @return ConfiguracaoEmpenhoLlaAtributoValor
     */
    public function setFkOrcamentoPao(\Urbem\CoreBundle\Entity\Orcamento\Pao $fkOrcamentoPao)
    {
        $this->exercicio = $fkOrcamentoPao->getExercicio();
        $this->numPao = $fkOrcamentoPao->getNumPao();
        $this->fkOrcamentoPao = $fkOrcamentoPao;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkOrcamentoPao
     *
     * @return \Urbem\CoreBundle\Entity\Orcamento\Pao
     */
    public function getFkOrcamentoPao()
    {
        return $this->fkOrcamentoPao;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkFolhapagamentoConfiguracaoEmpenhoLlaAtributo
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEmpenhoLlaAtributo $fkFolhapagamentoConfiguracaoEmpenhoLlaAtributo
     * @return ConfiguracaoEmpenhoLlaAtributoValor
     */
    public function setFkFolhapagamentoConfiguracaoEmpenhoLlaAtributo(\Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEmpenhoLlaAtributo $fkFolhapagamentoConfiguracaoEmpenhoLlaAtributo)
    {
        $this->codAtributo = $fkFolhapagamentoConfiguracaoEmpenhoLlaAtributo->getCodAtributo();
        $this->codModulo = $fkFolhapagamentoConfiguracaoEmpenhoLlaAtributo->getCodModulo();
        $this->codCadastro = $fkFolhapagamentoConfiguracaoEmpenhoLlaAtributo->getCodCadastro();
        $this->exercicio = $fkFolhapagamentoConfiguracaoEmpenhoLlaAtributo->getExercicio();
        $this->codConfiguracaoLla = $fkFolhapagamentoConfiguracaoEmpenhoLlaAtributo->getCodConfiguracaoLla();
        $this->timestamp = $fkFolhapagamentoConfiguracaoEmpenhoLlaAtributo->getTimestamp();
        $this->fkFolhapagamentoConfiguracaoEmpenhoLlaAtributo = $fkFolhapagamentoConfiguracaoEmpenhoLlaAtributo;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkFolhapagamentoConfiguracaoEmpenhoLlaAtributo
     *
     * @return \Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEmpenhoLlaAtributo
     */
    public function getFkFolhapagamentoConfiguracaoEmpenhoLlaAtributo()
    {
        return $this->fkFolhapagamentoConfiguracaoEmpenhoLlaAtributo;
    }
}
