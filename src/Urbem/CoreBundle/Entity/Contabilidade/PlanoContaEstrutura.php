<?php
 
namespace Urbem\CoreBundle\Entity\Contabilidade;

/**
 * PlanoContaEstrutura
 */
class PlanoContaEstrutura
{
    /**
     * PK
     * @var integer
     */
    private $codUf;

    /**
     * PK
     * @var integer
     */
    private $codPlano;

    /**
     * PK
     * @var string
     */
    private $codigoEstrutural;

    /**
     * @var string
     */
    private $titulo;

    /**
     * @var string
     */
    private $funcao;

    /**
     * @var string
     */
    private $naturezaSaldo;

    /**
     * @var string
     */
    private $escrituracao;

    /**
     * @var string
     */
    private $naturezaInformacao;

    /**
     * @var string
     */
    private $indicadorSuperavit;

    /**
     * @var integer
     */
    private $atributoTcepe;

    /**
     * @var integer
     */
    private $atributoTcemg;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Contabilidade\PlanoContaGeral
     */
    private $fkContabilidadePlanoContaGeral;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Tcepe\TipoContaCorrente
     */
    private $fkTcepeTipoContaCorrente;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Tcemg\TipoContaCorrente
     */
    private $fkTcemgTipoContaCorrente;


    /**
     * Set codUf
     *
     * @param integer $codUf
     * @return PlanoContaEstrutura
     */
    public function setCodUf($codUf)
    {
        $this->codUf = $codUf;
        return $this;
    }

    /**
     * Get codUf
     *
     * @return integer
     */
    public function getCodUf()
    {
        return $this->codUf;
    }

    /**
     * Set codPlano
     *
     * @param integer $codPlano
     * @return PlanoContaEstrutura
     */
    public function setCodPlano($codPlano)
    {
        $this->codPlano = $codPlano;
        return $this;
    }

    /**
     * Get codPlano
     *
     * @return integer
     */
    public function getCodPlano()
    {
        return $this->codPlano;
    }

    /**
     * Set codigoEstrutural
     *
     * @param string $codigoEstrutural
     * @return PlanoContaEstrutura
     */
    public function setCodigoEstrutural($codigoEstrutural)
    {
        $this->codigoEstrutural = $codigoEstrutural;
        return $this;
    }

    /**
     * Get codigoEstrutural
     *
     * @return string
     */
    public function getCodigoEstrutural()
    {
        return $this->codigoEstrutural;
    }

    /**
     * Set titulo
     *
     * @param string $titulo
     * @return PlanoContaEstrutura
     */
    public function setTitulo($titulo)
    {
        $this->titulo = $titulo;
        return $this;
    }

    /**
     * Get titulo
     *
     * @return string
     */
    public function getTitulo()
    {
        return $this->titulo;
    }

    /**
     * Set funcao
     *
     * @param string $funcao
     * @return PlanoContaEstrutura
     */
    public function setFuncao($funcao = null)
    {
        $this->funcao = $funcao;
        return $this;
    }

    /**
     * Get funcao
     *
     * @return string
     */
    public function getFuncao()
    {
        return $this->funcao;
    }

    /**
     * Set naturezaSaldo
     *
     * @param string $naturezaSaldo
     * @return PlanoContaEstrutura
     */
    public function setNaturezaSaldo($naturezaSaldo = null)
    {
        $this->naturezaSaldo = $naturezaSaldo;
        return $this;
    }

    /**
     * Get naturezaSaldo
     *
     * @return string
     */
    public function getNaturezaSaldo()
    {
        return $this->naturezaSaldo;
    }

    /**
     * Set escrituracao
     *
     * @param string $escrituracao
     * @return PlanoContaEstrutura
     */
    public function setEscrituracao($escrituracao)
    {
        $this->escrituracao = $escrituracao;
        return $this;
    }

    /**
     * Get escrituracao
     *
     * @return string
     */
    public function getEscrituracao()
    {
        return $this->escrituracao;
    }

    /**
     * Set naturezaInformacao
     *
     * @param string $naturezaInformacao
     * @return PlanoContaEstrutura
     */
    public function setNaturezaInformacao($naturezaInformacao = null)
    {
        $this->naturezaInformacao = $naturezaInformacao;
        return $this;
    }

