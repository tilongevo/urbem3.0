<?php
 
namespace Urbem\CoreBundle\Entity\Pessoal;

/**
 * TcepeConfiguracaoRelacionaHistorico
 */
class TcepeConfiguracaoRelacionaHistorico
{
    /**
     * PK
     * @var integer
     */
    private $codAssentamento;

    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DateTimePK
     */
    private $timestamp;

    /**
     * PK
     * @var integer
     */
    private $codTipoMovimentacao;

    /**
     * PK
     * @var string
     */
    private $exercicio;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Pessoal\Assentamento
     */
    private $fkPessoalAssentamento;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Tcepe\TipoMovimentacao
     */
    private $fkTcepeTipoMovimentacao;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimePK;
    }

    /**
     * Set codAssentamento
     *
     * @param integer $codAssentamento
     * @return TcepeConfiguracaoRelacionaHistorico
     */
    public function setCodAssentamento($codAssentamento)
    {
        $this->codAssentamento = $codAssentamento;
        return $this;
    }

    /**
     * Get codAssentamento
     *
     * @return integer
     */
    public function getCodAssentamento()
    {
        return $this->codAssentamento;
    }

    /**
     * Set timestamp
     *
     * @param \Urbem\CoreBundle\Helper\DateTimePK $timestamp
     * @return TcepeConfiguracaoRelacionaHistorico
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
     * Set codTipoMovimentacao
     *
     * @param integer $codTipoMovimentacao
     * @return TcepeConfiguracaoRelacionaHistorico
     */
    public function setCodTipoMovimentacao($codTipoMovimentacao)
    {
        $this->codTipoMovimentacao = $codTipoMovimentacao;
        return $this;
    }

    /**
     * Get codTipoMovimentacao
     *
     * @return integer
     */
    public function getCodTipoMovimentacao()
    {
        return $this->codTipoMovimentacao;
    }

    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return TcepeConfiguracaoRelacionaHistorico
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
     * ManyToOne (inverse side)
     * Set fkPessoalAssentamento
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\Assentamento $fkPessoalAssentamento
     * @return TcepeConfiguracaoRelacionaHistorico
     */
    public function setFkPessoalAssentamento(\Urbem\CoreBundle\Entity\Pessoal\Assentamento $fkPessoalAssentamento)
    {
        $this->codAssentamento = $fkPessoalAssentamento->getCodAssentamento();
        $this->timestamp = $fkPessoalAssentamento->getTimestamp();
        $this->fkPessoalAssentamento = $fkPessoalAssentamento;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkPessoalAssentamento
     *
     * @return \Urbem\CoreBundle\Entity\Pessoal\Assentamento
     */
    public function getFkPessoalAssentamento()
    {
        return $this->fkPessoalAssentamento;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkTcepeTipoMovimentacao
     *
     * @param \Urbem\CoreBundle\Entity\Tcepe\TipoMovimentacao $fkTcepeTipoMovimentacao
     * @return TcepeConfiguracaoRelacionaHistorico
     */
    public function setFkTcepeTipoMovimentacao(\Urbem\CoreBundle\Entity\Tcepe\TipoMovimentacao $fkTcepeTipoMovimentacao)
    {
        $this->codTipoMovimentacao = $fkTcepeTipoMovimentacao->getCodTipoMovimentacao();
        $this->fkTcepeTipoMovimentacao = $fkTcepeTipoMovimentacao;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkTcepeTipoMovimentacao
     *
     * @return \Urbem\CoreBundle\Entity\Tcepe\TipoMovimentacao
     */
    public function getFkTcepeTipoMovimentacao()
    {
        return $this->fkTcepeTipoMovimentacao;
    }
}
