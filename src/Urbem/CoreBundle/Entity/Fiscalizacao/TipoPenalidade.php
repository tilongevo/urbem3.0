<?php
 
namespace Urbem\CoreBundle\Entity\Fiscalizacao;

/**
 * TipoPenalidade
 */
class TipoPenalidade
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
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Fiscalizacao\Penalidade
     */
    private $fkFiscalizacaoPenalidades;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkFiscalizacaoPenalidades = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codTipo
     *
     * @param integer $codTipo
     * @return TipoPenalidade
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
     * @return TipoPenalidade
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
     * Add FiscalizacaoPenalidade
     *
     * @param \Urbem\CoreBundle\Entity\Fiscalizacao\Penalidade $fkFiscalizacaoPenalidade
     * @return TipoPenalidade
     */
    public function addFkFiscalizacaoPenalidades(\Urbem\CoreBundle\Entity\Fiscalizacao\Penalidade $fkFiscalizacaoPenalidade)
    {
        if (false === $this->fkFiscalizacaoPenalidades->contains($fkFiscalizacaoPenalidade)) {
            $fkFiscalizacaoPenalidade->setFkFiscalizacaoTipoPenalidade($this);
            $this->fkFiscalizacaoPenalidades->add($fkFiscalizacaoPenalidade);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FiscalizacaoPenalidade
     *
     * @param \Urbem\CoreBundle\Entity\Fiscalizacao\Penalidade $fkFiscalizacaoPenalidade
     */
    public function removeFkFiscalizacaoPenalidades(\Urbem\CoreBundle\Entity\Fiscalizacao\Penalidade $fkFiscalizacaoPenalidade)
    {
        $this->fkFiscalizacaoPenalidades->removeElement($fkFiscalizacaoPenalidade);
    }

    /**
     * OneToMany (owning side)
     * Get fkFiscalizacaoPenalidades
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Fiscalizacao\Penalidade
     */
    public function getFkFiscalizacaoPenalidades()
    {
        return $this->fkFiscalizacaoPenalidades;
    }
}