    /**
     * Get naturezaInformacao
     *
     * @return string
     */
    public function getNaturezaInformacao()
    {
        return $this->naturezaInformacao;
    }

    /**
     * Set indicadorSuperavit
     *
     * @param string $indicadorSuperavit
     * @return PlanoContaEstrutura
     */
    public function setIndicadorSuperavit($indicadorSuperavit = null)
    {
        $this->indicadorSuperavit = $indicadorSuperavit;
        return $this;
    }

    /**
     * Get indicadorSuperavit
     *
     * @return string
     */
    public function getIndicadorSuperavit()
    {
        return $this->indicadorSuperavit;
    }

    /**
     * Set atributoTcepe
     *
     * @param integer $atributoTcepe
     * @return PlanoContaEstrutura
     */
    public function setAtributoTcepe($atributoTcepe = null)
    {
        $this->atributoTcepe = $atributoTcepe;
        return $this;
    }

    /**
     * Get atributoTcepe
     *
     * @return integer
     */
    public function getAtributoTcepe()
    {
        return $this->atributoTcepe;
    }

    /**
     * Set atributoTcemg
     *
     * @param integer $atributoTcemg
     * @return PlanoContaEstrutura
     */
    public function setAtributoTcemg($atributoTcemg = null)
    {
        $this->atributoTcemg = $atributoTcemg;
        return $this;
    }

    /**
     * Get atributoTcemg
     *
     * @return integer
     */
    public function getAtributoTcemg()
    {
        return $this->atributoTcemg;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkContabilidadePlanoContaGeral
     *
     * @param \Urbem\CoreBundle\Entity\Contabilidade\PlanoContaGeral $fkContabilidadePlanoContaGeral
     * @return PlanoContaEstrutura
     */
    public function setFkContabilidadePlanoContaGeral(\Urbem\CoreBundle\Entity\Contabilidade\PlanoContaGeral $fkContabilidadePlanoContaGeral)
    {
        $this->codUf = $fkContabilidadePlanoContaGeral->getCodUf();
        $this->codPlano = $fkContabilidadePlanoContaGeral->getCodPlano();
        $this->fkContabilidadePlanoContaGeral = $fkContabilidadePlanoContaGeral;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkContabilidadePlanoContaGeral
     *
     * @return \Urbem\CoreBundle\Entity\Contabilidade\PlanoContaGeral
     */
    public function getFkContabilidadePlanoContaGeral()
    {
        return $this->fkContabilidadePlanoContaGeral;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkTcepeTipoContaCorrente
     *
     * @param \Urbem\CoreBundle\Entity\Tcepe\TipoContaCorrente $fkTcepeTipoContaCorrente
     * @return PlanoContaEstrutura
     */
    public function setFkTcepeTipoContaCorrente(\Urbem\CoreBundle\Entity\Tcepe\TipoContaCorrente $fkTcepeTipoContaCorrente)
    {
        $this->atributoTcepe = $fkTcepeTipoContaCorrente->getCodTipo();
        $this->fkTcepeTipoContaCorrente = $fkTcepeTipoContaCorrente;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkTcepeTipoContaCorrente
     *
     * @return \Urbem\CoreBundle\Entity\Tcepe\TipoContaCorrente
     */
    public function getFkTcepeTipoContaCorrente()
    {
        return $this->fkTcepeTipoContaCorrente;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkTcemgTipoContaCorrente
     *
     * @param \Urbem\CoreBundle\Entity\Tcemg\TipoContaCorrente $fkTcemgTipoContaCorrente
     * @return PlanoContaEstrutura
     */
    public function setFkTcemgTipoContaCorrente(\Urbem\CoreBundle\Entity\Tcemg\TipoContaCorrente $fkTcemgTipoContaCorrente)
    {
        $this->atributoTcemg = $fkTcemgTipoContaCorrente->getCodTipo();
        $this->fkTcemgTipoContaCorrente = $fkTcemgTipoContaCorrente;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkTcemgTipoContaCorrente
     *
     * @return \Urbem\CoreBundle\Entity\Tcemg\TipoContaCorrente
     */
    public function getFkTcemgTipoContaCorrente()
    {
        return $this->fkTcemgTipoContaCorrente;
    }
}
