<?php
 
namespace Urbem\CoreBundle\Entity\Imobiliario;

/**
 * LicencaLoteParcelamentoSolo
 */
class LicencaLoteParcelamentoSolo
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
     * @var integer
     */
    private $codLote;

    /**
     * PK
     * @var integer
     */
    private $codParcelamento;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Imobiliario\LicencaLote
     */
    private $fkImobiliarioLicencaLote;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Imobiliario\ParcelamentoSolo
     */
    private $fkImobiliarioParcelamentoSolo;


    /**
     * Set codLicenca
     *
     * @param integer $codLicenca
     * @return LicencaLoteParcelamentoSolo
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
     * @return LicencaLoteParcelamentoSolo
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
     * Set codLote
     *
     * @param integer $codLote
     * @return LicencaLoteParcelamentoSolo
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
     * Set codParcelamento
     *
     * @param integer $codParcelamento
     * @return LicencaLoteParcelamentoSolo
     */
    public function setCodParcelamento($codParcelamento)
    {
        $this->codParcelamento = $codParcelamento;
        return $this;
    }

    /**
     * Get codParcelamento
     *
     * @return integer
     */
    public function getCodParcelamento()
    {
        return $this->codParcelamento;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkImobiliarioLicencaLote
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\LicencaLote $fkImobiliarioLicencaLote
     * @return LicencaLoteParcelamentoSolo
     */
    public function setFkImobiliarioLicencaLote(\Urbem\CoreBundle\Entity\Imobiliario\LicencaLote $fkImobiliarioLicencaLote)
    {
        $this->codLicenca = $fkImobiliarioLicencaLote->getCodLicenca();
        $this->exercicio = $fkImobiliarioLicencaLote->getExercicio();
        $this->codLote = $fkImobiliarioLicencaLote->getCodLote();
        $this->fkImobiliarioLicencaLote = $fkImobiliarioLicencaLote;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkImobiliarioLicencaLote
     *
     * @return \Urbem\CoreBundle\Entity\Imobiliario\LicencaLote
     */
    public function getFkImobiliarioLicencaLote()
    {
        return $this->fkImobiliarioLicencaLote;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkImobiliarioParcelamentoSolo
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\ParcelamentoSolo $fkImobiliarioParcelamentoSolo
     * @return LicencaLoteParcelamentoSolo
     */
    public function setFkImobiliarioParcelamentoSolo(\Urbem\CoreBundle\Entity\Imobiliario\ParcelamentoSolo $fkImobiliarioParcelamentoSolo)
    {
        $this->codParcelamento = $fkImobiliarioParcelamentoSolo->getCodParcelamento();
        $this->fkImobiliarioParcelamentoSolo = $fkImobiliarioParcelamentoSolo;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkImobiliarioParcelamentoSolo
     *
     * @return \Urbem\CoreBundle\Entity\Imobiliario\ParcelamentoSolo
     */
    public function getFkImobiliarioParcelamentoSolo()
    {
        return $this->fkImobiliarioParcelamentoSolo;
    }
}
