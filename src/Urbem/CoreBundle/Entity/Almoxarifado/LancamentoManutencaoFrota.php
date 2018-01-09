<?php
 
namespace Urbem\CoreBundle\Entity\Almoxarifado;

/**
 * LancamentoManutencaoFrota
 */
class LancamentoManutencaoFrota
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
     * @var integer
     */
    private $codManutencao;

    /**
     * @var string
     */
    private $exercicio;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Almoxarifado\LancamentoMaterial
     */
    private $fkAlmoxarifadoLancamentoMaterial;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Frota\Manutencao
     */
    private $fkFrotaManutencao;


    /**
     * Set codLancamento
     *
     * @param integer $codLancamento
     * @return LancamentoManutencaoFrota
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
     * @return LancamentoManutencaoFrota
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
     * @return LancamentoManutencaoFrota
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
     * @return LancamentoManutencaoFrota
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
     * @return LancamentoManutencaoFrota
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
     * Set codManutencao
     *
     * @param integer $codManutencao
     * @return LancamentoManutencaoFrota
     */
    public function setCodManutencao($codManutencao)
    {
        $this->codManutencao = $codManutencao;
        return $this;
    }

    /**
     * Get codManutencao
     *
     * @return integer
     */
    public function getCodManutencao()
    {
        return $this->codManutencao;
    }

    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return LancamentoManutencaoFrota
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
     * ManyToOne (inverse side)
     * Set fkFrotaManutencao
     *
     * @param \Urbem\CoreBundle\Entity\Frota\Manutencao $fkFrotaManutencao
     * @return LancamentoManutencaoFrota
     */
    public function setFkFrotaManutencao(\Urbem\CoreBundle\Entity\Frota\Manutencao $fkFrotaManutencao)
    {
        $this->codManutencao = $fkFrotaManutencao->getCodManutencao();
        $this->exercicio = $fkFrotaManutencao->getExercicio();
        $this->fkFrotaManutencao = $fkFrotaManutencao;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkFrotaManutencao
     *
     * @return \Urbem\CoreBundle\Entity\Frota\Manutencao
     */
    public function getFkFrotaManutencao()
    {
        return $this->fkFrotaManutencao;
    }

    /**
     * OneToOne (owning side)
     * Set AlmoxarifadoLancamentoMaterial
     *
     * @param \Urbem\CoreBundle\Entity\Almoxarifado\LancamentoMaterial $fkAlmoxarifadoLancamentoMaterial
     * @return LancamentoManutencaoFrota
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
}
