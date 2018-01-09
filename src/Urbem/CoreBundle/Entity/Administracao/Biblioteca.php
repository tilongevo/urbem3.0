<?php
 
namespace Urbem\CoreBundle\Entity\Administracao;

/**
 * Biblioteca
 */
class Biblioteca
{
    /**
     * PK
     * @var integer
     */
    private $codModulo;

    /**
     * PK
     * @var integer
     */
    private $codBiblioteca;

    /**
     * @var string
     */
    private $nomBiblioteca;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Administracao\BibliotecaEntidade
     */
    private $fkAdministracaoBibliotecaEntidade;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Administracao\Funcao
     */
    private $fkAdministracaoFuncoes;

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
        $this->fkAdministracaoFuncoes = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codModulo
     *
     * @param integer $codModulo
     * @return Biblioteca
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
     * Set codBiblioteca
     *
     * @param integer $codBiblioteca
     * @return Biblioteca
     */
    public function setCodBiblioteca($codBiblioteca)
    {
        $this->codBiblioteca = $codBiblioteca;
        return $this;
    }

    /**
     * Get codBiblioteca
     *
     * @return integer
     */
    public function getCodBiblioteca()
    {
        return $this->codBiblioteca;
    }

    /**
     * Set nomBiblioteca
     *
     * @param string $nomBiblioteca
     * @return Biblioteca
     */
    public function setNomBiblioteca($nomBiblioteca)
    {
        $this->nomBiblioteca = $nomBiblioteca;
        return $this;
    }

    /**
     * Get nomBiblioteca
     *
     * @return string
     */
    public function getNomBiblioteca()
    {
        return $this->nomBiblioteca;
    }

    /**
     * OneToMany (owning side)
     * Add AdministracaoFuncao
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\Funcao $fkAdministracaoFuncao
     * @return Biblioteca
     */
    public function addFkAdministracaoFuncoes(\Urbem\CoreBundle\Entity\Administracao\Funcao $fkAdministracaoFuncao)
    {
        if (false === $this->fkAdministracaoFuncoes->contains($fkAdministracaoFuncao)) {
            $fkAdministracaoFuncao->setFkAdministracaoBiblioteca($this);
            $this->fkAdministracaoFuncoes->add($fkAdministracaoFuncao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove AdministracaoFuncao
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\Funcao $fkAdministracaoFuncao
     */
    public function removeFkAdministracaoFuncoes(\Urbem\CoreBundle\Entity\Administracao\Funcao $fkAdministracaoFuncao)
    {
        $this->fkAdministracaoFuncoes->removeElement($fkAdministracaoFuncao);
    }

    /**
     * OneToMany (owning side)
     * Get fkAdministracaoFuncoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Administracao\Funcao
     */
    public function getFkAdministracaoFuncoes()
    {
        return $this->fkAdministracaoFuncoes;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkAdministracaoModulo
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\Modulo $fkAdministracaoModulo
     * @return Biblioteca
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

    /**
     * OneToOne (inverse side)
     * Set AdministracaoBibliotecaEntidade
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\BibliotecaEntidade $fkAdministracaoBibliotecaEntidade
     * @return Biblioteca
     */
    public function setFkAdministracaoBibliotecaEntidade(\Urbem\CoreBundle\Entity\Administracao\BibliotecaEntidade $fkAdministracaoBibliotecaEntidade)
    {
        $fkAdministracaoBibliotecaEntidade->setFkAdministracaoBiblioteca($this);
        $this->fkAdministracaoBibliotecaEntidade = $fkAdministracaoBibliotecaEntidade;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkAdministracaoBibliotecaEntidade
     *
     * @return \Urbem\CoreBundle\Entity\Administracao\BibliotecaEntidade
     */
    public function getFkAdministracaoBibliotecaEntidade()
    {
        return $this->fkAdministracaoBibliotecaEntidade;
    }
}
