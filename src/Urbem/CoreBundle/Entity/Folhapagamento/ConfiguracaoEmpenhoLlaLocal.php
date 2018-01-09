<?php
 
namespace Urbem\CoreBundle\Entity\Folhapagamento;

/**
 * ConfiguracaoEmpenhoLlaLocal
 */
class ConfiguracaoEmpenhoLlaLocal
{
    /**
     * PK
     * @var string
     */
    private $exercicio;

    /**
     * PK
     * @var integer
     */
    private $codLocal;

    /**
     * PK
     * @var integer
     */
    private $codConfiguracaoLla;

    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    private $timestamp;

    /**
     * @var integer
     */
    private $numPao;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Orcamento\Pao
     */
    private $fkOrcamentoPao;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEmpenhoLla
     */
    private $fkFolhapagamentoConfiguracaoEmpenhoLla;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Organograma\Local
     */
    private $fkOrganogramaLocal;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
    }

    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return ConfiguracaoEmpenhoLlaLocal
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
     * Set codLocal
     *
     * @param integer $codLocal
     * @return ConfiguracaoEmpenhoLlaLocal
     */
    public function setCodLocal($codLocal)
    {
        $this->codLocal = $codLocal;
        return $this;
    }

    /**
     * Get codLocal
     *
     * @return integer
     */
    public function getCodLocal()
    {
        return $this->codLocal;
    }

    /**
     * Set codConfiguracaoLla
     *
     * @param integer $codConfiguracaoLla
     * @return ConfiguracaoEmpenhoLlaLocal
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
     * Set timestamp
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp
     * @return ConfiguracaoEmpenhoLlaLocal
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
     * Set numPao
     *
     * @param integer $numPao
     * @return ConfiguracaoEmpenhoLlaLocal
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
     * ManyToOne (inverse side)
     * Set fkOrcamentoPao
     *
     * @param \Urbem\CoreBundle\Entity\Orcamento\Pao $fkOrcamentoPao
     * @return ConfiguracaoEmpenhoLlaLocal
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
     * Set fkFolhapagamentoConfiguracaoEmpenhoLla
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEmpenhoLla $fkFolhapagamentoConfiguracaoEmpenhoLla
     * @return ConfiguracaoEmpenhoLlaLocal
     */
    public function setFkFolhapagamentoConfiguracaoEmpenhoLla(\Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEmpenhoLla $fkFolhapagamentoConfiguracaoEmpenhoLla)
    {
        $this->codConfiguracaoLla = $fkFolhapagamentoConfiguracaoEmpenhoLla->getCodConfiguracaoLla();
        $this->exercicio = $fkFolhapagamentoConfiguracaoEmpenhoLla->getExercicio();
        $this->timestamp = $fkFolhapagamentoConfiguracaoEmpenhoLla->getTimestamp();
        $this->fkFolhapagamentoConfiguracaoEmpenhoLla = $fkFolhapagamentoConfiguracaoEmpenhoLla;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkFolhapagamentoConfiguracaoEmpenhoLla
     *
     * @return \Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEmpenhoLla
     */
    public function getFkFolhapagamentoConfiguracaoEmpenhoLla()
    {
        return $this->fkFolhapagamentoConfiguracaoEmpenhoLla;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkOrganogramaLocal
     *
     * @param \Urbem\CoreBundle\Entity\Organograma\Local $fkOrganogramaLocal
     * @return ConfiguracaoEmpenhoLlaLocal
     */
    public function setFkOrganogramaLocal(\Urbem\CoreBundle\Entity\Organograma\Local $fkOrganogramaLocal)
    {
        $this->codLocal = $fkOrganogramaLocal->getCodLocal();
        $this->fkOrganogramaLocal = $fkOrganogramaLocal;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkOrganogramaLocal
     *
     * @return \Urbem\CoreBundle\Entity\Organograma\Local
     */
    public function getFkOrganogramaLocal()
    {
        return $this->fkOrganogramaLocal;
    }
}
