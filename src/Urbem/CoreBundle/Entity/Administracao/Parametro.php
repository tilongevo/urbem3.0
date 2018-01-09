<?php
 
namespace Urbem\CoreBundle\Entity\Administracao;

/**
 * Parametro
 */
class Parametro
{
    const DEMONSTRAR_SALDO_ESTOQUE = 'demonstrar_saldo_estoque';
    const HOMOLOGACAO_AUTOMATICA_REQUISICAO = 'homologacao_automatica_requisicao';

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
    private $codVariavel;

    /**
     * PK
     * @var integer
     */
    private $ordem;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Administracao\Variavel
     */
    private $fkAdministracaoVariavel;


    /**
     * Set codModulo
     *
     * @param integer $codModulo
     * @return Parametro
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
     * @return Parametro
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
     * @return Parametro
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
     * Set codVariavel
     *
     * @param integer $codVariavel
     * @return Parametro
     */
    public function setCodVariavel($codVariavel)
    {
        $this->codVariavel = $codVariavel;
        return $this;
    }

    /**
     * Get codVariavel
     *
     * @return integer
     */
    public function getCodVariavel()
    {
        return $this->codVariavel;
    }

    /**
     * Set ordem
     *
     * @param integer $ordem
     * @return Parametro
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
     * ManyToOne (inverse side)
     * Set fkAdministracaoVariavel
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\Variavel $fkAdministracaoVariavel
     * @return Parametro
     */
    public function setFkAdministracaoVariavel(\Urbem\CoreBundle\Entity\Administracao\Variavel $fkAdministracaoVariavel)
    {
        $this->codModulo = $fkAdministracaoVariavel->getCodModulo();
        $this->codBiblioteca = $fkAdministracaoVariavel->getCodBiblioteca();
        $this->codFuncao = $fkAdministracaoVariavel->getCodFuncao();
        $this->codVariavel = $fkAdministracaoVariavel->getCodVariavel();
        $this->fkAdministracaoVariavel = $fkAdministracaoVariavel;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkAdministracaoVariavel
     *
     * @return \Urbem\CoreBundle\Entity\Administracao\Variavel
     */
    public function getFkAdministracaoVariavel()
    {
        return $this->fkAdministracaoVariavel;
    }
}
