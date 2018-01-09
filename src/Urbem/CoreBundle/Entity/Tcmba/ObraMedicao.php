<?php
 
namespace Urbem\CoreBundle\Entity\Tcmba;

/**
 * ObraMedicao
 */
class ObraMedicao
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
    private $codMedicao;

    /**
     * @var integer
     */
    private $codMedida;

    /**
     * @var \DateTime
     */
    private $dataInicio;

    /**
     * @var \DateTime
     */
    private $dataFinal;

    /**
     * @var integer
     */
    private $vlMedicao;

    /**
     * @var string
     */
    private $nroNotaFiscal;

    /**
     * @var \DateTime
     */
    private $dataNotaFiscal;

    /**
     * @var integer
     */
    private $numcgm;

    /**
     * @var \DateTime
     */
    private $dataMedicao;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Tcmba\Obra
     */
    private $fkTcmbaObra;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Tcmba\MedidasObra
     */
    private $fkTcmbaMedidasObra;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\SwCgmPessoaFisica
     */
    private $fkSwCgmPessoaFisica;


    /**
     * Set codObra
     *
     * @param integer $codObra
     * @return ObraMedicao
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
     * @return ObraMedicao
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
     * @return ObraMedicao
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
     * @return ObraMedicao
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
     * Set codMedicao
     *
     * @param integer $codMedicao
     * @return ObraMedicao
     */
    public function setCodMedicao($codMedicao)
    {
        $this->codMedicao = $codMedicao;
        return $this;
    }

    /**
     * Get codMedicao
     *
     * @return integer
     */
    public function getCodMedicao()
    {
        return $this->codMedicao;
    }

    /**
     * Set codMedida
     *
     * @param integer $codMedida
     * @return ObraMedicao
     */
    public function setCodMedida($codMedida)
    {
        $this->codMedida = $codMedida;
        return $this;
    }

    /**
     * Get codMedida
     *
     * @return integer
     */
    public function getCodMedida()
    {
        return $this->codMedida;
    }

    /**
     * Set dataInicio
     *
     * @param \DateTime $dataInicio
     * @return ObraMedicao
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
     * @return ObraMedicao
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
     * Set vlMedicao
     *
     * @param integer $vlMedicao
     * @return ObraMedicao
     */
    public function setVlMedicao($vlMedicao)
    {
        $this->vlMedicao = $vlMedicao;
        return $this;
    }

    /**
     * Get vlMedicao
     *
     * @return integer
     */
    public function getVlMedicao()
    {
        return $this->vlMedicao;
    }

    /**
     * Set nroNotaFiscal
     *
     * @param string $nroNotaFiscal
     * @return ObraMedicao
     */
    public function setNroNotaFiscal($nroNotaFiscal)
    {
        $this->nroNotaFiscal = $nroNotaFiscal;
        return $this;
    }

    /**
     * Get nroNotaFiscal
     *
     * @return string
     */
    public function getNroNotaFiscal()
    {
        return $this->nroNotaFiscal;
    }

    /**
     * Set dataNotaFiscal
     *
     * @param \DateTime $dataNotaFiscal
     * @return ObraMedicao
     */
    public function setDataNotaFiscal(\DateTime $dataNotaFiscal)
    {
        $this->dataNotaFiscal = $dataNotaFiscal;
        return $this;
    }

    /**
     * Get dataNotaFiscal
     *
     * @return \DateTime
     */
    public function getDataNotaFiscal()
    {
        return $this->dataNotaFiscal;
    }

    /**
     * Set numcgm
     *
     * @param integer $numcgm
     * @return ObraMedicao
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
     * Set dataMedicao
     *
     * @param \DateTime $dataMedicao
     * @return ObraMedicao
     */
    public function setDataMedicao(\DateTime $dataMedicao)
    {
        $this->dataMedicao = $dataMedicao;
        return $this;
    }

    /**
     * Get dataMedicao
     *
     * @return \DateTime
     */
    public function getDataMedicao()
    {
        return $this->dataMedicao;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkTcmbaObra
     *
     * @param \Urbem\CoreBundle\Entity\Tcmba\Obra $fkTcmbaObra
     * @return ObraMedicao
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
     * Set fkTcmbaMedidasObra
     *
     * @param \Urbem\CoreBundle\Entity\Tcmba\MedidasObra $fkTcmbaMedidasObra
     * @return ObraMedicao
     */
    public function setFkTcmbaMedidasObra(\Urbem\CoreBundle\Entity\Tcmba\MedidasObra $fkTcmbaMedidasObra)
    {
        $this->codMedida = $fkTcmbaMedidasObra->getCodMedida();
        $this->fkTcmbaMedidasObra = $fkTcmbaMedidasObra;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkTcmbaMedidasObra
     *
     * @return \Urbem\CoreBundle\Entity\Tcmba\MedidasObra
     */
    public function getFkTcmbaMedidasObra()
    {
        return $this->fkTcmbaMedidasObra;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkSwCgmPessoaFisica
     *
     * @param \Urbem\CoreBundle\Entity\SwCgmPessoaFisica $fkSwCgmPessoaFisica
     * @return ObraMedicao
     */
    public function setFkSwCgmPessoaFisica(\Urbem\CoreBundle\Entity\SwCgmPessoaFisica $fkSwCgmPessoaFisica)
    {
        $this->numcgm = $fkSwCgmPessoaFisica->getNumcgm();
        $this->fkSwCgmPessoaFisica = $fkSwCgmPessoaFisica;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkSwCgmPessoaFisica
     *
     * @return \Urbem\CoreBundle\Entity\SwCgmPessoaFisica
     */
    public function getFkSwCgmPessoaFisica()
    {
        return $this->fkSwCgmPessoaFisica;
    }
}
