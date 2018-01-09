<?php
 
namespace Urbem\CoreBundle\Entity\Ldo;

/**
 * ConfiguracaoReceitaDespesa
 */
class ConfiguracaoReceitaDespesa
{
    /**
     * PK
     * @var integer
     */
    private $codPpa;

    /**
     * PK
     * @var string
     */
    private $ano;

    /**
     * PK
     * @var integer
     */
    private $codTipo;

    /**
     * PK
     * @var string
     */
    private $tipo;

    /**
     * PK
     * @var string
     */
    private $exercicio;

    /**
     * @var integer
     */
    private $vlArrecadadoLiquidado;

    /**
     * @var integer
     */
    private $vlPrevistoFixado;

    /**
     * @var integer
     */
    private $vlProjetado;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Ldo\Ldo
     */
    private $fkLdoLdo;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Ldo\TipoReceitaDespesa
     */
    private $fkLdoTipoReceitaDespesa;


    /**
     * Set codPpa
     *
     * @param integer $codPpa
     * @return ConfiguracaoReceitaDespesa
     */
    public function setCodPpa($codPpa)
    {
        $this->codPpa = $codPpa;
        return $this;
    }

    /**
     * Get codPpa
     *
     * @return integer
     */
    public function getCodPpa()
    {
        return $this->codPpa;
    }

    /**
     * Set ano
     *
     * @param string $ano
     * @return ConfiguracaoReceitaDespesa
     */
    public function setAno($ano)
    {
        $this->ano = $ano;
        return $this;
    }

    /**
     * Get ano
     *
     * @return string
     */
    public function getAno()
    {
        return $this->ano;
    }

    /**
     * Set codTipo
     *
     * @param integer $codTipo
     * @return ConfiguracaoReceitaDespesa
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
     * Set tipo
     *
     * @param string $tipo
     * @return ConfiguracaoReceitaDespesa
     */
    public function setTipo($tipo)
    {
        $this->tipo = $tipo;
        return $this;
    }

    /**
     * Get tipo
     *
     * @return string
     */
    public function getTipo()
    {
        return $this->tipo;
    }

    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return ConfiguracaoReceitaDespesa
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
     * Set vlArrecadadoLiquidado
     *
     * @param integer $vlArrecadadoLiquidado
     * @return ConfiguracaoReceitaDespesa
     */
    public function setVlArrecadadoLiquidado($vlArrecadadoLiquidado)
    {
        $this->vlArrecadadoLiquidado = $vlArrecadadoLiquidado;
        return $this;
    }

    /**
     * Get vlArrecadadoLiquidado
     *
     * @return integer
     */
    public function getVlArrecadadoLiquidado()
    {
        return $this->vlArrecadadoLiquidado;
    }

    /**
     * Set vlPrevistoFixado
     *
     * @param integer $vlPrevistoFixado
     * @return ConfiguracaoReceitaDespesa
     */
    public function setVlPrevistoFixado($vlPrevistoFixado)
    {
        $this->vlPrevistoFixado = $vlPrevistoFixado;
        return $this;
    }

    /**
     * Get vlPrevistoFixado
     *
     * @return integer
     */
    public function getVlPrevistoFixado()
    {
        return $this->vlPrevistoFixado;
    }

    /**
     * Set vlProjetado
     *
     * @param integer $vlProjetado
     * @return ConfiguracaoReceitaDespesa
     */
    public function setVlProjetado($vlProjetado)
    {
        $this->vlProjetado = $vlProjetado;
        return $this;
    }

    /**
     * Get vlProjetado
     *
     * @return integer
     */
    public function getVlProjetado()
    {
        return $this->vlProjetado;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkLdoLdo
     *
     * @param \Urbem\CoreBundle\Entity\Ldo\Ldo $fkLdoLdo
     * @return ConfiguracaoReceitaDespesa
     */
    public function setFkLdoLdo(\Urbem\CoreBundle\Entity\Ldo\Ldo $fkLdoLdo)
    {
        $this->codPpa = $fkLdoLdo->getCodPpa();
        $this->ano = $fkLdoLdo->getAno();
        $this->fkLdoLdo = $fkLdoLdo;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkLdoLdo
     *
     * @return \Urbem\CoreBundle\Entity\Ldo\Ldo
     */
    public function getFkLdoLdo()
    {
        return $this->fkLdoLdo;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkLdoTipoReceitaDespesa
     *
     * @param \Urbem\CoreBundle\Entity\Ldo\TipoReceitaDespesa $fkLdoTipoReceitaDespesa
     * @return ConfiguracaoReceitaDespesa
     */
    public function setFkLdoTipoReceitaDespesa(\Urbem\CoreBundle\Entity\Ldo\TipoReceitaDespesa $fkLdoTipoReceitaDespesa)
    {
        $this->codTipo = $fkLdoTipoReceitaDespesa->getCodTipo();
        $this->tipo = $fkLdoTipoReceitaDespesa->getTipo();
        $this->fkLdoTipoReceitaDespesa = $fkLdoTipoReceitaDespesa;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkLdoTipoReceitaDespesa
     *
     * @return \Urbem\CoreBundle\Entity\Ldo\TipoReceitaDespesa
     */
    public function getFkLdoTipoReceitaDespesa()
    {
        return $this->fkLdoTipoReceitaDespesa;
    }
}
