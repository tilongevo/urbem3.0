<?php

namespace Urbem\CoreBundle\Entity\Frota;

/**
 * VeiculoBaixado
 */
class VeiculoBaixado
{
    /**
     * PK
     * @var integer
     */
    private $codVeiculo;

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
    private $codTipoBaixa = 99;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Frota\Veiculo
     */
    private $fkFrotaVeiculo;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Frota\TipoBaixa
     */
    private $fkFrotaTipoBaixa;


    /**
     * Set codVeiculo
     *
     * @param integer $codVeiculo
     * @return VeiculoBaixado
     */
    public function setCodVeiculo($codVeiculo)
    {
        $this->codVeiculo = $codVeiculo;
        return $this;
    }

    /**
     * Get codVeiculo
     *
     * @return integer
     */
    public function getCodVeiculo()
    {
        return $this->codVeiculo;
    }

    /**
     * Set dtBaixa
     *
     * @param \DateTime $dtBaixa
     * @return VeiculoBaixado
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
     * @return VeiculoBaixado
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
     * Set codTipoBaixa
     *
     * @param integer $codTipoBaixa
     * @return VeiculoBaixado
     */
    public function setCodTipoBaixa($codTipoBaixa)
    {
        $this->codTipoBaixa = $codTipoBaixa;
        return $this;
    }

    /**
     * Get codTipoBaixa
     *
     * @return integer
     */
    public function getCodTipoBaixa()
    {
        return $this->codTipoBaixa;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkFrotaTipoBaixa
     *
     * @param \Urbem\CoreBundle\Entity\Frota\TipoBaixa $fkFrotaTipoBaixa
     * @return VeiculoBaixado
     */
    public function setFkFrotaTipoBaixa(\Urbem\CoreBundle\Entity\Frota\TipoBaixa $fkFrotaTipoBaixa)
    {
        $this->codTipoBaixa = $fkFrotaTipoBaixa->getCodTipo();
        $this->fkFrotaTipoBaixa = $fkFrotaTipoBaixa;

        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkFrotaTipoBaixa
     *
     * @return \Urbem\CoreBundle\Entity\Frota\TipoBaixa
     */
    public function getFkFrotaTipoBaixa()
    {
        return $this->fkFrotaTipoBaixa;
    }

    /**
     * OneToOne (owning side)
     * Set FrotaVeiculo
     *
     * @param \Urbem\CoreBundle\Entity\Frota\Veiculo $fkFrotaVeiculo
     * @return VeiculoBaixado
     */
    public function setFkFrotaVeiculo(\Urbem\CoreBundle\Entity\Frota\Veiculo $fkFrotaVeiculo)
    {
        $this->codVeiculo = $fkFrotaVeiculo->getCodVeiculo();
        $this->fkFrotaVeiculo = $fkFrotaVeiculo;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkFrotaVeiculo
     *
     * @return \Urbem\CoreBundle\Entity\Frota\Veiculo
     */
    public function getFkFrotaVeiculo()
    {
        return $this->fkFrotaVeiculo;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        if ($this->codVeiculo) {
            return sprintf(
                "%s - %s",
                $this->fkFrotaVeiculo,
                $this->dtBaixa->format('d/m/Y')
            );
        } else {
            return "Veiculo Baixado";
        }
    }
}
