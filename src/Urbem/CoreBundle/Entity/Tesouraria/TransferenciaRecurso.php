<?php
 
namespace Urbem\CoreBundle\Entity\Tesouraria;

/**
 * TransferenciaRecurso
 */
class TransferenciaRecurso
{
    /**
     * PK
     * @var string
     */
    private $tipo;

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
    private $codLote;

    /**
     * @var integer
     */
    private $codRecurso;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Tesouraria\Transferencia
     */
    private $fkTesourariaTransferencia;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Orcamento\Recurso
     */
    private $fkOrcamentoRecurso;


    /**
     * Set tipo
     *
     * @param string $tipo
     * @return TransferenciaRecurso
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
     * Set exercicio
     *
     * @param string $exercicio
     * @return TransferenciaRecurso
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
     * @return TransferenciaRecurso
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
     * Set codLote
     *
     * @param integer $codLote
     * @return TransferenciaRecurso
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
     * Set codRecurso
     *
     * @param integer $codRecurso
     * @return TransferenciaRecurso
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
     * ManyToOne (inverse side)
     * Set fkOrcamentoRecurso
     *
     * @param \Urbem\CoreBundle\Entity\Orcamento\Recurso $fkOrcamentoRecurso
     * @return TransferenciaRecurso
     */
    public function setFkOrcamentoRecurso(\Urbem\CoreBundle\Entity\Orcamento\Recurso $fkOrcamentoRecurso)
    {
        $this->exercicio = $fkOrcamentoRecurso->getExercicio();
        $this->codRecurso = $fkOrcamentoRecurso->getCodRecurso();
        $this->fkOrcamentoRecurso = $fkOrcamentoRecurso;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkOrcamentoRecurso
     *
     * @return \Urbem\CoreBundle\Entity\Orcamento\Recurso
     */
    public function getFkOrcamentoRecurso()
    {
        return $this->fkOrcamentoRecurso;
    }

    /**
     * OneToOne (owning side)
     * Set TesourariaTransferencia
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\Transferencia $fkTesourariaTransferencia
     * @return TransferenciaRecurso
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
     * OneToOne (owning side)
     * Get fkTesourariaTransferencia
     *
     * @return \Urbem\CoreBundle\Entity\Tesouraria\Transferencia
     */
    public function getFkTesourariaTransferencia()
    {
        return $this->fkTesourariaTransferencia;
    }
}
