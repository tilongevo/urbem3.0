<?php

namespace Urbem\CoreBundle\Entity\Pessoal;

/**
 * Regime
 */
class Regime
{
    /**
     * PK
     * @var integer
     */
    private $codRegime;

    /**
     * @var string
     */
    private $descricao;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\ContratoServidorRegimeFuncao
     */
    private $fkPessoalContratoServidorRegimeFuncoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\ConfiguracaoFormaPagamentoFerias
     */
    private $fkPessoalConfiguracaoFormaPagamentoFerias;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\ContratoServidor
     */
    private $fkPessoalContratoServidores;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\SubDivisao
     */
    private $fkPessoalSubDivisoes;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkPessoalContratoServidorRegimeFuncoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkPessoalConfiguracaoFormaPagamentoFerias = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkPessoalContratoServidores = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkPessoalSubDivisoes = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codRegime
     *
     * @param integer $codRegime
     * @return Regime
     */
    public function setCodRegime($codRegime)
    {
        $this->codRegime = $codRegime;
        return $this;
    }

    /**
     * Get codRegime
     *
     * @return integer
     */
    public function getCodRegime()
    {
        return $this->codRegime;
    }

    /**
     * Set descricao
     *
     * @param string $descricao
     * @return Regime
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
     * OneToMany (owning side)
     * Add PessoalContratoServidorRegimeFuncao
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\ContratoServidorRegimeFuncao $fkPessoalContratoServidorRegimeFuncao
     * @return Regime
     */
    public function addFkPessoalContratoServidorRegimeFuncoes(\Urbem\CoreBundle\Entity\Pessoal\ContratoServidorRegimeFuncao $fkPessoalContratoServidorRegimeFuncao)
    {
        if (false === $this->fkPessoalContratoServidorRegimeFuncoes->contains($fkPessoalContratoServidorRegimeFuncao)) {
            $fkPessoalContratoServidorRegimeFuncao->setFkPessoalRegime($this);
            $this->fkPessoalContratoServidorRegimeFuncoes->add($fkPessoalContratoServidorRegimeFuncao);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PessoalContratoServidorRegimeFuncao
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\ContratoServidorRegimeFuncao $fkPessoalContratoServidorRegimeFuncao
     */
    public function removeFkPessoalContratoServidorRegimeFuncoes(\Urbem\CoreBundle\Entity\Pessoal\ContratoServidorRegimeFuncao $fkPessoalContratoServidorRegimeFuncao)
    {
        $this->fkPessoalContratoServidorRegimeFuncoes->removeElement($fkPessoalContratoServidorRegimeFuncao);
    }

    /**
     * OneToMany (owning side)
     * Get fkPessoalContratoServidorRegimeFuncoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\ContratoServidorRegimeFuncao
     */
    public function getFkPessoalContratoServidorRegimeFuncoes()
    {
        return $this->fkPessoalContratoServidorRegimeFuncoes;
    }

    /**
     * OneToMany (owning side)
     * Add PessoalConfiguracaoFormaPagamentoFerias
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\ConfiguracaoFormaPagamentoFerias $fkPessoalConfiguracaoFormaPagamentoFerias
     * @return Regime
     */
    public function addFkPessoalConfiguracaoFormaPagamentoFerias(\Urbem\CoreBundle\Entity\Pessoal\ConfiguracaoFormaPagamentoFerias $fkPessoalConfiguracaoFormaPagamentoFerias)
    {
        if (false === $this->fkPessoalConfiguracaoFormaPagamentoFerias->contains($fkPessoalConfiguracaoFormaPagamentoFerias)) {
            $fkPessoalConfiguracaoFormaPagamentoFerias->setFkPessoalRegime($this);
            $this->fkPessoalConfiguracaoFormaPagamentoFerias->add($fkPessoalConfiguracaoFormaPagamentoFerias);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PessoalConfiguracaoFormaPagamentoFerias
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\ConfiguracaoFormaPagamentoFerias $fkPessoalConfiguracaoFormaPagamentoFerias
     */
    public function removeFkPessoalConfiguracaoFormaPagamentoFerias(\Urbem\CoreBundle\Entity\Pessoal\ConfiguracaoFormaPagamentoFerias $fkPessoalConfiguracaoFormaPagamentoFerias)
    {
        $this->fkPessoalConfiguracaoFormaPagamentoFerias->removeElement($fkPessoalConfiguracaoFormaPagamentoFerias);
    }

    /**
     * OneToMany (owning side)
     * Get fkPessoalConfiguracaoFormaPagamentoFerias
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\ConfiguracaoFormaPagamentoFerias
     */
    public function getFkPessoalConfiguracaoFormaPagamentoFerias()
    {
        return $this->fkPessoalConfiguracaoFormaPagamentoFerias;
    }

    /**
     * OneToMany (owning side)
     * Add PessoalContratoServidor
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\ContratoServidor $fkPessoalContratoServidor
     * @return Regime
     */
    public function addFkPessoalContratoServidores(\Urbem\CoreBundle\Entity\Pessoal\ContratoServidor $fkPessoalContratoServidor)
    {
        if (false === $this->fkPessoalContratoServidores->contains($fkPessoalContratoServidor)) {
            $fkPessoalContratoServidor->setFkPessoalRegime($this);
            $this->fkPessoalContratoServidores->add($fkPessoalContratoServidor);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PessoalContratoServidor
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\ContratoServidor $fkPessoalContratoServidor
     */
    public function removeFkPessoalContratoServidores(\Urbem\CoreBundle\Entity\Pessoal\ContratoServidor $fkPessoalContratoServidor)
    {
        $this->fkPessoalContratoServidores->removeElement($fkPessoalContratoServidor);
    }

    /**
     * OneToMany (owning side)
     * Get fkPessoalContratoServidores
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\ContratoServidor
     */
    public function getFkPessoalContratoServidores()
    {
        return $this->fkPessoalContratoServidores;
    }

    /**
     * OneToMany (owning side)
     * Add PessoalSubDivisao
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\SubDivisao $fkPessoalSubDivisao
     * @return Regime
     */
    public function addFkPessoalSubDivisoes(\Urbem\CoreBundle\Entity\Pessoal\SubDivisao $fkPessoalSubDivisao)
    {
        if (false === $this->fkPessoalSubDivisoes->contains($fkPessoalSubDivisao)) {
            $fkPessoalSubDivisao->setFkPessoalRegime($this);
            $this->fkPessoalSubDivisoes->add($fkPessoalSubDivisao);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PessoalSubDivisao
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\SubDivisao $fkPessoalSubDivisao
     */
    public function removeFkPessoalSubDivisoes(\Urbem\CoreBundle\Entity\Pessoal\SubDivisao $fkPessoalSubDivisao)
    {
        $this->fkPessoalSubDivisoes->removeElement($fkPessoalSubDivisao);
    }

    /**
     * OneToMany (owning side)
     * Get fkPessoalSubDivisoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\SubDivisao
     */
    public function getFkPessoalSubDivisoes()
    {
        return $this->fkPessoalSubDivisoes;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string) $this->descricao;
    }
}
