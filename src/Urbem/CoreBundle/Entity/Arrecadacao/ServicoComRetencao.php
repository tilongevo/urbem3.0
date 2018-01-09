<?php
 
namespace Urbem\CoreBundle\Entity\Arrecadacao;

/**
 * ServicoComRetencao
 */
class ServicoComRetencao
{
    /**
     * PK
     * @var integer
     */
    private $codAtividade;

    /**
     * PK
     * @var integer
     */
    private $codServico;

    /**
     * PK
     * @var integer
     */
    private $codMunicipio;

    /**
     * PK
     * @var integer
     */
    private $codUf;

    /**
     * PK
     * @var integer
     */
    private $numcgm;

    /**
     * PK
     * @var integer
     */
    private $inscricaoEconomica;

    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    private $timestamp;

    /**
     * PK
     * @var integer
     */
    private $ocorrencia;

    /**
     * @var integer
     */
    private $valorRetido;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Arrecadacao\FaturamentoServico
     */
    private $fkArrecadacaoFaturamentoServico;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\SwMunicipio
     */
    private $fkSwMunicipio;

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
     * Set codAtividade
     *
     * @param integer $codAtividade
     * @return ServicoComRetencao
     */
    public function setCodAtividade($codAtividade)
    {
        $this->codAtividade = $codAtividade;
        return $this;
    }

    /**
     * Get codAtividade
     *
     * @return integer
     */
    public function getCodAtividade()
    {
        return $this->codAtividade;
    }

    /**
     * Set codServico
     *
     * @param integer $codServico
     * @return ServicoComRetencao
     */
    public function setCodServico($codServico)
    {
        $this->codServico = $codServico;
        return $this;
    }

    /**
     * Get codServico
     *
     * @return integer
     */
    public function getCodServico()
    {
        return $this->codServico;
    }

    /**
     * Set codMunicipio
     *
     * @param integer $codMunicipio
     * @return ServicoComRetencao
     */
    public function setCodMunicipio($codMunicipio)
    {
        $this->codMunicipio = $codMunicipio;
        return $this;
    }

    /**
     * Get codMunicipio
     *
     * @return integer
     */
    public function getCodMunicipio()
    {
        return $this->codMunicipio;
    }

    /**
     * Set codUf
     *
     * @param integer $codUf
     * @return ServicoComRetencao
     */
    public function setCodUf($codUf)
    {
        $this->codUf = $codUf;
        return $this;
    }

    /**
     * Get codUf
     *
     * @return integer
     */
    public function getCodUf()
    {
        return $this->codUf;
    }

    /**
     * Set numcgm
     *
     * @param integer $numcgm
     * @return ServicoComRetencao
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
     * Set inscricaoEconomica
     *
     * @param integer $inscricaoEconomica
     * @return ServicoComRetencao
     */
    public function setInscricaoEconomica($inscricaoEconomica)
    {
        $this->inscricaoEconomica = $inscricaoEconomica;
        return $this;
    }

    /**
     * Get inscricaoEconomica
     *
     * @return integer
     */
    public function getInscricaoEconomica()
    {
        return $this->inscricaoEconomica;
    }

    /**
     * Set timestamp
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp
     * @return ServicoComRetencao
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
     * Set ocorrencia
     *
     * @param integer $ocorrencia
     * @return ServicoComRetencao
     */
    public function setOcorrencia($ocorrencia)
    {
        $this->ocorrencia = $ocorrencia;
        return $this;
    }

    /**
     * Get ocorrencia
     *
     * @return integer
     */
    public function getOcorrencia()
    {
        return $this->ocorrencia;
    }

    /**
     * Set valorRetido
     *
     * @param integer $valorRetido
     * @return ServicoComRetencao
     */
    public function setValorRetido($valorRetido)
    {
        $this->valorRetido = $valorRetido;
        return $this;
    }

    /**
     * Get valorRetido
     *
     * @return integer
     */
    public function getValorRetido()
    {
        return $this->valorRetido;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkArrecadacaoFaturamentoServico
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\FaturamentoServico $fkArrecadacaoFaturamentoServico
     * @return ServicoComRetencao
     */
    public function setFkArrecadacaoFaturamentoServico(\Urbem\CoreBundle\Entity\Arrecadacao\FaturamentoServico $fkArrecadacaoFaturamentoServico)
    {
        $this->codAtividade = $fkArrecadacaoFaturamentoServico->getCodAtividade();
        $this->codServico = $fkArrecadacaoFaturamentoServico->getCodServico();
        $this->inscricaoEconomica = $fkArrecadacaoFaturamentoServico->getInscricaoEconomica();
        $this->timestamp = $fkArrecadacaoFaturamentoServico->getTimestamp();
        $this->ocorrencia = $fkArrecadacaoFaturamentoServico->getOcorrencia();
        $this->fkArrecadacaoFaturamentoServico = $fkArrecadacaoFaturamentoServico;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkArrecadacaoFaturamentoServico
     *
     * @return \Urbem\CoreBundle\Entity\Arrecadacao\FaturamentoServico
     */
    public function getFkArrecadacaoFaturamentoServico()
    {
        return $this->fkArrecadacaoFaturamentoServico;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkSwMunicipio
     *
     * @param \Urbem\CoreBundle\Entity\SwMunicipio $fkSwMunicipio
     * @return ServicoComRetencao
     */
    public function setFkSwMunicipio(\Urbem\CoreBundle\Entity\SwMunicipio $fkSwMunicipio)
    {
        $this->codMunicipio = $fkSwMunicipio->getCodMunicipio();
        $this->codUf = $fkSwMunicipio->getCodUf();
        $this->fkSwMunicipio = $fkSwMunicipio;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkSwMunicipio
     *
     * @return \Urbem\CoreBundle\Entity\SwMunicipio
     */
    public function getFkSwMunicipio()
    {
        return $this->fkSwMunicipio;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkSwCgm
     *
     * @param \Urbem\CoreBundle\Entity\SwCgm $fkSwCgm
     * @return ServicoComRetencao
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
}
