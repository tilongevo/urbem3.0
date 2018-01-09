<?php
 
namespace Urbem\CoreBundle\Entity\Pessoal;

/**
 * AssentamentoVinculadoFuncao
 */
class AssentamentoVinculadoFuncao
{
    /**
     * PK
     * @var integer
     */
    private $codCondicao;

    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    private $timestamp;

    /**
     * PK
     * @var integer
     */
    private $codAssentamento;

    /**
     * PK
     * @var integer
     */
    private $codAssentamentoAssentamento;

    /**
     * @var integer
     */
    private $codFuncao;

    /**
     * @var string
     */
    private $condicao;

    /**
     * @var integer
     */
    private $diasIncidencia;

    /**
     * @var integer
     */
    private $diasProtelarAverbar;

    /**
     * @var integer
     */
    private $codModulo;

    /**
     * @var integer
     */
    private $codBiblioteca;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Pessoal\AssentamentoVinculado
     */
    private $fkPessoalAssentamentoVinculado;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Administracao\Funcao
     */
    private $fkAdministracaoFuncao;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
    }

    /**
     * Set codCondicao
     *
     * @param integer $codCondicao
     * @return AssentamentoVinculadoFuncao
     */
    public function setCodCondicao($codCondicao)
    {
        $this->codCondicao = $codCondicao;
        return $this;
    }

    /**
     * Get codCondicao
     *
     * @return integer
     */
    public function getCodCondicao()
    {
        return $this->codCondicao;
    }

    /**
     * Set timestamp
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp
     * @return AssentamentoVinculadoFuncao
     */
    public function setTimestamp(\Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp)
    {
        $this->timestamp = $timestamp;
        return $this;
    }

    /**
     * Get timestamp
     *
     * @return \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }

    /**
     * Set codAssentamento
     *
     * @param integer $codAssentamento
     * @return AssentamentoVinculadoFuncao
     */
    public function setCodAssentamento($codAssentamento)
    {
        $this->codAssentamento = $codAssentamento;
        return $this;
    }

    /**
     * Get codAssentamento
     *
     * @return integer
     */
    public function getCodAssentamento()
    {
        return $this->codAssentamento;
    }

    /**
     * Set codAssentamentoAssentamento
     *
     * @param integer $codAssentamentoAssentamento
     * @return AssentamentoVinculadoFuncao
     */
    public function setCodAssentamentoAssentamento($codAssentamentoAssentamento)
    {
        $this->codAssentamentoAssentamento = $codAssentamentoAssentamento;
        return $this;
    }

    /**
     * Get codAssentamentoAssentamento
     *
     * @return integer
     */
    public function getCodAssentamentoAssentamento()
    {
        return $this->codAssentamentoAssentamento;
    }

    /**
     * Set codFuncao
     *
     * @param integer $codFuncao
     * @return AssentamentoVinculadoFuncao
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
     * Set condicao
     *
     * @param string $condicao
     * @return AssentamentoVinculadoFuncao
     */
    public function setCondicao($condicao)
    {
        $this->condicao = $condicao;
        return $this;
    }

    /**
     * Get condicao
     *
     * @return string
     */
    public function getCondicao()
    {
        return $this->condicao;
    }

    /**
     * Set diasIncidencia
     *
     * @param integer $diasIncidencia
     * @return AssentamentoVinculadoFuncao
     */
    public function setDiasIncidencia($diasIncidencia)
    {
        $this->diasIncidencia = $diasIncidencia;
        return $this;
    }

    /**
     * Get diasIncidencia
     *
     * @return integer
     */
    public function getDiasIncidencia()
    {
        return $this->diasIncidencia;
    }

    /**
     * Set diasProtelarAverbar
     *
     * @param integer $diasProtelarAverbar
     * @return AssentamentoVinculadoFuncao
     */
    public function setDiasProtelarAverbar($diasProtelarAverbar)
    {
        $this->diasProtelarAverbar = $diasProtelarAverbar;
        return $this;
    }

    /**
     * Get diasProtelarAverbar
     *
     * @return integer
     */
    public function getDiasProtelarAverbar()
    {
        return $this->diasProtelarAverbar;
    }

    /**
     * Set codModulo
     *
     * @param integer $codModulo
     * @return AssentamentoVinculadoFuncao
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
     * @return AssentamentoVinculadoFuncao
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
     * ManyToOne (inverse side)
     * Set fkPessoalAssentamentoVinculado
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\AssentamentoVinculado $fkPessoalAssentamentoVinculado
     * @return AssentamentoVinculadoFuncao
     */
    public function setFkPessoalAssentamentoVinculado(\Urbem\CoreBundle\Entity\Pessoal\AssentamentoVinculado $fkPessoalAssentamentoVinculado)
    {
        $this->codCondicao = $fkPessoalAssentamentoVinculado->getCodCondicao();
        $this->codAssentamento = $fkPessoalAssentamentoVinculado->getCodAssentamento();
        $this->codAssentamentoAssentamento = $fkPessoalAssentamentoVinculado->getCodAssentamentoAssentamento();
        $this->timestamp = $fkPessoalAssentamentoVinculado->getTimestamp();
        $this->condicao = $fkPessoalAssentamentoVinculado->getCondicao();
        $this->diasIncidencia = $fkPessoalAssentamentoVinculado->getDiasIncidencia();
        $this->diasProtelarAverbar = $fkPessoalAssentamentoVinculado->getDiasProtelarAverbar();
        $this->fkPessoalAssentamentoVinculado = $fkPessoalAssentamentoVinculado;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkPessoalAssentamentoVinculado
     *
     * @return \Urbem\CoreBundle\Entity\Pessoal\AssentamentoVinculado
     */
    public function getFkPessoalAssentamentoVinculado()
    {
        return $this->fkPessoalAssentamentoVinculado;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkAdministracaoFuncao
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\Funcao $fkAdministracaoFuncao
     * @return AssentamentoVinculadoFuncao
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
}
