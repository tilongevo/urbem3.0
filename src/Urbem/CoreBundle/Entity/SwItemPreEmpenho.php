<?php
 
namespace Urbem\CoreBundle\Entity;

/**
 * SwItemPreEmpenho
 */
class SwItemPreEmpenho
{
    /**
     * PK
     * @var integer
     */
    private $codPreEmpenho;

    /**
     * PK
     * @var string
     */
    private $exercicio;

    /**
     * PK
     * @var integer
     */
    private $numItem;

    /**
     * @var integer
     */
    private $codGrandeza;

    /**
     * @var integer
     */
    private $codUnidade;

    /**
     * @var integer
     */
    private $quantidade;

    /**
     * @var string
     */
    private $nomUnidade;

    /**
     * @var integer
     */
    private $vlTotal;

    /**
     * @var string
     */
    private $nomItem;

    /**
     * @var string
     */
    private $complemento;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\SwItemPreEmpenhoCompra
     */
    private $fkSwItemPreEmpenhoCompra;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\SwPreEmpenho
     */
    private $fkSwPreEmpenho;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Administracao\UnidadeMedida
     */
    private $fkAdministracaoUnidadeMedida;


    /**
     * Set codPreEmpenho
     *
     * @param integer $codPreEmpenho
     * @return SwItemPreEmpenho
     */
    public function setCodPreEmpenho($codPreEmpenho)
    {
        $this->codPreEmpenho = $codPreEmpenho;
        return $this;
    }

    /**
     * Get codPreEmpenho
     *
     * @return integer
     */
    public function getCodPreEmpenho()
    {
        return $this->codPreEmpenho;
    }

    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return SwItemPreEmpenho
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
     * Set numItem
     *
     * @param integer $numItem
     * @return SwItemPreEmpenho
     */
    public function setNumItem($numItem)
    {
        $this->numItem = $numItem;
        return $this;
    }

    /**
     * Get numItem
     *
     * @return integer
     */
    public function getNumItem()
    {
        return $this->numItem;
    }

    /**
     * Set codGrandeza
     *
     * @param integer $codGrandeza
     * @return SwItemPreEmpenho
     */
    public function setCodGrandeza($codGrandeza)
    {
        $this->codGrandeza = $codGrandeza;
        return $this;
    }

    /**
     * Get codGrandeza
     *
     * @return integer
     */
    public function getCodGrandeza()
    {
        return $this->codGrandeza;
    }

    /**
     * Set codUnidade
     *
     * @param integer $codUnidade
     * @return SwItemPreEmpenho
     */
    public function setCodUnidade($codUnidade)
    {
        $this->codUnidade = $codUnidade;
        return $this;
    }

    /**
     * Get codUnidade
     *
     * @return integer
     */
    public function getCodUnidade()
    {
        return $this->codUnidade;
    }

    /**
     * Set quantidade
     *
     * @param integer $quantidade
     * @return SwItemPreEmpenho
     */
    public function setQuantidade($quantidade)
    {
        $this->quantidade = $quantidade;
        return $this;
    }

    /**
     * Get quantidade
     *
     * @return integer
     */
    public function getQuantidade()
    {
        return $this->quantidade;
    }

    /**
     * Set nomUnidade
     *
     * @param string $nomUnidade
     * @return SwItemPreEmpenho
     */
    public function setNomUnidade($nomUnidade)
    {
        $this->nomUnidade = $nomUnidade;
        return $this;
    }

    /**
     * Get nomUnidade
     *
     * @return string
     */
    public function getNomUnidade()
    {
        return $this->nomUnidade;
    }

    /**
     * Set vlTotal
     *
     * @param integer $vlTotal
     * @return SwItemPreEmpenho
     */
    public function setVlTotal($vlTotal)
    {
        $this->vlTotal = $vlTotal;
        return $this;
    }

    /**
     * Get vlTotal
     *
     * @return integer
     */
    public function getVlTotal()
    {
        return $this->vlTotal;
    }

    /**
     * Set nomItem
     *
     * @param string $nomItem
     * @return SwItemPreEmpenho
     */
    public function setNomItem($nomItem)
    {
        $this->nomItem = $nomItem;
        return $this;
    }

    /**
     * Get nomItem
     *
     * @return string
     */
    public function getNomItem()
    {
        return $this->nomItem;
    }

    /**
     * Set complemento
     *
     * @param string $complemento
     * @return SwItemPreEmpenho
     */
    public function setComplemento($complemento)
    {
        $this->complemento = $complemento;
        return $this;
    }

    /**
     * Get complemento
     *
     * @return string
     */
    public function getComplemento()
    {
        return $this->complemento;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkSwPreEmpenho
     *
     * @param \Urbem\CoreBundle\Entity\SwPreEmpenho $fkSwPreEmpenho
     * @return SwItemPreEmpenho
     */
    public function setFkSwPreEmpenho(\Urbem\CoreBundle\Entity\SwPreEmpenho $fkSwPreEmpenho)
    {
        $this->codPreEmpenho = $fkSwPreEmpenho->getCodPreEmpenho();
        $this->exercicio = $fkSwPreEmpenho->getExercicio();
        $this->fkSwPreEmpenho = $fkSwPreEmpenho;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkSwPreEmpenho
     *
     * @return \Urbem\CoreBundle\Entity\SwPreEmpenho
     */
    public function getFkSwPreEmpenho()
    {
        return $this->fkSwPreEmpenho;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkAdministracaoUnidadeMedida
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\UnidadeMedida $fkAdministracaoUnidadeMedida
     * @return SwItemPreEmpenho
     */
    public function setFkAdministracaoUnidadeMedida(\Urbem\CoreBundle\Entity\Administracao\UnidadeMedida $fkAdministracaoUnidadeMedida)
    {
        $this->codUnidade = $fkAdministracaoUnidadeMedida->getCodUnidade();
        $this->codGrandeza = $fkAdministracaoUnidadeMedida->getCodGrandeza();
        $this->fkAdministracaoUnidadeMedida = $fkAdministracaoUnidadeMedida;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkAdministracaoUnidadeMedida
     *
     * @return \Urbem\CoreBundle\Entity\Administracao\UnidadeMedida
     */
    public function getFkAdministracaoUnidadeMedida()
    {
        return $this->fkAdministracaoUnidadeMedida;
    }

    /**
     * OneToOne (inverse side)
     * Set SwItemPreEmpenhoCompra
     *
     * @param \Urbem\CoreBundle\Entity\SwItemPreEmpenhoCompra $fkSwItemPreEmpenhoCompra
     * @return SwItemPreEmpenho
     */
    public function setFkSwItemPreEmpenhoCompra(\Urbem\CoreBundle\Entity\SwItemPreEmpenhoCompra $fkSwItemPreEmpenhoCompra)
    {
        $fkSwItemPreEmpenhoCompra->setFkSwItemPreEmpenho($this);
        $this->fkSwItemPreEmpenhoCompra = $fkSwItemPreEmpenhoCompra;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkSwItemPreEmpenhoCompra
     *
     * @return \Urbem\CoreBundle\Entity\SwItemPreEmpenhoCompra
     */
    public function getFkSwItemPreEmpenhoCompra()
    {
        return $this->fkSwItemPreEmpenhoCompra;
    }
}
