<?php
 
namespace Urbem\CoreBundle\Entity\Almoxarifado;

/**
 * CatalogoClassificacaoBloqueio
 */
class CatalogoClassificacaoBloqueio
{
    /**
     * PK
     * @var integer
     */
    private $codClassificacao;

    /**
     * PK
     * @var integer
     */
    private $codCatalogo;

    /**
     * PK
     * @var integer
     */
    private $codAlmoxarifado;

    /**
     * @var string
     */
    private $exercicio;

    /**
     * @var integer
     */
    private $codInventario;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Almoxarifado\CatalogoClassificacao
     */
    private $fkAlmoxarifadoCatalogoClassificacao;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Almoxarifado\Inventario
     */
    private $fkAlmoxarifadoInventario;


    /**
     * Set codClassificacao
     *
     * @param integer $codClassificacao
     * @return CatalogoClassificacaoBloqueio
     */
    public function setCodClassificacao($codClassificacao)
    {
        $this->codClassificacao = $codClassificacao;
        return $this;
    }

    /**
     * Get codClassificacao
     *
     * @return integer
     */
    public function getCodClassificacao()
    {
        return $this->codClassificacao;
    }

    /**
     * Set codCatalogo
     *
     * @param integer $codCatalogo
     * @return CatalogoClassificacaoBloqueio
     */
    public function setCodCatalogo($codCatalogo)
    {
        $this->codCatalogo = $codCatalogo;
        return $this;
    }

    /**
     * Get codCatalogo
     *
     * @return integer
     */
    public function getCodCatalogo()
    {
        return $this->codCatalogo;
    }

    /**
     * Set codAlmoxarifado
     *
     * @param integer $codAlmoxarifado
     * @return CatalogoClassificacaoBloqueio
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
     * Set exercicio
     *
     * @param string $exercicio
     * @return CatalogoClassificacaoBloqueio
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
     * Set codInventario
     *
     * @param integer $codInventario
     * @return CatalogoClassificacaoBloqueio
     */
    public function setCodInventario($codInventario)
    {
        $this->codInventario = $codInventario;
        return $this;
    }

    /**
     * Get codInventario
     *
     * @return integer
     */
    public function getCodInventario()
    {
        return $this->codInventario;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkAlmoxarifadoCatalogoClassificacao
     *
     * @param \Urbem\CoreBundle\Entity\Almoxarifado\CatalogoClassificacao $fkAlmoxarifadoCatalogoClassificacao
     * @return CatalogoClassificacaoBloqueio
     */
    public function setFkAlmoxarifadoCatalogoClassificacao(\Urbem\CoreBundle\Entity\Almoxarifado\CatalogoClassificacao $fkAlmoxarifadoCatalogoClassificacao)
    {
        $this->codClassificacao = $fkAlmoxarifadoCatalogoClassificacao->getCodClassificacao();
        $this->codCatalogo = $fkAlmoxarifadoCatalogoClassificacao->getCodCatalogo();
        $this->fkAlmoxarifadoCatalogoClassificacao = $fkAlmoxarifadoCatalogoClassificacao;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkAlmoxarifadoCatalogoClassificacao
     *
     * @return \Urbem\CoreBundle\Entity\Almoxarifado\CatalogoClassificacao
     */
    public function getFkAlmoxarifadoCatalogoClassificacao()
    {
        return $this->fkAlmoxarifadoCatalogoClassificacao;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkAlmoxarifadoInventario
     *
     * @param \Urbem\CoreBundle\Entity\Almoxarifado\Inventario $fkAlmoxarifadoInventario
     * @return CatalogoClassificacaoBloqueio
     */
    public function setFkAlmoxarifadoInventario(\Urbem\CoreBundle\Entity\Almoxarifado\Inventario $fkAlmoxarifadoInventario)
    {
        $this->exercicio = $fkAlmoxarifadoInventario->getExercicio();
        $this->codAlmoxarifado = $fkAlmoxarifadoInventario->getCodAlmoxarifado();
        $this->codInventario = $fkAlmoxarifadoInventario->getCodInventario();
        $this->fkAlmoxarifadoInventario = $fkAlmoxarifadoInventario;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkAlmoxarifadoInventario
     *
     * @return \Urbem\CoreBundle\Entity\Almoxarifado\Inventario
     */
    public function getFkAlmoxarifadoInventario()
    {
        return $this->fkAlmoxarifadoInventario;
    }
}
