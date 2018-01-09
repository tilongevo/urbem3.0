<?php
 
namespace Urbem\CoreBundle\Entity\Imobiliario;

/**
 * BaixaUnidadeAutonoma
 */
class BaixaUnidadeAutonoma
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
    private $codTipo;

    /**
     * PK
     * @var integer
     */
    private $codConstrucao;

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
     * @var \Urbem\CoreBundle\Entity\Imobiliario\UnidadeAutonoma
     */
    private $fkImobiliarioUnidadeAutonoma;

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
     * @return BaixaUnidadeAutonoma
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
     * Set codTipo
     *
     * @param integer $codTipo
     * @return BaixaUnidadeAutonoma
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
     * Set codConstrucao
     *
     * @param integer $codConstrucao
     * @return BaixaUnidadeAutonoma
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
     * Set timestamp
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp
     * @return BaixaUnidadeAutonoma
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
     * @return BaixaUnidadeAutonoma
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
     * @return BaixaUnidadeAutonoma
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
     * @return BaixaUnidadeAutonoma
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
     * @return BaixaUnidadeAutonoma
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
     * Set fkImobiliarioUnidadeAutonoma
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\UnidadeAutonoma $fkImobiliarioUnidadeAutonoma
     * @return BaixaUnidadeAutonoma
     */
    public function setFkImobiliarioUnidadeAutonoma(\Urbem\CoreBundle\Entity\Imobiliario\UnidadeAutonoma $fkImobiliarioUnidadeAutonoma)
    {
        $this->inscricaoMunicipal = $fkImobiliarioUnidadeAutonoma->getInscricaoMunicipal();
        $this->codTipo = $fkImobiliarioUnidadeAutonoma->getCodTipo();
        $this->codConstrucao = $fkImobiliarioUnidadeAutonoma->getCodConstrucao();
        $this->fkImobiliarioUnidadeAutonoma = $fkImobiliarioUnidadeAutonoma;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkImobiliarioUnidadeAutonoma
     *
     * @return \Urbem\CoreBundle\Entity\Imobiliario\UnidadeAutonoma
     */
    public function getFkImobiliarioUnidadeAutonoma()
    {
        return $this->fkImobiliarioUnidadeAutonoma;
    }
}
