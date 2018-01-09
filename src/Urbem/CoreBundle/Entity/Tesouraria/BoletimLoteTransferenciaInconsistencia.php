<?php
 
namespace Urbem\CoreBundle\Entity\Tesouraria;

/**
 * BoletimLoteTransferenciaInconsistencia
 */
class BoletimLoteTransferenciaInconsistencia
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
    private $codLote;

    /**
     * PK
     * @var integer
     */
    private $codLoteArrecadacao;

    /**
     * PK
     * @var string
     */
    private $tipo;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Arrecadacao\Lote
     */
    private $fkArrecadacaoLote;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Tesouraria\Transferencia
     */
    private $fkTesourariaTransferencia;


    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return BoletimLoteTransferenciaInconsistencia
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
     * @return BoletimLoteTransferenciaInconsistencia
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
     * @return BoletimLoteTransferenciaInconsistencia
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
     * @return BoletimLoteTransferenciaInconsistencia
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
     * Set tipo
     *
     * @param string $tipo
     * @return BoletimLoteTransferenciaInconsistencia
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
     * ManyToOne (inverse side)
     * Set fkArrecadacaoLote
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\Lote $fkArrecadacaoLote
     * @return BoletimLoteTransferenciaInconsistencia
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
     * ManyToOne (inverse side)
     * Set fkTesourariaTransferencia
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\Transferencia $fkTesourariaTransferencia
     * @return BoletimLoteTransferenciaInconsistencia
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
