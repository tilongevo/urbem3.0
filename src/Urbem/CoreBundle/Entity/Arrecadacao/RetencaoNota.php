<?php
 
namespace Urbem\CoreBundle\Entity\Arrecadacao;

/**
 * RetencaoNota
 */
class RetencaoNota
{
    /**
     * PK
     * @var integer
     */
    private $codNota;

    /**
     * PK
     * @var integer
     */
    private $inscricaoEconomica;

    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    private $timestamp;

    /**
     * PK
     * @var integer
     */
    private $codRetencao;

    /**
     * @var integer
     */
    private $codMunicipio;

    /**
     * @var integer
     */
    private $codUf;

    /**
     * @var integer
     */
    private $numcgmRetentor;

    /**
     * @var string
     */
    private $numSerie;

    /**
     * @var integer
     */
    private $numNota;

    /**
     * @var \DateTime
     */
    private $dtEmissao;

    /**
     * @var integer
     */
    private $valorNota;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Arrecadacao\RetencaoServico
     */
    private $fkArrecadacaoRetencaoServicos;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Arrecadacao\RetencaoFonte
     */
    private $fkArrecadacaoRetencaoFonte;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\SwMunicipio
     */
    private $fkSwMunicipio;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\SwCgm
     */
    private $fkSwCgm;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkArrecadacaoRetencaoServicos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
    }

    /**
     * Set codNota
     *
     * @param integer $codNota
     * @return RetencaoNota
     */
    public function setCodNota($codNota)
    {
        $this->codNota = $codNota;
        return $this;
    }

    /**
     * Get codNota
     *
     * @return integer
     */
    public function getCodNota()
    {
        return $this->codNota;
    }

    /**
     * Set inscricaoEconomica
     *
     * @param integer $inscricaoEconomica
     * @return RetencaoNota
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
     * Set timestamp
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp
     * @return RetencaoNota
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
     * Set codRetencao
     *
     * @param integer $codRetencao
     * @return RetencaoNota
     */
    public function setCodRetencao($codRetencao)
    {
        $this->codRetencao = $codRetencao;
        return $this;
    }

    /**
     * Get codRetencao
     *
     * @return integer
     */
    public function getCodRetencao()
    {
        return $this->codRetencao;
    }

    /**
     * Set codMunicipio
     *
     * @param integer $codMunicipio
     * @return RetencaoNota
     */
    public function setCodMunicipio($codMunicipio)
    {
        $this->codMunicipio = $codMunicipio;
        return $this;
    }

    /**
     * Get codMunicipio
     *
     * @return integer
     */
    public function getCodMunicipio()
    {
        return $this->codMunicipio;
    }

    /**
     * Set codUf
     *
     * @param integer $codUf
     * @return RetencaoNota
     */
    public function setCodUf($codUf)
    {
        $this->codUf = $codUf;
        return $this;
    }

    /**
     * Get codUf
     *
     * @return integer
     */
    public function getCodUf()
    {
        return $this->codUf;
    }

    /**
     * Set numcgmRetentor
     *
     * @param integer $numcgmRetentor
     * @return RetencaoNota
     */
    public function setNumcgmRetentor($numcgmRetentor)
    {
        $this->numcgmRetentor = $numcgmRetentor;
        return $this;
    }

    /**
     * Get numcgmRetentor
     *
     * @return integer
     */
    public function getNumcgmRetentor()
    {
        return $this->numcgmRetentor;
    }

    /**
     * Set numSerie
     *
     * @param string $numSerie
     * @return RetencaoNota
     */
    public function setNumSerie($numSerie)
    {
        $this->numSerie = $numSerie;
        return $this;
    }

    /**
     * Get numSerie
     *
     * @return string
     */
    public function getNumSerie()
    {
        return $this->numSerie;
    }

    /**
     * Set numNota
     *
     * @param integer $numNota
     * @return RetencaoNota
     */
    public function setNumNota($numNota)
    {
        $this->numNota = $numNota;
        return $this;
    }

    /**
     * Get numNota
     *
     * @return integer
     */
    public function getNumNota()
    {
        return $this->numNota;
    }

    /**
     * Set dtEmissao
     *
     * @param \DateTime $dtEmissao
     * @return RetencaoNota
     */
    public function setDtEmissao(\DateTime $dtEmissao)
    {
        $this->dtEmissao = $dtEmissao;
        return $this;
    }

    /**
     * Get dtEmissao
     *
     * @return \DateTime
     */
    public function getDtEmissao()
    {
        return $this->dtEmissao;
    }

    /**
     * Set valorNota
     *
     * @param integer $valorNota
     * @return RetencaoNota
     */
    public function setValorNota($valorNota)
    {
        $this->valorNota = $valorNota;
        return $this;
    }

    /**
     * Get valorNota
     *
     * @return integer
     */
    public function getValorNota()
    {
        return $this->valorNota;
    }

    /**
     * OneToMany (owning side)
     * Add ArrecadacaoRetencaoServico
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\RetencaoServico $fkArrecadacaoRetencaoServico
     * @return RetencaoNota
     */
    public function addFkArrecadacaoRetencaoServicos(\Urbem\CoreBundle\Entity\Arrecadacao\RetencaoServico $fkArrecadacaoRetencaoServico)
    {
        if (false === $this->fkArrecadacaoRetencaoServicos->contains($fkArrecadacaoRetencaoServico)) {
            $fkArrecadacaoRetencaoServico->setFkArrecadacaoRetencaoNota($this);
            $this->fkArrecadacaoRetencaoServicos->add($fkArrecadacaoRetencaoServico);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ArrecadacaoRetencaoServico
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\RetencaoServico $fkArrecadacaoRetencaoServico
     */
    public function removeFkArrecadacaoRetencaoServicos(\Urbem\CoreBundle\Entity\Arrecadacao\RetencaoServico $fkArrecadacaoRetencaoServico)
    {
        $this->fkArrecadacaoRetencaoServicos->removeElement($fkArrecadacaoRetencaoServico);
    }

    /**
     * OneToMany (owning side)
     * Get fkArrecadacaoRetencaoServicos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Arrecadacao\RetencaoServico
     */
    public function getFkArrecadacaoRetencaoServicos()
    {
        return $this->fkArrecadacaoRetencaoServicos;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkArrecadacaoRetencaoFonte
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\RetencaoFonte $fkArrecadacaoRetencaoFonte
     * @return RetencaoNota
     */
    public function setFkArrecadacaoRetencaoFonte(\Urbem\CoreBundle\Entity\Arrecadacao\RetencaoFonte $fkArrecadacaoRetencaoFonte)
    {
        $this->codRetencao = $fkArrecadacaoRetencaoFonte->getCodRetencao();
        $this->inscricaoEconomica = $fkArrecadacaoRetencaoFonte->getInscricaoEconomica();
        $this->timestamp = $fkArrecadacaoRetencaoFonte->getTimestamp();
        $this->fkArrecadacaoRetencaoFonte = $fkArrecadacaoRetencaoFonte;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkArrecadacaoRetencaoFonte
     *
     * @return \Urbem\CoreBundle\Entity\Arrecadacao\RetencaoFonte
     */
    public function getFkArrecadacaoRetencaoFonte()
    {
        return $this->fkArrecadacaoRetencaoFonte;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkSwMunicipio
     *
     * @param \Urbem\CoreBundle\Entity\SwMunicipio $fkSwMunicipio
     * @return RetencaoNota
     */
    public function setFkSwMunicipio(\Urbem\CoreBundle\Entity\SwMunicipio $fkSwMunicipio)
    {
        $this->codMunicipio = $fkSwMunicipio->getCodMunicipio();
        $this->codUf = $fkSwMunicipio->getCodUf();
        $this->fkSwMunicipio = $fkSwMunicipio;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkSwMunicipio
     *
     * @return \Urbem\CoreBundle\Entity\SwMunicipio
     */
    public function getFkSwMunicipio()
    {
        return $this->fkSwMunicipio;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkSwCgm
     *
     * @param \Urbem\CoreBundle\Entity\SwCgm $fkSwCgm
     * @return RetencaoNota
     */
    public function setFkSwCgm(\Urbem\CoreBundle\Entity\SwCgm $fkSwCgm)
    {
        $this->numcgmRetentor = $fkSwCgm->getNumcgm();
        $this->fkSwCgm = $fkSwCgm;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkSwCgm
     *
     * @return \Urbem\CoreBundle\Entity\SwCgm
     */
    public function getFkSwCgm()
    {
        return $this->fkSwCgm;
    }
}
