<?php
 
namespace Urbem\CoreBundle\Entity\Pessoal;

/**
 * CarteiraVacinacao
 */
class CarteiraVacinacao
{
    /**
     * PK
     * @var integer
     */
    private $codCarteira;

    /**
     * @var \DateTime
     */
    private $dtApresentacao;

    /**
     * @var boolean
     */
    private $apresentada;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\DependenteCarteiraVacinacao
     */
    private $fkPessoalDependenteCarteiraVacinacoes;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkPessoalDependenteCarteiraVacinacoes = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codCarteira
     *
     * @param integer $codCarteira
     * @return CarteiraVacinacao
     */
    public function setCodCarteira($codCarteira)
    {
        $this->codCarteira = $codCarteira;
        return $this;
    }

    /**
     * Get codCarteira
     *
     * @return integer
     */
    public function getCodCarteira()
    {
        return $this->codCarteira;
    }

    /**
     * Set dtApresentacao
     *
     * @param \DateTime $dtApresentacao
     * @return CarteiraVacinacao
     */
    public function setDtApresentacao(\DateTime $dtApresentacao)
    {
        $this->dtApresentacao = $dtApresentacao;
        return $this;
    }

    /**
     * Get dtApresentacao
     *
     * @return \DateTime
     */
    public function getDtApresentacao()
    {
        return $this->dtApresentacao;
    }

    /**
     * Set apresentada
     *
     * @param boolean $apresentada
     * @return CarteiraVacinacao
     */
    public function setApresentada($apresentada)
    {
        $this->apresentada = $apresentada;
        return $this;
    }

    /**
     * Get apresentada
     *
     * @return boolean
     */
    public function getApresentada()
    {
        return $this->apresentada;
    }

    /**
     * OneToMany (owning side)
     * Add PessoalDependenteCarteiraVacinacao
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\DependenteCarteiraVacinacao $fkPessoalDependenteCarteiraVacinacao
     * @return CarteiraVacinacao
     */
    public function addFkPessoalDependenteCarteiraVacinacoes(\Urbem\CoreBundle\Entity\Pessoal\DependenteCarteiraVacinacao $fkPessoalDependenteCarteiraVacinacao)
    {
        if (false === $this->fkPessoalDependenteCarteiraVacinacoes->contains($fkPessoalDependenteCarteiraVacinacao)) {
            $fkPessoalDependenteCarteiraVacinacao->setFkPessoalCarteiraVacinacao($this);
            $this->fkPessoalDependenteCarteiraVacinacoes->add($fkPessoalDependenteCarteiraVacinacao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PessoalDependenteCarteiraVacinacao
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\DependenteCarteiraVacinacao $fkPessoalDependenteCarteiraVacinacao
     */
    public function removeFkPessoalDependenteCarteiraVacinacoes(\Urbem\CoreBundle\Entity\Pessoal\DependenteCarteiraVacinacao $fkPessoalDependenteCarteiraVacinacao)
    {
        $this->fkPessoalDependenteCarteiraVacinacoes->removeElement($fkPessoalDependenteCarteiraVacinacao);
    }

    /**
     * OneToMany (owning side)
     * Get fkPessoalDependenteCarteiraVacinacoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\DependenteCarteiraVacinacao
     */
    public function getFkPessoalDependenteCarteiraVacinacoes()
    {
        return $this->fkPessoalDependenteCarteiraVacinacoes;
    }
}
