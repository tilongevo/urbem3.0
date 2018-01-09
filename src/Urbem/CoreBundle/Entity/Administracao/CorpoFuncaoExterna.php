<?php
 
namespace Urbem\CoreBundle\Entity\Administracao;

/**
 * CorpoFuncaoExterna
 */
class CorpoFuncaoExterna
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
     * PK
     * @var integer
     */
    private $codFuncao;

    /**
     * PK
     * @var integer
     */
    private $codLinha;

    /**
     * @var integer
     */
    private $nivel;

    /**
     * @var string
     */
    private $linha;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Administracao\FuncaoExterna
     */
    private $fkAdministracaoFuncaoExterna;


    /**
     * Set codModulo
     *
     * @param integer $codModulo
     * @return CorpoFuncaoExterna
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
     * @return CorpoFuncaoExterna
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
     * Set codFuncao
     *
     * @param integer $codFuncao
     * @return CorpoFuncaoExterna
     */
    public function setCodFuncao($codFuncao)
    {
        $this->codFuncao = $codFuncao;
        return $this;
    }

    /**
     * Get codFuncao
     *
     * @return integer
     */
    public function getCodFuncao()
    {
        return $this->codFuncao;
    }

    /**
     * Set codLinha
     *
     * @param integer $codLinha
     * @return CorpoFuncaoExterna
     */
    public function setCodLinha($codLinha)
    {
        $this->codLinha = $codLinha;
        return $this;
    }

    /**
     * Get codLinha
     *
     * @return integer
     */
    public function getCodLinha()
    {
        return $this->codLinha;
    }

    /**
     * Set nivel
     *
     * @param integer $nivel
     * @return CorpoFuncaoExterna
     */
    public function setNivel($nivel = null)
    {
        $this->nivel = $nivel;
        return $this;
    }

    /**
     * Get nivel
     *
     * @return integer
     */
    public function getNivel()
    {
        return $this->nivel;
    }

    /**
     * Set linha
     *
     * @param string $linha
     * @return CorpoFuncaoExterna
     */
    public function setLinha($linha = null)
    {
        $this->linha = $linha;
        return $this;
    }

    /**
     * Get linha
     *
     * @return string
     */
    public function getLinha()
    {
        return $this->linha;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkAdministracaoFuncaoExterna
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\FuncaoExterna $fkAdministracaoFuncaoExterna
     * @return CorpoFuncaoExterna
     */
    public function setFkAdministracaoFuncaoExterna(\Urbem\CoreBundle\Entity\Administracao\FuncaoExterna $fkAdministracaoFuncaoExterna)
    {
        $this->codModulo = $fkAdministracaoFuncaoExterna->getCodModulo();
        $this->codBiblioteca = $fkAdministracaoFuncaoExterna->getCodBiblioteca();
        $this->codFuncao = $fkAdministracaoFuncaoExterna->getCodFuncao();
        $this->fkAdministracaoFuncaoExterna = $fkAdministracaoFuncaoExterna;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkAdministracaoFuncaoExterna
     *
     * @return \Urbem\CoreBundle\Entity\Administracao\FuncaoExterna
     */
    public function getFkAdministracaoFuncaoExterna()
    {
        return $this->fkAdministracaoFuncaoExterna;
    }
}
