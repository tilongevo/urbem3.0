<?php
 
namespace Urbem\CoreBundle\Entity\Arrecadacao;

/**
 * DesoneradoCadEconomico
 */
class DesoneradoCadEconomico
{
    /**
     * PK
     * @var integer
     */
    private $numcgm;

    /**
     * PK
     * @var integer
     */
    private $codDesoneracao;

    /**
     * PK
     * @var integer
     */
    private $inscricaoEconomica;

    /**
     * PK
     * @var integer
     */
    private $ocorrencia;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Arrecadacao\Desonerado
     */
    private $fkArrecadacaoDesonerado;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Economico\CadastroEconomico
     */
    private $fkEconomicoCadastroEconomico;


    /**
     * Set numcgm
     *
     * @param integer $numcgm
     * @return DesoneradoCadEconomico
     */
    public function setNumcgm($numcgm)
    {
        $this->numcgm = $numcgm;
        return $this;
    }

    /**
     * Get numcgm
     *
     * @return integer
     */
    public function getNumcgm()
    {
        return $this->numcgm;
    }

    /**
     * Set codDesoneracao
     *
     * @param integer $codDesoneracao
     * @return DesoneradoCadEconomico
     */
    public function setCodDesoneracao($codDesoneracao)
    {
        $this->codDesoneracao = $codDesoneracao;
        return $this;
    }

    /**
     * Get codDesoneracao
     *
     * @return integer
     */
    public function getCodDesoneracao()
    {
        return $this->codDesoneracao;
    }

    /**
     * Set inscricaoEconomica
     *
     * @param integer $inscricaoEconomica
     * @return DesoneradoCadEconomico
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
     * Set ocorrencia
     *
     * @param integer $ocorrencia
     * @return DesoneradoCadEconomico
     */
    public function setOcorrencia($ocorrencia)
    {
        $this->ocorrencia = $ocorrencia;
        return $this;
    }

    /**
     * Get ocorrencia
     *
     * @return integer
     */
    public function getOcorrencia()
    {
        return $this->ocorrencia;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkArrecadacaoDesonerado
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\Desonerado $fkArrecadacaoDesonerado
     * @return DesoneradoCadEconomico
     */
    public function setFkArrecadacaoDesonerado(\Urbem\CoreBundle\Entity\Arrecadacao\Desonerado $fkArrecadacaoDesonerado)
    {
        $this->codDesoneracao = $fkArrecadacaoDesonerado->getCodDesoneracao();
        $this->numcgm = $fkArrecadacaoDesonerado->getNumcgm();
        $this->ocorrencia = $fkArrecadacaoDesonerado->getOcorrencia();
        $this->fkArrecadacaoDesonerado = $fkArrecadacaoDesonerado;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkArrecadacaoDesonerado
     *
     * @return \Urbem\CoreBundle\Entity\Arrecadacao\Desonerado
     */
    public function getFkArrecadacaoDesonerado()
    {
        return $this->fkArrecadacaoDesonerado;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkEconomicoCadastroEconomico
     *
     * @param \Urbem\CoreBundle\Entity\Economico\CadastroEconomico $fkEconomicoCadastroEconomico
     * @return DesoneradoCadEconomico
     */
    public function setFkEconomicoCadastroEconomico(\Urbem\CoreBundle\Entity\Economico\CadastroEconomico $fkEconomicoCadastroEconomico)
    {
        $this->inscricaoEconomica = $fkEconomicoCadastroEconomico->getInscricaoEconomica();
        $this->fkEconomicoCadastroEconomico = $fkEconomicoCadastroEconomico;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkEconomicoCadastroEconomico
     *
     * @return \Urbem\CoreBundle\Entity\Economico\CadastroEconomico
     */
    public function getFkEconomicoCadastroEconomico()
    {
        return $this->fkEconomicoCadastroEconomico;
    }
}
