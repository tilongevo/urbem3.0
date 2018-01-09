<?php
 
namespace Urbem\CoreBundle\Entity\Empenho;

/**
 * OrdemPagamentoReciboExtra
 */
class OrdemPagamentoReciboExtra
{
    /**
     * PK
     * @var string
     */
    private $exercicio;

    /**
     * PK
     * @var integer
     */
    private $codEntidade;

    /**
     * PK
     * @var integer
     */
    private $codOrdem;

    /**
     * PK
     * @var integer
     */
    private $codReciboExtra;

    /**
     * PK
     * @var string
     */
    private $tipoRecibo;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Tesouraria\ReciboExtra
     */
    private $fkTesourariaReciboExtra;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Empenho\OrdemPagamento
     */
    private $fkEmpenhoOrdemPagamento;


    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return OrdemPagamentoReciboExtra
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
     * @return OrdemPagamentoReciboExtra
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
     * Set codOrdem
     *
     * @param integer $codOrdem
     * @return OrdemPagamentoReciboExtra
     */
    public function setCodOrdem($codOrdem)
    {
        $this->codOrdem = $codOrdem;
        return $this;
    }

    /**
     * Get codOrdem
     *
     * @return integer
     */
    public function getCodOrdem()
    {
        return $this->codOrdem;
    }

    /**
     * Set codReciboExtra
     *
     * @param integer $codReciboExtra
     * @return OrdemPagamentoReciboExtra
     */
    public function setCodReciboExtra($codReciboExtra)
    {
        $this->codReciboExtra = $codReciboExtra;
        return $this;
    }

    /**
     * Get codReciboExtra
     *
     * @return integer
     */
    public function getCodReciboExtra()
    {
        return $this->codReciboExtra;
    }

    /**
     * Set tipoRecibo
     *
     * @param string $tipoRecibo
     * @return OrdemPagamentoReciboExtra
     */
    public function setTipoRecibo($tipoRecibo)
    {
        $this->tipoRecibo = $tipoRecibo;
        return $this;
    }

    /**
     * Get tipoRecibo
     *
     * @return string
     */
    public function getTipoRecibo()
    {
        return $this->tipoRecibo;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkTesourariaReciboExtra
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\ReciboExtra $fkTesourariaReciboExtra
     * @return OrdemPagamentoReciboExtra
     */
    public function setFkTesourariaReciboExtra(\Urbem\CoreBundle\Entity\Tesouraria\ReciboExtra $fkTesourariaReciboExtra)
    {
        $this->codReciboExtra = $fkTesourariaReciboExtra->getCodReciboExtra();
        $this->exercicio = $fkTesourariaReciboExtra->getExercicio();
        $this->codEntidade = $fkTesourariaReciboExtra->getCodEntidade();
        $this->tipoRecibo = $fkTesourariaReciboExtra->getTipoRecibo();
        $this->fkTesourariaReciboExtra = $fkTesourariaReciboExtra;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkTesourariaReciboExtra
     *
     * @return \Urbem\CoreBundle\Entity\Tesouraria\ReciboExtra
     */
    public function getFkTesourariaReciboExtra()
    {
        return $this->fkTesourariaReciboExtra;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkEmpenhoOrdemPagamento
     *
     * @param \Urbem\CoreBundle\Entity\Empenho\OrdemPagamento $fkEmpenhoOrdemPagamento
     * @return OrdemPagamentoReciboExtra
     */
    public function setFkEmpenhoOrdemPagamento(\Urbem\CoreBundle\Entity\Empenho\OrdemPagamento $fkEmpenhoOrdemPagamento)
    {
        $this->codOrdem = $fkEmpenhoOrdemPagamento->getCodOrdem();
        $this->exercicio = $fkEmpenhoOrdemPagamento->getExercicio();
        $this->codEntidade = $fkEmpenhoOrdemPagamento->getCodEntidade();
        $this->fkEmpenhoOrdemPagamento = $fkEmpenhoOrdemPagamento;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkEmpenhoOrdemPagamento
     *
     * @return \Urbem\CoreBundle\Entity\Empenho\OrdemPagamento
     */
    public function getFkEmpenhoOrdemPagamento()
    {
        return $this->fkEmpenhoOrdemPagamento;
    }
}
