<?php
 
namespace Urbem\CoreBundle\Entity\Imobiliario;

/**
 * LicencaLoteLoteamento
 */
class LicencaLoteLoteamento
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
    private $codLoteamento;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Imobiliario\LicencaLote
     */
    private $fkImobiliarioLicencaLote;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Imobiliario\Loteamento
     */
    private $fkImobiliarioLoteamento;


    /**
     * Set codLicenca
     *
     * @param integer $codLicenca
     * @return LicencaLoteLoteamento
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
     * @return LicencaLoteLoteamento
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
     * @return LicencaLoteLoteamento
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
     * Set codLoteamento
     *
     * @param integer $codLoteamento
     * @return LicencaLoteLoteamento
     */
    public function setCodLoteamento($codLoteamento)
    {
        $this->codLoteamento = $codLoteamento;
        return $this;
    }

    /**
     * Get codLoteamento
     *
     * @return integer
     */
    public function getCodLoteamento()
    {
        return $this->codLoteamento;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkImobiliarioLicencaLote
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\LicencaLote $fkImobiliarioLicencaLote
     * @return LicencaLoteLoteamento
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
     * Set fkImobiliarioLoteamento
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\Loteamento $fkImobiliarioLoteamento
     * @return LicencaLoteLoteamento
     */
    public function setFkImobiliarioLoteamento(\Urbem\CoreBundle\Entity\Imobiliario\Loteamento $fkImobiliarioLoteamento)
    {
        $this->codLoteamento = $fkImobiliarioLoteamento->getCodLoteamento();
        $this->fkImobiliarioLoteamento = $fkImobiliarioLoteamento;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkImobiliarioLoteamento
     *
     * @return \Urbem\CoreBundle\Entity\Imobiliario\Loteamento
     */
    public function getFkImobiliarioLoteamento()
    {
        return $this->fkImobiliarioLoteamento;
    }
}
