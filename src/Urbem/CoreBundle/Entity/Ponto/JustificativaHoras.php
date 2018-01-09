<?php
 
namespace Urbem\CoreBundle\Entity\Ponto;

/**
 * JustificativaHoras
 */
class JustificativaHoras
{
    /**
     * PK
     * @var integer
     */
    private $codJustificativa;

    /**
     * @var string
     */
    private $horasFalta;

    /**
     * @var string
     */
    private $horasAbono;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Ponto\Justificativa
     */
    private $fkPontoJustificativa;


    /**
     * Set codJustificativa
     *
     * @param integer $codJustificativa
     * @return JustificativaHoras
     */
    public function setCodJustificativa($codJustificativa)
    {
        $this->codJustificativa = $codJustificativa;
        return $this;
    }

    /**
     * Get codJustificativa
     *
     * @return integer
     */
    public function getCodJustificativa()
    {
        return $this->codJustificativa;
    }

    /**
     * Set horasFalta
     *
     * @param string $horasFalta
     * @return JustificativaHoras
     */
    public function setHorasFalta($horasFalta)
    {
        $this->horasFalta = $horasFalta;
        return $this;
    }

    /**
     * Get horasFalta
     *
     * @return string
     */
    public function getHorasFalta()
    {
        return $this->horasFalta;
    }

    /**
     * Set horasAbono
     *
     * @param string $horasAbono
     * @return JustificativaHoras
     */
    public function setHorasAbono($horasAbono)
    {
        $this->horasAbono = $horasAbono;
        return $this;
    }

    /**
     * Get horasAbono
     *
     * @return string
     */
    public function getHorasAbono()
    {
        return $this->horasAbono;
    }

    /**
     * OneToOne (owning side)
     * Set PontoJustificativa
     *
     * @param \Urbem\CoreBundle\Entity\Ponto\Justificativa $fkPontoJustificativa
     * @return JustificativaHoras
     */
    public function setFkPontoJustificativa(\Urbem\CoreBundle\Entity\Ponto\Justificativa $fkPontoJustificativa)
    {
        $this->codJustificativa = $fkPontoJustificativa->getCodJustificativa();
        $this->fkPontoJustificativa = $fkPontoJustificativa;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkPontoJustificativa
     *
     * @return \Urbem\CoreBundle\Entity\Ponto\Justificativa
     */
    public function getFkPontoJustificativa()
    {
        return $this->fkPontoJustificativa;
    }
}
