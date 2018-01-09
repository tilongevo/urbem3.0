<?php
 
namespace Urbem\CoreBundle\Entity\Pessoal;

/**
 * AssentamentoGeradoContratoServidor
 */
class AssentamentoGeradoContratoServidor
{
    /**
     * PK
     * @var integer
     */
    private $codAssentamentoGerado;

    /**
     * @var integer
     */
    private $codContrato;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\AssentamentoGerado
     */
    private $fkPessoalAssentamentoGerados;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Pessoal\Contrato
     */
    private $fkPessoalContrato;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkPessoalAssentamentoGerados = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codAssentamentoGerado
     *
     * @param integer $codAssentamentoGerado
     * @return AssentamentoGeradoContratoServidor
     */
    public function setCodAssentamentoGerado($codAssentamentoGerado)
    {
        $this->codAssentamentoGerado = $codAssentamentoGerado;
        return $this;
    }

    /**
     * Get codAssentamentoGerado
     *
     * @return integer
     */
    public function getCodAssentamentoGerado()
    {
        return $this->codAssentamentoGerado;
    }

    /**
     * Set codContrato
     *
     * @param integer $codContrato
     * @return AssentamentoGeradoContratoServidor
     */
    public function setCodContrato($codContrato)
    {
        $this->codContrato = $codContrato;
        return $this;
    }

    /**
     * Get codContrato
     *
     * @return integer
     */
    public function getCodContrato()
    {
        return $this->codContrato;
    }

    /**
     * OneToMany (owning side)
     * Add PessoalAssentamentoGerado
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\AssentamentoGerado $fkPessoalAssentamentoGerado
     * @return AssentamentoGeradoContratoServidor
     */
    public function addFkPessoalAssentamentoGerados(\Urbem\CoreBundle\Entity\Pessoal\AssentamentoGerado $fkPessoalAssentamentoGerado)
    {
        if (false === $this->fkPessoalAssentamentoGerados->contains($fkPessoalAssentamentoGerado)) {
            $fkPessoalAssentamentoGerado->setFkPessoalAssentamentoGeradoContratoServidor($this);
            $this->fkPessoalAssentamentoGerados->add($fkPessoalAssentamentoGerado);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PessoalAssentamentoGerado
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\AssentamentoGerado $fkPessoalAssentamentoGerado
     */
    public function removeFkPessoalAssentamentoGerados(\Urbem\CoreBundle\Entity\Pessoal\AssentamentoGerado $fkPessoalAssentamentoGerado)
    {
        $this->fkPessoalAssentamentoGerados->removeElement($fkPessoalAssentamentoGerado);
    }

    /**
     * OneToMany (owning side)
     * Get fkPessoalAssentamentoGerados
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\AssentamentoGerado
     */
    public function getFkPessoalAssentamentoGerados()
    {
        return $this->fkPessoalAssentamentoGerados;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkPessoalContrato
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\Contrato $fkPessoalContrato
     * @return AssentamentoGeradoContratoServidor
     */
    public function setFkPessoalContrato(\Urbem\CoreBundle\Entity\Pessoal\Contrato $fkPessoalContrato)
    {
        $this->codContrato = $fkPessoalContrato->getCodContrato();
        $this->fkPessoalContrato = $fkPessoalContrato;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkPessoalContrato
     *
     * @return \Urbem\CoreBundle\Entity\Pessoal\Contrato
     */
    public function getFkPessoalContrato()
    {
        return $this->fkPessoalContrato;
    }
    
    /**
     * retorna o servidor vinculado a matricula
     * @return string
     */
    public function getServidor()
    {
        return $this->fkPessoalContrato->getFkPessoalContratoServidor()
        ->getFkPessoalServidorContratoServidores()->last()
        ->getFkPessoalServidor()
        ->getFkSwCgmPessoaFisica()
        ->getFkSwCgm()
        ->getNumcgm()
        . " - "
        . $this->fkPessoalContrato->getFkPessoalContratoServidor()
        ->getFkPessoalServidorContratoServidores()->last()
        ->getFkPessoalServidor()
        ->getFkSwCgmPessoaFisica()
        ->getFkSwCgm()
        ->getNomcgm();
    }
    
    /**
     * Retorna a classificação
     * @return string
     */
    public function getClassificacao()
    {
        return $this->fkPessoalAssentamentoGerados->last()
        ->getFkPessoalAssentamentoAssentamento()
        ->getFkPessoalClassificacaoAssentamento()
        ->getDescricao();
    }
    
    /**
     * Retorna o ultimo assentamento gerado
     * @return string
     */
    public function getAssentamento()
    {
        return $this->fkPessoalAssentamentoGerados->last()
        ->getFkPessoalAssentamentoAssentamento()->getDescricao();
    }
    
    /**
     * Retorna o período
     * @return string
     */
    public function getPeriodo()
    {
        $periodo = "";
        
        if ($this->fkPessoalAssentamentoGerados->last()->getPeriodoInicial()) {
            $periodo .= $this->fkPessoalAssentamentoGerados->last()->getPeriodoInicial()
            ->format("d/m/Y");
        }
        
        $periodo .= " a ";
        
        if ($this->fkPessoalAssentamentoGerados->last()->getPeriodoFinal()) {
            $periodo .= $this->fkPessoalAssentamentoGerados->last()->getPeriodoFinal()
            ->format("d/m/Y");
        }
        
        return $periodo;
    }
    
    /**
     * Retorna observação
     * @return string
     */
    public function getObservacao()
    {
        return $this->fkPessoalAssentamentoGerados->last()->getObservacao();
    }
}
