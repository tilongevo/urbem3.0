<?php
 
namespace Urbem\CoreBundle\Entity;

/**
 * SwCategoriaHabilitacaoVinculada
 */
class SwCategoriaHabilitacaoVinculada
{
    /**
     * PK
     * @var integer
     */
    private $codCategoria;

    /**
     * PK
     * @var integer
     */
    private $codCategoriaVinculada;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\SwCategoriaHabilitacao
     */
    private $fkSwCategoriaHabilitacao;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\SwCategoriaHabilitacao
     */
    private $fkSwCategoriaHabilitacao1;


    /**
     * Set codCategoria
     *
     * @param integer $codCategoria
     * @return SwCategoriaHabilitacaoVinculada
     */
    public function setCodCategoria($codCategoria)
    {
        $this->codCategoria = $codCategoria;
        return $this;
    }

    /**
     * Get codCategoria
     *
     * @return integer
     */
    public function getCodCategoria()
    {
        return $this->codCategoria;
    }

    /**
     * Set codCategoriaVinculada
     *
     * @param integer $codCategoriaVinculada
     * @return SwCategoriaHabilitacaoVinculada
     */
    public function setCodCategoriaVinculada($codCategoriaVinculada)
    {
        $this->codCategoriaVinculada = $codCategoriaVinculada;
        return $this;
    }

    /**
     * Get codCategoriaVinculada
     *
     * @return integer
     */
    public function getCodCategoriaVinculada()
    {
        return $this->codCategoriaVinculada;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkSwCategoriaHabilitacao
     *
     * @param \Urbem\CoreBundle\Entity\SwCategoriaHabilitacao $fkSwCategoriaHabilitacao
     * @return SwCategoriaHabilitacaoVinculada
     */
    public function setFkSwCategoriaHabilitacao(\Urbem\CoreBundle\Entity\SwCategoriaHabilitacao $fkSwCategoriaHabilitacao)
    {
        $this->codCategoria = $fkSwCategoriaHabilitacao->getCodCategoria();
        $this->fkSwCategoriaHabilitacao = $fkSwCategoriaHabilitacao;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkSwCategoriaHabilitacao
     *
     * @return \Urbem\CoreBundle\Entity\SwCategoriaHabilitacao
     */
    public function getFkSwCategoriaHabilitacao()
    {
        return $this->fkSwCategoriaHabilitacao;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkSwCategoriaHabilitacao1
     *
     * @param \Urbem\CoreBundle\Entity\SwCategoriaHabilitacao $fkSwCategoriaHabilitacao1
     * @return SwCategoriaHabilitacaoVinculada
     */
    public function setFkSwCategoriaHabilitacao1(\Urbem\CoreBundle\Entity\SwCategoriaHabilitacao $fkSwCategoriaHabilitacao1)
    {
        $this->codCategoriaVinculada = $fkSwCategoriaHabilitacao1->getCodCategoria();
        $this->fkSwCategoriaHabilitacao1 = $fkSwCategoriaHabilitacao1;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkSwCategoriaHabilitacao1
     *
     * @return \Urbem\CoreBundle\Entity\SwCategoriaHabilitacao
     */
    public function getFkSwCategoriaHabilitacao1()
    {
        return $this->fkSwCategoriaHabilitacao1;
    }
}
