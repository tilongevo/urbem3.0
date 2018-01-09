<?php
 
namespace Urbem\CoreBundle\Entity\Folhapagamento;

/**
 * Padrao
 */
class Padrao
{
    /**
     * PK
     * @var integer
     */
    private $codPadrao;

    /**
     * @var string
     */
    private $descricao;

    /**
     * @var integer
     */
    private $horasMensais;

    /**
     * @var integer
     */
    private $horasSemanais;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\NivelPadraoNivel
     */
    private $fkFolhapagamentoNivelPadraoNiveis;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\PadraoPadrao
     */
    private $fkFolhapagamentoPadraoPadroes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\CargoPadrao
     */
    private $fkPessoalCargoPadroes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\EspecialidadePadrao
     */
    private $fkPessoalEspecialidadePadroes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\ContratoServidorPadrao
     */
    private $fkPessoalContratoServidorPadroes;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkFolhapagamentoNivelPadraoNiveis = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkFolhapagamentoPadraoPadroes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkPessoalCargoPadroes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkPessoalEspecialidadePadroes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkPessoalContratoServidorPadroes = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codPadrao
     *
     * @param integer $codPadrao
     * @return Padrao
     */
    public function setCodPadrao($codPadrao)
    {
        $this->codPadrao = $codPadrao;
        return $this;
    }

    /**
     * Get codPadrao
     *
     * @return integer
     */
    public function getCodPadrao()
    {
        return $this->codPadrao;
    }

    /**
     * Set descricao
     *
     * @param string $descricao
     * @return Padrao
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
     * Set horasMensais
     *
     * @param integer $horasMensais
     * @return Padrao
     */
    public function setHorasMensais($horasMensais)
    {
        $this->horasMensais = $horasMensais;
        return $this;
    }

    /**
     * Get horasMensais
     *
     * @return integer
     */
    public function getHorasMensais()
    {
        return $this->horasMensais;
    }

    /**
     * Set horasSemanais
     *
     * @param integer $horasSemanais
     * @return Padrao
     */
    public function setHorasSemanais($horasSemanais)
    {
        $this->horasSemanais = $horasSemanais;
        return $this;
    }

    /**
     * Get horasSemanais
     *
     * @return integer
     */
    public function getHorasSemanais()
    {
        return $this->horasSemanais;
    }

