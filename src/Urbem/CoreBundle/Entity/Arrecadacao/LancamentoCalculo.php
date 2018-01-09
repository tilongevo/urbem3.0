<?php
 
namespace Urbem\CoreBundle\Entity\Arrecadacao;

/**
 * LancamentoCalculo
 */
class LancamentoCalculo
{
    /**
     * PK
     * @var integer
     */
    private $codCalculo;

    /**
     * PK
     * @var integer
     */
    private $codLancamento;

    /**
     * @var \DateTime
     */
    private $dtLancamento;

    /**
     * @var integer
     */
    private $valor;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Arrecadacao\LancamentoUsaDesoneracao
     */
    private $fkArrecadacaoLancamentoUsaDesoneracoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Arrecadacao\LancamentoConcedeDesoneracao
     */
    private $fkArrecadacaoLancamentoConcedeDesoneracoes;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Arrecadacao\Calculo
     */
    private $fkArrecadacaoCalculo;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Arrecadacao\Lancamento
     */
    private $fkArrecadacaoLancamento;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkArrecadacaoLancamentoUsaDesoneracoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkArrecadacaoLancamentoConcedeDesoneracoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->dtLancamento = new \DateTime;
    }

    /**
     * Set codCalculo
     *
     * @param integer $codCalculo
     * @return LancamentoCalculo
     */
    public function setCodCalculo($codCalculo)
    {
        $this->codCalculo = $codCalculo;
        return $this;
    }

    /**
     * Get codCalculo
     *
     * @return integer
     */
    public function getCodCalculo()
    {
        return $this->codCalculo;
    }

    /**
     * Set codLancamento
     *
     * @param integer $codLancamento
     * @return LancamentoCalculo
     */
    public function setCodLancamento($codLancamento)
    {
        $this->codLancamento = $codLancamento;
        return $this;
    }

    /**
     * Get codLancamento
     *
     * @return integer
     */
    public function getCodLancamento()
    {
        return $this->codLancamento;
    }

    /**
     * Set dtLancamento
     *
     * @param \DateTime $dtLancamento
     * @return LancamentoCalculo
     */
    public function setDtLancamento(\DateTime $dtLancamento)
    {
        $this->dtLancamento = $dtLancamento;
        return $this;
    }

    /**
     * Get dtLancamento
     *
     * @return \DateTime
     */
    public function getDtLancamento()
    {
        return $this->dtLancamento;
    }

    /**
     * Set valor
     *
     * @param integer $valor
     * @return LancamentoCalculo
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
     * OneToMany (owning side)
     * Add ArrecadacaoLancamentoUsaDesoneracao
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\LancamentoUsaDesoneracao $fkArrecadacaoLancamentoUsaDesoneracao
     * @return LancamentoCalculo
     */
    public function addFkArrecadacaoLancamentoUsaDesoneracoes(\Urbem\CoreBundle\Entity\Arrecadacao\LancamentoUsaDesoneracao $fkArrecadacaoLancamentoUsaDesoneracao)
    {
        if (false === $this->fkArrecadacaoLancamentoUsaDesoneracoes->contains($fkArrecadacaoLancamentoUsaDesoneracao)) {
            $fkArrecadacaoLancamentoUsaDesoneracao->setFkArrecadacaoLancamentoCalculo($this);
            $this->fkArrecadacaoLancamentoUsaDesoneracoes->add($fkArrecadacaoLancamentoUsaDesoneracao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ArrecadacaoLancamentoUsaDesoneracao
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\LancamentoUsaDesoneracao $fkArrecadacaoLancamentoUsaDesoneracao
     */
    public function removeFkArrecadacaoLancamentoUsaDesoneracoes(\Urbem\CoreBundle\Entity\Arrecadacao\LancamentoUsaDesoneracao $fkArrecadacaoLancamentoUsaDesoneracao)
    {
        $this->fkArrecadacaoLancamentoUsaDesoneracoes->removeElement($fkArrecadacaoLancamentoUsaDesoneracao);
    }

    /**
     * OneToMany (owning side)
     * Get fkArrecadacaoLancamentoUsaDesoneracoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Arrecadacao\LancamentoUsaDesoneracao
     */
    public function getFkArrecadacaoLancamentoUsaDesoneracoes()
    {
        return $this->fkArrecadacaoLancamentoUsaDesoneracoes;
    }

    /**
     * OneToMany (owning side)
     * Add ArrecadacaoLancamentoConcedeDesoneracao
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\LancamentoConcedeDesoneracao $fkArrecadacaoLancamentoConcedeDesoneracao
     * @return LancamentoCalculo
     */
    public function addFkArrecadacaoLancamentoConcedeDesoneracoes(\Urbem\CoreBundle\Entity\Arrecadacao\LancamentoConcedeDesoneracao $fkArrecadacaoLancamentoConcedeDesoneracao)
    {
        if (false === $this->fkArrecadacaoLancamentoConcedeDesoneracoes->contains($fkArrecadacaoLancamentoConcedeDesoneracao)) {
            $fkArrecadacaoLancamentoConcedeDesoneracao->setFkArrecadacaoLancamentoCalculo($this);
            $this->fkArrecadacaoLancamentoConcedeDesoneracoes->add($fkArrecadacaoLancamentoConcedeDesoneracao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ArrecadacaoLancamentoConcedeDesoneracao
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\LancamentoConcedeDesoneracao $fkArrecadacaoLancamentoConcedeDesoneracao
     */
    public function removeFkArrecadacaoLancamentoConcedeDesoneracoes(\Urbem\CoreBundle\Entity\Arrecadacao\LancamentoConcedeDesoneracao $fkArrecadacaoLancamentoConcedeDesoneracao)
    {
        $this->fkArrecadacaoLancamentoConcedeDesoneracoes->removeElement($fkArrecadacaoLancamentoConcedeDesoneracao);
    }

    /**
     * OneToMany (owning side)
     * Get fkArrecadacaoLancamentoConcedeDesoneracoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Arrecadacao\LancamentoConcedeDesoneracao
     */
    public function getFkArrecadacaoLancamentoConcedeDesoneracoes()
    {
        return $this->fkArrecadacaoLancamentoConcedeDesoneracoes;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkArrecadacaoCalculo
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\Calculo $fkArrecadacaoCalculo
     * @return LancamentoCalculo
     */
    public function setFkArrecadacaoCalculo(\Urbem\CoreBundle\Entity\Arrecadacao\Calculo $fkArrecadacaoCalculo)
    {
        $this->codCalculo = $fkArrecadacaoCalculo->getCodCalculo();
        $this->fkArrecadacaoCalculo = $fkArrecadacaoCalculo;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkArrecadacaoCalculo
     *
     * @return \Urbem\CoreBundle\Entity\Arrecadacao\Calculo
     */
    public function getFkArrecadacaoCalculo()
    {
        return $this->fkArrecadacaoCalculo;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkArrecadacaoLancamento
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\Lancamento $fkArrecadacaoLancamento
     * @return LancamentoCalculo
     */
    public function setFkArrecadacaoLancamento(\Urbem\CoreBundle\Entity\Arrecadacao\Lancamento $fkArrecadacaoLancamento)
    {
        $this->codLancamento = $fkArrecadacaoLancamento->getCodLancamento();
        $this->fkArrecadacaoLancamento = $fkArrecadacaoLancamento;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkArrecadacaoLancamento
     *
     * @return \Urbem\CoreBundle\Entity\Arrecadacao\Lancamento
     */
    public function getFkArrecadacaoLancamento()
    {
        return $this->fkArrecadacaoLancamento;
    }
}
