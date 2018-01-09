<?php
 
namespace Urbem\CoreBundle\Entity\Pessoal;

/**
 * MovSefipSaida
 */
class MovSefipSaida
{
    /**
     * PK
     * @var integer
     */
    private $codSefipSaida;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Pessoal\MovSefipSaidaMovSefipRetorno
     */
    private $fkPessoalMovSefipSaidaMovSefipRetorno;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Pessoal\Sefip
     */
    private $fkPessoalSefip;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\AssentamentoMovSefipSaida
     */
    private $fkPessoalAssentamentoMovSefipSaidas;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\CausaRescisao
     */
    private $fkPessoalCausaRescisoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\MovSefipSaidaCategoria
     */
    private $fkPessoalMovSefipSaidaCategorias;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkPessoalAssentamentoMovSefipSaidas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkPessoalCausaRescisoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkPessoalMovSefipSaidaCategorias = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codSefipSaida
     *
     * @param integer $codSefipSaida
     * @return MovSefipSaida
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
     * OneToMany (owning side)
     * Add PessoalAssentamentoMovSefipSaida
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\AssentamentoMovSefipSaida $fkPessoalAssentamentoMovSefipSaida
     * @return MovSefipSaida
     */
    public function addFkPessoalAssentamentoMovSefipSaidas(\Urbem\CoreBundle\Entity\Pessoal\AssentamentoMovSefipSaida $fkPessoalAssentamentoMovSefipSaida)
    {
        if (false === $this->fkPessoalAssentamentoMovSefipSaidas->contains($fkPessoalAssentamentoMovSefipSaida)) {
            $fkPessoalAssentamentoMovSefipSaida->setFkPessoalMovSefipSaida($this);
            $this->fkPessoalAssentamentoMovSefipSaidas->add($fkPessoalAssentamentoMovSefipSaida);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PessoalAssentamentoMovSefipSaida
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\AssentamentoMovSefipSaida $fkPessoalAssentamentoMovSefipSaida
     */
    public function removeFkPessoalAssentamentoMovSefipSaidas(\Urbem\CoreBundle\Entity\Pessoal\AssentamentoMovSefipSaida $fkPessoalAssentamentoMovSefipSaida)
    {
        $this->fkPessoalAssentamentoMovSefipSaidas->removeElement($fkPessoalAssentamentoMovSefipSaida);
    }

    /**
     * OneToMany (owning side)
     * Get fkPessoalAssentamentoMovSefipSaidas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\AssentamentoMovSefipSaida
     */
    public function getFkPessoalAssentamentoMovSefipSaidas()
    {
        return $this->fkPessoalAssentamentoMovSefipSaidas;
    }

    /**
     * OneToMany (owning side)
     * Add PessoalCausaRescisao
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\CausaRescisao $fkPessoalCausaRescisao
     * @return MovSefipSaida
     */
    public function addFkPessoalCausaRescisoes(\Urbem\CoreBundle\Entity\Pessoal\CausaRescisao $fkPessoalCausaRescisao)
    {
        if (false === $this->fkPessoalCausaRescisoes->contains($fkPessoalCausaRescisao)) {
            $fkPessoalCausaRescisao->setFkPessoalMovSefipSaida($this);
            $this->fkPessoalCausaRescisoes->add($fkPessoalCausaRescisao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PessoalCausaRescisao
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\CausaRescisao $fkPessoalCausaRescisao
     */
    public function removeFkPessoalCausaRescisoes(\Urbem\CoreBundle\Entity\Pessoal\CausaRescisao $fkPessoalCausaRescisao)
    {
        $this->fkPessoalCausaRescisoes->removeElement($fkPessoalCausaRescisao);
    }

    /**
     * OneToMany (owning side)
     * Get fkPessoalCausaRescisoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\CausaRescisao
     */
    public function getFkPessoalCausaRescisoes()
    {
        return $this->fkPessoalCausaRescisoes;
    }

    /**
     * OneToMany (owning side)
     * Add PessoalMovSefipSaidaCategoria
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\MovSefipSaidaCategoria $fkPessoalMovSefipSaidaCategoria
     * @return MovSefipSaida
     */
    public function addFkPessoalMovSefipSaidaCategorias(\Urbem\CoreBundle\Entity\Pessoal\MovSefipSaidaCategoria $fkPessoalMovSefipSaidaCategoria)
    {
        if (false === $this->fkPessoalMovSefipSaidaCategorias->contains($fkPessoalMovSefipSaidaCategoria)) {
            $fkPessoalMovSefipSaidaCategoria->setFkPessoalMovSefipSaida($this);
            $this->fkPessoalMovSefipSaidaCategorias->add($fkPessoalMovSefipSaidaCategoria);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PessoalMovSefipSaidaCategoria
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\MovSefipSaidaCategoria $fkPessoalMovSefipSaidaCategoria
     */
    public function removeFkPessoalMovSefipSaidaCategorias(\Urbem\CoreBundle\Entity\Pessoal\MovSefipSaidaCategoria $fkPessoalMovSefipSaidaCategoria)
    {
        $this->fkPessoalMovSefipSaidaCategorias->removeElement($fkPessoalMovSefipSaidaCategoria);
    }

    /**
     * OneToMany (owning side)
     * Get fkPessoalMovSefipSaidaCategorias
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\MovSefipSaidaCategoria
     */
    public function getFkPessoalMovSefipSaidaCategorias()
    {
        return $this->fkPessoalMovSefipSaidaCategorias;
    }

    /**
     * OneToOne (inverse side)
     * Set PessoalMovSefipSaidaMovSefipRetorno
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\MovSefipSaidaMovSefipRetorno $fkPessoalMovSefipSaidaMovSefipRetorno
     * @return MovSefipSaida
     */
    public function setFkPessoalMovSefipSaidaMovSefipRetorno(\Urbem\CoreBundle\Entity\Pessoal\MovSefipSaidaMovSefipRetorno $fkPessoalMovSefipSaidaMovSefipRetorno)
    {
        $fkPessoalMovSefipSaidaMovSefipRetorno->setFkPessoalMovSefipSaida($this);
        $this->fkPessoalMovSefipSaidaMovSefipRetorno = $fkPessoalMovSefipSaidaMovSefipRetorno;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkPessoalMovSefipSaidaMovSefipRetorno
     *
     * @return \Urbem\CoreBundle\Entity\Pessoal\MovSefipSaidaMovSefipRetorno
     */
    public function getFkPessoalMovSefipSaidaMovSefipRetorno()
    {
        return $this->fkPessoalMovSefipSaidaMovSefipRetorno;
    }

    /**
     * OneToOne (owning side)
     * Set PessoalSefip
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\Sefip $fkPessoalSefip
     * @return MovSefipSaida
     */
    public function setFkPessoalSefip(\Urbem\CoreBundle\Entity\Pessoal\Sefip $fkPessoalSefip)
    {
        $this->codSefipSaida = $fkPessoalSefip->getCodSefip();
        $this->fkPessoalSefip = $fkPessoalSefip;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkPessoalSefip
     *
     * @return \Urbem\CoreBundle\Entity\Pessoal\Sefip
     */
    public function getFkPessoalSefip()
    {
        return $this->fkPessoalSefip;
    }
}
