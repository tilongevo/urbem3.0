<?php
 
namespace Urbem\CoreBundle\Entity\Folhapagamento;

/**
 * ConfiguracaoEmpenhoLotacao
 */
class ConfiguracaoEmpenhoLotacao
{
    /**
     * PK
     * @var integer
     */
    private $codConfiguracao;

    /**
     * PK
     * @var string
     */
    private $exercicio;

    /**
     * PK
     * @var integer
     */
    private $codOrgao;

    /**
     * PK
     * @var integer
     */
    private $sequencia;

    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    private $timestamp;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEmpenho
     */
    private $fkFolhapagamentoConfiguracaoEmpenho;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Organograma\Orgao
     */
    private $fkOrganogramaOrgao;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
    }

    /**
     * Set codConfiguracao
     *
     * @param integer $codConfiguracao
     * @return ConfiguracaoEmpenhoLotacao
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
     * Set exercicio
     *
     * @param string $exercicio
     * @return ConfiguracaoEmpenhoLotacao
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
     * Set codOrgao
     *
     * @param integer $codOrgao
     * @return ConfiguracaoEmpenhoLotacao
     */
    public function setCodOrgao($codOrgao)
    {
        $this->codOrgao = $codOrgao;
        return $this;
    }

    /**
     * Get codOrgao
     *
     * @return integer
     */
    public function getCodOrgao()
    {
        return $this->codOrgao;
    }

    /**
     * Set sequencia
     *
     * @param integer $sequencia
     * @return ConfiguracaoEmpenhoLotacao
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
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp
     * @return ConfiguracaoEmpenhoLotacao
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
     * ManyToOne (inverse side)
     * Set fkFolhapagamentoConfiguracaoEmpenho
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEmpenho $fkFolhapagamentoConfiguracaoEmpenho
     * @return ConfiguracaoEmpenhoLotacao
     */
    public function setFkFolhapagamentoConfiguracaoEmpenho(\Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEmpenho $fkFolhapagamentoConfiguracaoEmpenho)
    {
        $this->codConfiguracao = $fkFolhapagamentoConfiguracaoEmpenho->getCodConfiguracao();
        $this->exercicio = $fkFolhapagamentoConfiguracaoEmpenho->getExercicio();
        $this->sequencia = $fkFolhapagamentoConfiguracaoEmpenho->getSequencia();
        $this->timestamp = $fkFolhapagamentoConfiguracaoEmpenho->getTimestamp();
        $this->fkFolhapagamentoConfiguracaoEmpenho = $fkFolhapagamentoConfiguracaoEmpenho;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkFolhapagamentoConfiguracaoEmpenho
     *
     * @return \Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEmpenho
     */
    public function getFkFolhapagamentoConfiguracaoEmpenho()
    {
        return $this->fkFolhapagamentoConfiguracaoEmpenho;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkOrganogramaOrgao
     *
     * @param \Urbem\CoreBundle\Entity\Organograma\Orgao $fkOrganogramaOrgao
     * @return ConfiguracaoEmpenhoLotacao
     */
    public function setFkOrganogramaOrgao(\Urbem\CoreBundle\Entity\Organograma\Orgao $fkOrganogramaOrgao)
    {
        $this->codOrgao = $fkOrganogramaOrgao->getCodOrgao();
        $this->fkOrganogramaOrgao = $fkOrganogramaOrgao;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkOrganogramaOrgao
     *
     * @return \Urbem\CoreBundle\Entity\Organograma\Orgao
     */
    public function getFkOrganogramaOrgao()
    {
        return $this->fkOrganogramaOrgao;
    }
}
