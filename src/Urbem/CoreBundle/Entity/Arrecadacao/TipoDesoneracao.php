<?php
 
namespace Urbem\CoreBundle\Entity\Arrecadacao;

/**
 * TipoDesoneracao
 */
class TipoDesoneracao
{
    /**
     * PK
     * @var integer
     */
    private $codTipoDesoneracao;

    /**
     * @var string
     */
    private $descricao;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Arrecadacao\Desoneracao
     */
    private $fkArrecadacaoDesoneracoes;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkArrecadacaoDesoneracoes = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codTipoDesoneracao
     *
     * @param integer $codTipoDesoneracao
     * @return TipoDesoneracao
     */
    public function setCodTipoDesoneracao($codTipoDesoneracao)
    {
        $this->codTipoDesoneracao = $codTipoDesoneracao;
        return $this;
    }

    /**
     * Get codTipoDesoneracao
     *
     * @return integer
     */
    public function getCodTipoDesoneracao()
    {
        return $this->codTipoDesoneracao;
    }

    /**
     * Set descricao
     *
     * @param string $descricao
     * @return TipoDesoneracao
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
     * Add ArrecadacaoDesoneracao
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\Desoneracao $fkArrecadacaoDesoneracao
     * @return TipoDesoneracao
     */
    public function addFkArrecadacaoDesoneracoes(\Urbem\CoreBundle\Entity\Arrecadacao\Desoneracao $fkArrecadacaoDesoneracao)
    {
        if (false === $this->fkArrecadacaoDesoneracoes->contains($fkArrecadacaoDesoneracao)) {
            $fkArrecadacaoDesoneracao->setFkArrecadacaoTipoDesoneracao($this);
            $this->fkArrecadacaoDesoneracoes->add($fkArrecadacaoDesoneracao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ArrecadacaoDesoneracao
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\Desoneracao $fkArrecadacaoDesoneracao
     */
    public function removeFkArrecadacaoDesoneracoes(\Urbem\CoreBundle\Entity\Arrecadacao\Desoneracao $fkArrecadacaoDesoneracao)
    {
        $this->fkArrecadacaoDesoneracoes->removeElement($fkArrecadacaoDesoneracao);
    }

    /**
     * OneToMany (owning side)
     * Get fkArrecadacaoDesoneracoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Arrecadacao\Desoneracao
     */
    public function getFkArrecadacaoDesoneracoes()
    {
        return $this->fkArrecadacaoDesoneracoes;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->descricao;
    }
}
