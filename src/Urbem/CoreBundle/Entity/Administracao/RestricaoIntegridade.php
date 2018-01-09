<?php
 
namespace Urbem\CoreBundle\Entity\Administracao;

/**
 * RestricaoIntegridade
 */
class RestricaoIntegridade
{
    /**
     * PK
     * @var integer
     */
    private $codIntegridade;

    /**
     * @var string
     */
    private $nomIntegridade;

    /**
     * @var string
     */
    private $descricao;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Administracao\AtributoIntegridade
     */
    private $fkAdministracaoAtributoIntegridades;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\SwAtributoIntegridade
     */
    private $fkSwAtributoIntegridades;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkAdministracaoAtributoIntegridades = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkSwAtributoIntegridades = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codIntegridade
     *
     * @param integer $codIntegridade
     * @return RestricaoIntegridade
     */
    public function setCodIntegridade($codIntegridade)
    {
        $this->codIntegridade = $codIntegridade;
        return $this;
    }

    /**
     * Get codIntegridade
     *
     * @return integer
     */
    public function getCodIntegridade()
    {
        return $this->codIntegridade;
    }

    /**
     * Set nomIntegridade
     *
     * @param string $nomIntegridade
     * @return RestricaoIntegridade
     */
    public function setNomIntegridade($nomIntegridade)
    {
        $this->nomIntegridade = $nomIntegridade;
        return $this;
    }

    /**
     * Get nomIntegridade
     *
     * @return string
     */
    public function getNomIntegridade()
    {
        return $this->nomIntegridade;
    }

    /**
     * Set descricao
     *
     * @param string $descricao
     * @return RestricaoIntegridade
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
     * Add AdministracaoAtributoIntegridade
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\AtributoIntegridade $fkAdministracaoAtributoIntegridade
     * @return RestricaoIntegridade
     */
    public function addFkAdministracaoAtributoIntegridades(\Urbem\CoreBundle\Entity\Administracao\AtributoIntegridade $fkAdministracaoAtributoIntegridade)
    {
        if (false === $this->fkAdministracaoAtributoIntegridades->contains($fkAdministracaoAtributoIntegridade)) {
            $fkAdministracaoAtributoIntegridade->setFkAdministracaoRestricaoIntegridade($this);
            $this->fkAdministracaoAtributoIntegridades->add($fkAdministracaoAtributoIntegridade);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove AdministracaoAtributoIntegridade
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\AtributoIntegridade $fkAdministracaoAtributoIntegridade
     */
    public function removeFkAdministracaoAtributoIntegridades(\Urbem\CoreBundle\Entity\Administracao\AtributoIntegridade $fkAdministracaoAtributoIntegridade)
    {
        $this->fkAdministracaoAtributoIntegridades->removeElement($fkAdministracaoAtributoIntegridade);
    }

    /**
     * OneToMany (owning side)
     * Get fkAdministracaoAtributoIntegridades
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Administracao\AtributoIntegridade
     */
    public function getFkAdministracaoAtributoIntegridades()
    {
        return $this->fkAdministracaoAtributoIntegridades;
    }

    /**
     * OneToMany (owning side)
     * Add SwAtributoIntegridade
     *
     * @param \Urbem\CoreBundle\Entity\SwAtributoIntegridade $fkSwAtributoIntegridade
     * @return RestricaoIntegridade
     */
    public function addFkSwAtributoIntegridades(\Urbem\CoreBundle\Entity\SwAtributoIntegridade $fkSwAtributoIntegridade)
    {
        if (false === $this->fkSwAtributoIntegridades->contains($fkSwAtributoIntegridade)) {
            $fkSwAtributoIntegridade->setFkAdministracaoRestricaoIntegridade($this);
            $this->fkSwAtributoIntegridades->add($fkSwAtributoIntegridade);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove SwAtributoIntegridade
     *
     * @param \Urbem\CoreBundle\Entity\SwAtributoIntegridade $fkSwAtributoIntegridade
     */
    public function removeFkSwAtributoIntegridades(\Urbem\CoreBundle\Entity\SwAtributoIntegridade $fkSwAtributoIntegridade)
    {
        $this->fkSwAtributoIntegridades->removeElement($fkSwAtributoIntegridade);
    }

    /**
     * OneToMany (owning side)
     * Get fkSwAtributoIntegridades
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\SwAtributoIntegridade
     */
    public function getFkSwAtributoIntegridades()
    {
        return $this->fkSwAtributoIntegridades;
    }
}
