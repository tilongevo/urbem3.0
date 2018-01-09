<?php
 
namespace Urbem\CoreBundle\Entity\Pessoal;

/**
 * AssentamentoGerado
 */
class AssentamentoGerado
{
    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    private $timestamp;

    /**
     * PK
     * @var integer
     */
    private $codAssentamentoGerado;

    /**
     * @var integer
     */
    private $codAssentamento;

    /**
     * @var \DateTime
     */
    private $periodoInicial;

    /**
     * @var \DateTime
     */
    private $periodoFinal;

    /**
     * @var boolean
     */
    private $automatico = false;

    /**
     * @var string
     */
    private $observacao;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Pessoal\AssentamentoGeradoExcluido
     */
    private $fkPessoalAssentamentoGeradoExcluido;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Pessoal\AssentamentoLicencaPremio
     */
    private $fkPessoalAssentamentoLicencaPremio;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\AssentamentoGeradoNorma
     */
    private $fkPessoalAssentamentoGeradoNormas;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Pessoal\AssentamentoGeradoContratoServidor
     */
    private $fkPessoalAssentamentoGeradoContratoServidor;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Pessoal\AssentamentoAssentamento
     */
    private $fkPessoalAssentamentoAssentamento;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkPessoalAssentamentoGeradoNormas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
    }

    /**
     * Set timestamp
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp
     * @return AssentamentoGerado
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
     * Set codAssentamentoGerado
     *
     * @param integer $codAssentamentoGerado
     * @return AssentamentoGerado
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
     * Set codAssentamento
     *
     * @param integer $codAssentamento
     * @return AssentamentoGerado
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
     * Set periodoInicial
     *
     * @param \DateTime $periodoInicial
     * @return AssentamentoGerado
     */
    public function setPeriodoInicial(\DateTime $periodoInicial)
    {
        $this->periodoInicial = $periodoInicial;
        return $this;
    }

    /**
     * Get periodoInicial
     *
     * @return \DateTime
     */
    public function getPeriodoInicial()
    {
        return $this->periodoInicial;
    }

    /**
     * Set periodoFinal
     *
     * @param \DateTime $periodoFinal
     * @return AssentamentoGerado
     */
    public function setPeriodoFinal(\DateTime $periodoFinal = null)
    {
        $this->periodoFinal = $periodoFinal;
        return $this;
    }

    /**
     * Get periodoFinal
     *
     * @return \DateTime
     */
    public function getPeriodoFinal()
    {
        return $this->periodoFinal;
    }

    /**
     * Set automatico
     *
     * @param boolean $automatico
     * @return AssentamentoGerado
     */
    public function setAutomatico($automatico)
    {
        $this->automatico = $automatico;
        return $this;
    }

    /**
     * Get automatico
     *
     * @return boolean
     */
    public function getAutomatico()
    {
        return $this->automatico;
    }

    /**
     * Set observacao
     *
     * @param string $observacao
     * @return AssentamentoGerado
     */
    public function setObservacao($observacao = null)
    {
        $this->observacao = $observacao;
        return $this;
    }

    /**
     * Get observacao
     *
     * @return string
     */
    public function getObservacao()
    {
        return $this->observacao;
    }

    /**
     * OneToMany (owning side)
     * Add PessoalAssentamentoGeradoNorma
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\AssentamentoGeradoNorma $fkPessoalAssentamentoGeradoNorma
     * @return AssentamentoGerado
     */
    public function addFkPessoalAssentamentoGeradoNormas(\Urbem\CoreBundle\Entity\Pessoal\AssentamentoGeradoNorma $fkPessoalAssentamentoGeradoNorma)
    {
        if (false === $this->fkPessoalAssentamentoGeradoNormas->contains($fkPessoalAssentamentoGeradoNorma)) {
            $fkPessoalAssentamentoGeradoNorma->setFkPessoalAssentamentoGerado($this);
            $this->fkPessoalAssentamentoGeradoNormas->add($fkPessoalAssentamentoGeradoNorma);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PessoalAssentamentoGeradoNorma
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\AssentamentoGeradoNorma $fkPessoalAssentamentoGeradoNorma
     */
    public function removeFkPessoalAssentamentoGeradoNormas(\Urbem\CoreBundle\Entity\Pessoal\AssentamentoGeradoNorma $fkPessoalAssentamentoGeradoNorma)
    {
        $this->fkPessoalAssentamentoGeradoNormas->removeElement($fkPessoalAssentamentoGeradoNorma);
    }

    /**
     * OneToMany (owning side)
     * Get fkPessoalAssentamentoGeradoNormas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\AssentamentoGeradoNorma
     */
    public function getFkPessoalAssentamentoGeradoNormas()
    {
        return $this->fkPessoalAssentamentoGeradoNormas;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkPessoalAssentamentoGeradoContratoServidor
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\AssentamentoGeradoContratoServidor $fkPessoalAssentamentoGeradoContratoServidor
     * @return AssentamentoGerado
     */
    public function setFkPessoalAssentamentoGeradoContratoServidor(\Urbem\CoreBundle\Entity\Pessoal\AssentamentoGeradoContratoServidor $fkPessoalAssentamentoGeradoContratoServidor)
    {
        $this->codAssentamentoGerado = $fkPessoalAssentamentoGeradoContratoServidor->getCodAssentamentoGerado();
        $this->fkPessoalAssentamentoGeradoContratoServidor = $fkPessoalAssentamentoGeradoContratoServidor;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkPessoalAssentamentoGeradoContratoServidor
     *
     * @return \Urbem\CoreBundle\Entity\Pessoal\AssentamentoGeradoContratoServidor
     */
    public function getFkPessoalAssentamentoGeradoContratoServidor()
    {
        return $this->fkPessoalAssentamentoGeradoContratoServidor;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkPessoalAssentamentoAssentamento
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\AssentamentoAssentamento $fkPessoalAssentamentoAssentamento
     * @return AssentamentoGerado
     */
    public function setFkPessoalAssentamentoAssentamento(\Urbem\CoreBundle\Entity\Pessoal\AssentamentoAssentamento $fkPessoalAssentamentoAssentamento)
    {
        $this->codAssentamento = $fkPessoalAssentamentoAssentamento->getCodAssentamento();
        $this->fkPessoalAssentamentoAssentamento = $fkPessoalAssentamentoAssentamento;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkPessoalAssentamentoAssentamento
     *
     * @return \Urbem\CoreBundle\Entity\Pessoal\AssentamentoAssentamento
     */
    public function getFkPessoalAssentamentoAssentamento()
    {
        return $this->fkPessoalAssentamentoAssentamento;
    }

    /**
     * OneToOne (inverse side)
     * Set PessoalAssentamentoGeradoExcluido
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\AssentamentoGeradoExcluido $fkPessoalAssentamentoGeradoExcluido
     * @return AssentamentoGerado
     */
    public function setFkPessoalAssentamentoGeradoExcluido(\Urbem\CoreBundle\Entity\Pessoal\AssentamentoGeradoExcluido $fkPessoalAssentamentoGeradoExcluido)
    {
        $fkPessoalAssentamentoGeradoExcluido->setFkPessoalAssentamentoGerado($this);
        $this->fkPessoalAssentamentoGeradoExcluido = $fkPessoalAssentamentoGeradoExcluido;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkPessoalAssentamentoGeradoExcluido
     *
     * @return \Urbem\CoreBundle\Entity\Pessoal\AssentamentoGeradoExcluido
     */
    public function getFkPessoalAssentamentoGeradoExcluido()
    {
        return $this->fkPessoalAssentamentoGeradoExcluido;
    }

    /**
     * OneToOne (inverse side)
     * Set PessoalAssentamentoLicencaPremio
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\AssentamentoLicencaPremio $fkPessoalAssentamentoLicencaPremio
     * @return AssentamentoGerado
     */
    public function setFkPessoalAssentamentoLicencaPremio(\Urbem\CoreBundle\Entity\Pessoal\AssentamentoLicencaPremio $fkPessoalAssentamentoLicencaPremio)
    {
        $fkPessoalAssentamentoLicencaPremio->setFkPessoalAssentamentoGerado($this);
        $this->fkPessoalAssentamentoLicencaPremio = $fkPessoalAssentamentoLicencaPremio;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkPessoalAssentamentoLicencaPremio
     *
     * @return \Urbem\CoreBundle\Entity\Pessoal\AssentamentoLicencaPremio
     */
    public function getFkPessoalAssentamentoLicencaPremio()
    {
        return $this->fkPessoalAssentamentoLicencaPremio;
    }
}
