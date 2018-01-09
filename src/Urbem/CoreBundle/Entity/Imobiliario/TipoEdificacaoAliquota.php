<?php
 
namespace Urbem\CoreBundle\Entity\Imobiliario;

/**
 * TipoEdificacaoAliquota
 */
class TipoEdificacaoAliquota
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
    private $aliquotaTerritorial;

    /**
     * @var integer
     */
    private $aliquotaPredial;

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
     * @return TipoEdificacaoAliquota
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
     * @return TipoEdificacaoAliquota
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
     * @return TipoEdificacaoAliquota
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
     * @return TipoEdificacaoAliquota
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
     * Set aliquotaTerritorial
     *
     * @param integer $aliquotaTerritorial
     * @return TipoEdificacaoAliquota
     */
    public function setAliquotaTerritorial($aliquotaTerritorial)
    {
        $this->aliquotaTerritorial = $aliquotaTerritorial;
        return $this;
    }

    /**
     * Get aliquotaTerritorial
     *
     * @return integer
     */
    public function getAliquotaTerritorial()
    {
        return $this->aliquotaTerritorial;
    }

    /**
     * Set aliquotaPredial
     *
     * @param integer $aliquotaPredial
     * @return TipoEdificacaoAliquota
     */
    public function setAliquotaPredial($aliquotaPredial)
    {
        $this->aliquotaPredial = $aliquotaPredial;
        return $this;
    }

    /**
     * Get aliquotaPredial
     *
     * @return integer
     */
    public function getAliquotaPredial()
    {
        return $this->aliquotaPredial;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkImobiliarioTipoEdificacao
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\TipoEdificacao $fkImobiliarioTipoEdificacao
     * @return TipoEdificacaoAliquota
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
     * @return TipoEdificacaoAliquota
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
