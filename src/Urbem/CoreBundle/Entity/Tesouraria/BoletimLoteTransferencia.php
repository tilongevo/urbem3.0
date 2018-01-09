<?php
 
namespace Urbem\CoreBundle\Entity\Tesouraria;

/**
 * BoletimLoteTransferencia
 */
class BoletimLoteTransferencia
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
     * PK
     * @var integer
     */
    private $codLoteArrecadacao;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Tesouraria\BoletimLoteTransferenciaEstornada
     */
    private $fkTesourariaBoletimLoteTransferenciaEstornada;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Tesouraria\Transferencia
     */
    private $fkTesourariaTransferencia;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Arrecadacao\Lote
     */
    private $fkArrecadacaoLote;


    /**
     * Set tipo
     *
     * @param string $tipo
     * @return BoletimLoteTransferencia
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
     * @return BoletimLoteTransferencia
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
     * @return BoletimLoteTransferencia
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
     * @return BoletimLoteTransferencia
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
     * Set codLoteArrecadacao
     *
     * @param integer $codLoteArrecadacao
     * @return BoletimLoteTransferencia
     */
    public function setCodLoteArrecadacao($codLoteArrecadacao)
    {
        $this->codLoteArrecadacao = $codLoteArrecadacao;
        return $this;
    }

    /**
     * Get codLoteArrecadacao
     *
     * @return integer
     */
    public function getCodLoteArrecadacao()
    {
        return $this->codLoteArrecadacao;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkTesourariaTransferencia
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\Transferencia $fkTesourariaTransferencia
     * @return BoletimLoteTransferencia
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
     * Set fkArrecadacaoLote
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\Lote $fkArrecadacaoLote
     * @return BoletimLoteTransferencia
     */
    public function setFkArrecadacaoLote(\Urbem\CoreBundle\Entity\Arrecadacao\Lote $fkArrecadacaoLote)
    {
        $this->exercicio = $fkArrecadacaoLote->getExercicio();
        $this->codLoteArrecadacao = $fkArrecadacaoLote->getCodLote();
        $this->fkArrecadacaoLote = $fkArrecadacaoLote;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkArrecadacaoLote
     *
     * @return \Urbem\CoreBundle\Entity\Arrecadacao\Lote
     */
    public function getFkArrecadacaoLote()
    {
        return $this->fkArrecadacaoLote;
    }

    /**
     * OneToOne (inverse side)
     * Set TesourariaBoletimLoteTransferenciaEstornada
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\BoletimLoteTransferenciaEstornada $fkTesourariaBoletimLoteTransferenciaEstornada
     * @return BoletimLoteTransferencia
     */
    public function setFkTesourariaBoletimLoteTransferenciaEstornada(\Urbem\CoreBundle\Entity\Tesouraria\BoletimLoteTransferenciaEstornada $fkTesourariaBoletimLoteTransferenciaEstornada)
    {
        $fkTesourariaBoletimLoteTransferenciaEstornada->setFkTesourariaBoletimLoteTransferencia($this);
        $this->fkTesourariaBoletimLoteTransferenciaEstornada = $fkTesourariaBoletimLoteTransferenciaEstornada;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkTesourariaBoletimLoteTransferenciaEstornada
     *
     * @return \Urbem\CoreBundle\Entity\Tesouraria\BoletimLoteTransferenciaEstornada
     */
    public function getFkTesourariaBoletimLoteTransferenciaEstornada()
    {
        return $this->fkTesourariaBoletimLoteTransferenciaEstornada;
    }
}
