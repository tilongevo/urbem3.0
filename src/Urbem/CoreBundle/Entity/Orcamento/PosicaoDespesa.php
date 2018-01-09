<?php
 
namespace Urbem\CoreBundle\Entity\Orcamento;

/**
 * PosicaoDespesa
 */
class PosicaoDespesa
{
    /**
     * PK
     * @var string
     */
    private $exercicio;

    /**
     * PK
     * @var integer
     */
    private $codPosicao;

    /**
     * @var string
     */
    private $mascara;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Orcamento\ClassificacaoDespesa
     */
    private $fkOrcamentoClassificacaoDespesas;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkOrcamentoClassificacaoDespesas = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return PosicaoDespesa
     */
    public function setExercicio($exercicio)
    {
        $this->exercicio = $exercicio;
        return $this;
    }

    /**
     * Get exercicio
     *
     * @return string
     */
    public function getExercicio()
    {
        return $this->exercicio;
    }

    /**
     * Set codPosicao
     *
     * @param integer $codPosicao
     * @return PosicaoDespesa
     */
    public function setCodPosicao($codPosicao)
    {
        $this->codPosicao = $codPosicao;
        return $this;
    }

    /**
     * Get codPosicao
     *
     * @return integer
     */
    public function getCodPosicao()
    {
        return $this->codPosicao;
    }

    /**
     * Set mascara
     *
     * @param string $mascara
     * @return PosicaoDespesa
     */
    public function setMascara($mascara)
    {
        $this->mascara = $mascara;
        return $this;
    }

    /**
     * Get mascara
     *
     * @return string
     */
    public function getMascara()
    {
        return $this->mascara;
    }

    /**
     * OneToMany (owning side)
     * Add OrcamentoClassificacaoDespesa
     *
     * @param \Urbem\CoreBundle\Entity\Orcamento\ClassificacaoDespesa $fkOrcamentoClassificacaoDespesa
     * @return PosicaoDespesa
     */
    public function addFkOrcamentoClassificacaoDespesas(\Urbem\CoreBundle\Entity\Orcamento\ClassificacaoDespesa $fkOrcamentoClassificacaoDespesa)
    {
        if (false === $this->fkOrcamentoClassificacaoDespesas->contains($fkOrcamentoClassificacaoDespesa)) {
            $fkOrcamentoClassificacaoDespesa->setFkOrcamentoPosicaoDespesa($this);
            $this->fkOrcamentoClassificacaoDespesas->add($fkOrcamentoClassificacaoDespesa);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove OrcamentoClassificacaoDespesa
     *
     * @param \Urbem\CoreBundle\Entity\Orcamento\ClassificacaoDespesa $fkOrcamentoClassificacaoDespesa
     */
    public function removeFkOrcamentoClassificacaoDespesas(\Urbem\CoreBundle\Entity\Orcamento\ClassificacaoDespesa $fkOrcamentoClassificacaoDespesa)
    {
        $this->fkOrcamentoClassificacaoDespesas->removeElement($fkOrcamentoClassificacaoDespesa);
    }

    /**
     * OneToMany (owning side)
     * Get fkOrcamentoClassificacaoDespesas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Orcamento\ClassificacaoDespesa
     */
    public function getFkOrcamentoClassificacaoDespesas()
    {
        return $this->fkOrcamentoClassificacaoDespesas;
    }
}
