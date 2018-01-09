<?php
 
namespace Urbem\CoreBundle\Entity\Stn;

/**
 * RiscosFiscais
 */
class RiscosFiscais
{
    /**
     * PK
     * @var integer
     */
    private $codRisco;

    /**
     * PK
     * @var integer
     */
    private $codEntidade;

    /**
     * PK
     * @var string
     */
    private $exercicio;

    /**
     * @var string
     */
    private $descricao;

    /**
     * @var integer
     */
    private $valor;

    /**
     * @var integer
     */
    private $codIdentificador;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Stn\Providencias
     */
    private $fkStnProvidencias;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Orcamento\Entidade
     */
    private $fkOrcamentoEntidade;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Stn\IdentificadorRiscoFiscal
     */
    private $fkStnIdentificadorRiscoFiscal;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkStnProvidencias = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codRisco
     *
     * @param integer $codRisco
     * @return RiscosFiscais
     */
    public function setCodRisco($codRisco)
    {
        $this->codRisco = $codRisco;
        return $this;
    }

    /**
     * Get codRisco
     *
     * @return integer
     */
    public function getCodRisco()
    {
        return $this->codRisco;
    }

    /**
     * Set codEntidade
     *
     * @param integer $codEntidade
     * @return RiscosFiscais
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
     * Set exercicio
     *
     * @param string $exercicio
     * @return RiscosFiscais
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
     * Set descricao
     *
     * @param string $descricao
     * @return RiscosFiscais
     */
    public function setDescricao($descricao)
    {
        $this->descricao = $descricao;
        return $this;
    }

    /**
     * Get descricao
     *
     * @return string
     */
    public function getDescricao()
    {
        return $this->descricao;
    }

    /**
     * Set valor
     *
     * @param integer $valor
     * @return RiscosFiscais
     */
    public function setValor($valor)
    {
        $this->valor = $valor;
        return $this;
    }

    /**
     * Get valor
     *
     * @return integer
     */
    public function getValor()
    {
        return $this->valor;
    }

    /**
     * Set codIdentificador
     *
     * @param integer $codIdentificador
     * @return RiscosFiscais
     */
    public function setCodIdentificador($codIdentificador = null)
    {
        $this->codIdentificador = $codIdentificador;
        return $this;
    }

    /**
     * Get codIdentificador
     *
     * @return integer
     */
    public function getCodIdentificador()
    {
        return $this->codIdentificador;
    }

    /**
     * OneToMany (owning side)
     * Add StnProvidencias
     *
     * @param \Urbem\CoreBundle\Entity\Stn\Providencias $fkStnProvidencias
     * @return RiscosFiscais
     */
    public function addFkStnProvidencias(\Urbem\CoreBundle\Entity\Stn\Providencias $fkStnProvidencias)
    {
        if (false === $this->fkStnProvidencias->contains($fkStnProvidencias)) {
            $fkStnProvidencias->setFkStnRiscosFiscais($this);
            $this->fkStnProvidencias->add($fkStnProvidencias);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove StnProvidencias
     *
     * @param \Urbem\CoreBundle\Entity\Stn\Providencias $fkStnProvidencias
     */
    public function removeFkStnProvidencias(\Urbem\CoreBundle\Entity\Stn\Providencias $fkStnProvidencias)
    {
        $this->fkStnProvidencias->removeElement($fkStnProvidencias);
    }

    /**
     * OneToMany (owning side)
     * Get fkStnProvidencias
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Stn\Providencias
     */
    public function getFkStnProvidencias()
    {
        return $this->fkStnProvidencias;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkOrcamentoEntidade
     *
     * @param \Urbem\CoreBundle\Entity\Orcamento\Entidade $fkOrcamentoEntidade
     * @return RiscosFiscais
     */
    public function setFkOrcamentoEntidade(\Urbem\CoreBundle\Entity\Orcamento\Entidade $fkOrcamentoEntidade)
    {
        $this->exercicio = $fkOrcamentoEntidade->getExercicio();
        $this->codEntidade = $fkOrcamentoEntidade->getCodEntidade();
        $this->fkOrcamentoEntidade = $fkOrcamentoEntidade;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkOrcamentoEntidade
     *
     * @return \Urbem\CoreBundle\Entity\Orcamento\Entidade
     */
    public function getFkOrcamentoEntidade()
    {
        return $this->fkOrcamentoEntidade;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkStnIdentificadorRiscoFiscal
     *
     * @param \Urbem\CoreBundle\Entity\Stn\IdentificadorRiscoFiscal $fkStnIdentificadorRiscoFiscal
     * @return RiscosFiscais
     */
    public function setFkStnIdentificadorRiscoFiscal(\Urbem\CoreBundle\Entity\Stn\IdentificadorRiscoFiscal $fkStnIdentificadorRiscoFiscal)
    {
        $this->codIdentificador = $fkStnIdentificadorRiscoFiscal->getCodIdentificador();
        $this->fkStnIdentificadorRiscoFiscal = $fkStnIdentificadorRiscoFiscal;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkStnIdentificadorRiscoFiscal
     *
     * @return \Urbem\CoreBundle\Entity\Stn\IdentificadorRiscoFiscal
     */
    public function getFkStnIdentificadorRiscoFiscal()
    {
        return $this->fkStnIdentificadorRiscoFiscal;
    }
}
