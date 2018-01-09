<?php
 
namespace Urbem\CoreBundle\Entity\Fiscalizacao;

/**
 * RetencaoNota
 */
class RetencaoNota
{
    /**
     * PK
     * @var integer
     */
    private $codProcesso;

    /**
     * PK
     * @var string
     */
    private $competencia;

    /**
     * PK
     * @var integer
     */
    private $codNota;

    /**
     * @var integer
     */
    private $numcgm;

    /**
     * @var integer
     */
    private $codMunicipio;

    /**
     * @var integer
     */
    private $codUf;

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
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Fiscalizacao\RetencaoServico
     */
    private $fkFiscalizacaoRetencaoServicos;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Fiscalizacao\RetencaoFonte
     */
    private $fkFiscalizacaoRetencaoFonte;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\SwCgm
     */
    private $fkSwCgm;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\SwMunicipio
     */
    private $fkSwMunicipio;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkFiscalizacaoRetencaoServicos = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codProcesso
     *
     * @param integer $codProcesso
     * @return RetencaoNota
     */
    public function setCodProcesso($codProcesso)
    {
        $this->codProcesso = $codProcesso;
        return $this;
    }

    /**
     * Get codProcesso
     *
     * @return integer
     */
    public function getCodProcesso()
    {
        return $this->codProcesso;
    }

    /**
     * Set competencia
     *
     * @param string $competencia
     * @return RetencaoNota
     */
    public function setCompetencia($competencia)
    {
        $this->competencia = $competencia;
        return $this;
    }

    /**
     * Get competencia
     *
     * @return string
     */
    public function getCompetencia()
    {
        return $this->competencia;
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
     * Set numcgm
     *
     * @param integer $numcgm
     * @return RetencaoNota
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
     * Add FiscalizacaoRetencaoServico
     *
     * @param \Urbem\CoreBundle\Entity\Fiscalizacao\RetencaoServico $fkFiscalizacaoRetencaoServico
     * @return RetencaoNota
     */
    public function addFkFiscalizacaoRetencaoServicos(\Urbem\CoreBundle\Entity\Fiscalizacao\RetencaoServico $fkFiscalizacaoRetencaoServico)
    {
        if (false === $this->fkFiscalizacaoRetencaoServicos->contains($fkFiscalizacaoRetencaoServico)) {
            $fkFiscalizacaoRetencaoServico->setFkFiscalizacaoRetencaoNota($this);
            $this->fkFiscalizacaoRetencaoServicos->add($fkFiscalizacaoRetencaoServico);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FiscalizacaoRetencaoServico
     *
     * @param \Urbem\CoreBundle\Entity\Fiscalizacao\RetencaoServico $fkFiscalizacaoRetencaoServico
     */
    public function removeFkFiscalizacaoRetencaoServicos(\Urbem\CoreBundle\Entity\Fiscalizacao\RetencaoServico $fkFiscalizacaoRetencaoServico)
    {
        $this->fkFiscalizacaoRetencaoServicos->removeElement($fkFiscalizacaoRetencaoServico);
    }

    /**
     * OneToMany (owning side)
     * Get fkFiscalizacaoRetencaoServicos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Fiscalizacao\RetencaoServico
     */
    public function getFkFiscalizacaoRetencaoServicos()
    {
        return $this->fkFiscalizacaoRetencaoServicos;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkFiscalizacaoRetencaoFonte
     *
     * @param \Urbem\CoreBundle\Entity\Fiscalizacao\RetencaoFonte $fkFiscalizacaoRetencaoFonte
     * @return RetencaoNota
     */
    public function setFkFiscalizacaoRetencaoFonte(\Urbem\CoreBundle\Entity\Fiscalizacao\RetencaoFonte $fkFiscalizacaoRetencaoFonte)
    {
        $this->codProcesso = $fkFiscalizacaoRetencaoFonte->getCodProcesso();
        $this->competencia = $fkFiscalizacaoRetencaoFonte->getCompetencia();
        $this->fkFiscalizacaoRetencaoFonte = $fkFiscalizacaoRetencaoFonte;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkFiscalizacaoRetencaoFonte
     *
     * @return \Urbem\CoreBundle\Entity\Fiscalizacao\RetencaoFonte
     */
    public function getFkFiscalizacaoRetencaoFonte()
    {
        return $this->fkFiscalizacaoRetencaoFonte;
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
        $this->numcgm = $fkSwCgm->getNumcgm();
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
}
