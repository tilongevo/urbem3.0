<?php
 
namespace Urbem\CoreBundle\Entity\Fiscalizacao;

/**
 * NaturezaFiscalizacao
 */
class NaturezaFiscalizacao
{
    /**
     * PK
     * @var integer
     */
    private $codNatureza;

    /**
     * @var string
     */
    private $descricao;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Fiscalizacao\ProcessoFiscal
     */
    private $fkFiscalizacaoProcessoFiscais;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkFiscalizacaoProcessoFiscais = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codNatureza
     *
     * @param integer $codNatureza
     * @return NaturezaFiscalizacao
     */
    public function setCodNatureza($codNatureza)
    {
        $this->codNatureza = $codNatureza;
        return $this;
    }

    /**
     * Get codNatureza
     *
     * @return integer
     */
    public function getCodNatureza()
    {
        return $this->codNatureza;
    }

    /**
     * Set descricao
     *
     * @param string $descricao
     * @return NaturezaFiscalizacao
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
     * Add FiscalizacaoProcessoFiscal
     *
     * @param \Urbem\CoreBundle\Entity\Fiscalizacao\ProcessoFiscal $fkFiscalizacaoProcessoFiscal
     * @return NaturezaFiscalizacao
     */
    public function addFkFiscalizacaoProcessoFiscais(\Urbem\CoreBundle\Entity\Fiscalizacao\ProcessoFiscal $fkFiscalizacaoProcessoFiscal)
    {
        if (false === $this->fkFiscalizacaoProcessoFiscais->contains($fkFiscalizacaoProcessoFiscal)) {
            $fkFiscalizacaoProcessoFiscal->setFkFiscalizacaoNaturezaFiscalizacao($this);
            $this->fkFiscalizacaoProcessoFiscais->add($fkFiscalizacaoProcessoFiscal);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FiscalizacaoProcessoFiscal
     *
     * @param \Urbem\CoreBundle\Entity\Fiscalizacao\ProcessoFiscal $fkFiscalizacaoProcessoFiscal
     */
    public function removeFkFiscalizacaoProcessoFiscais(\Urbem\CoreBundle\Entity\Fiscalizacao\ProcessoFiscal $fkFiscalizacaoProcessoFiscal)
    {
        $this->fkFiscalizacaoProcessoFiscais->removeElement($fkFiscalizacaoProcessoFiscal);
    }

    /**
     * OneToMany (owning side)
     * Get fkFiscalizacaoProcessoFiscais
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Fiscalizacao\ProcessoFiscal
     */
    public function getFkFiscalizacaoProcessoFiscais()
    {
        return $this->fkFiscalizacaoProcessoFiscais;
    }
}
