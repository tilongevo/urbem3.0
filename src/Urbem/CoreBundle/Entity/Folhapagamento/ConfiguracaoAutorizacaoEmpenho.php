<?php
 
namespace Urbem\CoreBundle\Entity\Folhapagamento;

/**
 * ConfiguracaoAutorizacaoEmpenho
 */
class ConfiguracaoAutorizacaoEmpenho
{
    /**
     * PK
     * @var integer
     */
    private $codConfiguracaoAutorizacao;

    /**
     * PK
     * @var string
     */
    private $exercicio;

    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    private $timestamp;

    /**
     * @var integer
     */
    private $codModalidade;

    /**
     * @var integer
     */
    private $numcgm;

    /**
     * @var boolean
     */
    private $complementar = false;

    /**
     * @var string
     */
    private $descricaoItem;

    /**
     * @var \DateTime
     */
    private $vigencia;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoAutorizacaoEmpenhoComplemento
     */
    private $fkFolhapagamentoConfiguracaoAutorizacaoEmpenhoComplemento;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoAutorizacaoEmpenhoDescricao
     */
    private $fkFolhapagamentoConfiguracaoAutorizacaoEmpenhoDescricao;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoAutorizacaoEmpenhoHistorico
     */
    private $fkFolhapagamentoConfiguracaoAutorizacaoEmpenhoHistorico;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Compras\Modalidade
     */
    private $fkComprasModalidade;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\SwCgm
     */
    private $fkSwCgm;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
    }

    /**
     * Set codConfiguracaoAutorizacao
     *
     * @param integer $codConfiguracaoAutorizacao
     * @return ConfiguracaoAutorizacaoEmpenho
     */
    public function setCodConfiguracaoAutorizacao($codConfiguracaoAutorizacao)
    {
        $this->codConfiguracaoAutorizacao = $codConfiguracaoAutorizacao;
        return $this;
    }

    /**
     * Get codConfiguracaoAutorizacao
     *
     * @return integer
     */
    public function getCodConfiguracaoAutorizacao()
    {
        return $this->codConfiguracaoAutorizacao;
    }

    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return ConfiguracaoAutorizacaoEmpenho
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
     * Set timestamp
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp
     * @return ConfiguracaoAutorizacaoEmpenho
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
     * Set codModalidade
     *
     * @param integer $codModalidade
     * @return ConfiguracaoAutorizacaoEmpenho
     */
    public function setCodModalidade($codModalidade)
    {
        $this->codModalidade = $codModalidade;
        return $this;
    }

    /**
     * Get codModalidade
     *
     * @return integer
     */
    public function getCodModalidade()
    {
        return $this->codModalidade;
    }

    /**
     * Set numcgm
     *
     * @param integer $numcgm
     * @return ConfiguracaoAutorizacaoEmpenho
     */
    public function setNumcgm($numcgm)
    {
        $this->numcgm = $numcgm;
        return $this;
    }

    /**
     * Get numcgm
     *
     * @return integer
     */
    public function getNumcgm()
    {
        return $this->numcgm;
    }

    /**
     * Set complementar
     *
     * @param boolean $complementar
     * @return ConfiguracaoAutorizacaoEmpenho
     */
    public function setComplementar($complementar)
    {
        $this->complementar = $complementar;
        return $this;
    }

    /**
     * Get complementar
     *
     * @return boolean
     */
    public function getComplementar()
    {
        return $this->complementar;
    }

    /**
     * Set descricaoItem
     *
     * @param string $descricaoItem
     * @return ConfiguracaoAutorizacaoEmpenho
     */
    public function setDescricaoItem($descricaoItem)
    {
        $this->descricaoItem = $descricaoItem;
        return $this;
    }

    /**
     * Get descricaoItem
     *
     * @return string
     */
    public function getDescricaoItem()
    {
        return $this->descricaoItem;
    }

    /**
     * Set vigencia
     *
     * @param \DateTime $vigencia
     * @return ConfiguracaoAutorizacaoEmpenho
     */
    public function setVigencia(\DateTime $vigencia)
    {
        $this->vigencia = $vigencia;
        return $this;
    }

    /**
     * Get vigencia
     *
     * @return \DateTime
     */
    public function getVigencia()
    {
        return $this->vigencia;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkComprasModalidade
     *
     * @param \Urbem\CoreBundle\Entity\Compras\Modalidade $fkComprasModalidade
     * @return ConfiguracaoAutorizacaoEmpenho
     */
    public function setFkComprasModalidade(\Urbem\CoreBundle\Entity\Compras\Modalidade $fkComprasModalidade)
    {
        $this->codModalidade = $fkComprasModalidade->getCodModalidade();
        $this->fkComprasModalidade = $fkComprasModalidade;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkComprasModalidade
     *
     * @return \Urbem\CoreBundle\Entity\Compras\Modalidade
     */
    public function getFkComprasModalidade()
    {
        return $this->fkComprasModalidade;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkSwCgm
     *
     * @param \Urbem\CoreBundle\Entity\SwCgm $fkSwCgm
     * @return ConfiguracaoAutorizacaoEmpenho
     */
    public function setFkSwCgm(\Urbem\CoreBundle\Entity\SwCgm $fkSwCgm)
    {
        $this->numcgm = $fkSwCgm->getNumcgm();
        $this->fkSwCgm = $fkSwCgm;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkSwCgm
     *
     * @return \Urbem\CoreBundle\Entity\SwCgm
     */
    public function getFkSwCgm()
    {
        return $this->fkSwCgm;
    }

    /**
     * OneToOne (inverse side)
     * Set FolhapagamentoConfiguracaoAutorizacaoEmpenhoComplemento
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoAutorizacaoEmpenhoComplemento $fkFolhapagamentoConfiguracaoAutorizacaoEmpenhoComplemento
     * @return ConfiguracaoAutorizacaoEmpenho
     */
    public function setFkFolhapagamentoConfiguracaoAutorizacaoEmpenhoComplemento(\Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoAutorizacaoEmpenhoComplemento $fkFolhapagamentoConfiguracaoAutorizacaoEmpenhoComplemento)
    {
        $fkFolhapagamentoConfiguracaoAutorizacaoEmpenhoComplemento->setFkFolhapagamentoConfiguracaoAutorizacaoEmpenho($this);
        $this->fkFolhapagamentoConfiguracaoAutorizacaoEmpenhoComplemento = $fkFolhapagamentoConfiguracaoAutorizacaoEmpenhoComplemento;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkFolhapagamentoConfiguracaoAutorizacaoEmpenhoComplemento
     *
     * @return \Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoAutorizacaoEmpenhoComplemento
     */
    public function getFkFolhapagamentoConfiguracaoAutorizacaoEmpenhoComplemento()
    {
        return $this->fkFolhapagamentoConfiguracaoAutorizacaoEmpenhoComplemento;
    }

    /**
     * OneToOne (inverse side)
     * Set FolhapagamentoConfiguracaoAutorizacaoEmpenhoDescricao
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoAutorizacaoEmpenhoDescricao $fkFolhapagamentoConfiguracaoAutorizacaoEmpenhoDescricao
     * @return ConfiguracaoAutorizacaoEmpenho
     */
    public function setFkFolhapagamentoConfiguracaoAutorizacaoEmpenhoDescricao(\Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoAutorizacaoEmpenhoDescricao $fkFolhapagamentoConfiguracaoAutorizacaoEmpenhoDescricao)
    {
        $fkFolhapagamentoConfiguracaoAutorizacaoEmpenhoDescricao->setFkFolhapagamentoConfiguracaoAutorizacaoEmpenho($this);
        $this->fkFolhapagamentoConfiguracaoAutorizacaoEmpenhoDescricao = $fkFolhapagamentoConfiguracaoAutorizacaoEmpenhoDescricao;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkFolhapagamentoConfiguracaoAutorizacaoEmpenhoDescricao
     *
     * @return \Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoAutorizacaoEmpenhoDescricao
     */
    public function getFkFolhapagamentoConfiguracaoAutorizacaoEmpenhoDescricao()
    {
        return $this->fkFolhapagamentoConfiguracaoAutorizacaoEmpenhoDescricao;
    }

    /**
     * OneToOne (inverse side)
     * Set FolhapagamentoConfiguracaoAutorizacaoEmpenhoHistorico
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoAutorizacaoEmpenhoHistorico $fkFolhapagamentoConfiguracaoAutorizacaoEmpenhoHistorico
     * @return ConfiguracaoAutorizacaoEmpenho
     */
    public function setFkFolhapagamentoConfiguracaoAutorizacaoEmpenhoHistorico(\Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoAutorizacaoEmpenhoHistorico $fkFolhapagamentoConfiguracaoAutorizacaoEmpenhoHistorico)
    {
        $fkFolhapagamentoConfiguracaoAutorizacaoEmpenhoHistorico->setFkFolhapagamentoConfiguracaoAutorizacaoEmpenho($this);
        $this->fkFolhapagamentoConfiguracaoAutorizacaoEmpenhoHistorico = $fkFolhapagamentoConfiguracaoAutorizacaoEmpenhoHistorico;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkFolhapagamentoConfiguracaoAutorizacaoEmpenhoHistorico
     *
     * @return \Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoAutorizacaoEmpenhoHistorico
     */
    public function getFkFolhapagamentoConfiguracaoAutorizacaoEmpenhoHistorico()
    {
        return $this->fkFolhapagamentoConfiguracaoAutorizacaoEmpenhoHistorico;
    }
}
