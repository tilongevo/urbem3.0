<?php
 
namespace Urbem\CoreBundle\Entity\Tesouraria;

/**
 * ReciboExtraTransferencia
 */
class ReciboExtraTransferencia
{
    /**
     * PK
     * @var integer
     */
    private $codReciboExtra;

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
    private $tipoRecibo;

    /**
     * PK
     * @var string
     */
    private $tipo;

    /**
     * PK
     * @var integer
     */
    private $codLote;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Tesouraria\ReciboExtra
     */
    private $fkTesourariaReciboExtra;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Tesouraria\Transferencia
     */
    private $fkTesourariaTransferencia;


    /**
     * Set codReciboExtra
     *
     * @param integer $codReciboExtra
     * @return ReciboExtraTransferencia
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
     * Set codEntidade
     *
     * @param integer $codEntidade
     * @return ReciboExtraTransferencia
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
     * @return ReciboExtraTransferencia
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
     * Set tipoRecibo
     *
     * @param string $tipoRecibo
     * @return ReciboExtraTransferencia
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
     * Set tipo
     *
     * @param string $tipo
     * @return ReciboExtraTransferencia
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
     * Set codLote
     *
     * @param integer $codLote
     * @return ReciboExtraTransferencia
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
     * ManyToOne (inverse side)
     * Set fkTesourariaReciboExtra
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\ReciboExtra $fkTesourariaReciboExtra
     * @return ReciboExtraTransferencia
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
     * Set fkTesourariaTransferencia
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\Transferencia $fkTesourariaTransferencia
     * @return ReciboExtraTransferencia
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
}
