<?php
 
namespace Urbem\CoreBundle\Entity\Folhapagamento;

/**
 * ConfiguracaoEmpenhoLlaLotacao
 */
class ConfiguracaoEmpenhoLlaLotacao
{
    /**
     * PK
     * @var integer
     */
    private $codOrgao;

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
     * @var \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    private $timestamp;

    /**
     * @var integer
     */
    private $numPao;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Organograma\Orgao
     */
    private $fkOrganogramaOrgao;

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
     * Constructor
     */
    public function __construct()
    {
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
    }

    /**
     * Set codOrgao
     *
     * @param integer $codOrgao
     * @return ConfiguracaoEmpenhoLlaLotacao
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
     * Set exercicio
     *
     * @param string $exercicio
     * @return ConfiguracaoEmpenhoLlaLotacao
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
     * @return ConfiguracaoEmpenhoLlaLotacao
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
     * @return ConfiguracaoEmpenhoLlaLotacao
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
     * @return ConfiguracaoEmpenhoLlaLotacao
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
     * Set fkOrganogramaOrgao
     *
     * @param \Urbem\CoreBundle\Entity\Organograma\Orgao $fkOrganogramaOrgao
     * @return ConfiguracaoEmpenhoLlaLotacao
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

    /**
     * ManyToOne (inverse side)
     * Set fkOrcamentoPao
     *
     * @param \Urbem\CoreBundle\Entity\Orcamento\Pao $fkOrcamentoPao
     * @return ConfiguracaoEmpenhoLlaLotacao
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
     * @return ConfiguracaoEmpenhoLlaLotacao
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
}
