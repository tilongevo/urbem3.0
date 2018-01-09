<?php
 
namespace Urbem\CoreBundle\Entity\Tceam;

/**
 * ConfiguracaoArquivoLicitacao
 */
class ConfiguracaoArquivoLicitacao
{
    /**
     * PK
     * @var integer
     */
    private $codMapa;

    /**
     * PK
     * @var string
     */
    private $exercicio;

    /**
     * @var integer
     */
    private $diarioOficial;

    /**
     * @var string
     */
    private $arquivoTexto;

    /**
     * @var \DateTime
     */
    private $dtPublicacaoHomologacao;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Compras\Mapa
     */
    private $fkComprasMapa;


    /**
     * Set codMapa
     *
     * @param integer $codMapa
     * @return ConfiguracaoArquivoLicitacao
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
     * Set exercicio
     *
     * @param string $exercicio
     * @return ConfiguracaoArquivoLicitacao
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
     * Set diarioOficial
     *
     * @param integer $diarioOficial
     * @return ConfiguracaoArquivoLicitacao
     */
    public function setDiarioOficial($diarioOficial = null)
    {
        $this->diarioOficial = $diarioOficial;
        return $this;
    }

    /**
     * Get diarioOficial
     *
     * @return integer
     */
    public function getDiarioOficial()
    {
        return $this->diarioOficial;
    }

    /**
     * Set arquivoTexto
     *
     * @param string $arquivoTexto
     * @return ConfiguracaoArquivoLicitacao
     */
    public function setArquivoTexto($arquivoTexto = null)
    {
        $this->arquivoTexto = $arquivoTexto;
        return $this;
    }

    /**
     * Get arquivoTexto
     *
     * @return string
     */
    public function getArquivoTexto()
    {
        return $this->arquivoTexto;
    }

    /**
     * Set dtPublicacaoHomologacao
     *
     * @param \DateTime $dtPublicacaoHomologacao
     * @return ConfiguracaoArquivoLicitacao
     */
    public function setDtPublicacaoHomologacao(\DateTime $dtPublicacaoHomologacao = null)
    {
        $this->dtPublicacaoHomologacao = $dtPublicacaoHomologacao;
        return $this;
    }

    /**
     * Get dtPublicacaoHomologacao
     *
     * @return \DateTime
     */
    public function getDtPublicacaoHomologacao()
    {
        return $this->dtPublicacaoHomologacao;
    }

    /**
     * OneToOne (owning side)
     * Set ComprasMapa
     *
     * @param \Urbem\CoreBundle\Entity\Compras\Mapa $fkComprasMapa
     * @return ConfiguracaoArquivoLicitacao
     */
    public function setFkComprasMapa(\Urbem\CoreBundle\Entity\Compras\Mapa $fkComprasMapa)
    {
        $this->exercicio = $fkComprasMapa->getExercicio();
        $this->codMapa = $fkComprasMapa->getCodMapa();
        $this->fkComprasMapa = $fkComprasMapa;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkComprasMapa
     *
     * @return \Urbem\CoreBundle\Entity\Compras\Mapa
     */
    public function getFkComprasMapa()
    {
        return $this->fkComprasMapa;
    }
}
