<?php
 
namespace Urbem\CoreBundle\Entity\Arrecadacao;

/**
 * VariaveisLayoutCarne
 */
class VariaveisLayoutCarne
{
    /**
     * PK
     * @var integer
     */
    private $codModelo;

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
     * @var integer
     */
    private $ordem;

    /**
     * @var integer
     */
    private $posicaoInicial;

    /**
     * @var integer
     */
    private $largura;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Arrecadacao\ModeloCarne
     */
    private $fkArrecadacaoModeloCarne;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Administracao\AtributoDinamico
     */
    private $fkAdministracaoAtributoDinamico;


    /**
     * Set codModelo
     *
     * @param integer $codModelo
     * @return VariaveisLayoutCarne
     */
    public function setCodModelo($codModelo)
    {
        $this->codModelo = $codModelo;
        return $this;
    }

    /**
     * Get codModelo
     *
     * @return integer
     */
    public function getCodModelo()
    {
        return $this->codModelo;
    }

    /**
     * Set codModulo
     *
     * @param integer $codModulo
     * @return VariaveisLayoutCarne
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
     * @return VariaveisLayoutCarne
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
     * @return VariaveisLayoutCarne
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
     * Set ordem
     *
     * @param integer $ordem
     * @return VariaveisLayoutCarne
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
     * Set posicaoInicial
     *
     * @param integer $posicaoInicial
     * @return VariaveisLayoutCarne
     */
    public function setPosicaoInicial($posicaoInicial)
    {
        $this->posicaoInicial = $posicaoInicial;
        return $this;
    }

    /**
     * Get posicaoInicial
     *
     * @return integer
     */
    public function getPosicaoInicial()
    {
        return $this->posicaoInicial;
    }

    /**
     * Set largura
     *
     * @param integer $largura
     * @return VariaveisLayoutCarne
     */
    public function setLargura($largura)
    {
        $this->largura = $largura;
        return $this;
    }

    /**
     * Get largura
     *
     * @return integer
     */
    public function getLargura()
    {
        return $this->largura;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkArrecadacaoModeloCarne
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\ModeloCarne $fkArrecadacaoModeloCarne
     * @return VariaveisLayoutCarne
     */
    public function setFkArrecadacaoModeloCarne(\Urbem\CoreBundle\Entity\Arrecadacao\ModeloCarne $fkArrecadacaoModeloCarne)
    {
        $this->codModelo = $fkArrecadacaoModeloCarne->getCodModelo();
        $this->fkArrecadacaoModeloCarne = $fkArrecadacaoModeloCarne;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkArrecadacaoModeloCarne
     *
     * @return \Urbem\CoreBundle\Entity\Arrecadacao\ModeloCarne
     */
    public function getFkArrecadacaoModeloCarne()
    {
        return $this->fkArrecadacaoModeloCarne;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkAdministracaoAtributoDinamico
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\AtributoDinamico $fkAdministracaoAtributoDinamico
     * @return VariaveisLayoutCarne
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
