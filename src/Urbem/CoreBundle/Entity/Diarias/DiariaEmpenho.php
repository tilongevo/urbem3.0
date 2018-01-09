<?php
 
namespace Urbem\CoreBundle\Entity\Diarias;

/**
 * DiariaEmpenho
 */
class DiariaEmpenho
{
    /**
     * PK
     * @var integer
     */
    private $codDiaria;

    /**
     * PK
     * @var integer
     */
    private $codContrato;

    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DateTimePK
     */
    private $timestamp;

    /**
     * @var string
     */
    private $exercicio;

    /**
     * @var integer
     */
    private $codEntidade;

    /**
     * @var integer
     */
    private $codAutorizacao;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Diarias\Diaria
     */
    private $fkDiariasDiaria;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Empenho\AutorizacaoEmpenho
     */
    private $fkEmpenhoAutorizacaoEmpenho;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimePK;
    }

    /**
     * Set codDiaria
     *
     * @param integer $codDiaria
     * @return DiariaEmpenho
     */
    public function setCodDiaria($codDiaria)
    {
        $this->codDiaria = $codDiaria;
        return $this;
    }

    /**
     * Get codDiaria
     *
     * @return integer
     */
    public function getCodDiaria()
    {
        return $this->codDiaria;
    }

    /**
     * Set codContrato
     *
     * @param integer $codContrato
     * @return DiariaEmpenho
     */
    public function setCodContrato($codContrato)
    {
        $this->codContrato = $codContrato;
        return $this;
    }

    /**
     * Get codContrato
     *
     * @return integer
     */
    public function getCodContrato()
    {
        return $this->codContrato;
    }

    /**
     * Set timestamp
     *
     * @param \Urbem\CoreBundle\Helper\DateTimePK $timestamp
     * @return DiariaEmpenho
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
     * Set exercicio
     *
     * @param string $exercicio
     * @return DiariaEmpenho
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
     * Set codEntidade
     *
     * @param integer $codEntidade
     * @return DiariaEmpenho
     */
    public function setCodEntidade($codEntidade)
    {
        $this->codEntidade = $codEntidade;
        return $this;
    }

    /**
     * Get codEntidade
     *
     * @return integer
     */
    public function getCodEntidade()
    {
        return $this->codEntidade;
    }

    /**
     * Set codAutorizacao
     *
     * @param integer $codAutorizacao
     * @return DiariaEmpenho
     */
    public function setCodAutorizacao($codAutorizacao)
    {
        $this->codAutorizacao = $codAutorizacao;
        return $this;
    }

    /**
     * Get codAutorizacao
     *
     * @return integer
     */
    public function getCodAutorizacao()
    {
        return $this->codAutorizacao;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkEmpenhoAutorizacaoEmpenho
     *
     * @param \Urbem\CoreBundle\Entity\Empenho\AutorizacaoEmpenho $fkEmpenhoAutorizacaoEmpenho
     * @return DiariaEmpenho
     */
    public function setFkEmpenhoAutorizacaoEmpenho(\Urbem\CoreBundle\Entity\Empenho\AutorizacaoEmpenho $fkEmpenhoAutorizacaoEmpenho)
    {
        $this->codAutorizacao = $fkEmpenhoAutorizacaoEmpenho->getCodAutorizacao();
        $this->exercicio = $fkEmpenhoAutorizacaoEmpenho->getExercicio();
        $this->codEntidade = $fkEmpenhoAutorizacaoEmpenho->getCodEntidade();
        $this->fkEmpenhoAutorizacaoEmpenho = $fkEmpenhoAutorizacaoEmpenho;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkEmpenhoAutorizacaoEmpenho
     *
     * @return \Urbem\CoreBundle\Entity\Empenho\AutorizacaoEmpenho
     */
    public function getFkEmpenhoAutorizacaoEmpenho()
    {
        return $this->fkEmpenhoAutorizacaoEmpenho;
    }

    /**
     * OneToOne (owning side)
     * Set DiariasDiaria
     *
     * @param \Urbem\CoreBundle\Entity\Diarias\Diaria $fkDiariasDiaria
     * @return DiariaEmpenho
     */
    public function setFkDiariasDiaria(\Urbem\CoreBundle\Entity\Diarias\Diaria $fkDiariasDiaria)
    {
        $this->codDiaria = $fkDiariasDiaria->getCodDiaria();
        $this->codContrato = $fkDiariasDiaria->getCodContrato();
        $this->timestamp = $fkDiariasDiaria->getTimestamp();
        $this->fkDiariasDiaria = $fkDiariasDiaria;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkDiariasDiaria
     *
     * @return \Urbem\CoreBundle\Entity\Diarias\Diaria
     */
    public function getFkDiariasDiaria()
    {
        return $this->fkDiariasDiaria;
    }
}
