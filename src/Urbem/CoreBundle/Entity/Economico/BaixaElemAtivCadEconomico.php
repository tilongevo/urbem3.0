<?php
 
namespace Urbem\CoreBundle\Entity\Economico;

/**
 * BaixaElemAtivCadEconomico
 */
class BaixaElemAtivCadEconomico
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
    private $codElemento;

    /**
     * PK
     * @var integer
     */
    private $ocorrenciaElemento;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Economico\ElementoAtivCadEconomico
     */
    private $fkEconomicoElementoAtivCadEconomico;


    /**
     * Set inscricaoEconomica
     *
     * @param integer $inscricaoEconomica
     * @return BaixaElemAtivCadEconomico
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
     * @return BaixaElemAtivCadEconomico
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
     * @return BaixaElemAtivCadEconomico
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
     * Set codElemento
     *
     * @param integer $codElemento
     * @return BaixaElemAtivCadEconomico
     */
    public function setCodElemento($codElemento)
    {
        $this->codElemento = $codElemento;
        return $this;
    }

    /**
     * Get codElemento
     *
     * @return integer
     */
    public function getCodElemento()
    {
        return $this->codElemento;
    }

    /**
     * Set ocorrenciaElemento
     *
     * @param integer $ocorrenciaElemento
     * @return BaixaElemAtivCadEconomico
     */
    public function setOcorrenciaElemento($ocorrenciaElemento)
    {
        $this->ocorrenciaElemento = $ocorrenciaElemento;
        return $this;
    }

    /**
     * Get ocorrenciaElemento
     *
     * @return integer
     */
    public function getOcorrenciaElemento()
    {
        return $this->ocorrenciaElemento;
    }

    /**
     * OneToOne (owning side)
     * Set EconomicoElementoAtivCadEconomico
     *
     * @param \Urbem\CoreBundle\Entity\Economico\ElementoAtivCadEconomico $fkEconomicoElementoAtivCadEconomico
     * @return BaixaElemAtivCadEconomico
     */
    public function setFkEconomicoElementoAtivCadEconomico(\Urbem\CoreBundle\Entity\Economico\ElementoAtivCadEconomico $fkEconomicoElementoAtivCadEconomico)
    {
        $this->inscricaoEconomica = $fkEconomicoElementoAtivCadEconomico->getInscricaoEconomica();
        $this->codAtividade = $fkEconomicoElementoAtivCadEconomico->getCodAtividade();
        $this->ocorrenciaAtividade = $fkEconomicoElementoAtivCadEconomico->getOcorrenciaAtividade();
        $this->codElemento = $fkEconomicoElementoAtivCadEconomico->getCodElemento();
        $this->ocorrenciaElemento = $fkEconomicoElementoAtivCadEconomico->getOcorrenciaElemento();
        $this->fkEconomicoElementoAtivCadEconomico = $fkEconomicoElementoAtivCadEconomico;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkEconomicoElementoAtivCadEconomico
     *
     * @return \Urbem\CoreBundle\Entity\Economico\ElementoAtivCadEconomico
     */
    public function getFkEconomicoElementoAtivCadEconomico()
    {
        return $this->fkEconomicoElementoAtivCadEconomico;
    }
}