    /**
     * OneToMany (owning side)
     * Add FolhapagamentoNivelPadraoNivel
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\NivelPadraoNivel $fkFolhapagamentoNivelPadraoNivel
     * @return Padrao
     */
    public function addFkFolhapagamentoNivelPadraoNiveis(\Urbem\CoreBundle\Entity\Folhapagamento\NivelPadraoNivel $fkFolhapagamentoNivelPadraoNivel)
    {
        if (false === $this->fkFolhapagamentoNivelPadraoNiveis->contains($fkFolhapagamentoNivelPadraoNivel)) {
            $fkFolhapagamentoNivelPadraoNivel->setFkFolhapagamentoPadrao($this);
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
     * Set fkFolhapagamentoNivelPadraoNiveis
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\NivelPadraoNivel
     */
    public function setFkFolhapagamentoNivelPadraoNiveis($fkFolhapagamentoNivelPadraoNiveis)
    {
        return $this->fkFolhapagamentoNivelPadraoNiveis = $fkFolhapagamentoNivelPadraoNiveis;
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
     * Add FolhapagamentoPadraoPadrao
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\PadraoPadrao $fkFolhapagamentoPadraoPadrao
     * @return Padrao
     */
    public function addFkFolhapagamentoPadraoPadroes(\Urbem\CoreBundle\Entity\Folhapagamento\PadraoPadrao $fkFolhapagamentoPadraoPadrao)
    {
        if (false === $this->fkFolhapagamentoPadraoPadroes->contains($fkFolhapagamentoPadraoPadrao)) {
            $fkFolhapagamentoPadraoPadrao->setFkFolhapagamentoPadrao($this);
            $this->fkFolhapagamentoPadraoPadroes->add($fkFolhapagamentoPadraoPadrao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FolhapagamentoPadraoPadrao
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\PadraoPadrao $fkFolhapagamentoPadraoPadrao
     */
    public function removeFkFolhapagamentoPadraoPadroes(\Urbem\CoreBundle\Entity\Folhapagamento\PadraoPadrao $fkFolhapagamentoPadraoPadrao)
    {
        $this->fkFolhapagamentoPadraoPadroes->removeElement($fkFolhapagamentoPadraoPadrao);
    }

    /**
     * OneToMany (owning side)
     * Get fkFolhapagamentoPadraoPadroes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\PadraoPadrao
     */
    public function getFkFolhapagamentoPadraoPadroes()
    {
        return $this->fkFolhapagamentoPadraoPadroes;
    }

    /**
     * OneToMany (owning side)
     * Add PessoalCargoPadrao
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\CargoPadrao $fkPessoalCargoPadrao
     * @return Padrao
     */
    public function addFkPessoalCargoPadroes(\Urbem\CoreBundle\Entity\Pessoal\CargoPadrao $fkPessoalCargoPadrao)
    {
        if (false === $this->fkPessoalCargoPadroes->contains($fkPessoalCargoPadrao)) {
            $fkPessoalCargoPadrao->setFkFolhapagamentoPadrao($this);
            $this->fkPessoalCargoPadroes->add($fkPessoalCargoPadrao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PessoalCargoPadrao
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\CargoPadrao $fkPessoalCargoPadrao
     */
    public function removeFkPessoalCargoPadroes(\Urbem\CoreBundle\Entity\Pessoal\CargoPadrao $fkPessoalCargoPadrao)
    {
        $this->fkPessoalCargoPadroes->removeElement($fkPessoalCargoPadrao);
    }

    /**
     * OneToMany (owning side)
     * Get fkPessoalCargoPadroes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\CargoPadrao
     */
    public function getFkPessoalCargoPadroes()
    {
        return $this->fkPessoalCargoPadroes;
    }

    /**
     * OneToMany (owning side)
     * Add PessoalEspecialidadePadrao
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\EspecialidadePadrao $fkPessoalEspecialidadePadrao
     * @return Padrao
     */
    public function addFkPessoalEspecialidadePadroes(\Urbem\CoreBundle\Entity\Pessoal\EspecialidadePadrao $fkPessoalEspecialidadePadrao)
    {
        if (false === $this->fkPessoalEspecialidadePadroes->contains($fkPessoalEspecialidadePadrao)) {
            $fkPessoalEspecialidadePadrao->setFkFolhapagamentoPadrao($this);
            $this->fkPessoalEspecialidadePadroes->add($fkPessoalEspecialidadePadrao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PessoalEspecialidadePadrao
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\EspecialidadePadrao $fkPessoalEspecialidadePadrao
     */
    public function removeFkPessoalEspecialidadePadroes(\Urbem\CoreBundle\Entity\Pessoal\EspecialidadePadrao $fkPessoalEspecialidadePadrao)
    {
        $this->fkPessoalEspecialidadePadroes->removeElement($fkPessoalEspecialidadePadrao);
    }

    /**
     * OneToMany (owning side)
     * Get fkPessoalEspecialidadePadroes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\EspecialidadePadrao
     */
    public function getFkPessoalEspecialidadePadroes()
    {
        return $this->fkPessoalEspecialidadePadroes;
    }

    /**
     * OneToMany (owning side)
     * Add PessoalContratoServidorPadrao
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\ContratoServidorPadrao $fkPessoalContratoServidorPadrao
     * @return Padrao
     */
    public function addFkPessoalContratoServidorPadroes(\Urbem\CoreBundle\Entity\Pessoal\ContratoServidorPadrao $fkPessoalContratoServidorPadrao)
    {
        if (false === $this->fkPessoalContratoServidorPadroes->contains($fkPessoalContratoServidorPadrao)) {
            $fkPessoalContratoServidorPadrao->setFkFolhapagamentoPadrao($this);
            $this->fkPessoalContratoServidorPadroes->add($fkPessoalContratoServidorPadrao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PessoalContratoServidorPadrao
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\ContratoServidorPadrao $fkPessoalContratoServidorPadrao
     */
    public function removeFkPessoalContratoServidorPadroes(\Urbem\CoreBundle\Entity\Pessoal\ContratoServidorPadrao $fkPessoalContratoServidorPadrao)
    {
        $this->fkPessoalContratoServidorPadroes->removeElement($fkPessoalContratoServidorPadrao);
    }

    /**
     * OneToMany (owning side)
     * Get fkPessoalContratoServidorPadroes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\ContratoServidorPadrao
     */
    public function getFkPessoalContratoServidorPadroes()
    {
        return $this->fkPessoalContratoServidorPadroes;
    }
    
    /**
     * @return string
     */
    public function __toString()
    {
        return (string) $this->getDescricao();
    }
}
