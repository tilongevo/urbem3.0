<?php
 
namespace Urbem\CoreBundle\Entity\Tesouraria;

/**
 * TransferenciaCredor
 */
class TransferenciaCredor
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
    private $numcgm;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Tesouraria\Transferencia
     */
    private $fkTesourariaTransferencia;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\SwCgm
     */
    private $fkSwCgm;


    /**
     * Set tipo
     *
     * @param string $tipo
     * @return TransferenciaCredor
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
     * @return TransferenciaCredor
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
     * @return TransferenciaCredor
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
     * @return TransferenciaCredor
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
     * Set numcgm
     *
     * @param integer $numcgm
     * @return TransferenciaCredor
     */
    public function setNumcgm($numcgm)
    {
        $this->numcgm = $numcgm;
        return $this;
    }

    /**
     * Get numcgm
     *
     * @return integer
     */
    public function getNumcgm()
    {
        return $this->numcgm;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkSwCgm
     *
     * @param \Urbem\CoreBundle\Entity\SwCgm $fkSwCgm
     * @return TransferenciaCredor
     */
    public function setFkSwCgm(\Urbem\CoreBundle\Entity\SwCgm $fkSwCgm)
    {
        $this->numcgm = $fkSwCgm->getNumcgm();
        $this->fkSwCgm = $fkSwCgm;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkSwCgm
     *
     * @return \Urbem\CoreBundle\Entity\SwCgm
     */
    public function getFkSwCgm()
    {
        return $this->fkSwCgm;
    }

    /**
     * OneToOne (owning side)
     * Set TesourariaTransferencia
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\Transferencia $fkTesourariaTransferencia
     * @return TransferenciaCredor
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
