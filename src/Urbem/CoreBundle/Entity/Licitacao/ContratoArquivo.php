<?php
 
namespace Urbem\CoreBundle\Entity\Licitacao;

/**
 * ContratoArquivo
 */
class ContratoArquivo
{
    /**
     * PK
     * @var integer
     */
    private $numContrato;

    /**
     * PK
     * @var string
     */
    private $exercicio;

    /**
     * PK
     * @var integer
     */
    private $codEntidade;

    /**
     * PK
     * @var string
     */
    private $arquivo;

    /**
     * @var string
     */
    private $nomArquivo;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Licitacao\Contrato
     */
    private $fkLicitacaoContrato;


    /**
     * Set numContrato
     *
     * @param integer $numContrato
     * @return ContratoArquivo
     */
    public function setNumContrato($numContrato)
    {
        $this->numContrato = $numContrato;
        return $this;
    }

    /**
     * Get numContrato
     *
     * @return integer
     */
    public function getNumContrato()
    {
        return $this->numContrato;
    }

    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return ContratoArquivo
     */
    public function setExercicio($exercicio)
    {
        $this->exercicio = $exercicio;
        return $this;
    }

    /**
     * Get exercicio
     *
     * @return string
     */
    public function getExercicio()
    {
        return $this->exercicio;
    }

    /**
     * Set codEntidade
     *
     * @param integer $codEntidade
     * @return ContratoArquivo
     */
    public function setCodEntidade($codEntidade)
    {
        $this->codEntidade = $codEntidade;
        return $this;
    }

    /**
     * Get codEntidade
     *
     * @return integer
     */
    public function getCodEntidade()
    {
        return $this->codEntidade;
    }

    /**
     * Set arquivo
     *
     * @param string $arquivo
     * @return ContratoArquivo
     */
    public function setArquivo($arquivo)
    {
        $this->arquivo = $arquivo;
        return $this;
    }

    /**
     * Get arquivo
     *
     * @return string
     */
    public function getArquivo()
    {
        return $this->arquivo;
    }

    /**
     * Set nomArquivo
     *
     * @param string $nomArquivo
     * @return ContratoArquivo
     */
    public function setNomArquivo($nomArquivo)
    {
        $this->nomArquivo = $nomArquivo;
        return $this;
    }

    /**
     * Get nomArquivo
     *
     * @return string
     */
    public function getNomArquivo()
    {
        return $this->nomArquivo;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkLicitacaoContrato
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\Contrato $fkLicitacaoContrato
     * @return ContratoArquivo
     */
    public function setFkLicitacaoContrato(\Urbem\CoreBundle\Entity\Licitacao\Contrato $fkLicitacaoContrato)
    {
        $this->exercicio = $fkLicitacaoContrato->getExercicio();
        $this->codEntidade = $fkLicitacaoContrato->getCodEntidade();
        $this->numContrato = $fkLicitacaoContrato->getNumContrato();
        $this->fkLicitacaoContrato = $fkLicitacaoContrato;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkLicitacaoContrato
     *
     * @return \Urbem\CoreBundle\Entity\Licitacao\Contrato
     */
    public function getFkLicitacaoContrato()
    {
        return $this->fkLicitacaoContrato;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string) $this->getNumContrato(). " - ". $this->getNomArquivo();
    }
}
