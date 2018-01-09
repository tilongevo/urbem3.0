<?php
 
namespace Urbem\CoreBundle\Entity\Folhapagamento;

/**
 * NivelPadrao
 */
class NivelPadrao
{
    /**
     * PK
     * @var integer
     */
    private $codNivelPadrao;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\NivelPadraoNivel
     */
    private $fkFolhapagamentoNivelPadraoNiveis;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\ContratoServidorNivelPadrao
     */
    private $fkPessoalContratoServidorNivelPadroes;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkFolhapagamentoNivelPadraoNiveis = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkPessoalContratoServidorNivelPadroes = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codNivelPadrao
     *
     * @param integer $codNivelPadrao
     * @return NivelPadrao
     */
    public function setCodNivelPadrao($codNivelPadrao)
    {
        $this->codNivelPadrao = $codNivelPadrao;
        return $this;
    }

    /**
     * Get codNivelPadrao
     *
     * @return integer
     */
    public function getCodNivelPadrao()
    {
        return $this->codNivelPadrao;
    }

    /**
     * OneToMany (owning side)
     * Add FolhapagamentoNivelPadraoNivel
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\NivelPadraoNivel $fkFolhapagamentoNivelPadraoNivel
     * @return NivelPadrao
     */
    public function addFkFolhapagamentoNivelPadraoNiveis(\Urbem\CoreBundle\Entity\Folhapagamento\NivelPadraoNivel $fkFolhapagamentoNivelPadraoNivel)
    {
        if (false === $this->fkFolhapagamentoNivelPadraoNiveis->contains($fkFolhapagamentoNivelPadraoNivel)) {
            $fkFolhapagamentoNivelPadraoNivel->setFkFolhapagamentoNivelPadrao($this);
            $this->fkFolhapagamentoNivelPadraoNiveis->add($fkFolhapagamentoNivelPadraoNivel);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FolhapagamentoNivelPadraoNivel
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\NivelPadraoNivel $fkFolhapagamentoNivelPadraoNivel
     */
    public function removeFkFolhapagamentoNivelPadraoNiveis(\Urbem\CoreBundle\Entity\Folhapagamento\NivelPadraoNivel $fkFolhapagamentoNivelPadraoNivel)
    {
        $this->fkFolhapagamentoNivelPadraoNiveis->removeElement($fkFolhapagamentoNivelPadraoNivel);
    }

    /**
     * OneToMany (owning side)
     * Get fkFolhapagamentoNivelPadraoNiveis
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\NivelPadraoNivel
     */
    public function getFkFolhapagamentoNivelPadraoNiveis()
    {
        return $this->fkFolhapagamentoNivelPadraoNiveis;
    }

    /**
     * OneToMany (owning side)
     * Add PessoalContratoServidorNivelPadrao
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\ContratoServidorNivelPadrao $fkPessoalContratoServidorNivelPadrao
     * @return NivelPadrao
     */
    public function addFkPessoalContratoServidorNivelPadroes(\Urbem\CoreBundle\Entity\Pessoal\ContratoServidorNivelPadrao $fkPessoalContratoServidorNivelPadrao)
    {
        if (false === $this->fkPessoalContratoServidorNivelPadroes->contains($fkPessoalContratoServidorNivelPadrao)) {
            $fkPessoalContratoServidorNivelPadrao->setFkFolhapagamentoNivelPadrao($this);
            $this->fkPessoalContratoServidorNivelPadroes->add($fkPessoalContratoServidorNivelPadrao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PessoalContratoServidorNivelPadrao
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\ContratoServidorNivelPadrao $fkPessoalContratoServidorNivelPadrao
     */
    public function removeFkPessoalContratoServidorNivelPadroes(\Urbem\CoreBundle\Entity\Pessoal\ContratoServidorNivelPadrao $fkPessoalContratoServidorNivelPadrao)
    {
        $this->fkPessoalContratoServidorNivelPadroes->removeElement($fkPessoalContratoServidorNivelPadrao);
    }

    /**
     * OneToMany (owning side)
     * Get fkPessoalContratoServidorNivelPadroes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\ContratoServidorNivelPadrao
     */
    public function getFkPessoalContratoServidorNivelPadroes()
    {
        return $this->fkPessoalContratoServidorNivelPadroes;
    }
}
