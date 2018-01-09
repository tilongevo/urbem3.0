<?php
 
namespace Urbem\CoreBundle\Entity\Imobiliario;

/**
 * TipoEdificacaoValorM2
 */
class TipoEdificacaoValorM2
{
    /**
     * PK
     * @var integer
     */
    private $codTipo;

    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DateTimePK
     */
    private $timestamp;

    /**
     * @var integer
     */
    private $codNorma;

    /**
     * @var \DateTime
     */
    private $dtVigencia;

    /**
     * @var integer
     */
    private $valorM2Territorial;

    /**
     * @var integer
     */
    private $valorM2Predial;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Imobiliario\TipoEdificacao
     */
    private $fkImobiliarioTipoEdificacao;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Normas\Norma
     */
    private $fkNormasNorma;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimePK;
    }

    /**
     * Set codTipo
     *
     * @param integer $codTipo
     * @return TipoEdificacaoValorM2
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
     * @param \Urbem\CoreBundle\Helper\DateTimePK $timestamp
     * @return TipoEdificacaoValorM2
     */
    public function setTimestamp(\Urbem\CoreBundle\Helper\DateTimePK $timestamp)
    {
        $this->timestamp = $timestamp;
        return $this;
    }

    /**
     * Get timestamp
     *
     * @return \Urbem\CoreBundle\Helper\DateTimePK
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }

    /**
     * Set codNorma
     *
     * @param integer $codNorma
     * @return TipoEdificacaoValorM2
     */
    public function setCodNorma($codNorma)
    {
        $this->codNorma = $codNorma;
        return $this;
    }

    /**
     * Get codNorma
     *
     * @return integer
     */
    public function getCodNorma()
    {
        return $this->codNorma;
    }

    /**
     * Set dtVigencia
     *
     * @param \DateTime $dtVigencia
     * @return TipoEdificacaoValorM2
     */
    public function setDtVigencia(\DateTime $dtVigencia)
    {
        $this->dtVigencia = $dtVigencia;
        return $this;
    }

    /**
     * Get dtVigencia
     *
     * @return \DateTime
     */
    public function getDtVigencia()
    {
        return $this->dtVigencia;
    }

    /**
     * Set valorM2Territorial
     *
     * @param integer $valorM2Territorial
     * @return TipoEdificacaoValorM2
     */
    public function setValorM2Territorial($valorM2Territorial)
    {
        $this->valorM2Territorial = $valorM2Territorial;
        return $this;
    }

    /**
     * Get valorM2Territorial
     *
     * @return integer
     */
    public function getValorM2Territorial()
    {
        return $this->valorM2Territorial;
    }

    /**
     * Set valorM2Predial
     *
     * @param integer $valorM2Predial
     * @return TipoEdificacaoValorM2
     */
    public function setValorM2Predial($valorM2Predial)
    {
        $this->valorM2Predial = $valorM2Predial;
        return $this;
    }

    /**
     * Get valorM2Predial
     *
     * @return integer
     */
    public function getValorM2Predial()
    {
        return $this->valorM2Predial;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkImobiliarioTipoEdificacao
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\TipoEdificacao $fkImobiliarioTipoEdificacao
     * @return TipoEdificacaoValorM2
     */
    public function setFkImobiliarioTipoEdificacao(\Urbem\CoreBundle\Entity\Imobiliario\TipoEdificacao $fkImobiliarioTipoEdificacao)
    {
        $this->codTipo = $fkImobiliarioTipoEdificacao->getCodTipo();
        $this->fkImobiliarioTipoEdificacao = $fkImobiliarioTipoEdificacao;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkImobiliarioTipoEdificacao
     *
     * @return \Urbem\CoreBundle\Entity\Imobiliario\TipoEdificacao
     */
    public function getFkImobiliarioTipoEdificacao()
    {
        return $this->fkImobiliarioTipoEdificacao;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkNormasNorma
     *
     * @param \Urbem\CoreBundle\Entity\Normas\Norma $fkNormasNorma
     * @return TipoEdificacaoValorM2
     */
    public function setFkNormasNorma(\Urbem\CoreBundle\Entity\Normas\Norma $fkNormasNorma)
    {
        $this->codNorma = $fkNormasNorma->getCodNorma();
        $this->fkNormasNorma = $fkNormasNorma;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkNormasNorma
     *
     * @return \Urbem\CoreBundle\Entity\Normas\Norma
     */
    public function getFkNormasNorma()
    {
        return $this->fkNormasNorma;
    }
}
