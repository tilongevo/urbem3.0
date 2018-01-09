<?php
 
namespace Urbem\CoreBundle\Entity\Patrimonio;

/**
 * BemBaixado
 */
class BemBaixado
{
    /**
     * PK
     * @var integer
     */
    private $codBem;

    /**
     * @var \DateTime
     */
    private $dtBaixa;

    /**
     * @var string
     */
    private $motivo;

    /**
     * @var integer
     */
    private $tipoBaixa = 0;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Patrimonio\Bem
     */
    private $fkPatrimonioBem;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Patrimonio\TipoBaixa
     */
    private $fkPatrimonioTipoBaixa;


    /**
     * Set codBem
     *
     * @param integer $codBem
     * @return BemBaixado
     */
    public function setCodBem($codBem)
    {
        $this->codBem = $codBem;
        return $this;
    }

    /**
     * Get codBem
     *
     * @return integer
     */
    public function getCodBem()
    {
        return $this->codBem;
    }

    /**
     * Set dtBaixa
     *
     * @param \DateTime $dtBaixa
     * @return BemBaixado
     */
    public function setDtBaixa(\DateTime $dtBaixa)
    {
        $this->dtBaixa = $dtBaixa;
        return $this;
    }

    /**
     * Get dtBaixa
     *
     * @return \DateTime
     */
    public function getDtBaixa()
    {
        return $this->dtBaixa;
    }

    /**
     * Set motivo
     *
     * @param string $motivo
     * @return BemBaixado
     */
    public function setMotivo($motivo)
    {
        $this->motivo = $motivo;
        return $this;
    }

    /**
     * Get motivo
     *
     * @return string
     */
    public function getMotivo()
    {
        return $this->motivo;
    }

    /**
     * Set tipoBaixa
     *
     * @param integer $tipoBaixa
     * @return BemBaixado
     */
    public function setTipoBaixa($tipoBaixa)
    {
        $this->tipoBaixa = $tipoBaixa;
        return $this;
    }

    /**
     * Get tipoBaixa
     *
     * @return integer
     */
    public function getTipoBaixa()
    {
        return $this->tipoBaixa;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkPatrimonioTipoBaixa
     *
     * @param \Urbem\CoreBundle\Entity\Patrimonio\TipoBaixa $fkPatrimonioTipoBaixa
     * @return BemBaixado
     */
    public function setFkPatrimonioTipoBaixa(\Urbem\CoreBundle\Entity\Patrimonio\TipoBaixa $fkPatrimonioTipoBaixa)
    {
        $this->tipoBaixa = $fkPatrimonioTipoBaixa->getCodTipo();
        $this->fkPatrimonioTipoBaixa = $fkPatrimonioTipoBaixa;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkPatrimonioTipoBaixa
     *
     * @return \Urbem\CoreBundle\Entity\Patrimonio\TipoBaixa
     */
    public function getFkPatrimonioTipoBaixa()
    {
        return $this->fkPatrimonioTipoBaixa;
    }

    /**
     * OneToOne (owning side)
     * Set PatrimonioBem
     *
     * @param \Urbem\CoreBundle\Entity\Patrimonio\Bem $fkPatrimonioBem
     * @return BemBaixado
     */
    public function setFkPatrimonioBem(\Urbem\CoreBundle\Entity\Patrimonio\Bem $fkPatrimonioBem)
    {
        $this->codBem = $fkPatrimonioBem->getCodBem();
        $this->fkPatrimonioBem = $fkPatrimonioBem;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkPatrimonioBem
     *
     * @return \Urbem\CoreBundle\Entity\Patrimonio\Bem
     */
    public function getFkPatrimonioBem()
    {
        return $this->fkPatrimonioBem;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return sprintf(
            "%s",
            $this->fkPatrimonioBem
        );
    }
}
