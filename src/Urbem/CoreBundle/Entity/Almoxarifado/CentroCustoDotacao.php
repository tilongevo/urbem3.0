<?php

namespace Urbem\CoreBundle\Entity\Almoxarifado;

/**
 * CentroCustoDotacao
 */
class CentroCustoDotacao
{
    /**
     * PK
     * @var integer
     */
    private $codDespesa;

    /**
     * PK
     * @var string
     */
    private $exercicio;

    /**
     * PK
     * @var integer
     */
    private $codCentro;

    /**
     * PK
     * @var integer
     */
    private $codEntidade;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Orcamento\Despesa
     */
    private $fkOrcamentoDespesa;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Almoxarifado\CentroCustoEntidade
     */
    private $fkAlmoxarifadoCentroCustoEntidade;


    /**
     * Set codDespesa
     *
     * @param integer $codDespesa
     * @return CentroCustoDotacao
     */
    public function setCodDespesa($codDespesa)
    {
        $this->codDespesa = $codDespesa;
        return $this;
    }

    /**
     * Get codDespesa
     *
     * @return integer
     */
    public function getCodDespesa()
    {
        return $this->codDespesa;
    }

    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return CentroCustoDotacao
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
     * Set codCentro
     *
     * @param integer $codCentro
     * @return CentroCustoDotacao
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
     * Set codEntidade
     *
     * @param integer $codEntidade
     * @return CentroCustoDotacao
     */
    public function setCodEntidade($codEntidade)
    {
        $this->codEntidade = $codEntidade;
        return $this;
    }

    /**
     * Get codEntidade
     *
     * @return integer
     */
    public function getCodEntidade()
    {
        return $this->codEntidade;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkOrcamentoDespesa
     *
     * @param \Urbem\CoreBundle\Entity\Orcamento\Despesa $fkOrcamentoDespesa
     * @return CentroCustoDotacao
     */
    public function setFkOrcamentoDespesa(\Urbem\CoreBundle\Entity\Orcamento\Despesa $fkOrcamentoDespesa)
    {
        $this->exercicio = $fkOrcamentoDespesa->getExercicio();
        $this->codDespesa = $fkOrcamentoDespesa->getCodDespesa();
        $this->fkOrcamentoDespesa = $fkOrcamentoDespesa;

        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkOrcamentoDespesa
     *
     * @return \Urbem\CoreBundle\Entity\Orcamento\Despesa
     */
    public function getFkOrcamentoDespesa()
    {
        return $this->fkOrcamentoDespesa;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkAlmoxarifadoCentroCustoEntidade
     *
     * @param \Urbem\CoreBundle\Entity\Almoxarifado\CentroCustoEntidade $fkAlmoxarifadoCentroCustoEntidade
     * @return CentroCustoDotacao
     */
    public function setFkAlmoxarifadoCentroCustoEntidade(\Urbem\CoreBundle\Entity\Almoxarifado\CentroCustoEntidade $fkAlmoxarifadoCentroCustoEntidade)
    {
        $this->exercicio = $fkAlmoxarifadoCentroCustoEntidade->getExercicio();
        $this->codEntidade = $fkAlmoxarifadoCentroCustoEntidade->getCodEntidade();
        $this->codCentro = $fkAlmoxarifadoCentroCustoEntidade->getCodCentro();
        $this->fkAlmoxarifadoCentroCustoEntidade = $fkAlmoxarifadoCentroCustoEntidade;

        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkAlmoxarifadoCentroCustoEntidade
     *
     * @return \Urbem\CoreBundle\Entity\Almoxarifado\CentroCustoEntidade
     */
    public function getFkAlmoxarifadoCentroCustoEntidade()
    {
        return $this->fkAlmoxarifadoCentroCustoEntidade;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        if ($this->codDespesa) {
            return (string) $this->fkOrcamentoDespesa;
        } else {
            return 'Centro Custo Dotação';
        }
    }
}
