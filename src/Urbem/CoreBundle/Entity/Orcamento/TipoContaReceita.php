<?php
 
namespace Urbem\CoreBundle\Entity\Orcamento;

/**
 * TipoContaReceita
 */
class TipoContaReceita
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
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Orcamento\PosicaoReceita
     */
    private $fkOrcamentoPosicaoReceitas;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkOrcamentoPosicaoReceitas = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codTipo
     *
     * @param integer $codTipo
     * @return TipoContaReceita
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
     * @return TipoContaReceita
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
     * Add OrcamentoPosicaoReceita
     *
     * @param \Urbem\CoreBundle\Entity\Orcamento\PosicaoReceita $fkOrcamentoPosicaoReceita
     * @return TipoContaReceita
     */
    public function addFkOrcamentoPosicaoReceitas(\Urbem\CoreBundle\Entity\Orcamento\PosicaoReceita $fkOrcamentoPosicaoReceita)
    {
        if (false === $this->fkOrcamentoPosicaoReceitas->contains($fkOrcamentoPosicaoReceita)) {
            $fkOrcamentoPosicaoReceita->setFkOrcamentoTipoContaReceita($this);
            $this->fkOrcamentoPosicaoReceitas->add($fkOrcamentoPosicaoReceita);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove OrcamentoPosicaoReceita
     *
     * @param \Urbem\CoreBundle\Entity\Orcamento\PosicaoReceita $fkOrcamentoPosicaoReceita
     */
    public function removeFkOrcamentoPosicaoReceitas(\Urbem\CoreBundle\Entity\Orcamento\PosicaoReceita $fkOrcamentoPosicaoReceita)
    {
        $this->fkOrcamentoPosicaoReceitas->removeElement($fkOrcamentoPosicaoReceita);
    }

    /**
     * OneToMany (owning side)
     * Get fkOrcamentoPosicaoReceitas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Orcamento\PosicaoReceita
     */
    public function getFkOrcamentoPosicaoReceitas()
    {
        return $this->fkOrcamentoPosicaoReceitas;
    }
}
