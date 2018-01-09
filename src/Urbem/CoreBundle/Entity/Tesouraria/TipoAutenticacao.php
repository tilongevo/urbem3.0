<?php
 
namespace Urbem\CoreBundle\Entity\Tesouraria;

/**
 * TipoAutenticacao
 */
class TipoAutenticacao
{
    /**
     * PK
     * @var string
     */
    private $codTipoAutenticacao;

    /**
     * @var string
     */
    private $descricao;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tesouraria\Autenticacao
     */
    private $fkTesourariaAutenticacoes;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkTesourariaAutenticacoes = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codTipoAutenticacao
     *
     * @param string $codTipoAutenticacao
     * @return TipoAutenticacao
     */
    public function setCodTipoAutenticacao($codTipoAutenticacao)
    {
        $this->codTipoAutenticacao = $codTipoAutenticacao;
        return $this;
    }

    /**
     * Get codTipoAutenticacao
     *
     * @return string
     */
    public function getCodTipoAutenticacao()
    {
        return $this->codTipoAutenticacao;
    }

    /**
     * Set descricao
     *
     * @param string $descricao
     * @return TipoAutenticacao
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
     * Add TesourariaAutenticacao
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\Autenticacao $fkTesourariaAutenticacao
     * @return TipoAutenticacao
     */
    public function addFkTesourariaAutenticacoes(\Urbem\CoreBundle\Entity\Tesouraria\Autenticacao $fkTesourariaAutenticacao)
    {
        if (false === $this->fkTesourariaAutenticacoes->contains($fkTesourariaAutenticacao)) {
            $fkTesourariaAutenticacao->setFkTesourariaTipoAutenticacao($this);
            $this->fkTesourariaAutenticacoes->add($fkTesourariaAutenticacao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TesourariaAutenticacao
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\Autenticacao $fkTesourariaAutenticacao
     */
    public function removeFkTesourariaAutenticacoes(\Urbem\CoreBundle\Entity\Tesouraria\Autenticacao $fkTesourariaAutenticacao)
    {
        $this->fkTesourariaAutenticacoes->removeElement($fkTesourariaAutenticacao);
    }

    /**
     * OneToMany (owning side)
     * Get fkTesourariaAutenticacoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tesouraria\Autenticacao
     */
    public function getFkTesourariaAutenticacoes()
    {
        return $this->fkTesourariaAutenticacoes;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->codTipoAutenticacao;
    }
}
