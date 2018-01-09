<?php
 
namespace Urbem\CoreBundle\Entity\Tcmba;

/**
 * ObraContratos
 */
class ObraContratos
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
    private $codContratacao;

    /**
     * PK
     * @var integer
     */
    private $numcgm;

    /**
     * @var string
     */
    private $nroInstrumento;

    /**
     * @var string
     */
    private $nroContrato;

    /**
     * @var string
     */
    private $nroConvenio;

    /**
     * @var string
     */
    private $nroParceria;

    /**
     * @var string
     */
    private $funcaoCgm;

    /**
     * @var \DateTime
     */
    private $dataInicio;

    /**
     * @var \DateTime
     */
    private $dataFinal;

    /**
     * @var string
     */
    private $lotacao;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Tcmba\Obra
     */
    private $fkTcmbaObra;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Tcmba\TipoContratacaoObra
     */
    private $fkTcmbaTipoContratacaoObra;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\SwCgmPessoaFisica
     */
    private $fkSwCgmPessoaFisica;


    /**
     * Set codObra
     *
     * @param integer $codObra
     * @return ObraContratos
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
     * @return ObraContratos
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
     * @return ObraContratos
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
     * @return ObraContratos
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
     * Set codContratacao
     *
     * @param integer $codContratacao
     * @return ObraContratos
     */
    public function setCodContratacao($codContratacao)
    {
        $this->codContratacao = $codContratacao;
        return $this;
    }

    /**
     * Get codContratacao
     *
     * @return integer
     */
    public function getCodContratacao()
    {
        return $this->codContratacao;
    }

    /**
     * Set numcgm
     *
     * @param integer $numcgm
     * @return ObraContratos
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
     * Set nroInstrumento
     *
     * @param string $nroInstrumento
     * @return ObraContratos
     */
    public function setNroInstrumento($nroInstrumento = null)
    {
        $this->nroInstrumento = $nroInstrumento;
        return $this;
    }

    /**
     * Get nroInstrumento
     *
     * @return string
     */
    public function getNroInstrumento()
    {
        return $this->nroInstrumento;
    }

    /**
     * Set nroContrato
     *
     * @param string $nroContrato
     * @return ObraContratos
     */
    public function setNroContrato($nroContrato = null)
    {
        $this->nroContrato = $nroContrato;
        return $this;
    }

    /**
     * Get nroContrato
     *
     * @return string
     */
    public function getNroContrato()
    {
        return $this->nroContrato;
    }

    /**
     * Set nroConvenio
     *
     * @param string $nroConvenio
     * @return ObraContratos
     */
    public function setNroConvenio($nroConvenio = null)
    {
        $this->nroConvenio = $nroConvenio;
        return $this;
    }

    /**
     * Get nroConvenio
     *
     * @return string
     */
    public function getNroConvenio()
    {
        return $this->nroConvenio;
    }

    /**
     * Set nroParceria
     *
     * @param string $nroParceria
     * @return ObraContratos
     */
    public function setNroParceria($nroParceria = null)
    {
        $this->nroParceria = $nroParceria;
        return $this;
    }

    /**
     * Get nroParceria
     *
     * @return string
     */
    public function getNroParceria()
    {
        return $this->nroParceria;
    }

    /**
     * Set funcaoCgm
     *
     * @param string $funcaoCgm
     * @return ObraContratos
     */
    public function setFuncaoCgm($funcaoCgm)
    {
        $this->funcaoCgm = $funcaoCgm;
        return $this;
    }

    /**
     * Get funcaoCgm
     *
     * @return string
     */
    public function getFuncaoCgm()
    {
        return $this->funcaoCgm;
    }

    /**
     * Set dataInicio
     *
     * @param \DateTime $dataInicio
     * @return ObraContratos
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
     * @return ObraContratos
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
     * Set lotacao
     *
     * @param string $lotacao
     * @return ObraContratos
     */
    public function setLotacao($lotacao = null)
    {
        $this->lotacao = $lotacao;
        return $this;
    }

    /**
     * Get lotacao
     *
     * @return string
     */
    public function getLotacao()
    {
        return $this->lotacao;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkTcmbaObra
     *
     * @param \Urbem\CoreBundle\Entity\Tcmba\Obra $fkTcmbaObra
     * @return ObraContratos
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
     * Set fkTcmbaTipoContratacaoObra
     *
     * @param \Urbem\CoreBundle\Entity\Tcmba\TipoContratacaoObra $fkTcmbaTipoContratacaoObra
     * @return ObraContratos
     */
    public function setFkTcmbaTipoContratacaoObra(\Urbem\CoreBundle\Entity\Tcmba\TipoContratacaoObra $fkTcmbaTipoContratacaoObra)
    {
        $this->codContratacao = $fkTcmbaTipoContratacaoObra->getCodContratacao();
        $this->fkTcmbaTipoContratacaoObra = $fkTcmbaTipoContratacaoObra;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkTcmbaTipoContratacaoObra
     *
     * @return \Urbem\CoreBundle\Entity\Tcmba\TipoContratacaoObra
     */
    public function getFkTcmbaTipoContratacaoObra()
    {
        return $this->fkTcmbaTipoContratacaoObra;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkSwCgmPessoaFisica
     *
     * @param \Urbem\CoreBundle\Entity\SwCgmPessoaFisica $fkSwCgmPessoaFisica
     * @return ObraContratos
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
