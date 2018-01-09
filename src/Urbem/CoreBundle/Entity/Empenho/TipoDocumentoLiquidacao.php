<?php
 
namespace Urbem\CoreBundle\Entity\Empenho;

/**
 * TipoDocumentoLiquidacao
 */
class TipoDocumentoLiquidacao
{
    /**
     * PK
     * @var integer
     */
    private $codTipoDocumentoLiquidacao;

    /**
     * @var string
     */
    private $descricao;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Empenho\DocumentoLiquidacao
     */
    private $fkEmpenhoDocumentoLiquidacoes;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkEmpenhoDocumentoLiquidacoes = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codTipoDocumentoLiquidacao
     *
     * @param integer $codTipoDocumentoLiquidacao
     * @return TipoDocumentoLiquidacao
     */
    public function setCodTipoDocumentoLiquidacao($codTipoDocumentoLiquidacao)
    {
        $this->codTipoDocumentoLiquidacao = $codTipoDocumentoLiquidacao;
        return $this;
    }

    /**
     * Get codTipoDocumentoLiquidacao
     *
     * @return integer
     */
    public function getCodTipoDocumentoLiquidacao()
    {
        return $this->codTipoDocumentoLiquidacao;
    }

    /**
     * Set descricao
     *
     * @param string $descricao
     * @return TipoDocumentoLiquidacao
     */
    public function setDescricao($descricao)
    {
        $this->descricao = $descricao;
        return $this;
    }

    /**
     * Get descricao
     *
     * @return string
     */
    public function getDescricao()
    {
        return $this->descricao;
    }

    /**
     * OneToMany (owning side)
     * Add EmpenhoDocumentoLiquidacao
     *
     * @param \Urbem\CoreBundle\Entity\Empenho\DocumentoLiquidacao $fkEmpenhoDocumentoLiquidacao
     * @return TipoDocumentoLiquidacao
     */
    public function addFkEmpenhoDocumentoLiquidacoes(\Urbem\CoreBundle\Entity\Empenho\DocumentoLiquidacao $fkEmpenhoDocumentoLiquidacao)
    {
        if (false === $this->fkEmpenhoDocumentoLiquidacoes->contains($fkEmpenhoDocumentoLiquidacao)) {
            $fkEmpenhoDocumentoLiquidacao->setFkEmpenhoTipoDocumentoLiquidacao($this);
            $this->fkEmpenhoDocumentoLiquidacoes->add($fkEmpenhoDocumentoLiquidacao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove EmpenhoDocumentoLiquidacao
     *
     * @param \Urbem\CoreBundle\Entity\Empenho\DocumentoLiquidacao $fkEmpenhoDocumentoLiquidacao
     */
    public function removeFkEmpenhoDocumentoLiquidacoes(\Urbem\CoreBundle\Entity\Empenho\DocumentoLiquidacao $fkEmpenhoDocumentoLiquidacao)
    {
        $this->fkEmpenhoDocumentoLiquidacoes->removeElement($fkEmpenhoDocumentoLiquidacao);
    }

    /**
     * OneToMany (owning side)
     * Get fkEmpenhoDocumentoLiquidacoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Empenho\DocumentoLiquidacao
     */
    public function getFkEmpenhoDocumentoLiquidacoes()
    {
        return $this->fkEmpenhoDocumentoLiquidacoes;
    }
}
