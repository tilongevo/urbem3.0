<?php

namespace Urbem\CoreBundle\Entity\Economico;

/**
 * AtividadeModalidadeIndicador
 */
class AtividadeModalidadeIndicador
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
    private $codIndicador;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Economico\AtividadeModalidadeLancamento
     */
    private $fkEconomicoAtividadeModalidadeLancamento;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Monetario\IndicadorEconomico
     */
    private $fkMonetarioIndicadorEconomico;

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
     * @return AtividadeModalidadeIndicador
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
     * @return AtividadeModalidadeIndicador
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
     * @return AtividadeModalidadeIndicador
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
     * Set codIndicador
     *
     * @param integer $codIndicador
     * @return AtividadeModalidadeIndicador
     */
    public function setCodIndicador($codIndicador)
    {
        $this->codIndicador = $codIndicador;
        return $this;
    }

    /**
     * Get codIndicador
     *
     * @return integer
     */
    public function getCodIndicador()
    {
        return $this->codIndicador;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkEconomicoAtividadeModalidadeLancamento
     *
     * @param \Urbem\CoreBundle\Entity\Economico\AtividadeModalidadeLancamento $fkEconomicoAtividadeModalidadeLancamento
     * @return AtividadeModalidadeIndicador
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
     * Set fkMonetarioIndicadorEconomico
     *
     * @param \Urbem\CoreBundle\Entity\Monetario\IndicadorEconomico $fkMonetarioIndicadorEconomico
     * @return AtividadeModalidadeIndicador
     */
    public function setFkMonetarioIndicadorEconomico(\Urbem\CoreBundle\Entity\Monetario\IndicadorEconomico $fkMonetarioIndicadorEconomico)
    {
        $this->codIndicador = $fkMonetarioIndicadorEconomico->getCodIndicador();
        $this->fkMonetarioIndicadorEconomico = $fkMonetarioIndicadorEconomico;

        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkMonetarioIndicadorEconomico
     *
     * @return \Urbem\CoreBundle\Entity\Monetario\IndicadorEconomico
     */
    public function getFkMonetarioIndicadorEconomico()
    {
        return $this->fkMonetarioIndicadorEconomico;
    }
}
