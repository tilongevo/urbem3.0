<?php
 
namespace Urbem\CoreBundle\Entity\Economico;

/**
 * CadEconModalidadeIndicador
 */
class CadEconModalidadeIndicador
{
    /**
     * PK
     * @var integer
     */
    private $inscricaoEconomica;

    /**
     * PK
     * @var integer
     */
    private $codAtividade;

    /**
     * PK
     * @var integer
     */
    private $ocorrenciaAtividade;

    /**
     * PK
     * @var integer
     */
    private $codModalidade;

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
     * @var \Urbem\CoreBundle\Entity\Economico\CadastroEconomicoModalidadeLancamento
     */
    private $fkEconomicoCadastroEconomicoModalidadeLancamento;

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
     * Set inscricaoEconomica
     *
     * @param integer $inscricaoEconomica
     * @return CadEconModalidadeIndicador
     */
    public function setInscricaoEconomica($inscricaoEconomica)
    {
        $this->inscricaoEconomica = $inscricaoEconomica;
        return $this;
    }

    /**
     * Get inscricaoEconomica
     *
     * @return integer
     */
    public function getInscricaoEconomica()
    {
        return $this->inscricaoEconomica;
    }

    /**
     * Set codAtividade
     *
     * @param integer $codAtividade
     * @return CadEconModalidadeIndicador
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
     * Set ocorrenciaAtividade
     *
     * @param integer $ocorrenciaAtividade
     * @return CadEconModalidadeIndicador
     */
    public function setOcorrenciaAtividade($ocorrenciaAtividade)
    {
        $this->ocorrenciaAtividade = $ocorrenciaAtividade;
        return $this;
    }

    /**
     * Get ocorrenciaAtividade
     *
     * @return integer
     */
    public function getOcorrenciaAtividade()
    {
        return $this->ocorrenciaAtividade;
    }

    /**
     * Set codModalidade
     *
     * @param integer $codModalidade
     * @return CadEconModalidadeIndicador
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
     * Set dtInicio
     *
     * @param \Urbem\CoreBundle\Helper\DatePK $dtInicio
     * @return CadEconModalidadeIndicador
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
     * @return CadEconModalidadeIndicador
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
     * Set fkEconomicoCadastroEconomicoModalidadeLancamento
     *
     * @param \Urbem\CoreBundle\Entity\Economico\CadastroEconomicoModalidadeLancamento $fkEconomicoCadastroEconomicoModalidadeLancamento
     * @return CadEconModalidadeIndicador
     */
    public function setFkEconomicoCadastroEconomicoModalidadeLancamento(\Urbem\CoreBundle\Entity\Economico\CadastroEconomicoModalidadeLancamento $fkEconomicoCadastroEconomicoModalidadeLancamento)
    {
        $this->codModalidade = $fkEconomicoCadastroEconomicoModalidadeLancamento->getCodModalidade();
        $this->codAtividade = $fkEconomicoCadastroEconomicoModalidadeLancamento->getCodAtividade();
        $this->inscricaoEconomica = $fkEconomicoCadastroEconomicoModalidadeLancamento->getInscricaoEconomica();
        $this->ocorrenciaAtividade = $fkEconomicoCadastroEconomicoModalidadeLancamento->getOcorrenciaAtividade();
        $this->dtInicio = $fkEconomicoCadastroEconomicoModalidadeLancamento->getDtInicio();
        $this->fkEconomicoCadastroEconomicoModalidadeLancamento = $fkEconomicoCadastroEconomicoModalidadeLancamento;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkEconomicoCadastroEconomicoModalidadeLancamento
     *
     * @return \Urbem\CoreBundle\Entity\Economico\CadastroEconomicoModalidadeLancamento
     */
    public function getFkEconomicoCadastroEconomicoModalidadeLancamento()
    {
        return $this->fkEconomicoCadastroEconomicoModalidadeLancamento;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkMonetarioIndicadorEconomico
     *
     * @param \Urbem\CoreBundle\Entity\Monetario\IndicadorEconomico $fkMonetarioIndicadorEconomico
     * @return CadEconModalidadeIndicador
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
