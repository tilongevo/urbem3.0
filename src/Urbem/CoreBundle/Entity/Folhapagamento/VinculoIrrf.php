<?php
 
namespace Urbem\CoreBundle\Entity\Folhapagamento;

/**
 * VinculoIrrf
 */
class VinculoIrrf
{
    /**
     * PK
     * @var integer
     */
    private $codVinculo;

    /**
     * @var string
     */
    private $descricao;

    /**
     * @var integer
     */
    private $idadeLimite;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\Dependente
     */
    private $fkPessoalDependentes;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkPessoalDependentes = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codVinculo
     *
     * @param integer $codVinculo
     * @return VinculoIrrf
     */
    public function setCodVinculo($codVinculo)
    {
        $this->codVinculo = $codVinculo;
        return $this;
    }

    /**
     * Get codVinculo
     *
     * @return integer
     */
    public function getCodVinculo()
    {
        return $this->codVinculo;
    }

    /**
     * Set descricao
     *
     * @param string $descricao
     * @return VinculoIrrf
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
     * Set idadeLimite
     *
     * @param integer $idadeLimite
     * @return VinculoIrrf
     */
    public function setIdadeLimite($idadeLimite)
    {
        $this->idadeLimite = $idadeLimite;
        return $this;
    }

    /**
     * Get idadeLimite
     *
     * @return integer
     */
    public function getIdadeLimite()
    {
        return $this->idadeLimite;
    }

    /**
     * OneToMany (owning side)
     * Add PessoalDependente
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\Dependente $fkPessoalDependente
     * @return VinculoIrrf
     */
    public function addFkPessoalDependentes(\Urbem\CoreBundle\Entity\Pessoal\Dependente $fkPessoalDependente)
    {
        if (false === $this->fkPessoalDependentes->contains($fkPessoalDependente)) {
            $fkPessoalDependente->setFkFolhapagamentoVinculoIrrf($this);
            $this->fkPessoalDependentes->add($fkPessoalDependente);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PessoalDependente
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\Dependente $fkPessoalDependente
     */
    public function removeFkPessoalDependentes(\Urbem\CoreBundle\Entity\Pessoal\Dependente $fkPessoalDependente)
    {
        $this->fkPessoalDependentes->removeElement($fkPessoalDependente);
    }

    /**
     * OneToMany (owning side)
     * Get fkPessoalDependentes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\Dependente
     */
    public function getFkPessoalDependentes()
    {
        return $this->fkPessoalDependentes;
    }
}
