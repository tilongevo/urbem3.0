<?php
 
namespace Urbem\CoreBundle\Entity\Empenho;

use Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;

/**
 * AutorizacaoAnulada
 */
class AutorizacaoAnulada
{
    /**
     * PK
     * @var integer
     */
    private $codEntidade;

    /**
     * PK
     * @var string
     */
    private $exercicio;

    /**
     * PK
     * @var integer
     */
    private $codAutorizacao;

    /**
     * @var DateTimeMicrosecondPK
     */
    private $dtAnulacao;

    /**
     * @var string
     */
    private $motivo;

    /**
     * @var \Urbem\CoreBundle\Helper\TimeMicrosecondPK
     */
    private $hora;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Empenho\AutorizacaoEmpenho
     */
    private $fkEmpenhoAutorizacaoEmpenho;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->hora = new \Urbem\CoreBundle\Helper\TimeMicrosecondPK;
    }

    /**
     * Set codEntidade
     *
     * @param integer $codEntidade
     * @return AutorizacaoAnulada
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
     * Set exercicio
     *
     * @param string $exercicio
     * @return AutorizacaoAnulada
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
     * Set codAutorizacao
     *
     * @param integer $codAutorizacao
     * @return AutorizacaoAnulada
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
     * Set dtAnulacao
     *
     * @param DateTimeMicrosecondPK $dtAnulacao
     * @return AutorizacaoAnulada
     */
    public function setDtAnulacao(DateTimeMicrosecondPK $dtAnulacao)
    {
        $this->dtAnulacao = $dtAnulacao;
        return $this;
    }

    /**
     * Get dtAnulacao
     *
     * @return DateTimeMicrosecondPK
     */
    public function getDtAnulacao()
    {
        return $this->dtAnulacao;
    }

    /**
     * Set motivo
     *
     * @param string $motivo
     * @return AutorizacaoAnulada
     */
    public function setMotivo($motivo)
    {
        $this->motivo = $motivo;
        return $this;
    }

    /**
     * Get motivo
     *
     * @return string
     */
    public function getMotivo()
    {
        return $this->motivo;
    }

    /**
     * Set hora
     *
     * @param \Urbem\CoreBundle\Helper\TimeMicrosecondPK $hora
     * @return AutorizacaoAnulada
     */
    public function setHora(\Urbem\CoreBundle\Helper\TimeMicrosecondPK $hora)
    {
        $this->hora = $hora;
        return $this;
    }

    /**
     * Get hora
     *
     * @return \Urbem\CoreBundle\Helper\TimeMicrosecondPK
     */
    public function getHora()
    {
        return $this->hora;
    }

    /**
     * OneToOne (owning side)
     * Set EmpenhoAutorizacaoEmpenho
     *
     * @param \Urbem\CoreBundle\Entity\Empenho\AutorizacaoEmpenho $fkEmpenhoAutorizacaoEmpenho
     * @return AutorizacaoAnulada
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
     * OneToOne (owning side)
     * Get fkEmpenhoAutorizacaoEmpenho
     *
     * @return \Urbem\CoreBundle\Entity\Empenho\AutorizacaoEmpenho
     */
    public function getFkEmpenhoAutorizacaoEmpenho()
    {
        return $this->fkEmpenhoAutorizacaoEmpenho;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return sprintf('(%s/%s)', $this->codAutorizacao, $this->exercicio);
    }
}
