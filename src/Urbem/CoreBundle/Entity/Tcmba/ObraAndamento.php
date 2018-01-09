<?php
 
namespace Urbem\CoreBundle\Entity\Tcmba;

/**
 * ObraAndamento
 */
class ObraAndamento
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
    private $codSituacao;

    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DatePK
     */
    private $dataSituacao;

    /**
     * @var string
     */
    private $justificativa;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Tcmba\Obra
     */
    private $fkTcmbaObra;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Tcmba\SituacaoObra
     */
    private $fkTcmbaSituacaoObra;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->dataSituacao = new \Urbem\CoreBundle\Helper\DatePK;
    }

    /**
     * Set codObra
     *
     * @param integer $codObra
     * @return ObraAndamento
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
     * @return ObraAndamento
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
     * @return ObraAndamento
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
     * @return ObraAndamento
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
     * Set codSituacao
     *
     * @param integer $codSituacao
     * @return ObraAndamento
     */
    public function setCodSituacao($codSituacao)
    {
        $this->codSituacao = $codSituacao;
        return $this;
    }

    /**
     * Get codSituacao
     *
     * @return integer
     */
    public function getCodSituacao()
    {
        return $this->codSituacao;
    }

    /**
     * Set dataSituacao
     *
     * @param \Urbem\CoreBundle\Helper\DatePK $dataSituacao
     * @return ObraAndamento
     */
    public function setDataSituacao(\Urbem\CoreBundle\Helper\DatePK $dataSituacao)
    {
        $this->dataSituacao = $dataSituacao;
        return $this;
    }

    /**
     * Get dataSituacao
     *
     * @return \Urbem\CoreBundle\Helper\DatePK
     */
    public function getDataSituacao()
    {
        return $this->dataSituacao;
    }

    /**
     * Set justificativa
     *
     * @param string $justificativa
     * @return ObraAndamento
     */
    public function setJustificativa($justificativa = null)
    {
        $this->justificativa = $justificativa;
        return $this;
    }

    /**
     * Get justificativa
     *
     * @return string
     */
    public function getJustificativa()
    {
        return $this->justificativa;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkTcmbaObra
     *
     * @param \Urbem\CoreBundle\Entity\Tcmba\Obra $fkTcmbaObra
     * @return ObraAndamento
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
     * Set fkTcmbaSituacaoObra
     *
     * @param \Urbem\CoreBundle\Entity\Tcmba\SituacaoObra $fkTcmbaSituacaoObra
     * @return ObraAndamento
     */
    public function setFkTcmbaSituacaoObra(\Urbem\CoreBundle\Entity\Tcmba\SituacaoObra $fkTcmbaSituacaoObra)
    {
        $this->codSituacao = $fkTcmbaSituacaoObra->getCodSituacao();
        $this->fkTcmbaSituacaoObra = $fkTcmbaSituacaoObra;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkTcmbaSituacaoObra
     *
     * @return \Urbem\CoreBundle\Entity\Tcmba\SituacaoObra
     */
    public function getFkTcmbaSituacaoObra()
    {
        return $this->fkTcmbaSituacaoObra;
    }
}
