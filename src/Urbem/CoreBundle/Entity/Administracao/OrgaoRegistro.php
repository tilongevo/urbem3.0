<?php
 
namespace Urbem\CoreBundle\Entity\Administracao;

/**
 * OrgaoRegistro
 */
class OrgaoRegistro
{
    /**
     * PK
     * @var integer
     */
    private $codigo;

    /**
     * @var string
     */
    private $descricao;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\SwCgmPessoaJuridica
     */
    private $fkSwCgmPessoaJuridicas;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkSwCgmPessoaJuridicas = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codigo
     *
     * @param integer $codigo
     * @return OrgaoRegistro
     */
    public function setCodigo($codigo)
    {
        $this->codigo = $codigo;
        return $this;
    }

    /**
     * Get codigo
     *
     * @return integer
     */
    public function getCodigo()
    {
        return $this->codigo;
    }

    /**
     * Set descricao
     *
     * @param string $descricao
     * @return OrgaoRegistro
     */
    public function setDescricao($descricao = null)
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
     * Add SwCgmPessoaJuridica
     *
     * @param \Urbem\CoreBundle\Entity\SwCgmPessoaJuridica $fkSwCgmPessoaJuridica
     * @return OrgaoRegistro
     */
    public function addFkSwCgmPessoaJuridicas(\Urbem\CoreBundle\Entity\SwCgmPessoaJuridica $fkSwCgmPessoaJuridica)
    {
        if (false === $this->fkSwCgmPessoaJuridicas->contains($fkSwCgmPessoaJuridica)) {
            $fkSwCgmPessoaJuridica->setFkAdministracaoOrgaoRegistro($this);
            $this->fkSwCgmPessoaJuridicas->add($fkSwCgmPessoaJuridica);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove SwCgmPessoaJuridica
     *
     * @param \Urbem\CoreBundle\Entity\SwCgmPessoaJuridica $fkSwCgmPessoaJuridica
     */
    public function removeFkSwCgmPessoaJuridicas(\Urbem\CoreBundle\Entity\SwCgmPessoaJuridica $fkSwCgmPessoaJuridica)
    {
        $this->fkSwCgmPessoaJuridicas->removeElement($fkSwCgmPessoaJuridica);
    }

    /**
     * OneToMany (owning side)
     * Get fkSwCgmPessoaJuridicas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\SwCgmPessoaJuridica
     */
    public function getFkSwCgmPessoaJuridicas()
    {
        return $this->fkSwCgmPessoaJuridicas;
    }
}
