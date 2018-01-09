<?php
 
namespace Urbem\CoreBundle\Entity\Tceto;

/**
 * ClassificacaoReceitaDespesa
 */
class ClassificacaoReceitaDespesa
{
    /**
     * PK
     * @var integer
     */
    private $codClassificacao;

    /**
     * @var string
     */
    private $descricao;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tceto\PlanoAnaliticaClassificacao
     */
    private $fkTcetoPlanoAnaliticaClassificacoes;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkTcetoPlanoAnaliticaClassificacoes = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codClassificacao
     *
     * @param integer $codClassificacao
     * @return ClassificacaoReceitaDespesa
     */
    public function setCodClassificacao($codClassificacao)
    {
        $this->codClassificacao = $codClassificacao;
        return $this;
    }

    /**
     * Get codClassificacao
     *
     * @return integer
     */
    public function getCodClassificacao()
    {
        return $this->codClassificacao;
    }

    /**
     * Set descricao
     *
     * @param string $descricao
     * @return ClassificacaoReceitaDespesa
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
     * Add TcetoPlanoAnaliticaClassificacao
     *
     * @param \Urbem\CoreBundle\Entity\Tceto\PlanoAnaliticaClassificacao $fkTcetoPlanoAnaliticaClassificacao
     * @return ClassificacaoReceitaDespesa
     */
    public function addFkTcetoPlanoAnaliticaClassificacoes(\Urbem\CoreBundle\Entity\Tceto\PlanoAnaliticaClassificacao $fkTcetoPlanoAnaliticaClassificacao)
    {
        if (false === $this->fkTcetoPlanoAnaliticaClassificacoes->contains($fkTcetoPlanoAnaliticaClassificacao)) {
            $fkTcetoPlanoAnaliticaClassificacao->setFkTcetoClassificacaoReceitaDespesa($this);
            $this->fkTcetoPlanoAnaliticaClassificacoes->add($fkTcetoPlanoAnaliticaClassificacao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcetoPlanoAnaliticaClassificacao
     *
     * @param \Urbem\CoreBundle\Entity\Tceto\PlanoAnaliticaClassificacao $fkTcetoPlanoAnaliticaClassificacao
     */
    public function removeFkTcetoPlanoAnaliticaClassificacoes(\Urbem\CoreBundle\Entity\Tceto\PlanoAnaliticaClassificacao $fkTcetoPlanoAnaliticaClassificacao)
    {
        $this->fkTcetoPlanoAnaliticaClassificacoes->removeElement($fkTcetoPlanoAnaliticaClassificacao);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcetoPlanoAnaliticaClassificacoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tceto\PlanoAnaliticaClassificacao
     */
    public function getFkTcetoPlanoAnaliticaClassificacoes()
    {
        return $this->fkTcetoPlanoAnaliticaClassificacoes;
    }
}
