<?php
 
namespace Urbem\CoreBundle\Entity\Fiscalizacao;

/**
 * TipoInutilizacao
 */
class TipoInutilizacao
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
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Fiscalizacao\BaixaNotas
     */
    private $fkFiscalizacaoBaixaNotas;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkFiscalizacaoBaixaNotas = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codTipo
     *
     * @param integer $codTipo
     * @return TipoInutilizacao
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
     * @return TipoInutilizacao
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
     * Add FiscalizacaoBaixaNotas
     *
     * @param \Urbem\CoreBundle\Entity\Fiscalizacao\BaixaNotas $fkFiscalizacaoBaixaNotas
     * @return TipoInutilizacao
     */
    public function addFkFiscalizacaoBaixaNotas(\Urbem\CoreBundle\Entity\Fiscalizacao\BaixaNotas $fkFiscalizacaoBaixaNotas)
    {
        if (false === $this->fkFiscalizacaoBaixaNotas->contains($fkFiscalizacaoBaixaNotas)) {
            $fkFiscalizacaoBaixaNotas->setFkFiscalizacaoTipoInutilizacao($this);
            $this->fkFiscalizacaoBaixaNotas->add($fkFiscalizacaoBaixaNotas);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FiscalizacaoBaixaNotas
     *
     * @param \Urbem\CoreBundle\Entity\Fiscalizacao\BaixaNotas $fkFiscalizacaoBaixaNotas
     */
    public function removeFkFiscalizacaoBaixaNotas(\Urbem\CoreBundle\Entity\Fiscalizacao\BaixaNotas $fkFiscalizacaoBaixaNotas)
    {
        $this->fkFiscalizacaoBaixaNotas->removeElement($fkFiscalizacaoBaixaNotas);
    }

    /**
     * OneToMany (owning side)
     * Get fkFiscalizacaoBaixaNotas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Fiscalizacao\BaixaNotas
     */
    public function getFkFiscalizacaoBaixaNotas()
    {
        return $this->fkFiscalizacaoBaixaNotas;
    }
}
