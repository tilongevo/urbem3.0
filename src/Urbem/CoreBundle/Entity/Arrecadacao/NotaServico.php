<?php
 
namespace Urbem\CoreBundle\Entity\Arrecadacao;

/**
 * NotaServico
 */
class NotaServico
{
    /**
     * PK
     * @var integer
     */
    private $codNota;

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
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Arrecadacao\Nota
     */
    private $fkArrecadacaoNota;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Arrecadacao\FaturamentoServico
     */
    private $fkArrecadacaoFaturamentoServico;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
    }

    /**
     * Set codNota
     *
     * @param integer $codNota
     * @return NotaServico
     */
    public function setCodNota($codNota)
    {
        $this->codNota = $codNota;
        return $this;
    }

    /**
     * Get codNota
     *
     * @return integer
     */
    public function getCodNota()
    {
        return $this->codNota;
    }

    /**
     * Set codAtividade
     *
     * @param integer $codAtividade
     * @return NotaServico
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
     * @return NotaServico
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
     * Set inscricaoEconomica
     *
     * @param integer $inscricaoEconomica
     * @return NotaServico
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
     * @return NotaServico
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
     * @return NotaServico
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
     * ManyToOne (inverse side)
     * Set fkArrecadacaoNota
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\Nota $fkArrecadacaoNota
     * @return NotaServico
     */
    public function setFkArrecadacaoNota(\Urbem\CoreBundle\Entity\Arrecadacao\Nota $fkArrecadacaoNota)
    {
        $this->codNota = $fkArrecadacaoNota->getCodNota();
        $this->fkArrecadacaoNota = $fkArrecadacaoNota;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkArrecadacaoNota
     *
     * @return \Urbem\CoreBundle\Entity\Arrecadacao\Nota
     */
    public function getFkArrecadacaoNota()
    {
        return $this->fkArrecadacaoNota;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkArrecadacaoFaturamentoServico
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\FaturamentoServico $fkArrecadacaoFaturamentoServico
     * @return NotaServico
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
}
