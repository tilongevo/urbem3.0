<?php
 
namespace Urbem\CoreBundle\Entity\Ponto;

/**
 * EscalaExclusao
 */
class EscalaExclusao
{
    /**
     * PK
     * @var integer
     */
    private $codEscala;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Ponto\Escala
     */
    private $fkPontoEscala;


    /**
     * Set codEscala
     *
     * @param integer $codEscala
     * @return EscalaExclusao
     */
    public function setCodEscala($codEscala)
    {
        $this->codEscala = $codEscala;
        return $this;
    }

    /**
     * Get codEscala
     *
     * @return integer
     */
    public function getCodEscala()
    {
        return $this->codEscala;
    }

    /**
     * OneToOne (owning side)
     * Set PontoEscala
     *
     * @param \Urbem\CoreBundle\Entity\Ponto\Escala $fkPontoEscala
     * @return EscalaExclusao
     */
    public function setFkPontoEscala(\Urbem\CoreBundle\Entity\Ponto\Escala $fkPontoEscala)
    {
        $this->codEscala = $fkPontoEscala->getCodEscala();
        $this->fkPontoEscala = $fkPontoEscala;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkPontoEscala
     *
     * @return \Urbem\CoreBundle\Entity\Ponto\Escala
     */
    public function getFkPontoEscala()
    {
        return $this->fkPontoEscala;
    }
}
