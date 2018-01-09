<?php
 
namespace Urbem\CoreBundle\Entity\Compras;

/**
 * CotacaoAnulada
 */
class CotacaoAnulada
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
    private $codCotacao;

    /**
     * @var string
     */
    private $motivo;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Compras\Cotacao
     */
    private $fkComprasCotacao;


    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return CotacaoAnulada
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
     * Set codCotacao
     *
     * @param integer $codCotacao
     * @return CotacaoAnulada
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
     * Set motivo
     *
     * @param string $motivo
     * @return CotacaoAnulada
     */
    public function setMotivo($motivo)
    {
        $this->motivo = $motivo;
        return $this;
    }

    /**
     * Get motivo
     *
     * @return string
     */
    public function getMotivo()
    {
        return $this->motivo;
    }

    /**
     * OneToOne (owning side)
     * Set ComprasCotacao
     *
     * @param \Urbem\CoreBundle\Entity\Compras\Cotacao $fkComprasCotacao
     * @return CotacaoAnulada
     */
    public function setFkComprasCotacao(\Urbem\CoreBundle\Entity\Compras\Cotacao $fkComprasCotacao)
    {
        $this->exercicio = $fkComprasCotacao->getExercicio();
        $this->codCotacao = $fkComprasCotacao->getCodCotacao();
        $this->fkComprasCotacao = $fkComprasCotacao;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkComprasCotacao
     *
     * @return \Urbem\CoreBundle\Entity\Compras\Cotacao
     */
    public function getFkComprasCotacao()
    {
        return $this->fkComprasCotacao;
    }
}
