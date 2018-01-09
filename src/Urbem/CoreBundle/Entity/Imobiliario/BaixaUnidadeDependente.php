<?php
 
namespace Urbem\CoreBundle\Entity\Imobiliario;

/**
 * BaixaUnidadeDependente
 */
class BaixaUnidadeDependente
{
    /**
     * PK
     * @var integer
     */
    private $inscricaoMunicipal;

    /**
     * PK
     * @var integer
     */
    private $codConstrucaoDependente;

    /**
     * PK
     * @var integer
     */
    private $codConstrucao;

    /**
     * PK
     * @var integer
     */
    private $codTipo;

    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    private $timestamp;

    /**
     * @var string
     */
    private $justificativa;

    /**
     * @var string
     */
    private $justificativaTermino;

    /**
     * @var \DateTime
     */
    private $dtInicio;

    /**
     * @var \DateTime
     */
    private $dtTermino;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Imobiliario\UnidadeDependente
     */
    private $fkImobiliarioUnidadeDependente;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
    }

    /**
     * Set inscricaoMunicipal
     *
     * @param integer $inscricaoMunicipal
     * @return BaixaUnidadeDependente
     */
    public function setInscricaoMunicipal($inscricaoMunicipal)
    {
        $this->inscricaoMunicipal = $inscricaoMunicipal;
        return $this;
    }

    /**
     * Get inscricaoMunicipal
     *
     * @return integer
     */
    public function getInscricaoMunicipal()
    {
        return $this->inscricaoMunicipal;
    }

    /**
     * Set codConstrucaoDependente
     *
     * @param integer $codConstrucaoDependente
     * @return BaixaUnidadeDependente
     */
    public function setCodConstrucaoDependente($codConstrucaoDependente)
    {
        $this->codConstrucaoDependente = $codConstrucaoDependente;
        return $this;
    }

    /**
     * Get codConstrucaoDependente
     *
     * @return integer
     */
    public function getCodConstrucaoDependente()
    {
        return $this->codConstrucaoDependente;
    }

    /**
     * Set codConstrucao
     *
     * @param integer $codConstrucao
     * @return BaixaUnidadeDependente
     */
    public function setCodConstrucao($codConstrucao)
    {
        $this->codConstrucao = $codConstrucao;
        return $this;
    }

    /**
     * Get codConstrucao
     *
     * @return integer
     */
    public function getCodConstrucao()
    {
        return $this->codConstrucao;
    }

    /**
     * Set codTipo
     *
     * @param integer $codTipo
     * @return BaixaUnidadeDependente
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
     * @return BaixaUnidadeDependente
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
     * Set justificativa
     *
     * @param string $justificativa
     * @return BaixaUnidadeDependente
     */
    public function setJustificativa($justificativa)
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
     * Set justificativaTermino
     *
     * @param string $justificativaTermino
     * @return BaixaUnidadeDependente
     */
    public function setJustificativaTermino($justificativaTermino = null)
    {
        $this->justificativaTermino = $justificativaTermino;
        return $this;
    }

    /**
     * Get justificativaTermino
     *
     * @return string
     */
    public function getJustificativaTermino()
    {
        return $this->justificativaTermino;
    }

    /**
     * Set dtInicio
     *
     * @param \DateTime $dtInicio
     * @return BaixaUnidadeDependente
     */
    public function setDtInicio(\DateTime $dtInicio)
    {
        $this->dtInicio = $dtInicio;
        return $this;
    }

    /**
     * Get dtInicio
     *
     * @return \DateTime
     */
    public function getDtInicio()
    {
        return $this->dtInicio;
    }

    /**
     * Set dtTermino
     *
     * @param \DateTime $dtTermino
     * @return BaixaUnidadeDependente
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
     * ManyToOne (inverse side)
     * Set fkImobiliarioUnidadeDependente
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\UnidadeDependente $fkImobiliarioUnidadeDependente
     * @return BaixaUnidadeDependente
     */
    public function setFkImobiliarioUnidadeDependente(\Urbem\CoreBundle\Entity\Imobiliario\UnidadeDependente $fkImobiliarioUnidadeDependente)
    {
        $this->inscricaoMunicipal = $fkImobiliarioUnidadeDependente->getInscricaoMunicipal();
        $this->codConstrucaoDependente = $fkImobiliarioUnidadeDependente->getCodConstrucaoDependente();
        $this->codTipo = $fkImobiliarioUnidadeDependente->getCodTipo();
        $this->codConstrucao = $fkImobiliarioUnidadeDependente->getCodConstrucao();
        $this->fkImobiliarioUnidadeDependente = $fkImobiliarioUnidadeDependente;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkImobiliarioUnidadeDependente
     *
     * @return \Urbem\CoreBundle\Entity\Imobiliario\UnidadeDependente
     */
    public function getFkImobiliarioUnidadeDependente()
    {
        return $this->fkImobiliarioUnidadeDependente;
    }
}
