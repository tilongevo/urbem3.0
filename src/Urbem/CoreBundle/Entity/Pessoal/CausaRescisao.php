<?php
 
namespace Urbem\CoreBundle\Entity\Pessoal;

/**
 * CausaRescisao
 */
class CausaRescisao
{
    /**
     * PK
     * @var integer
     */
    private $codCausaRescisao;

    /**
     * @var integer
     */
    private $codSefipSaida;

    /**
     * @var integer
     */
    private $numCausa;

    /**
     * @var string
     */
    private $descricao;

    /**
     * @var string
     */
    private $codCausaAfastamento;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\CausaRescisaoCaged
     */
    private $fkPessoalCausaRescisaoCageds;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\CasoCausa
     */
    private $fkPessoalCasoCausas;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\AssentamentoCausaRescisao
     */
    private $fkPessoalAssentamentoCausaRescisoes;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Pessoal\MovSefipSaida
     */
    private $fkPessoalMovSefipSaida;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Pessoal\CausaAfastamentoMte
     */
    private $fkPessoalCausaAfastamentoMte;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkPessoalCausaRescisaoCageds = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkPessoalCasoCausas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkPessoalAssentamentoCausaRescisoes = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codCausaRescisao
     *
     * @param integer $codCausaRescisao
     * @return CausaRescisao
     */
    public function setCodCausaRescisao($codCausaRescisao)
    {
        $this->codCausaRescisao = $codCausaRescisao;
        return $this;
    }

    /**
     * Get codCausaRescisao
     *
     * @return integer
     */
    public function getCodCausaRescisao()
    {
        return $this->codCausaRescisao;
    }

    /**
     * Set codSefipSaida
     *
     * @param integer $codSefipSaida
     * @return CausaRescisao
     */
    public function setCodSefipSaida($codSefipSaida)
    {
        $this->codSefipSaida = $codSefipSaida;
        return $this;
    }

    /**
     * Get codSefipSaida
     *
     * @return integer
     */
    public function getCodSefipSaida()
    {
        return $this->codSefipSaida;
    }

    /**
     * Set numCausa
     *
     * @param integer $numCausa
     * @return CausaRescisao
     */
    public function setNumCausa($numCausa)
    {
        $this->numCausa = $numCausa;
        return $this;
    }

    /**
     * Get numCausa
     *
     * @return integer
     */
    public function getNumCausa()
    {
        return $this->numCausa;
    }

    /**
     * Set descricao
     *
     * @param string $descricao
     * @return CausaRescisao
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
     * Set codCausaAfastamento
     *
     * @param string $codCausaAfastamento
     * @return CausaRescisao
     */
    public function setCodCausaAfastamento($codCausaAfastamento)
    {
        $this->codCausaAfastamento = $codCausaAfastamento;
        return $this;
    }

    /**
     * Get codCausaAfastamento
     *
     * @return string
     */
    public function getCodCausaAfastamento()
    {
        return $this->codCausaAfastamento;
    }

