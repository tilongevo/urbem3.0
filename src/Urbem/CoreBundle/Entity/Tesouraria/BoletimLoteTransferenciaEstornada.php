<?php
 
namespace Urbem\CoreBundle\Entity\Tesouraria;

/**
 * BoletimLoteTransferenciaEstornada
 */
class BoletimLoteTransferenciaEstornada
{
    /**
     * PK
     * @var integer
     */
    private $codLoteArrecadacao;

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
     * @var \DateTime
     */
    private $timestampEstorno;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Tesouraria\BoletimLoteTransferencia
     */
    private $fkTesourariaBoletimLoteTransferencia;


    /**
     * Set codLoteArrecadacao
     *
     * @param integer $codLoteArrecadacao
     * @return BoletimLoteTransferenciaEstornada
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
     * Set codLote
     *
     * @param integer $codLote
     * @return BoletimLoteTransferenciaEstornada
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
     * @return BoletimLoteTransferenciaEstornada
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
     * @return BoletimLoteTransferenciaEstornada
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
     * @return BoletimLoteTransferenciaEstornada
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
     * Set timestampEstorno
     *
     * @param \DateTime $timestampEstorno
     * @return BoletimLoteTransferenciaEstornada
     */
    public function setTimestampEstorno(\DateTime $timestampEstorno)
    {
        $this->timestampEstorno = $timestampEstorno;
        return $this;
    }

    /**
     * Get timestampEstorno
     *
     * @return \DateTime
     */
    public function getTimestampEstorno()
    {
        return $this->timestampEstorno;
    }

    /**
     * OneToOne (owning side)
     * Set TesourariaBoletimLoteTransferencia
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\BoletimLoteTransferencia $fkTesourariaBoletimLoteTransferencia
     * @return BoletimLoteTransferenciaEstornada
     */
    public function setFkTesourariaBoletimLoteTransferencia(\Urbem\CoreBundle\Entity\Tesouraria\BoletimLoteTransferencia $fkTesourariaBoletimLoteTransferencia)
    {
        $this->tipo = $fkTesourariaBoletimLoteTransferencia->getTipo();
        $this->exercicio = $fkTesourariaBoletimLoteTransferencia->getExercicio();
        $this->codEntidade = $fkTesourariaBoletimLoteTransferencia->getCodEntidade();
        $this->codLote = $fkTesourariaBoletimLoteTransferencia->getCodLote();
        $this->codLoteArrecadacao = $fkTesourariaBoletimLoteTransferencia->getCodLoteArrecadacao();
        $this->fkTesourariaBoletimLoteTransferencia = $fkTesourariaBoletimLoteTransferencia;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkTesourariaBoletimLoteTransferencia
     *
     * @return \Urbem\CoreBundle\Entity\Tesouraria\BoletimLoteTransferencia
     */
    public function getFkTesourariaBoletimLoteTransferencia()
    {
        return $this->fkTesourariaBoletimLoteTransferencia;
    }
}
