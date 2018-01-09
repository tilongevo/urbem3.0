<?php
 
namespace Urbem\CoreBundle\Entity\Folhapagamento;

/**
 * ConfiguracaoEventoDespesa
 */
class ConfiguracaoEventoDespesa
{
    /**
     * PK
     * @var integer
     */
    private $codEvento;

    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    private $timestamp;

    /**
     * PK
     * @var integer
     */
    private $codConfiguracao;

    /**
     * @var string
     */
    private $exercicio;

    /**
     * @var integer
     */
    private $codConta;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Folhapagamento\EventoConfiguracaoEvento
     */
    private $fkFolhapagamentoEventoConfiguracaoEvento;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Orcamento\ContaDespesa
     */
    private $fkOrcamentoContaDespesa;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
    }

    /**
     * Set codEvento
     *
     * @param integer $codEvento
     * @return ConfiguracaoEventoDespesa
     */
    public function setCodEvento($codEvento)
    {
        $this->codEvento = $codEvento;
        return $this;
    }

    /**
     * Get codEvento
     *
     * @return integer
     */
    public function getCodEvento()
    {
        return $this->codEvento;
    }

    /**
     * Set timestamp
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp
     * @return ConfiguracaoEventoDespesa
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
     * Set codConfiguracao
     *
     * @param integer $codConfiguracao
     * @return ConfiguracaoEventoDespesa
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
     * @return ConfiguracaoEventoDespesa
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
     * Set codConta
     *
     * @param integer $codConta
     * @return ConfiguracaoEventoDespesa
     */
    public function setCodConta($codConta)
    {
        $this->codConta = $codConta;
        return $this;
    }

    /**
     * Get codConta
     *
     * @return integer
     */
    public function getCodConta()
    {
        return $this->codConta;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkOrcamentoContaDespesa
     *
     * @param \Urbem\CoreBundle\Entity\Orcamento\ContaDespesa $fkOrcamentoContaDespesa
     * @return ConfiguracaoEventoDespesa
     */
    public function setFkOrcamentoContaDespesa(\Urbem\CoreBundle\Entity\Orcamento\ContaDespesa $fkOrcamentoContaDespesa)
    {
        $this->exercicio = $fkOrcamentoContaDespesa->getExercicio();
        $this->codConta = $fkOrcamentoContaDespesa->getCodConta();
        $this->fkOrcamentoContaDespesa = $fkOrcamentoContaDespesa;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkOrcamentoContaDespesa
     *
     * @return \Urbem\CoreBundle\Entity\Orcamento\ContaDespesa
     */
    public function getFkOrcamentoContaDespesa()
    {
        return $this->fkOrcamentoContaDespesa;
    }

    /**
     * OneToOne (owning side)
     * Set FolhapagamentoEventoConfiguracaoEvento
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\EventoConfiguracaoEvento $fkFolhapagamentoEventoConfiguracaoEvento
     * @return ConfiguracaoEventoDespesa
     */
    public function setFkFolhapagamentoEventoConfiguracaoEvento(\Urbem\CoreBundle\Entity\Folhapagamento\EventoConfiguracaoEvento $fkFolhapagamentoEventoConfiguracaoEvento)
    {
        $this->codEvento = $fkFolhapagamentoEventoConfiguracaoEvento->getCodEvento();
        $this->timestamp = $fkFolhapagamentoEventoConfiguracaoEvento->getTimestamp();
        $this->codConfiguracao = $fkFolhapagamentoEventoConfiguracaoEvento->getCodConfiguracao();
        $this->fkFolhapagamentoEventoConfiguracaoEvento = $fkFolhapagamentoEventoConfiguracaoEvento;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkFolhapagamentoEventoConfiguracaoEvento
     *
     * @return \Urbem\CoreBundle\Entity\Folhapagamento\EventoConfiguracaoEvento
     */
    public function getFkFolhapagamentoEventoConfiguracaoEvento()
    {
        return $this->fkFolhapagamentoEventoConfiguracaoEvento;
    }
}
