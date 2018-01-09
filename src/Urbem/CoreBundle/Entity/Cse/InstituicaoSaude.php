<?php
 
namespace Urbem\CoreBundle\Entity\Cse;

/**
 * InstituicaoSaude
 */
class InstituicaoSaude
{
    /**
     * PK
     * @var integer
     */
    private $codInstituicao;

    /**
     * @var string
     */
    private $nomInstituicao;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Cse\PrescricaoExame
     */
    private $fkCsePrescricaoExames;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Cse\PrescricaoInternacao
     */
    private $fkCsePrescricaoInternacoes;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkCsePrescricaoExames = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkCsePrescricaoInternacoes = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codInstituicao
     *
     * @param integer $codInstituicao
     * @return InstituicaoSaude
     */
    public function setCodInstituicao($codInstituicao)
    {
        $this->codInstituicao = $codInstituicao;
        return $this;
    }

    /**
     * Get codInstituicao
     *
     * @return integer
     */
    public function getCodInstituicao()
    {
        return $this->codInstituicao;
    }

    /**
     * Set nomInstituicao
     *
     * @param string $nomInstituicao
     * @return InstituicaoSaude
     */
    public function setNomInstituicao($nomInstituicao)
    {
        $this->nomInstituicao = $nomInstituicao;
        return $this;
    }

    /**
     * Get nomInstituicao
     *
     * @return string
     */
    public function getNomInstituicao()
    {
        return $this->nomInstituicao;
    }

    /**
     * OneToMany (owning side)
     * Add CsePrescricaoExame
     *
     * @param \Urbem\CoreBundle\Entity\Cse\PrescricaoExame $fkCsePrescricaoExame
     * @return InstituicaoSaude
     */
    public function addFkCsePrescricaoExames(\Urbem\CoreBundle\Entity\Cse\PrescricaoExame $fkCsePrescricaoExame)
    {
        if (false === $this->fkCsePrescricaoExames->contains($fkCsePrescricaoExame)) {
            $fkCsePrescricaoExame->setFkCseInstituicaoSaude($this);
            $this->fkCsePrescricaoExames->add($fkCsePrescricaoExame);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove CsePrescricaoExame
     *
     * @param \Urbem\CoreBundle\Entity\Cse\PrescricaoExame $fkCsePrescricaoExame
     */
    public function removeFkCsePrescricaoExames(\Urbem\CoreBundle\Entity\Cse\PrescricaoExame $fkCsePrescricaoExame)
    {
        $this->fkCsePrescricaoExames->removeElement($fkCsePrescricaoExame);
    }

    /**
     * OneToMany (owning side)
     * Get fkCsePrescricaoExames
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Cse\PrescricaoExame
     */
    public function getFkCsePrescricaoExames()
    {
        return $this->fkCsePrescricaoExames;
    }

    /**
     * OneToMany (owning side)
     * Add CsePrescricaoInternacao
     *
     * @param \Urbem\CoreBundle\Entity\Cse\PrescricaoInternacao $fkCsePrescricaoInternacao
     * @return InstituicaoSaude
     */
    public function addFkCsePrescricaoInternacoes(\Urbem\CoreBundle\Entity\Cse\PrescricaoInternacao $fkCsePrescricaoInternacao)
    {
        if (false === $this->fkCsePrescricaoInternacoes->contains($fkCsePrescricaoInternacao)) {
            $fkCsePrescricaoInternacao->setFkCseInstituicaoSaude($this);
            $this->fkCsePrescricaoInternacoes->add($fkCsePrescricaoInternacao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove CsePrescricaoInternacao
     *
     * @param \Urbem\CoreBundle\Entity\Cse\PrescricaoInternacao $fkCsePrescricaoInternacao
     */
    public function removeFkCsePrescricaoInternacoes(\Urbem\CoreBundle\Entity\Cse\PrescricaoInternacao $fkCsePrescricaoInternacao)
    {
        $this->fkCsePrescricaoInternacoes->removeElement($fkCsePrescricaoInternacao);
    }

    /**
     * OneToMany (owning side)
     * Get fkCsePrescricaoInternacoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Cse\PrescricaoInternacao
     */
    public function getFkCsePrescricaoInternacoes()
    {
        return $this->fkCsePrescricaoInternacoes;
    }
}
