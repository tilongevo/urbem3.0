<?php
 
namespace Urbem\CoreBundle\Entity;

/**
 * SwReciboImpresso
 */
class SwReciboImpresso
{
    /**
     * PK
     * @var integer
     */
    private $codAndamento;

    /**
     * PK
     * @var integer
     */
    private $codProcesso;

    /**
     * PK
     * @var string
     */
    private $anoExercicio;

    /**
     * @var integer
     */
    private $codRecibo;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\SwRecebimento
     */
    private $fkSwRecebimento;


    /**
     * Set codAndamento
     *
     * @param integer $codAndamento
     * @return SwReciboImpresso
     */
    public function setCodAndamento($codAndamento)
    {
        $this->codAndamento = $codAndamento;
        return $this;
    }

    /**
     * Get codAndamento
     *
     * @return integer
     */
    public function getCodAndamento()
    {
        return $this->codAndamento;
    }

    /**
     * Set codProcesso
     *
     * @param integer $codProcesso
     * @return SwReciboImpresso
     */
    public function setCodProcesso($codProcesso)
    {
        $this->codProcesso = $codProcesso;
        return $this;
    }

    /**
     * Get codProcesso
     *
     * @return integer
     */
    public function getCodProcesso()
    {
        return $this->codProcesso;
    }

    /**
     * Set anoExercicio
     *
     * @param string $anoExercicio
     * @return SwReciboImpresso
     */
    public function setAnoExercicio($anoExercicio)
    {
        $this->anoExercicio = $anoExercicio;
        return $this;
    }

    /**
     * Get anoExercicio
     *
     * @return string
     */
    public function getAnoExercicio()
    {
        return $this->anoExercicio;
    }

    /**
     * Set codRecibo
     *
     * @param integer $codRecibo
     * @return SwReciboImpresso
     */
    public function setCodRecibo($codRecibo)
    {
        $this->codRecibo = $codRecibo;
        return $this;
    }

    /**
     * Get codRecibo
     *
     * @return integer
     */
    public function getCodRecibo()
    {
        return $this->codRecibo;
    }

    /**
     * OneToOne (owning side)
     * Set SwRecebimento
     *
     * @param \Urbem\CoreBundle\Entity\SwRecebimento $fkSwRecebimento
     * @return SwReciboImpresso
     */
    public function setFkSwRecebimento(\Urbem\CoreBundle\Entity\SwRecebimento $fkSwRecebimento)
    {
        $this->codAndamento = $fkSwRecebimento->getCodAndamento();
        $this->codProcesso = $fkSwRecebimento->getCodProcesso();
        $this->anoExercicio = $fkSwRecebimento->getAnoExercicio();
        $this->fkSwRecebimento = $fkSwRecebimento;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkSwRecebimento
     *
     * @return \Urbem\CoreBundle\Entity\SwRecebimento
     */
    public function getFkSwRecebimento()
    {
        return $this->fkSwRecebimento;
    }
}
