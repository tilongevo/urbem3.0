<?php
 
namespace Urbem\CoreBundle\Entity\Arrecadacao;

/**
 * NotaFiscal
 */
class NotaFiscal
{
    /**
     * PK
     * @var integer
     */
    private $codNota;

    /**
     * @var string
     */
    private $nroSerie;

    /**
     * @var integer
     */
    private $nroNota;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Arrecadacao\Nota
     */
    private $fkArrecadacaoNota;


    /**
     * Set codNota
     *
     * @param integer $codNota
     * @return NotaFiscal
     */
    public function setCodNota($codNota)
    {
        $this->codNota = $codNota;
        return $this;
    }

    /**
     * Get codNota
     *
     * @return integer
     */
    public function getCodNota()
    {
        return $this->codNota;
    }

    /**
     * Set nroSerie
     *
     * @param string $nroSerie
     * @return NotaFiscal
     */
    public function setNroSerie($nroSerie)
    {
        $this->nroSerie = $nroSerie;
        return $this;
    }

    /**
     * Get nroSerie
     *
     * @return string
     */
    public function getNroSerie()
    {
        return $this->nroSerie;
    }

    /**
     * Set nroNota
     *
     * @param integer $nroNota
     * @return NotaFiscal
     */
    public function setNroNota($nroNota)
    {
        $this->nroNota = $nroNota;
        return $this;
    }

    /**
     * Get nroNota
     *
     * @return integer
     */
    public function getNroNota()
    {
        return $this->nroNota;
    }

    /**
     * OneToOne (owning side)
     * Set ArrecadacaoNota
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\Nota $fkArrecadacaoNota
     * @return NotaFiscal
     */
    public function setFkArrecadacaoNota(\Urbem\CoreBundle\Entity\Arrecadacao\Nota $fkArrecadacaoNota)
    {
        $this->codNota = $fkArrecadacaoNota->getCodNota();
        $this->fkArrecadacaoNota = $fkArrecadacaoNota;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkArrecadacaoNota
     *
     * @return \Urbem\CoreBundle\Entity\Arrecadacao\Nota
     */
    public function getFkArrecadacaoNota()
    {
        return $this->fkArrecadacaoNota;
    }
}
