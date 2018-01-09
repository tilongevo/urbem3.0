<?php
 
namespace Urbem\CoreBundle\Entity\Economico;

/**
 * ElementoAtivCadEconomico
 */
class ElementoAtivCadEconomico
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
     * @var boolean
     */
    private $ativo = true;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Economico\BaixaElemAtivCadEconomico
     */
    private $fkEconomicoBaixaElemAtivCadEconomico;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Economico\AtributoElemCadEconomicoValor
     */
    private $fkEconomicoAtributoElemCadEconomicoValores;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Economico\AtividadeCadastroEconomico
     */
    private $fkEconomicoAtividadeCadastroEconomico;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Economico\ElementoAtividade
     */
    private $fkEconomicoElementoAtividade;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkEconomicoAtributoElemCadEconomicoValores = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set inscricaoEconomica
     *
     * @param integer $inscricaoEconomica
     * @return ElementoAtivCadEconomico
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
     * @return ElementoAtivCadEconomico
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
     * @return ElementoAtivCadEconomico
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
     * @return ElementoAtivCadEconomico
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
     * @return ElementoAtivCadEconomico
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
     * Set ativo
     *
     * @param boolean $ativo
     * @return ElementoAtivCadEconomico
     */
    public function setAtivo($ativo)
    {
        $this->ativo = $ativo;
        return $this;
    }

    /**
     * Get ativo
     *
     * @return boolean
     */
    public function getAtivo()
    {
        return $this->ativo;
    }

    /**
     * OneToMany (owning side)
     * Add EconomicoAtributoElemCadEconomicoValor
     *
     * @param \Urbem\CoreBundle\Entity\Economico\AtributoElemCadEconomicoValor $fkEconomicoAtributoElemCadEconomicoValor
     * @return ElementoAtivCadEconomico
     */
    public function addFkEconomicoAtributoElemCadEconomicoValores(\Urbem\CoreBundle\Entity\Economico\AtributoElemCadEconomicoValor $fkEconomicoAtributoElemCadEconomicoValor)
    {
        if (false === $this->fkEconomicoAtributoElemCadEconomicoValores->contains($fkEconomicoAtributoElemCadEconomicoValor)) {
            $fkEconomicoAtributoElemCadEconomicoValor->setFkEconomicoElementoAtivCadEconomico($this);
            $this->fkEconomicoAtributoElemCadEconomicoValores->add($fkEconomicoAtributoElemCadEconomicoValor);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove EconomicoAtributoElemCadEconomicoValor
     *
     * @param \Urbem\CoreBundle\Entity\Economico\AtributoElemCadEconomicoValor $fkEconomicoAtributoElemCadEconomicoValor
     */
    public function removeFkEconomicoAtributoElemCadEconomicoValores(\Urbem\CoreBundle\Entity\Economico\AtributoElemCadEconomicoValor $fkEconomicoAtributoElemCadEconomicoValor)
    {
        $this->fkEconomicoAtributoElemCadEconomicoValores->removeElement($fkEconomicoAtributoElemCadEconomicoValor);
    }

    /**
     * OneToMany (owning side)
     * Get fkEconomicoAtributoElemCadEconomicoValores
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Economico\AtributoElemCadEconomicoValor
     */
    public function getFkEconomicoAtributoElemCadEconomicoValores()
    {
        return $this->fkEconomicoAtributoElemCadEconomicoValores;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkEconomicoAtividadeCadastroEconomico
     *
     * @param \Urbem\CoreBundle\Entity\Economico\AtividadeCadastroEconomico $fkEconomicoAtividadeCadastroEconomico
     * @return ElementoAtivCadEconomico
     */
    public function setFkEconomicoAtividadeCadastroEconomico(\Urbem\CoreBundle\Entity\Economico\AtividadeCadastroEconomico $fkEconomicoAtividadeCadastroEconomico)
    {
        $this->inscricaoEconomica = $fkEconomicoAtividadeCadastroEconomico->getInscricaoEconomica();
        $this->codAtividade = $fkEconomicoAtividadeCadastroEconomico->getCodAtividade();
        $this->ocorrenciaAtividade = $fkEconomicoAtividadeCadastroEconomico->getOcorrenciaAtividade();
        $this->fkEconomicoAtividadeCadastroEconomico = $fkEconomicoAtividadeCadastroEconomico;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkEconomicoAtividadeCadastroEconomico
     *
     * @return \Urbem\CoreBundle\Entity\Economico\AtividadeCadastroEconomico
     */
    public function getFkEconomicoAtividadeCadastroEconomico()
    {
        return $this->fkEconomicoAtividadeCadastroEconomico;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkEconomicoElementoAtividade
     *
     * @param \Urbem\CoreBundle\Entity\Economico\ElementoAtividade $fkEconomicoElementoAtividade
     * @return ElementoAtivCadEconomico
     */
    public function setFkEconomicoElementoAtividade(\Urbem\CoreBundle\Entity\Economico\ElementoAtividade $fkEconomicoElementoAtividade)
    {
        $this->codAtividade = $fkEconomicoElementoAtividade->getCodAtividade();
        $this->codElemento = $fkEconomicoElementoAtividade->getCodElemento();
        $this->fkEconomicoElementoAtividade = $fkEconomicoElementoAtividade;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkEconomicoElementoAtividade
     *
     * @return \Urbem\CoreBundle\Entity\Economico\ElementoAtividade
     */
    public function getFkEconomicoElementoAtividade()
    {
        return $this->fkEconomicoElementoAtividade;
    }

    /**
     * OneToOne (inverse side)
     * Set EconomicoBaixaElemAtivCadEconomico
     *
     * @param \Urbem\CoreBundle\Entity\Economico\BaixaElemAtivCadEconomico $fkEconomicoBaixaElemAtivCadEconomico
     * @return ElementoAtivCadEconomico
     */
    public function setFkEconomicoBaixaElemAtivCadEconomico(\Urbem\CoreBundle\Entity\Economico\BaixaElemAtivCadEconomico $fkEconomicoBaixaElemAtivCadEconomico)
    {
        $fkEconomicoBaixaElemAtivCadEconomico->setFkEconomicoElementoAtivCadEconomico($this);
        $this->fkEconomicoBaixaElemAtivCadEconomico = $fkEconomicoBaixaElemAtivCadEconomico;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkEconomicoBaixaElemAtivCadEconomico
     *
     * @return \Urbem\CoreBundle\Entity\Economico\BaixaElemAtivCadEconomico
     */
    public function getFkEconomicoBaixaElemAtivCadEconomico()
    {
        return $this->fkEconomicoBaixaElemAtivCadEconomico;
    }
}
