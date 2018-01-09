<?php
 
namespace Urbem\CoreBundle\Entity\Administracao;

/**
 * BibliotecaEntidade
 */
class BibliotecaEntidade
{
    /**
     * PK
     * @var integer
     */
    private $codBiblioteca;

    /**
     * PK
     * @var integer
     */
    private $codModulo;

    /**
     * @var string
     */
    private $exercicio;

    /**
     * @var integer
     */
    private $codEntidade;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Administracao\Biblioteca
     */
    private $fkAdministracaoBiblioteca;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Orcamento\Entidade
     */
    private $fkOrcamentoEntidade;


    /**
     * Set codBiblioteca
     *
     * @param integer $codBiblioteca
     * @return BibliotecaEntidade
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
     * Set codModulo
     *
     * @param integer $codModulo
     * @return BibliotecaEntidade
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
     * Set exercicio
     *
     * @param string $exercicio
     * @return BibliotecaEntidade
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
     * Set codEntidade
     *
     * @param integer $codEntidade
     * @return BibliotecaEntidade
     */
    public function setCodEntidade($codEntidade)
    {
        $this->codEntidade = $codEntidade;
        return $this;
    }

    /**
     * Get codEntidade
     *
     * @return integer
     */
    public function getCodEntidade()
    {
        return $this->codEntidade;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkOrcamentoEntidade
     *
     * @param \Urbem\CoreBundle\Entity\Orcamento\Entidade $fkOrcamentoEntidade
     * @return BibliotecaEntidade
     */
    public function setFkOrcamentoEntidade(\Urbem\CoreBundle\Entity\Orcamento\Entidade $fkOrcamentoEntidade)
    {
        $this->exercicio = $fkOrcamentoEntidade->getExercicio();
        $this->codEntidade = $fkOrcamentoEntidade->getCodEntidade();
        $this->fkOrcamentoEntidade = $fkOrcamentoEntidade;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkOrcamentoEntidade
     *
     * @return \Urbem\CoreBundle\Entity\Orcamento\Entidade
     */
    public function getFkOrcamentoEntidade()
    {
        return $this->fkOrcamentoEntidade;
    }

    /**
     * OneToOne (owning side)
     * Set AdministracaoBiblioteca
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\Biblioteca $fkAdministracaoBiblioteca
     * @return BibliotecaEntidade
     */
    public function setFkAdministracaoBiblioteca(\Urbem\CoreBundle\Entity\Administracao\Biblioteca $fkAdministracaoBiblioteca)
    {
        $this->codModulo = $fkAdministracaoBiblioteca->getCodModulo();
        $this->codBiblioteca = $fkAdministracaoBiblioteca->getCodBiblioteca();
        $this->fkAdministracaoBiblioteca = $fkAdministracaoBiblioteca;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkAdministracaoBiblioteca
     *
     * @return \Urbem\CoreBundle\Entity\Administracao\Biblioteca
     */
    public function getFkAdministracaoBiblioteca()
    {
        return $this->fkAdministracaoBiblioteca;
    }
}
