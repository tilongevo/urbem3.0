<?php
 
namespace Urbem\CoreBundle\Entity\Tcepe;

/**
 * TipoTransferenciaRecebida
 */
class TipoTransferenciaRecebida
{
    /**
     * PK
     * @var integer
     */
    private $codLote;

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
     * @var string
     */
    private $tipo;

    /**
     * PK
     * @var integer
     */
    private $codTipoTcepe;

    /**
     * @var integer
     */
    private $codEntidadeTransferidora;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Tesouraria\Transferencia
     */
    private $fkTesourariaTransferencia;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Orcamento\Entidade
     */
    private $fkOrcamentoEntidade;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Tcepe\TipoTransferencia
     */
    private $fkTcepeTipoTransferencia;


    /**
     * Set codLote
     *
     * @param integer $codLote
     * @return TipoTransferenciaRecebida
     */
    public function setCodLote($codLote)
    {
        $this->codLote = $codLote;
        return $this;
    }

    /**
     * Get codLote
     *
     * @return integer
     */
    public function getCodLote()
    {
        return $this->codLote;
    }

    /**
     * Set codEntidade
     *
     * @param integer $codEntidade
     * @return TipoTransferenciaRecebida
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
     * @return TipoTransferenciaRecebida
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
     * Set tipo
     *
     * @param string $tipo
     * @return TipoTransferenciaRecebida
     */
    public function setTipo($tipo)
    {
        $this->tipo = $tipo;
        return $this;
    }

    /**
     * Get tipo
     *
     * @return string
     */
    public function getTipo()
    {
        return $this->tipo;
    }

    /**
     * Set codTipoTcepe
     *
     * @param integer $codTipoTcepe
     * @return TipoTransferenciaRecebida
     */
    public function setCodTipoTcepe($codTipoTcepe)
    {
        $this->codTipoTcepe = $codTipoTcepe;
        return $this;
    }

    /**
     * Get codTipoTcepe
     *
     * @return integer
     */
    public function getCodTipoTcepe()
    {
        return $this->codTipoTcepe;
    }

    /**
     * Set codEntidadeTransferidora
     *
     * @param integer $codEntidadeTransferidora
     * @return TipoTransferenciaRecebida
     */
    public function setCodEntidadeTransferidora($codEntidadeTransferidora)
    {
        $this->codEntidadeTransferidora = $codEntidadeTransferidora;
        return $this;
    }

    /**
     * Get codEntidadeTransferidora
     *
     * @return integer
     */
    public function getCodEntidadeTransferidora()
    {
        return $this->codEntidadeTransferidora;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkTesourariaTransferencia
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\Transferencia $fkTesourariaTransferencia
     * @return TipoTransferenciaRecebida
     */
    public function setFkTesourariaTransferencia(\Urbem\CoreBundle\Entity\Tesouraria\Transferencia $fkTesourariaTransferencia)
    {
        $this->codLote = $fkTesourariaTransferencia->getCodLote();
        $this->exercicio = $fkTesourariaTransferencia->getExercicio();
        $this->codEntidade = $fkTesourariaTransferencia->getCodEntidade();
        $this->tipo = $fkTesourariaTransferencia->getTipo();
        $this->fkTesourariaTransferencia = $fkTesourariaTransferencia;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkTesourariaTransferencia
     *
     * @return \Urbem\CoreBundle\Entity\Tesouraria\Transferencia
     */
    public function getFkTesourariaTransferencia()
    {
        return $this->fkTesourariaTransferencia;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkOrcamentoEntidade
     *
     * @param \Urbem\CoreBundle\Entity\Orcamento\Entidade $fkOrcamentoEntidade
     * @return TipoTransferenciaRecebida
     */
    public function setFkOrcamentoEntidade(\Urbem\CoreBundle\Entity\Orcamento\Entidade $fkOrcamentoEntidade)
    {
        $this->exercicio = $fkOrcamentoEntidade->getExercicio();
        $this->codEntidadeTransferidora = $fkOrcamentoEntidade->getCodEntidade();
        $this->fkOrcamentoEntidade = $fkOrcamentoEntidade;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkOrcamentoEntidade
     *
     * @return \Urbem\CoreBundle\Entity\Orcamento\Entidade
     */
    public function getFkOrcamentoEntidade()
    {
        return $this->fkOrcamentoEntidade;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkTcepeTipoTransferencia
     *
     * @param \Urbem\CoreBundle\Entity\Tcepe\TipoTransferencia $fkTcepeTipoTransferencia
     * @return TipoTransferenciaRecebida
     */
    public function setFkTcepeTipoTransferencia(\Urbem\CoreBundle\Entity\Tcepe\TipoTransferencia $fkTcepeTipoTransferencia)
    {
        $this->codTipoTcepe = $fkTcepeTipoTransferencia->getCodTipo();
        $this->fkTcepeTipoTransferencia = $fkTcepeTipoTransferencia;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkTcepeTipoTransferencia
     *
     * @return \Urbem\CoreBundle\Entity\Tcepe\TipoTransferencia
     */
    public function getFkTcepeTipoTransferencia()
    {
        return $this->fkTcepeTipoTransferencia;
    }
}
