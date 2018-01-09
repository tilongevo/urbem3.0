<?php
 
namespace Urbem\CoreBundle\Entity\Pessoal;

/**
 * AssentamentoVantagem
 */
class AssentamentoVantagem
{
    /**
     * PK
     * @var integer
     */
    private $codAssentamento;

    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DateTimePK
     */
    private $timestamp;

    /**
     * @var \DateTime
     */
    private $dtInicial;

    /**
     * @var \DateTime
     */
    private $dtFinal;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Pessoal\Assentamento
     */
    private $fkPessoalAssentamento;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\AssentamentoFaixaCorrecao
     */
    private $fkPessoalAssentamentoFaixaCorrecoes;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkPessoalAssentamentoFaixaCorrecoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimePK;
    }

    /**
     * Set codAssentamento
     *
     * @param integer $codAssentamento
     * @return AssentamentoVantagem
     */
    public function setCodAssentamento($codAssentamento)
    {
        $this->codAssentamento = $codAssentamento;
        return $this;
    }

    /**
     * Get codAssentamento
     *
     * @return integer
     */
    public function getCodAssentamento()
    {
        return $this->codAssentamento;
    }

    /**
     * Set timestamp
     *
     * @param \Urbem\CoreBundle\Helper\DateTimePK $timestamp
     * @return AssentamentoVantagem
     */
    public function setTimestamp(\Urbem\CoreBundle\Helper\DateTimePK $timestamp)
    {
        $this->timestamp = $timestamp;
        return $this;
    }

    /**
     * Get timestamp
     *
     * @return \Urbem\CoreBundle\Helper\DateTimePK
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }

    /**
     * Set dtInicial
     *
     * @param \DateTime $dtInicial
     * @return AssentamentoVantagem
     */
    public function setDtInicial(\DateTime $dtInicial)
    {
        $this->dtInicial = $dtInicial;
        return $this;
    }

    /**
     * Get dtInicial
     *
     * @return \DateTime
     */
    public function getDtInicial()
    {
        return $this->dtInicial;
    }

    /**
     * Set dtFinal
     *
     * @param \DateTime $dtFinal
     * @return AssentamentoVantagem
     */
    public function setDtFinal(\DateTime $dtFinal = null)
    {
        $this->dtFinal = $dtFinal;
        return $this;
    }

    /**
     * Get dtFinal
     *
     * @return \DateTime
     */
    public function getDtFinal()
    {
        return $this->dtFinal;
    }

    /**
     * OneToMany (owning side)
     * Add PessoalAssentamentoFaixaCorrecao
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\AssentamentoFaixaCorrecao $fkPessoalAssentamentoFaixaCorrecao
     * @return AssentamentoVantagem
     */
    public function addFkPessoalAssentamentoFaixaCorrecoes(\Urbem\CoreBundle\Entity\Pessoal\AssentamentoFaixaCorrecao $fkPessoalAssentamentoFaixaCorrecao)
    {
        if (false === $this->fkPessoalAssentamentoFaixaCorrecoes->contains($fkPessoalAssentamentoFaixaCorrecao)) {
            $fkPessoalAssentamentoFaixaCorrecao->setFkPessoalAssentamentoVantagem($this);
            $this->fkPessoalAssentamentoFaixaCorrecoes->add($fkPessoalAssentamentoFaixaCorrecao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PessoalAssentamentoFaixaCorrecao
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\AssentamentoFaixaCorrecao $fkPessoalAssentamentoFaixaCorrecao
     */
    public function removeFkPessoalAssentamentoFaixaCorrecoes(\Urbem\CoreBundle\Entity\Pessoal\AssentamentoFaixaCorrecao $fkPessoalAssentamentoFaixaCorrecao)
    {
        $this->fkPessoalAssentamentoFaixaCorrecoes->removeElement($fkPessoalAssentamentoFaixaCorrecao);
    }

    /**
     * OneToMany (owning side)
     * Get fkPessoalAssentamentoFaixaCorrecoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\AssentamentoFaixaCorrecao
     */
    public function getFkPessoalAssentamentoFaixaCorrecoes()
    {
        return $this->fkPessoalAssentamentoFaixaCorrecoes;
    }

    /**
     * OneToOne (owning side)
     * Set PessoalAssentamento
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\Assentamento $fkPessoalAssentamento
     * @return AssentamentoVantagem
     */
    public function setFkPessoalAssentamento(\Urbem\CoreBundle\Entity\Pessoal\Assentamento $fkPessoalAssentamento)
    {
        $this->codAssentamento = $fkPessoalAssentamento->getCodAssentamento();
        $this->timestamp = $fkPessoalAssentamento->getTimestamp();
        $this->fkPessoalAssentamento = $fkPessoalAssentamento;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkPessoalAssentamento
     *
     * @return \Urbem\CoreBundle\Entity\Pessoal\Assentamento
     */
    public function getFkPessoalAssentamento()
    {
        return $this->fkPessoalAssentamento;
    }
}
