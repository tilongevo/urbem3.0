<?php
 
namespace Urbem\CoreBundle\Entity\Administracao;

/**
 * Funcionalidade
 */
class Funcionalidade
{
    /**
     * PK
     * @var integer
     */
    private $codFuncionalidade;

    /**
     * @var integer
     */
    private $codModulo;

    /**
     * @var string
     */
    private $nomFuncionalidade;

    /**
     * @var string
     */
    private $nomDiretorio;

    /**
     * @var integer
     */
    private $ordem;

    /**
     * @var boolean
     */
    private $ativo = true;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Administracao\Acao
     */
    private $fkAdministracaoAcoes;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Administracao\Modulo
     */
    private $fkAdministracaoModulo;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkAdministracaoAcoes = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codFuncionalidade
     *
     * @param integer $codFuncionalidade
     * @return Funcionalidade
     */
    public function setCodFuncionalidade($codFuncionalidade)
    {
        $this->codFuncionalidade = $codFuncionalidade;
        return $this;
    }

    /**
     * Get codFuncionalidade
     *
     * @return integer
     */
    public function getCodFuncionalidade()
    {
        return $this->codFuncionalidade;
    }

    /**
     * Set codModulo
     *
     * @param integer $codModulo
     * @return Funcionalidade
     */
    public function setCodModulo($codModulo)
    {
        $this->codModulo = $codModulo;
        return $this;
    }

    /**
     * Get codModulo
     *
     * @return integer
     */
    public function getCodModulo()
    {
        return $this->codModulo;
    }

    /**
     * Set nomFuncionalidade
     *
     * @param string $nomFuncionalidade
     * @return Funcionalidade
     */
    public function setNomFuncionalidade($nomFuncionalidade)
    {
        $this->nomFuncionalidade = $nomFuncionalidade;
        return $this;
    }

    /**
     * Get nomFuncionalidade
     *
     * @return string
     */
    public function getNomFuncionalidade()
    {
        return $this->nomFuncionalidade;
    }

    /**
     * Set nomDiretorio
     *
     * @param string $nomDiretorio
     * @return Funcionalidade
     */
    public function setNomDiretorio($nomDiretorio)
    {
        $this->nomDiretorio = $nomDiretorio;
        return $this;
    }

    /**
     * Get nomDiretorio
     *
     * @return string
     */
    public function getNomDiretorio()
    {
        return $this->nomDiretorio;
    }

    /**
     * Set ordem
     *
     * @param integer $ordem
     * @return Funcionalidade
     */
    public function setOrdem($ordem)
    {
        $this->ordem = $ordem;
        return $this;
    }

    /**
     * Get ordem
     *
     * @return integer
     */
    public function getOrdem()
    {
        return $this->ordem;
    }

    /**
     * Set ativo
     *
     * @param boolean $ativo
     * @return Funcionalidade
     */
    public function setAtivo($ativo)
    {
        $this->ativo = $ativo;
        return $this;
    }

    /**
     * Get ativo
     *
     * @return boolean
     */
    public function getAtivo()
    {
        return $this->ativo;
    }

    /**
     * OneToMany (owning side)
     * Add AdministracaoAcao
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\Acao $fkAdministracaoAcao
     * @return Funcionalidade
     */
    public function addFkAdministracaoAcoes(\Urbem\CoreBundle\Entity\Administracao\Acao $fkAdministracaoAcao)
    {
        if (false === $this->fkAdministracaoAcoes->contains($fkAdministracaoAcao)) {
            $fkAdministracaoAcao->setFkAdministracaoFuncionalidade($this);
            $this->fkAdministracaoAcoes->add($fkAdministracaoAcao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove AdministracaoAcao
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\Acao $fkAdministracaoAcao
     */
    public function removeFkAdministracaoAcoes(\Urbem\CoreBundle\Entity\Administracao\Acao $fkAdministracaoAcao)
    {
        $this->fkAdministracaoAcoes->removeElement($fkAdministracaoAcao);
    }

    /**
     * OneToMany (owning side)
     * Get fkAdministracaoAcoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Administracao\Acao
     */
    public function getFkAdministracaoAcoes()
    {
        return $this->fkAdministracaoAcoes;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkAdministracaoModulo
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\Modulo $fkAdministracaoModulo
     * @return Funcionalidade
     */
    public function setFkAdministracaoModulo(\Urbem\CoreBundle\Entity\Administracao\Modulo $fkAdministracaoModulo)
    {
        $this->codModulo = $fkAdministracaoModulo->getCodModulo();
        $this->fkAdministracaoModulo = $fkAdministracaoModulo;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkAdministracaoModulo
     *
     * @return \Urbem\CoreBundle\Entity\Administracao\Modulo
     */
    public function getFkAdministracaoModulo()
    {
        return $this->fkAdministracaoModulo;
    }
}
