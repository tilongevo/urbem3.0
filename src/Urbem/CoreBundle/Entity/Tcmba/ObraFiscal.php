<?php
 
namespace Urbem\CoreBundle\Entity\Tcmba;

/**
 * ObraFiscal
 */
class ObraFiscal
{
    /**
     * PK
     * @var integer
     */
    private $codObra;

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
     * @var integer
     */
    private $codTipo;

    /**
     * PK
     * @var integer
     */
    private $numcgm;

    /**
     * @var string
     */
    private $matricula;

    /**
     * @var string
     */
    private $registroProfissional;

    /**
     * @var \DateTime
     */
    private $dataInicio;

    /**
     * @var \DateTime
     */
    private $dataFinal;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Tcmba\Obra
     */
    private $fkTcmbaObra;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\SwCgm
     */
    private $fkSwCgm;


    /**
     * Set codObra
     *
     * @param integer $codObra
     * @return ObraFiscal
     */
    public function setCodObra($codObra)
    {
        $this->codObra = $codObra;
        return $this;
    }

    /**
     * Get codObra
     *
     * @return integer
     */
    public function getCodObra()
    {
        return $this->codObra;
    }

    /**
     * Set codEntidade
     *
     * @param integer $codEntidade
     * @return ObraFiscal
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
     * @return ObraFiscal
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
     * Set codTipo
     *
     * @param integer $codTipo
     * @return ObraFiscal
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
     * Set numcgm
     *
     * @param integer $numcgm
     * @return ObraFiscal
     */
    public function setNumcgm($numcgm)
    {
        $this->numcgm = $numcgm;
        return $this;
    }

    /**
     * Get numcgm
     *
     * @return integer
     */
    public function getNumcgm()
    {
        return $this->numcgm;
    }

    /**
     * Set matricula
     *
     * @param string $matricula
     * @return ObraFiscal
     */
    public function setMatricula($matricula = null)
    {
        $this->matricula = $matricula;
        return $this;
    }

    /**
     * Get matricula
     *
     * @return string
     */
    public function getMatricula()
    {
        return $this->matricula;
    }

    /**
     * Set registroProfissional
     *
     * @param string $registroProfissional
     * @return ObraFiscal
     */
    public function setRegistroProfissional($registroProfissional = null)
    {
        $this->registroProfissional = $registroProfissional;
        return $this;
    }

    /**
     * Get registroProfissional
     *
     * @return string
     */
    public function getRegistroProfissional()
    {
        return $this->registroProfissional;
    }

    /**
     * Set dataInicio
     *
     * @param \DateTime $dataInicio
     * @return ObraFiscal
     */
    public function setDataInicio(\DateTime $dataInicio)
    {
        $this->dataInicio = $dataInicio;
        return $this;
    }

    /**
     * Get dataInicio
     *
     * @return \DateTime
     */
    public function getDataInicio()
    {
        return $this->dataInicio;
    }

    /**
     * Set dataFinal
     *
     * @param \DateTime $dataFinal
     * @return ObraFiscal
     */
    public function setDataFinal(\DateTime $dataFinal)
    {
        $this->dataFinal = $dataFinal;
        return $this;
    }

    /**
     * Get dataFinal
     *
     * @return \DateTime
     */
    public function getDataFinal()
    {
        return $this->dataFinal;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkTcmbaObra
     *
     * @param \Urbem\CoreBundle\Entity\Tcmba\Obra $fkTcmbaObra
     * @return ObraFiscal
     */
    public function setFkTcmbaObra(\Urbem\CoreBundle\Entity\Tcmba\Obra $fkTcmbaObra)
    {
        $this->codObra = $fkTcmbaObra->getCodObra();
        $this->codEntidade = $fkTcmbaObra->getCodEntidade();
        $this->exercicio = $fkTcmbaObra->getExercicio();
        $this->codTipo = $fkTcmbaObra->getCodTipo();
        $this->fkTcmbaObra = $fkTcmbaObra;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkTcmbaObra
     *
     * @return \Urbem\CoreBundle\Entity\Tcmba\Obra
     */
    public function getFkTcmbaObra()
    {
        return $this->fkTcmbaObra;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkSwCgm
     *
     * @param \Urbem\CoreBundle\Entity\SwCgm $fkSwCgm
     * @return ObraFiscal
     */
    public function setFkSwCgm(\Urbem\CoreBundle\Entity\SwCgm $fkSwCgm)
    {
        $this->numcgm = $fkSwCgm->getNumcgm();
        $this->fkSwCgm = $fkSwCgm;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkSwCgm
     *
     * @return \Urbem\CoreBundle\Entity\SwCgm
     */
    public function getFkSwCgm()
    {
        return $this->fkSwCgm;
    }
}
