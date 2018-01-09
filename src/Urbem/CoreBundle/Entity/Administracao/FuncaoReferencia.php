<?php
 
namespace Urbem\CoreBundle\Entity\Administracao;

/**
 * FuncaoReferencia
 */
class FuncaoReferencia
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
    private $codModuloExterna;

    /**
     * PK
     * @var integer
     */
    private $codBibliotecaExterna;

    /**
     * PK
     * @var integer
     */
    private $codFuncaoExterna;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Administracao\Funcao
     */
    private $fkAdministracaoFuncao;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Administracao\FuncaoExterna
     */
    private $fkAdministracaoFuncaoExterna;


    /**
     * Set codModulo
     *
     * @param integer $codModulo
     * @return FuncaoReferencia
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
     * @return FuncaoReferencia
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
     * @return FuncaoReferencia
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
     * Set codModuloExterna
     *
     * @param integer $codModuloExterna
     * @return FuncaoReferencia
     */
    public function setCodModuloExterna($codModuloExterna)
    {
        $this->codModuloExterna = $codModuloExterna;
        return $this;
    }

    /**
     * Get codModuloExterna
     *
     * @return integer
     */
    public function getCodModuloExterna()
    {
        return $this->codModuloExterna;
    }

    /**
     * Set codBibliotecaExterna
     *
     * @param integer $codBibliotecaExterna
     * @return FuncaoReferencia
     */
    public function setCodBibliotecaExterna($codBibliotecaExterna)
    {
        $this->codBibliotecaExterna = $codBibliotecaExterna;
        return $this;
    }

    /**
     * Get codBibliotecaExterna
     *
     * @return integer
     */
    public function getCodBibliotecaExterna()
    {
        return $this->codBibliotecaExterna;
    }

    /**
     * Set codFuncaoExterna
     *
     * @param integer $codFuncaoExterna
     * @return FuncaoReferencia
     */
    public function setCodFuncaoExterna($codFuncaoExterna)
    {
        $this->codFuncaoExterna = $codFuncaoExterna;
        return $this;
    }

    /**
     * Get codFuncaoExterna
     *
     * @return integer
     */
    public function getCodFuncaoExterna()
    {
        return $this->codFuncaoExterna;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkAdministracaoFuncao
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\Funcao $fkAdministracaoFuncao
     * @return FuncaoReferencia
     */
    public function setFkAdministracaoFuncao(\Urbem\CoreBundle\Entity\Administracao\Funcao $fkAdministracaoFuncao)
    {
        $this->codModulo = $fkAdministracaoFuncao->getCodModulo();
        $this->codBiblioteca = $fkAdministracaoFuncao->getCodBiblioteca();
        $this->codFuncao = $fkAdministracaoFuncao->getCodFuncao();
        $this->fkAdministracaoFuncao = $fkAdministracaoFuncao;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkAdministracaoFuncao
     *
     * @return \Urbem\CoreBundle\Entity\Administracao\Funcao
     */
    public function getFkAdministracaoFuncao()
    {
        return $this->fkAdministracaoFuncao;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkAdministracaoFuncaoExterna
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\FuncaoExterna $fkAdministracaoFuncaoExterna
     * @return FuncaoReferencia
     */
    public function setFkAdministracaoFuncaoExterna(\Urbem\CoreBundle\Entity\Administracao\FuncaoExterna $fkAdministracaoFuncaoExterna)
    {
        $this->codModuloExterna = $fkAdministracaoFuncaoExterna->getCodModulo();
        $this->codBibliotecaExterna = $fkAdministracaoFuncaoExterna->getCodBiblioteca();
        $this->codFuncaoExterna = $fkAdministracaoFuncaoExterna->getCodFuncao();
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
