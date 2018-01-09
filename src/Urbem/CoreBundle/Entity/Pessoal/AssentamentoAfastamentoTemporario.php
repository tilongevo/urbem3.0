<?php
 
namespace Urbem\CoreBundle\Entity\Pessoal;

/**
 * AssentamentoAfastamentoTemporario
 */
class AssentamentoAfastamentoTemporario
{
    /**
     * PK
     * @var integer
     */
    private $codAssentamento;

    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    private $timestamp;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Pessoal\AssentamentoAfastamentoTemporarioDuracao
     */
    private $fkPessoalAssentamentoAfastamentoTemporarioDuracao;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Pessoal\AssentamentoMovSefipSaida
     */
    private $fkPessoalAssentamentoMovSefipSaida;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Pessoal\AssentamentoRaisAfastamento
     */
    private $fkPessoalAssentamentoRaisAfastamento;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Pessoal\Assentamento
     */
    private $fkPessoalAssentamento;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\AssentamentoFaixaDesconto
     */
    private $fkPessoalAssentamentoFaixaDescontos;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkPessoalAssentamentoFaixaDescontos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
    }

    /**
     * Set codAssentamento
     *
     * @param integer $codAssentamento
     * @return AssentamentoAfastamentoTemporario
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
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp
     * @return AssentamentoAfastamentoTemporario
     */
    public function setTimestamp(\Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp)
    {
        $this->timestamp = $timestamp;
        return $this;
    }

    /**
     * Get timestamp
     *
     * @return \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }

    /**
     * OneToMany (owning side)
     * Add PessoalAssentamentoFaixaDesconto
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\AssentamentoFaixaDesconto $fkPessoalAssentamentoFaixaDesconto
     * @return AssentamentoAfastamentoTemporario
     */
    public function addFkPessoalAssentamentoFaixaDescontos(\Urbem\CoreBundle\Entity\Pessoal\AssentamentoFaixaDesconto $fkPessoalAssentamentoFaixaDesconto)
    {
        if (false === $this->fkPessoalAssentamentoFaixaDescontos->contains($fkPessoalAssentamentoFaixaDesconto)) {
            $fkPessoalAssentamentoFaixaDesconto->setFkPessoalAssentamentoAfastamentoTemporario($this);
            $this->fkPessoalAssentamentoFaixaDescontos->add($fkPessoalAssentamentoFaixaDesconto);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PessoalAssentamentoFaixaDesconto
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\AssentamentoFaixaDesconto $fkPessoalAssentamentoFaixaDesconto
     */
    public function removeFkPessoalAssentamentoFaixaDescontos(\Urbem\CoreBundle\Entity\Pessoal\AssentamentoFaixaDesconto $fkPessoalAssentamentoFaixaDesconto)
    {
        $this->fkPessoalAssentamentoFaixaDescontos->removeElement($fkPessoalAssentamentoFaixaDesconto);
    }

    /**
     * OneToMany (owning side)
     * Get fkPessoalAssentamentoFaixaDescontos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\AssentamentoFaixaDesconto
     */
    public function getFkPessoalAssentamentoFaixaDescontos()
    {
        return $this->fkPessoalAssentamentoFaixaDescontos;
    }

    /**
     * OneToOne (inverse side)
     * Set PessoalAssentamentoAfastamentoTemporarioDuracao
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\AssentamentoAfastamentoTemporarioDuracao $fkPessoalAssentamentoAfastamentoTemporarioDuracao
     * @return AssentamentoAfastamentoTemporario
     */
    public function setFkPessoalAssentamentoAfastamentoTemporarioDuracao(\Urbem\CoreBundle\Entity\Pessoal\AssentamentoAfastamentoTemporarioDuracao $fkPessoalAssentamentoAfastamentoTemporarioDuracao)
    {
        $fkPessoalAssentamentoAfastamentoTemporarioDuracao->setFkPessoalAssentamentoAfastamentoTemporario($this);
        $this->fkPessoalAssentamentoAfastamentoTemporarioDuracao = $fkPessoalAssentamentoAfastamentoTemporarioDuracao;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkPessoalAssentamentoAfastamentoTemporarioDuracao
     *
     * @return \Urbem\CoreBundle\Entity\Pessoal\AssentamentoAfastamentoTemporarioDuracao
     */
    public function getFkPessoalAssentamentoAfastamentoTemporarioDuracao()
    {
        return $this->fkPessoalAssentamentoAfastamentoTemporarioDuracao;
    }

    /**
     * OneToOne (inverse side)
     * Set PessoalAssentamentoMovSefipSaida
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\AssentamentoMovSefipSaida $fkPessoalAssentamentoMovSefipSaida
     * @return AssentamentoAfastamentoTemporario
     */
    public function setFkPessoalAssentamentoMovSefipSaida(\Urbem\CoreBundle\Entity\Pessoal\AssentamentoMovSefipSaida $fkPessoalAssentamentoMovSefipSaida)
    {
        $fkPessoalAssentamentoMovSefipSaida->setFkPessoalAssentamentoAfastamentoTemporario($this);
        $this->fkPessoalAssentamentoMovSefipSaida = $fkPessoalAssentamentoMovSefipSaida;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkPessoalAssentamentoMovSefipSaida
     *
     * @return \Urbem\CoreBundle\Entity\Pessoal\AssentamentoMovSefipSaida
     */
    public function getFkPessoalAssentamentoMovSefipSaida()
    {
        return $this->fkPessoalAssentamentoMovSefipSaida;
    }

    /**
     * OneToOne (inverse side)
     * Set PessoalAssentamentoRaisAfastamento
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\AssentamentoRaisAfastamento $fkPessoalAssentamentoRaisAfastamento
     * @return AssentamentoAfastamentoTemporario
     */
    public function setFkPessoalAssentamentoRaisAfastamento(\Urbem\CoreBundle\Entity\Pessoal\AssentamentoRaisAfastamento $fkPessoalAssentamentoRaisAfastamento)
    {
        $fkPessoalAssentamentoRaisAfastamento->setFkPessoalAssentamentoAfastamentoTemporario($this);
        $this->fkPessoalAssentamentoRaisAfastamento = $fkPessoalAssentamentoRaisAfastamento;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkPessoalAssentamentoRaisAfastamento
     *
     * @return \Urbem\CoreBundle\Entity\Pessoal\AssentamentoRaisAfastamento
     */
    public function getFkPessoalAssentamentoRaisAfastamento()
    {
        return $this->fkPessoalAssentamentoRaisAfastamento;
    }

    /**
     * OneToOne (owning side)
     * Set PessoalAssentamento
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\Assentamento $fkPessoalAssentamento
     * @return AssentamentoAfastamentoTemporario
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
