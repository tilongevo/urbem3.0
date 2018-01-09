<?php
 
namespace Urbem\CoreBundle\Entity\Tceto;

/**
 * TransferenciaTipoTransferencia
 */
class TransferenciaTipoTransferencia
{
    /**
     * PK
     * @var integer
     */
    private $codLote;

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
     * @var string
     */
    private $tipo;

    /**
     * @var integer
     */
    private $codTipoTransferencia;

    /**
     * @var string
     */
    private $exercicioEmpenho;

    /**
     * @var integer
     */
    private $codEmpenho;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Tesouraria\Transferencia
     */
    private $fkTesourariaTransferencia;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Empenho\Empenho
     */
    private $fkEmpenhoEmpenho;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Tceto\TipoTransferencia
     */
    private $fkTcetoTipoTransferencia;


    /**
     * Set codLote
     *
     * @param integer $codLote
     * @return TransferenciaTipoTransferencia
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
     * Set exercicio
     *
     * @param string $exercicio
     * @return TransferenciaTipoTransferencia
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
     * @return TransferenciaTipoTransferencia
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
     * Set tipo
     *
     * @param string $tipo
     * @return TransferenciaTipoTransferencia
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
     * Set codTipoTransferencia
     *
     * @param integer $codTipoTransferencia
     * @return TransferenciaTipoTransferencia
     */
    public function setCodTipoTransferencia($codTipoTransferencia)
    {
        $this->codTipoTransferencia = $codTipoTransferencia;
        return $this;
    }

    /**
     * Get codTipoTransferencia
     *
     * @return integer
     */
    public function getCodTipoTransferencia()
    {
        return $this->codTipoTransferencia;
    }

    /**
     * Set exercicioEmpenho
     *
     * @param string $exercicioEmpenho
     * @return TransferenciaTipoTransferencia
     */
    public function setExercicioEmpenho($exercicioEmpenho = null)
    {
        $this->exercicioEmpenho = $exercicioEmpenho;
        return $this;
    }

    /**
     * Get exercicioEmpenho
     *
     * @return string
     */
    public function getExercicioEmpenho()
    {
        return $this->exercicioEmpenho;
    }

    /**
     * Set codEmpenho
     *
     * @param integer $codEmpenho
     * @return TransferenciaTipoTransferencia
     */
    public function setCodEmpenho($codEmpenho = null)
    {
        $this->codEmpenho = $codEmpenho;
        return $this;
    }

    /**
     * Get codEmpenho
     *
     * @return integer
     */
    public function getCodEmpenho()
    {
        return $this->codEmpenho;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkEmpenhoEmpenho
     *
     * @param \Urbem\CoreBundle\Entity\Empenho\Empenho $fkEmpenhoEmpenho
     * @return TransferenciaTipoTransferencia
     */
    public function setFkEmpenhoEmpenho(\Urbem\CoreBundle\Entity\Empenho\Empenho $fkEmpenhoEmpenho)
    {
        $this->codEmpenho = $fkEmpenhoEmpenho->getCodEmpenho();
        $this->exercicioEmpenho = $fkEmpenhoEmpenho->getExercicio();
        $this->codEntidade = $fkEmpenhoEmpenho->getCodEntidade();
        $this->fkEmpenhoEmpenho = $fkEmpenhoEmpenho;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkEmpenhoEmpenho
     *
     * @return \Urbem\CoreBundle\Entity\Empenho\Empenho
     */
    public function getFkEmpenhoEmpenho()
    {
        return $this->fkEmpenhoEmpenho;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkTcetoTipoTransferencia
     *
     * @param \Urbem\CoreBundle\Entity\Tceto\TipoTransferencia $fkTcetoTipoTransferencia
     * @return TransferenciaTipoTransferencia
     */
    public function setFkTcetoTipoTransferencia(\Urbem\CoreBundle\Entity\Tceto\TipoTransferencia $fkTcetoTipoTransferencia)
    {
        $this->codTipoTransferencia = $fkTcetoTipoTransferencia->getCodTipo();
        $this->fkTcetoTipoTransferencia = $fkTcetoTipoTransferencia;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkTcetoTipoTransferencia
     *
     * @return \Urbem\CoreBundle\Entity\Tceto\TipoTransferencia
     */
    public function getFkTcetoTipoTransferencia()
    {
        return $this->fkTcetoTipoTransferencia;
    }

    /**
     * OneToOne (owning side)
     * Set TesourariaTransferencia
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\Transferencia $fkTesourariaTransferencia
     * @return TransferenciaTipoTransferencia
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
