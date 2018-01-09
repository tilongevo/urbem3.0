<?php
 
namespace Urbem\CoreBundle\Entity\Tcmgo;

/**
 * FundamentacaoLegal
 */
class FundamentacaoLegal
{
    /**
     * PK
     * @var string
     */
    private $codFundamentacao;

    /**
     * @var string
     */
    private $descricao;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcmgo\EmpenhoModalidade
     */
    private $fkTcmgoEmpenhoModalidades;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkTcmgoEmpenhoModalidades = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codFundamentacao
     *
     * @param string $codFundamentacao
     * @return FundamentacaoLegal
     */
    public function setCodFundamentacao($codFundamentacao)
    {
        $this->codFundamentacao = $codFundamentacao;
        return $this;
    }

    /**
     * Get codFundamentacao
     *
     * @return string
     */
    public function getCodFundamentacao()
    {
        return $this->codFundamentacao;
    }

    /**
     * Set descricao
     *
     * @param string $descricao
     * @return FundamentacaoLegal
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
     * Add TcmgoEmpenhoModalidade
     *
     * @param \Urbem\CoreBundle\Entity\Tcmgo\EmpenhoModalidade $fkTcmgoEmpenhoModalidade
     * @return FundamentacaoLegal
     */
    public function addFkTcmgoEmpenhoModalidades(\Urbem\CoreBundle\Entity\Tcmgo\EmpenhoModalidade $fkTcmgoEmpenhoModalidade)
    {
        if (false === $this->fkTcmgoEmpenhoModalidades->contains($fkTcmgoEmpenhoModalidade)) {
            $fkTcmgoEmpenhoModalidade->setFkTcmgoFundamentacaoLegal($this);
            $this->fkTcmgoEmpenhoModalidades->add($fkTcmgoEmpenhoModalidade);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcmgoEmpenhoModalidade
     *
     * @param \Urbem\CoreBundle\Entity\Tcmgo\EmpenhoModalidade $fkTcmgoEmpenhoModalidade
     */
    public function removeFkTcmgoEmpenhoModalidades(\Urbem\CoreBundle\Entity\Tcmgo\EmpenhoModalidade $fkTcmgoEmpenhoModalidade)
    {
        $this->fkTcmgoEmpenhoModalidades->removeElement($fkTcmgoEmpenhoModalidade);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcmgoEmpenhoModalidades
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcmgo\EmpenhoModalidade
     */
    public function getFkTcmgoEmpenhoModalidades()
    {
        return $this->fkTcmgoEmpenhoModalidades;
    }
}
