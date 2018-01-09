<?php
 
namespace Urbem\CoreBundle\Entity\Arrecadacao;

/**
 * DesoneradoImovel
 */
class DesoneradoImovel
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
    private $inscricaoMunicipal;

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
     * @var \Urbem\CoreBundle\Entity\Imobiliario\Imovel
     */
    private $fkImobiliarioImovel;


    /**
     * Set numcgm
     *
     * @param integer $numcgm
     * @return DesoneradoImovel
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
     * @return DesoneradoImovel
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
     * Set inscricaoMunicipal
     *
     * @param integer $inscricaoMunicipal
     * @return DesoneradoImovel
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
     * Set ocorrencia
     *
     * @param integer $ocorrencia
     * @return DesoneradoImovel
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
     * @return DesoneradoImovel
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
     * Set fkImobiliarioImovel
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\Imovel $fkImobiliarioImovel
     * @return DesoneradoImovel
     */
    public function setFkImobiliarioImovel(\Urbem\CoreBundle\Entity\Imobiliario\Imovel $fkImobiliarioImovel)
    {
        $this->inscricaoMunicipal = $fkImobiliarioImovel->getInscricaoMunicipal();
        $this->fkImobiliarioImovel = $fkImobiliarioImovel;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkImobiliarioImovel
     *
     * @return \Urbem\CoreBundle\Entity\Imobiliario\Imovel
     */
    public function getFkImobiliarioImovel()
    {
        return $this->fkImobiliarioImovel;
    }
}
