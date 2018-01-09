<?php
 
namespace Urbem\CoreBundle\Entity\Arrecadacao;

/**
 * TipoCompensacao
 */
class TipoCompensacao
{
    /**
     * PK
     * @var integer
     */
    private $codTipo;

    /**
     * @var string
     */
    private $descricao;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Arrecadacao\Compensacao
     */
    private $fkArrecadacaoCompensacoes;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkArrecadacaoCompensacoes = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codTipo
     *
     * @param integer $codTipo
     * @return TipoCompensacao
     */
    public function setCodTipo($codTipo)
    {
        $this->codTipo = $codTipo;
        return $this;
    }

    /**
     * Get codTipo
     *
     * @return integer
     */
    public function getCodTipo()
    {
        return $this->codTipo;
    }

    /**
     * Set descricao
     *
     * @param string $descricao
     * @return TipoCompensacao
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
     * Add ArrecadacaoCompensacao
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\Compensacao $fkArrecadacaoCompensacao
     * @return TipoCompensacao
     */
    public function addFkArrecadacaoCompensacoes(\Urbem\CoreBundle\Entity\Arrecadacao\Compensacao $fkArrecadacaoCompensacao)
    {
        if (false === $this->fkArrecadacaoCompensacoes->contains($fkArrecadacaoCompensacao)) {
            $fkArrecadacaoCompensacao->setFkArrecadacaoTipoCompensacao($this);
            $this->fkArrecadacaoCompensacoes->add($fkArrecadacaoCompensacao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ArrecadacaoCompensacao
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\Compensacao $fkArrecadacaoCompensacao
     */
    public function removeFkArrecadacaoCompensacoes(\Urbem\CoreBundle\Entity\Arrecadacao\Compensacao $fkArrecadacaoCompensacao)
    {
        $this->fkArrecadacaoCompensacoes->removeElement($fkArrecadacaoCompensacao);
    }

    /**
     * OneToMany (owning side)
     * Get fkArrecadacaoCompensacoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Arrecadacao\Compensacao
     */
    public function getFkArrecadacaoCompensacoes()
    {
        return $this->fkArrecadacaoCompensacoes;
    }
}
