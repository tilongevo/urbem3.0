<?php
 
namespace Urbem\CoreBundle\Entity\Ldo;

/**
 * AcaoValidada
 */
class AcaoValidada
{
    /**
     * PK
     * @var integer
     */
    private $codAcao;

    /**
     * PK
     * @var string
     */
    private $ano;

    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    private $timestampAcaoDados;

    /**
     * PK
     * @var integer
     */
    private $codRecurso;

    /**
     * PK
     * @var string
     */
    private $exercicioRecurso;

    /**
     * @var integer
     */
    private $valor;

    /**
     * @var integer
     */
    private $quantidade;

    /**
     * @var \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    private $timestamp;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Ppa\AcaoQuantidade
     */
    private $fkPpaAcaoQuantidade;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->timestampAcaoDados = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
    }

    /**
     * Set codAcao
     *
     * @param integer $codAcao
     * @return AcaoValidada
     */
    public function setCodAcao($codAcao)
    {
        $this->codAcao = $codAcao;
        return $this;
    }

    /**
     * Get codAcao
     *
     * @return integer
     */
    public function getCodAcao()
    {
        return $this->codAcao;
    }

    /**
     * Set ano
     *
     * @param string $ano
     * @return AcaoValidada
     */
    public function setAno($ano)
    {
        $this->ano = $ano;
        return $this;
    }

    /**
     * Get ano
     *
     * @return string
     */
    public function getAno()
    {
        return $this->ano;
    }

    /**
     * Set timestampAcaoDados
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestampAcaoDados
     * @return AcaoValidada
     */
    public function setTimestampAcaoDados(\Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestampAcaoDados)
    {
        $this->timestampAcaoDados = $timestampAcaoDados;
        return $this;
    }

    /**
     * Get timestampAcaoDados
     *
     * @return \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    public function getTimestampAcaoDados()
    {
        return $this->timestampAcaoDados;
    }

    /**
     * Set codRecurso
     *
     * @param integer $codRecurso
     * @return AcaoValidada
     */
    public function setCodRecurso($codRecurso)
    {
        $this->codRecurso = $codRecurso;
        return $this;
    }

    /**
     * Get codRecurso
     *
     * @return integer
     */
    public function getCodRecurso()
    {
        return $this->codRecurso;
    }

    /**
     * Set exercicioRecurso
     *
     * @param string $exercicioRecurso
     * @return AcaoValidada
     */
    public function setExercicioRecurso($exercicioRecurso)
    {
        $this->exercicioRecurso = $exercicioRecurso;
        return $this;
    }

    /**
     * Get exercicioRecurso
     *
     * @return string
     */
    public function getExercicioRecurso()
    {
        return $this->exercicioRecurso;
    }

    /**
     * Set valor
     *
     * @param integer $valor
     * @return AcaoValidada
     */
    public function setValor($valor)
    {
        $this->valor = $valor;
        return $this;
    }

    /**
     * Get valor
     *
     * @return integer
     */
    public function getValor()
    {
        return $this->valor;
    }

    /**
     * Set quantidade
     *
     * @param integer $quantidade
     * @return AcaoValidada
     */
    public function setQuantidade($quantidade)
    {
        $this->quantidade = $quantidade;
        return $this;
    }

    /**
     * Get quantidade
     *
     * @return integer
     */
    public function getQuantidade()
    {
        return $this->quantidade;
    }

    /**
     * Set timestamp
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp
     * @return AcaoValidada
     */
    public function setTimestamp(\Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp = null)
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
     * OneToOne (owning side)
     * Set PpaAcaoQuantidade
     *
     * @param \Urbem\CoreBundle\Entity\Ppa\AcaoQuantidade $fkPpaAcaoQuantidade
     * @return AcaoValidada
     */
    public function setFkPpaAcaoQuantidade(\Urbem\CoreBundle\Entity\Ppa\AcaoQuantidade $fkPpaAcaoQuantidade)
    {
        $this->codAcao = $fkPpaAcaoQuantidade->getCodAcao();
        $this->timestampAcaoDados = $fkPpaAcaoQuantidade->getTimestampAcaoDados();
        $this->ano = $fkPpaAcaoQuantidade->getAno();
        $this->codRecurso = $fkPpaAcaoQuantidade->getCodRecurso();
        $this->exercicioRecurso = $fkPpaAcaoQuantidade->getExercicioRecurso();
        $this->fkPpaAcaoQuantidade = $fkPpaAcaoQuantidade;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkPpaAcaoQuantidade
     *
     * @return \Urbem\CoreBundle\Entity\Ppa\AcaoQuantidade
     */
    public function getFkPpaAcaoQuantidade()
    {
        return $this->fkPpaAcaoQuantidade;
    }
}
