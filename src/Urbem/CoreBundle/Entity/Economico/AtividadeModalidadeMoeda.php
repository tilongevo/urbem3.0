<?php
 
namespace Urbem\CoreBundle\Entity\Economico;

/**
 * AtividadeModalidadeMoeda
 */
class AtividadeModalidadeMoeda
{
    /**
     * PK
     * @var integer
     */
    private $codModalidade;

    /**
     * PK
     * @var integer
     */
    private $codAtividade;

    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DatePK
     */
    private $dtInicio;

    /**
     * PK
     * @var integer
     */
    private $codMoeda;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Economico\AtividadeModalidadeLancamento
     */
    private $fkEconomicoAtividadeModalidadeLancamento;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Monetario\Moeda
     */
    private $fkMonetarioMoeda;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->dtInicio = new \Urbem\CoreBundle\Helper\DatePK;
    }

    /**
     * Set codModalidade
     *
     * @param integer $codModalidade
     * @return AtividadeModalidadeMoeda
     */
    public function setCodModalidade($codModalidade)
    {
        $this->codModalidade = $codModalidade;
        return $this;
    }

    /**
     * Get codModalidade
     *
     * @return integer
     */
    public function getCodModalidade()
    {
        return $this->codModalidade;
    }

    /**
     * Set codAtividade
     *
     * @param integer $codAtividade
     * @return AtividadeModalidadeMoeda
     */
    public function setCodAtividade($codAtividade)
    {
        $this->codAtividade = $codAtividade;
        return $this;
    }

    /**
     * Get codAtividade
     *
     * @return integer
     */
    public function getCodAtividade()
    {
        return $this->codAtividade;
    }

    /**
     * Set dtInicio
     *
     * @param \Urbem\CoreBundle\Helper\DatePK $dtInicio
     * @return AtividadeModalidadeMoeda
     */
    public function setDtInicio(\Urbem\CoreBundle\Helper\DatePK $dtInicio)
    {
        $this->dtInicio = $dtInicio;
        return $this;
    }

    /**
     * Get dtInicio
     *
     * @return \Urbem\CoreBundle\Helper\DatePK
     */
    public function getDtInicio()
    {
        return $this->dtInicio;
    }

    /**
     * Set codMoeda
     *
     * @param integer $codMoeda
     * @return AtividadeModalidadeMoeda
     */
    public function setCodMoeda($codMoeda)
    {
        $this->codMoeda = $codMoeda;
        return $this;
    }

    /**
     * Get codMoeda
     *
     * @return integer
     */
    public function getCodMoeda()
    {
        return $this->codMoeda;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkEconomicoAtividadeModalidadeLancamento
     *
     * @param \Urbem\CoreBundle\Entity\Economico\AtividadeModalidadeLancamento $fkEconomicoAtividadeModalidadeLancamento
     * @return AtividadeModalidadeMoeda
     */
    public function setFkEconomicoAtividadeModalidadeLancamento(\Urbem\CoreBundle\Entity\Economico\AtividadeModalidadeLancamento $fkEconomicoAtividadeModalidadeLancamento)
    {
        $this->codAtividade = $fkEconomicoAtividadeModalidadeLancamento->getCodAtividade();
        $this->codModalidade = $fkEconomicoAtividadeModalidadeLancamento->getCodModalidade();
        $this->dtInicio = $fkEconomicoAtividadeModalidadeLancamento->getDtInicio();
        $this->fkEconomicoAtividadeModalidadeLancamento = $fkEconomicoAtividadeModalidadeLancamento;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkEconomicoAtividadeModalidadeLancamento
     *
     * @return \Urbem\CoreBundle\Entity\Economico\AtividadeModalidadeLancamento
     */
    public function getFkEconomicoAtividadeModalidadeLancamento()
    {
        return $this->fkEconomicoAtividadeModalidadeLancamento;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkMonetarioMoeda
     *
     * @param \Urbem\CoreBundle\Entity\Monetario\Moeda $fkMonetarioMoeda
     * @return AtividadeModalidadeMoeda
     */
    public function setFkMonetarioMoeda(\Urbem\CoreBundle\Entity\Monetario\Moeda $fkMonetarioMoeda)
    {
        $this->codMoeda = $fkMonetarioMoeda->getCodMoeda();
        $this->fkMonetarioMoeda = $fkMonetarioMoeda;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkMonetarioMoeda
     *
     * @return \Urbem\CoreBundle\Entity\Monetario\Moeda
     */
    public function getFkMonetarioMoeda()
    {
        return $this->fkMonetarioMoeda;
    }
}
