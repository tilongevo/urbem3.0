<?php
 
namespace Urbem\CoreBundle\Entity\Imobiliario;

/**
 * AtributoTipoEdificacaoValor
 */
class AtributoTipoEdificacaoValor
{
    /**
     * PK
     * @var integer
     */
    private $codTipo;

    /**
     * PK
     * @var integer
     */
    private $codConstrucao;

    /**
     * PK
     * @var integer
     */
    private $codAtributo;

    /**
     * PK
     * @var integer
     */
    private $codCadastro;

    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    private $timestamp;

    /**
     * PK
     * @var integer
     */
    private $codModulo;

    /**
     * @var string
     */
    private $valor;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Imobiliario\AtributoTipoEdificacao
     */
    private $fkImobiliarioAtributoTipoEdificacao;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Imobiliario\ConstrucaoEdificacao
     */
    private $fkImobiliarioConstrucaoEdificacao;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
    }

    /**
     * Set codTipo
     *
     * @param integer $codTipo
     * @return AtributoTipoEdificacaoValor
     */
    public function setCodTipo($codTipo)
    {
        $this->codTipo = $codTipo;
        return $this;
    }

    /**
     * Get codTipo
     *
     * @return integer
     */
    public function getCodTipo()
    {
        return $this->codTipo;
    }

    /**
     * Set codConstrucao
     *
     * @param integer $codConstrucao
     * @return AtributoTipoEdificacaoValor
     */
    public function setCodConstrucao($codConstrucao)
    {
        $this->codConstrucao = $codConstrucao;
        return $this;
    }

    /**
     * Get codConstrucao
     *
     * @return integer
     */
    public function getCodConstrucao()
    {
        return $this->codConstrucao;
    }

    /**
     * Set codAtributo
     *
     * @param integer $codAtributo
     * @return AtributoTipoEdificacaoValor
     */
    public function setCodAtributo($codAtributo)
    {
        $this->codAtributo = $codAtributo;
        return $this;
    }

    /**
     * Get codAtributo
     *
     * @return integer
     */
    public function getCodAtributo()
    {
        return $this->codAtributo;
    }

    /**
     * Set codCadastro
     *
     * @param integer $codCadastro
     * @return AtributoTipoEdificacaoValor
     */
    public function setCodCadastro($codCadastro)
    {
        $this->codCadastro = $codCadastro;
        return $this;
    }

    /**
     * Get codCadastro
     *
     * @return integer
     */
    public function getCodCadastro()
    {
        return $this->codCadastro;
    }

    /**
     * Set timestamp
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp
     * @return AtributoTipoEdificacaoValor
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
     * Set codModulo
     *
     * @param integer $codModulo
     * @return AtributoTipoEdificacaoValor
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
     * Set valor
     *
     * @param string $valor
     * @return AtributoTipoEdificacaoValor
     */
    public function setValor($valor)
    {
        $this->valor = $valor;
        return $this;
    }

    /**
     * Get valor
     *
     * @return string
     */
    public function getValor()
    {
        return $this->valor;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkImobiliarioAtributoTipoEdificacao
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\AtributoTipoEdificacao $fkImobiliarioAtributoTipoEdificacao
     * @return AtributoTipoEdificacaoValor
     */
    public function setFkImobiliarioAtributoTipoEdificacao(\Urbem\CoreBundle\Entity\Imobiliario\AtributoTipoEdificacao $fkImobiliarioAtributoTipoEdificacao)
    {
        $this->codTipo = $fkImobiliarioAtributoTipoEdificacao->getCodTipo();
        $this->codAtributo = $fkImobiliarioAtributoTipoEdificacao->getCodAtributo();
        $this->codCadastro = $fkImobiliarioAtributoTipoEdificacao->getCodCadastro();
        $this->codModulo = $fkImobiliarioAtributoTipoEdificacao->getCodModulo();
        $this->fkImobiliarioAtributoTipoEdificacao = $fkImobiliarioAtributoTipoEdificacao;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkImobiliarioAtributoTipoEdificacao
     *
     * @return \Urbem\CoreBundle\Entity\Imobiliario\AtributoTipoEdificacao
     */
    public function getFkImobiliarioAtributoTipoEdificacao()
    {
        return $this->fkImobiliarioAtributoTipoEdificacao;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkImobiliarioConstrucaoEdificacao
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\ConstrucaoEdificacao $fkImobiliarioConstrucaoEdificacao
     * @return AtributoTipoEdificacaoValor
     */
    public function setFkImobiliarioConstrucaoEdificacao(\Urbem\CoreBundle\Entity\Imobiliario\ConstrucaoEdificacao $fkImobiliarioConstrucaoEdificacao)
    {
        $this->codTipo = $fkImobiliarioConstrucaoEdificacao->getCodTipo();
        $this->codConstrucao = $fkImobiliarioConstrucaoEdificacao->getCodConstrucao();
        $this->fkImobiliarioConstrucaoEdificacao = $fkImobiliarioConstrucaoEdificacao;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkImobiliarioConstrucaoEdificacao
     *
     * @return \Urbem\CoreBundle\Entity\Imobiliario\ConstrucaoEdificacao
     */
    public function getFkImobiliarioConstrucaoEdificacao()
    {
        return $this->fkImobiliarioConstrucaoEdificacao;
    }
}
