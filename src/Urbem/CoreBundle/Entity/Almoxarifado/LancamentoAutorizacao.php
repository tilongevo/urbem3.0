<?php
 
namespace Urbem\CoreBundle\Entity\Almoxarifado;

/**
 * LancamentoAutorizacao
 */
class LancamentoAutorizacao
{
    /**
     * PK
     * @var integer
     */
    private $codLancamento;

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
    private $codAlmoxarifado;

    /**
     * PK
     * @var integer
     */
    private $codCentro;

    /**
     * @var string
     */
    private $exercicio;

    /**
     * @var integer
     */
    private $codAutorizacao;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Almoxarifado\LancamentoMaterial
     */
    private $fkAlmoxarifadoLancamentoMaterial;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Frota\Autorizacao
     */
    private $fkFrotaAutorizacao;


    /**
     * Set codLancamento
     *
     * @param integer $codLancamento
     * @return LancamentoAutorizacao
     */
    public function setCodLancamento($codLancamento)
    {
        $this->codLancamento = $codLancamento;
        return $this;
    }

    /**
     * Get codLancamento
     *
     * @return integer
     */
    public function getCodLancamento()
    {
        return $this->codLancamento;
    }

    /**
     * Set codItem
     *
     * @param integer $codItem
     * @return LancamentoAutorizacao
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
     * @return LancamentoAutorizacao
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
     * Set codAlmoxarifado
     *
     * @param integer $codAlmoxarifado
     * @return LancamentoAutorizacao
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
     * Set codCentro
     *
     * @param integer $codCentro
     * @return LancamentoAutorizacao
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
     * Set exercicio
     *
     * @param string $exercicio
     * @return LancamentoAutorizacao
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
     * Set codAutorizacao
     *
     * @param integer $codAutorizacao
     * @return LancamentoAutorizacao
     */
    public function setCodAutorizacao($codAutorizacao)
    {
        $this->codAutorizacao = $codAutorizacao;
        return $this;
    }

    /**
     * Get codAutorizacao
     *
     * @return integer
     */
    public function getCodAutorizacao()
    {
        return $this->codAutorizacao;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkFrotaAutorizacao
     *
     * @param \Urbem\CoreBundle\Entity\Frota\Autorizacao $fkFrotaAutorizacao
     * @return LancamentoAutorizacao
     */
    public function setFkFrotaAutorizacao(\Urbem\CoreBundle\Entity\Frota\Autorizacao $fkFrotaAutorizacao)
    {
        $this->codAutorizacao = $fkFrotaAutorizacao->getCodAutorizacao();
        $this->exercicio = $fkFrotaAutorizacao->getExercicio();
        $this->fkFrotaAutorizacao = $fkFrotaAutorizacao;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkFrotaAutorizacao
     *
     * @return \Urbem\CoreBundle\Entity\Frota\Autorizacao
     */
    public function getFkFrotaAutorizacao()
    {
        return $this->fkFrotaAutorizacao;
    }

    /**
     * OneToOne (owning side)
     * Set AlmoxarifadoLancamentoMaterial
     *
     * @param \Urbem\CoreBundle\Entity\Almoxarifado\LancamentoMaterial $fkAlmoxarifadoLancamentoMaterial
     * @return LancamentoAutorizacao
     */
    public function setFkAlmoxarifadoLancamentoMaterial(\Urbem\CoreBundle\Entity\Almoxarifado\LancamentoMaterial $fkAlmoxarifadoLancamentoMaterial)
    {
        $this->codLancamento = $fkAlmoxarifadoLancamentoMaterial->getCodLancamento();
        $this->codItem = $fkAlmoxarifadoLancamentoMaterial->getCodItem();
        $this->codMarca = $fkAlmoxarifadoLancamentoMaterial->getCodMarca();
        $this->codAlmoxarifado = $fkAlmoxarifadoLancamentoMaterial->getCodAlmoxarifado();
        $this->codCentro = $fkAlmoxarifadoLancamentoMaterial->getCodCentro();
        $this->fkAlmoxarifadoLancamentoMaterial = $fkAlmoxarifadoLancamentoMaterial;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkAlmoxarifadoLancamentoMaterial
     *
     * @return \Urbem\CoreBundle\Entity\Almoxarifado\LancamentoMaterial
     */
    public function getFkAlmoxarifadoLancamentoMaterial()
    {
        return $this->fkAlmoxarifadoLancamentoMaterial;
    }

    public function __toString()
    {
        return "{$this->codLancamento}/{$this->exercicio}";
    }
}
