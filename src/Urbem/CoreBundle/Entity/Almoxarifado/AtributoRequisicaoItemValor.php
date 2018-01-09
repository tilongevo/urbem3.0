<?php
 
namespace Urbem\CoreBundle\Entity\Almoxarifado;

/**
 * AtributoRequisicaoItemValor
 */
class AtributoRequisicaoItemValor
{
    /**
     * PK
     * @var string
     */
    private $exercicio;

    /**
     * PK
     * @var integer
     */
    private $codAlmoxarifado;

    /**
     * PK
     * @var integer
     */
    private $codRequisicao;

    /**
     * PK
     * @var integer
     */
    private $codItem;

    /**
     * PK
     * @var integer
     */
    private $codMarca;

    /**
     * PK
     * @var integer
     */
    private $codCentro;

    /**
     * PK
     * @var integer
     */
    private $codSequencial;

    /**
     * PK
     * @var integer
     */
    private $codModulo;

    /**
     * PK
     * @var integer
     */
    private $codCadastro;

    /**
     * PK
     * @var integer
     */
    private $codAtributo;

    /**
     * @var string
     */
    private $valor;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Almoxarifado\AtributoRequisicaoItem
     */
    private $fkAlmoxarifadoAtributoRequisicaoItem;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Administracao\AtributoDinamico
     */
    private $fkAdministracaoAtributoDinamico;


    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return AtributoRequisicaoItemValor
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
     * Set codAlmoxarifado
     *
     * @param integer $codAlmoxarifado
     * @return AtributoRequisicaoItemValor
     */
    public function setCodAlmoxarifado($codAlmoxarifado)
    {
        $this->codAlmoxarifado = $codAlmoxarifado;
        return $this;
    }

    /**
     * Get codAlmoxarifado
     *
     * @return integer
     */
    public function getCodAlmoxarifado()
    {
        return $this->codAlmoxarifado;
    }

    /**
     * Set codRequisicao
     *
     * @param integer $codRequisicao
     * @return AtributoRequisicaoItemValor
     */
    public function setCodRequisicao($codRequisicao)
    {
        $this->codRequisicao = $codRequisicao;
        return $this;
    }

    /**
     * Get codRequisicao
     *
     * @return integer
     */
    public function getCodRequisicao()
    {
        return $this->codRequisicao;
    }

    /**
     * Set codItem
     *
     * @param integer $codItem
     * @return AtributoRequisicaoItemValor
     */
    public function setCodItem($codItem)
    {
        $this->codItem = $codItem;
        return $this;
    }

    /**
     * Get codItem
     *
     * @return integer
     */
    public function getCodItem()
    {
        return $this->codItem;
    }

    /**
     * Set codMarca
     *
     * @param integer $codMarca
     * @return AtributoRequisicaoItemValor
     */
    public function setCodMarca($codMarca)
    {
        $this->codMarca = $codMarca;
        return $this;
    }

    /**
     * Get codMarca
     *
     * @return integer
     */
    public function getCodMarca()
    {
        return $this->codMarca;
    }

    /**
     * Set codCentro
     *
     * @param integer $codCentro
     * @return AtributoRequisicaoItemValor
     */
    public function setCodCentro($codCentro)
    {
        $this->codCentro = $codCentro;
        return $this;
    }

    /**
     * Get codCentro
     *
     * @return integer
     */
    public function getCodCentro()
    {
        return $this->codCentro;
    }

    /**
     * Set codSequencial
     *
     * @param integer $codSequencial
     * @return AtributoRequisicaoItemValor
     */
    public function setCodSequencial($codSequencial)
    {
        $this->codSequencial = $codSequencial;
        return $this;
    }

    /**
     * Get codSequencial
     *
     * @return integer
     */
    public function getCodSequencial()
    {
        return $this->codSequencial;
    }

    /**
     * Set codModulo
     *
     * @param integer $codModulo
     * @return AtributoRequisicaoItemValor
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
     * Set codCadastro
     *
     * @param integer $codCadastro
     * @return AtributoRequisicaoItemValor
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
     * Set codAtributo
     *
     * @param integer $codAtributo
     * @return AtributoRequisicaoItemValor
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
     * Set valor
     *
     * @param string $valor
     * @return AtributoRequisicaoItemValor
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
     * Set fkAlmoxarifadoAtributoRequisicaoItem
     *
     * @param \Urbem\CoreBundle\Entity\Almoxarifado\AtributoRequisicaoItem $fkAlmoxarifadoAtributoRequisicaoItem
     * @return AtributoRequisicaoItemValor
     */
    public function setFkAlmoxarifadoAtributoRequisicaoItem(\Urbem\CoreBundle\Entity\Almoxarifado\AtributoRequisicaoItem $fkAlmoxarifadoAtributoRequisicaoItem)
    {
        $this->exercicio = $fkAlmoxarifadoAtributoRequisicaoItem->getExercicio();
        $this->codAlmoxarifado = $fkAlmoxarifadoAtributoRequisicaoItem->getCodAlmoxarifado();
        $this->codRequisicao = $fkAlmoxarifadoAtributoRequisicaoItem->getCodRequisicao();
        $this->codItem = $fkAlmoxarifadoAtributoRequisicaoItem->getCodItem();
        $this->codMarca = $fkAlmoxarifadoAtributoRequisicaoItem->getCodMarca();
        $this->codCentro = $fkAlmoxarifadoAtributoRequisicaoItem->getCodCentro();
        $this->codSequencial = $fkAlmoxarifadoAtributoRequisicaoItem->getCodSequencial();
        $this->fkAlmoxarifadoAtributoRequisicaoItem = $fkAlmoxarifadoAtributoRequisicaoItem;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkAlmoxarifadoAtributoRequisicaoItem
     *
     * @return \Urbem\CoreBundle\Entity\Almoxarifado\AtributoRequisicaoItem
     */
    public function getFkAlmoxarifadoAtributoRequisicaoItem()
    {
        return $this->fkAlmoxarifadoAtributoRequisicaoItem;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkAdministracaoAtributoDinamico
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\AtributoDinamico $fkAdministracaoAtributoDinamico
     * @return AtributoRequisicaoItemValor
     */
    public function setFkAdministracaoAtributoDinamico(\Urbem\CoreBundle\Entity\Administracao\AtributoDinamico $fkAdministracaoAtributoDinamico)
    {
        $this->codModulo = $fkAdministracaoAtributoDinamico->getCodModulo();
        $this->codCadastro = $fkAdministracaoAtributoDinamico->getCodCadastro();
        $this->codAtributo = $fkAdministracaoAtributoDinamico->getCodAtributo();
        $this->fkAdministracaoAtributoDinamico = $fkAdministracaoAtributoDinamico;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkAdministracaoAtributoDinamico
     *
     * @return \Urbem\CoreBundle\Entity\Administracao\AtributoDinamico
     */
    public function getFkAdministracaoAtributoDinamico()
    {
        return $this->fkAdministracaoAtributoDinamico;
    }
}
