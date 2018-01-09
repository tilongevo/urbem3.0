<?php
 
namespace Urbem\CoreBundle\Entity\Compras;

/**
 * MapaCotacao
 */
class MapaCotacao
{
    /**
     * PK
     * @var integer
     */
    private $codCotacao;

    /**
     * PK
     * @var integer
     */
    private $codMapa;

    /**
     * PK
     * @var string
     */
    private $exercicioCotacao;

    /**
     * PK
     * @var string
     */
    private $exercicioMapa;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Compras\Cotacao
     */
    private $fkComprasCotacao;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Compras\Mapa
     */
    private $fkComprasMapa;


    /**
     * Set codCotacao
     *
     * @param integer $codCotacao
     * @return MapaCotacao
     */
    public function setCodCotacao($codCotacao)
    {
        $this->codCotacao = $codCotacao;
        return $this;
    }

    /**
     * Get codCotacao
     *
     * @return integer
     */
    public function getCodCotacao()
    {
        return $this->codCotacao;
    }

    /**
     * Set codMapa
     *
     * @param integer $codMapa
     * @return MapaCotacao
     */
    public function setCodMapa($codMapa)
    {
        $this->codMapa = $codMapa;
        return $this;
    }

    /**
     * Get codMapa
     *
     * @return integer
     */
    public function getCodMapa()
    {
        return $this->codMapa;
    }

    /**
     * Set exercicioCotacao
     *
     * @param string $exercicioCotacao
     * @return MapaCotacao
     */
    public function setExercicioCotacao($exercicioCotacao)
    {
        $this->exercicioCotacao = $exercicioCotacao;
        return $this;
    }

    /**
     * Get exercicioCotacao
     *
     * @return string
     */
    public function getExercicioCotacao()
    {
        return $this->exercicioCotacao;
    }

    /**
     * Set exercicioMapa
     *
     * @param string $exercicioMapa
     * @return MapaCotacao
     */
    public function setExercicioMapa($exercicioMapa)
    {
        $this->exercicioMapa = $exercicioMapa;
        return $this;
    }

    /**
     * Get exercicioMapa
     *
     * @return string
     */
    public function getExercicioMapa()
    {
        return $this->exercicioMapa;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkComprasCotacao
     *
     * @param \Urbem\CoreBundle\Entity\Compras\Cotacao $fkComprasCotacao
     * @return MapaCotacao
     */
    public function setFkComprasCotacao(\Urbem\CoreBundle\Entity\Compras\Cotacao $fkComprasCotacao)
    {
        $this->exercicioCotacao = $fkComprasCotacao->getExercicio();
        $this->codCotacao = $fkComprasCotacao->getCodCotacao();
        $this->fkComprasCotacao = $fkComprasCotacao;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkComprasCotacao
     *
     * @return \Urbem\CoreBundle\Entity\Compras\Cotacao
     */
    public function getFkComprasCotacao()
    {
        return $this->fkComprasCotacao;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkComprasMapa
     *
     * @param \Urbem\CoreBundle\Entity\Compras\Mapa $fkComprasMapa
     * @return MapaCotacao
     */
    public function setFkComprasMapa(\Urbem\CoreBundle\Entity\Compras\Mapa $fkComprasMapa)
    {
        $this->exercicioMapa = $fkComprasMapa->getExercicio();
        $this->codMapa = $fkComprasMapa->getCodMapa();
        $this->fkComprasMapa = $fkComprasMapa;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkComprasMapa
     *
     * @return \Urbem\CoreBundle\Entity\Compras\Mapa
     */
    public function getFkComprasMapa()
    {
        return $this->fkComprasMapa;
    }
}
