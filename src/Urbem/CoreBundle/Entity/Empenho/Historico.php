<?php
 
namespace Urbem\CoreBundle\Entity\Empenho;

/**
 * Historico
 */
class Historico
{
    /**
     * PK
     * @var integer
     */
    private $codHistorico;

    /**
     * PK
     * @var string
     */
    private $exercicio;

    /**
     * @var string
     */
    private $nomHistorico;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Empenho\PreEmpenho
     */
    private $fkEmpenhoPreEmpenhos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoAutorizacaoEmpenhoHistorico
     */
    private $fkFolhapagamentoConfiguracaoAutorizacaoEmpenhoHistoricos;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkEmpenhoPreEmpenhos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkFolhapagamentoConfiguracaoAutorizacaoEmpenhoHistoricos = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codHistorico
     *
     * @param integer $codHistorico
     * @return Historico
     */
    public function setCodHistorico($codHistorico)
    {
        $this->codHistorico = $codHistorico;
        return $this;
    }

    /**
     * Get codHistorico
     *
     * @return integer
     */
    public function getCodHistorico()
    {
        return $this->codHistorico;
    }

    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return Historico
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
     * Set nomHistorico
     *
     * @param string $nomHistorico
     * @return Historico
     */
    public function setNomHistorico($nomHistorico)
    {
        $this->nomHistorico = $nomHistorico;
        return $this;
    }

    /**
     * Get nomHistorico
     *
     * @return string
     */
    public function getNomHistorico()
    {
        return $this->nomHistorico;
    }

    /**
     * OneToMany (owning side)
     * Add EmpenhoPreEmpenho
     *
     * @param \Urbem\CoreBundle\Entity\Empenho\PreEmpenho $fkEmpenhoPreEmpenho
     * @return Historico
     */
    public function addFkEmpenhoPreEmpenhos(\Urbem\CoreBundle\Entity\Empenho\PreEmpenho $fkEmpenhoPreEmpenho)
    {
        if (false === $this->fkEmpenhoPreEmpenhos->contains($fkEmpenhoPreEmpenho)) {
            $fkEmpenhoPreEmpenho->setFkEmpenhoHistorico($this);
            $this->fkEmpenhoPreEmpenhos->add($fkEmpenhoPreEmpenho);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove EmpenhoPreEmpenho
     *
     * @param \Urbem\CoreBundle\Entity\Empenho\PreEmpenho $fkEmpenhoPreEmpenho
     */
    public function removeFkEmpenhoPreEmpenhos(\Urbem\CoreBundle\Entity\Empenho\PreEmpenho $fkEmpenhoPreEmpenho)
    {
        $this->fkEmpenhoPreEmpenhos->removeElement($fkEmpenhoPreEmpenho);
    }

    /**
     * OneToMany (owning side)
     * Get fkEmpenhoPreEmpenhos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Empenho\PreEmpenho
     */
    public function getFkEmpenhoPreEmpenhos()
    {
        return $this->fkEmpenhoPreEmpenhos;
    }

    /**
     * OneToMany (owning side)
     * Add FolhapagamentoConfiguracaoAutorizacaoEmpenhoHistorico
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoAutorizacaoEmpenhoHistorico $fkFolhapagamentoConfiguracaoAutorizacaoEmpenhoHistorico
     * @return Historico
     */
    public function addFkFolhapagamentoConfiguracaoAutorizacaoEmpenhoHistoricos(\Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoAutorizacaoEmpenhoHistorico $fkFolhapagamentoConfiguracaoAutorizacaoEmpenhoHistorico)
    {
        if (false === $this->fkFolhapagamentoConfiguracaoAutorizacaoEmpenhoHistoricos->contains($fkFolhapagamentoConfiguracaoAutorizacaoEmpenhoHistorico)) {
            $fkFolhapagamentoConfiguracaoAutorizacaoEmpenhoHistorico->setFkEmpenhoHistorico($this);
            $this->fkFolhapagamentoConfiguracaoAutorizacaoEmpenhoHistoricos->add($fkFolhapagamentoConfiguracaoAutorizacaoEmpenhoHistorico);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FolhapagamentoConfiguracaoAutorizacaoEmpenhoHistorico
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoAutorizacaoEmpenhoHistorico $fkFolhapagamentoConfiguracaoAutorizacaoEmpenhoHistorico
     */
    public function removeFkFolhapagamentoConfiguracaoAutorizacaoEmpenhoHistoricos(\Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoAutorizacaoEmpenhoHistorico $fkFolhapagamentoConfiguracaoAutorizacaoEmpenhoHistorico)
    {
        $this->fkFolhapagamentoConfiguracaoAutorizacaoEmpenhoHistoricos->removeElement($fkFolhapagamentoConfiguracaoAutorizacaoEmpenhoHistorico);
    }

    /**
     * OneToMany (owning side)
     * Get fkFolhapagamentoConfiguracaoAutorizacaoEmpenhoHistoricos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoAutorizacaoEmpenhoHistorico
     */
    public function getFkFolhapagamentoConfiguracaoAutorizacaoEmpenhoHistoricos()
    {
        return $this->fkFolhapagamentoConfiguracaoAutorizacaoEmpenhoHistoricos;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string) $this->nomHistorico;
    }
}
