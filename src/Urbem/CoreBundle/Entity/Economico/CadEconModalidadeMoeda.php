<?php
 
namespace Urbem\CoreBundle\Entity\Economico;

/**
 * CadEconModalidadeMoeda
 */
class CadEconModalidadeMoeda
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
    private $codMoeda;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Economico\CadastroEconomicoModalidadeLancamento
     */
    private $fkEconomicoCadastroEconomicoModalidadeLancamento;

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
     * Set inscricaoEconomica
     *
     * @param integer $inscricaoEconomica
     * @return CadEconModalidadeMoeda
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
     * @return CadEconModalidadeMoeda
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
     * @return CadEconModalidadeMoeda
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
     * @return CadEconModalidadeMoeda
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
     * @return CadEconModalidadeMoeda
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
     * @return CadEconModalidadeMoeda
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
     * Set fkEconomicoCadastroEconomicoModalidadeLancamento
     *
     * @param \Urbem\CoreBundle\Entity\Economico\CadastroEconomicoModalidadeLancamento $fkEconomicoCadastroEconomicoModalidadeLancamento
     * @return CadEconModalidadeMoeda
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
     * Set fkMonetarioMoeda
     *
     * @param \Urbem\CoreBundle\Entity\Monetario\Moeda $fkMonetarioMoeda
     * @return CadEconModalidadeMoeda
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