    /**
     * OneToMany (owning side)
     * Add PessoalCausaRescisaoCaged
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\CausaRescisaoCaged $fkPessoalCausaRescisaoCaged
     * @return CausaRescisao
     */
    public function addFkPessoalCausaRescisaoCageds(\Urbem\CoreBundle\Entity\Pessoal\CausaRescisaoCaged $fkPessoalCausaRescisaoCaged)
    {
        if (false === $this->fkPessoalCausaRescisaoCageds->contains($fkPessoalCausaRescisaoCaged)) {
            $fkPessoalCausaRescisaoCaged->setFkPessoalCausaRescisao($this);
            $this->fkPessoalCausaRescisaoCageds->add($fkPessoalCausaRescisaoCaged);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PessoalCausaRescisaoCaged
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\CausaRescisaoCaged $fkPessoalCausaRescisaoCaged
     */
    public function removeFkPessoalCausaRescisaoCageds(\Urbem\CoreBundle\Entity\Pessoal\CausaRescisaoCaged $fkPessoalCausaRescisaoCaged)
    {
        $this->fkPessoalCausaRescisaoCageds->removeElement($fkPessoalCausaRescisaoCaged);
    }

    /**
     * OneToMany (owning side)
     * Get fkPessoalCausaRescisaoCageds
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\CausaRescisaoCaged
     */
    public function getFkPessoalCausaRescisaoCageds()
    {
        return $this->fkPessoalCausaRescisaoCageds;
    }

    /**
     * OneToMany (owning side)
     * Add PessoalCasoCausa
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\CasoCausa $fkPessoalCasoCausa
     * @return CausaRescisao
     */
    public function addFkPessoalCasoCausas(\Urbem\CoreBundle\Entity\Pessoal\CasoCausa $fkPessoalCasoCausa)
    {
        if (false === $this->fkPessoalCasoCausas->contains($fkPessoalCasoCausa)) {
            $fkPessoalCasoCausa->setFkPessoalCausaRescisao($this);
            $this->fkPessoalCasoCausas->add($fkPessoalCasoCausa);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PessoalCasoCausa
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\CasoCausa $fkPessoalCasoCausa
     */
    public function removeFkPessoalCasoCausas(\Urbem\CoreBundle\Entity\Pessoal\CasoCausa $fkPessoalCasoCausa)
    {
        $this->fkPessoalCasoCausas->removeElement($fkPessoalCasoCausa);
    }

    /**
     * OneToMany (owning side)
     * Get fkPessoalCasoCausas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\CasoCausa
     */
    public function getFkPessoalCasoCausas()
    {
        return $this->fkPessoalCasoCausas;
    }

    /**
     * OneToMany (owning side)
     * Add PessoalAssentamentoCausaRescisao
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\AssentamentoCausaRescisao $fkPessoalAssentamentoCausaRescisao
     * @return CausaRescisao
     */
    public function addFkPessoalAssentamentoCausaRescisoes(\Urbem\CoreBundle\Entity\Pessoal\AssentamentoCausaRescisao $fkPessoalAssentamentoCausaRescisao)
    {
        if (false === $this->fkPessoalAssentamentoCausaRescisoes->contains($fkPessoalAssentamentoCausaRescisao)) {
            $fkPessoalAssentamentoCausaRescisao->setFkPessoalCausaRescisao($this);
            $this->fkPessoalAssentamentoCausaRescisoes->add($fkPessoalAssentamentoCausaRescisao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PessoalAssentamentoCausaRescisao
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\AssentamentoCausaRescisao $fkPessoalAssentamentoCausaRescisao
     */
    public function removeFkPessoalAssentamentoCausaRescisoes(\Urbem\CoreBundle\Entity\Pessoal\AssentamentoCausaRescisao $fkPessoalAssentamentoCausaRescisao)
    {
        $this->fkPessoalAssentamentoCausaRescisoes->removeElement($fkPessoalAssentamentoCausaRescisao);
    }

    /**
     * OneToMany (owning side)
     * Get fkPessoalAssentamentoCausaRescisoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\AssentamentoCausaRescisao
     */
    public function getFkPessoalAssentamentoCausaRescisoes()
    {
        return $this->fkPessoalAssentamentoCausaRescisoes;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkPessoalMovSefipSaida
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\MovSefipSaida $fkPessoalMovSefipSaida
     * @return CausaRescisao
     */
    public function setFkPessoalMovSefipSaida(\Urbem\CoreBundle\Entity\Pessoal\MovSefipSaida $fkPessoalMovSefipSaida)
    {
        $this->codSefipSaida = $fkPessoalMovSefipSaida->getCodSefipSaida();
        $this->fkPessoalMovSefipSaida = $fkPessoalMovSefipSaida;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkPessoalMovSefipSaida
     *
     * @return \Urbem\CoreBundle\Entity\Pessoal\MovSefipSaida
     */
    public function getFkPessoalMovSefipSaida()
    {
        return $this->fkPessoalMovSefipSaida;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkPessoalCausaAfastamentoMte
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\CausaAfastamentoMte $fkPessoalCausaAfastamentoMte
     * @return CausaRescisao
     */
    public function setFkPessoalCausaAfastamentoMte(\Urbem\CoreBundle\Entity\Pessoal\CausaAfastamentoMte $fkPessoalCausaAfastamentoMte)
    {
        $this->codCausaAfastamento = $fkPessoalCausaAfastamentoMte->getCodCausaAfastamento();
        $this->fkPessoalCausaAfastamentoMte = $fkPessoalCausaAfastamentoMte;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkPessoalCausaAfastamentoMte
     *
     * @return \Urbem\CoreBundle\Entity\Pessoal\CausaAfastamentoMte
     */
    public function getFkPessoalCausaAfastamentoMte()
    {
        return $this->fkPessoalCausaAfastamentoMte;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string) $this->descricao;
    }
}
