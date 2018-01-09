<?php

namespace Urbem\CoreBundle\Entity\Economico;

/**
 * BaixaLicenca
 */
class BaixaLicenca
{
    /**
     * PK
     * @var integer
     */
    private $codLicenca;

    /**
     * PK
     * @var string
     */
    private $exercicio;

    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DatePK
     */
    private $dtInicio;

    /**
     * @var \DateTime
     */
    private $dtTermino;

    /**
     * @var integer
     */
    private $codTipo;

    /**
     * @var \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    private $timestamp;

    /**
     * @var string
     */
    private $motivo;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Economico\ProcessoBaixaLicenca
     */
    private $fkEconomicoProcessoBaixaLicencas;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Economico\Licenca
     */
    private $fkEconomicoLicenca;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Economico\TipoBaixa
     */
    private $fkEconomicoTipoBaixa;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkEconomicoProcessoBaixaLicencas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->dtInicio = new \Urbem\CoreBundle\Helper\DatePK;
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
    }

    /**
     * Set codLicenca
     *
     * @param integer $codLicenca
     * @return BaixaLicenca
     */
    public function setCodLicenca($codLicenca)
    {
        $this->codLicenca = $codLicenca;
        return $this;
    }

    /**
     * Get codLicenca
     *
     * @return integer
     */
    public function getCodLicenca()
    {
        return $this->codLicenca;
    }

    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return BaixaLicenca
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
     * Set dtInicio
     *
     * @param \Urbem\CoreBundle\Helper\DatePK $dtInicio
     * @return BaixaLicenca
     */
    public function setDtInicio(\Urbem\CoreBundle\Helper\DatePK $dtInicio)
    {
        $this->dtInicio = $dtInicio;
        return $this;
    }

    /**
     * Get dtInicio
     *
     * @return \Urbem\CoreBundle\Helper\DatePK
     */
    public function getDtInicio()
    {
        return $this->dtInicio;
    }

    /**
     * Set dtTermino
     *
     * @param \DateTime $dtTermino
     * @return BaixaLicenca
     */
    public function setDtTermino(\DateTime $dtTermino = null)
    {
        $this->dtTermino = $dtTermino;
        return $this;
    }

    /**
     * Get dtTermino
     *
     * @return \DateTime
     */
    public function getDtTermino()
    {
        return $this->dtTermino;
    }

    /**
     * Set codTipo
     *
     * @param integer $codTipo
     * @return BaixaLicenca
     */
    public function setCodTipo($codTipo)
    {
        $this->codTipo = $codTipo;
        return $this;
    }

    /**
     * Get codTipo
     *
     * @return integer
     */
    public function getCodTipo()
    {
        return $this->codTipo;
    }

    /**
     * Set timestamp
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp
     * @return BaixaLicenca
     */
    public function setTimestamp(\Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp)
    {
        $this->timestamp = $timestamp;
        return $this;
    }

    /**
     * Get timestamp
     *
     * @return \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }

    /**
     * Set motivo
     *
     * @param string $motivo
     * @return BaixaLicenca
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
     * OneToMany (owning side)
     * Add EconomicoProcessoBaixaLicenca
     *
     * @param \Urbem\CoreBundle\Entity\Economico\ProcessoBaixaLicenca $fkEconomicoProcessoBaixaLicenca
     * @return BaixaLicenca
     */
    public function addFkEconomicoProcessoBaixaLicencas(\Urbem\CoreBundle\Entity\Economico\ProcessoBaixaLicenca $fkEconomicoProcessoBaixaLicenca)
    {
        if (false === $this->fkEconomicoProcessoBaixaLicencas->contains($fkEconomicoProcessoBaixaLicenca)) {
            $fkEconomicoProcessoBaixaLicenca->setFkEconomicoBaixaLicenca($this);
            $this->fkEconomicoProcessoBaixaLicencas->add($fkEconomicoProcessoBaixaLicenca);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove EconomicoProcessoBaixaLicenca
     *
     * @param \Urbem\CoreBundle\Entity\Economico\ProcessoBaixaLicenca $fkEconomicoProcessoBaixaLicenca
     */
    public function removeFkEconomicoProcessoBaixaLicencas(\Urbem\CoreBundle\Entity\Economico\ProcessoBaixaLicenca $fkEconomicoProcessoBaixaLicenca)
    {
        $this->fkEconomicoProcessoBaixaLicencas->removeElement($fkEconomicoProcessoBaixaLicenca);
    }

    /**
     * OneToMany (owning side)
     * Get fkEconomicoProcessoBaixaLicencas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Economico\ProcessoBaixaLicenca
     */
    public function getFkEconomicoProcessoBaixaLicencas()
    {
        return $this->fkEconomicoProcessoBaixaLicencas;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkEconomicoLicenca
     *
     * @param \Urbem\CoreBundle\Entity\Economico\Licenca $fkEconomicoLicenca
     * @return BaixaLicenca
     */
    public function setFkEconomicoLicenca(\Urbem\CoreBundle\Entity\Economico\Licenca $fkEconomicoLicenca)
    {
        $this->codLicenca = $fkEconomicoLicenca->getCodLicenca();
        $this->exercicio = $fkEconomicoLicenca->getExercicio();
        $this->fkEconomicoLicenca = $fkEconomicoLicenca;

        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkEconomicoLicenca
     *
     * @return \Urbem\CoreBundle\Entity\Economico\Licenca
     */
    public function getFkEconomicoLicenca()
    {
        return $this->fkEconomicoLicenca;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkEconomicoTipoBaixa
     *
     * @param \Urbem\CoreBundle\Entity\Economico\TipoBaixa $fkEconomicoTipoBaixa
     * @return BaixaLicenca
     */
    public function setFkEconomicoTipoBaixa(\Urbem\CoreBundle\Entity\Economico\TipoBaixa $fkEconomicoTipoBaixa)
    {
        $this->codTipo = $fkEconomicoTipoBaixa->getCodTipo();
        $this->fkEconomicoTipoBaixa = $fkEconomicoTipoBaixa;

        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkEconomicoTipoBaixa
     *
     * @return \Urbem\CoreBundle\Entity\Economico\TipoBaixa
     */
    public function getFkEconomicoTipoBaixa()
    {
        return $this->fkEconomicoTipoBaixa;
    }
}
