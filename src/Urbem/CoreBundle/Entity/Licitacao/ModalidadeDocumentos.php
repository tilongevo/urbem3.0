<?php
 
namespace Urbem\CoreBundle\Entity\Licitacao;

/**
 * ModalidadeDocumentos
 */
class ModalidadeDocumentos
{
    /**
     * PK
     * @var integer
     */
    private $codDocumento;

    /**
     * PK
     * @var integer
     */
    private $codModalidade;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Licitacao\Documento
     */
    private $fkLicitacaoDocumento;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Compras\Modalidade
     */
    private $fkComprasModalidade;


    /**
     * Set codDocumento
     *
     * @param integer $codDocumento
     * @return ModalidadeDocumentos
     */
    public function setCodDocumento($codDocumento)
    {
        $this->codDocumento = $codDocumento;
        return $this;
    }

    /**
     * Get codDocumento
     *
     * @return integer
     */
    public function getCodDocumento()
    {
        return $this->codDocumento;
    }

    /**
     * Set codModalidade
     *
     * @param integer $codModalidade
     * @return ModalidadeDocumentos
     */
    public function setCodModalidade($codModalidade)
    {
        $this->codModalidade = $codModalidade;
        return $this;
    }

    /**
     * Get codModalidade
     *
     * @return integer
     */
    public function getCodModalidade()
    {
        return $this->codModalidade;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkLicitacaoDocumento
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\Documento $fkLicitacaoDocumento
     * @return ModalidadeDocumentos
     */
    public function setFkLicitacaoDocumento(\Urbem\CoreBundle\Entity\Licitacao\Documento $fkLicitacaoDocumento)
    {
        $this->codDocumento = $fkLicitacaoDocumento->getCodDocumento();
        $this->fkLicitacaoDocumento = $fkLicitacaoDocumento;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkLicitacaoDocumento
     *
     * @return \Urbem\CoreBundle\Entity\Licitacao\Documento
     */
    public function getFkLicitacaoDocumento()
    {
        return $this->fkLicitacaoDocumento;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkComprasModalidade
     *
     * @param \Urbem\CoreBundle\Entity\Compras\Modalidade $fkComprasModalidade
     * @return ModalidadeDocumentos
     */
    public function setFkComprasModalidade(\Urbem\CoreBundle\Entity\Compras\Modalidade $fkComprasModalidade)
    {
        $this->codModalidade = $fkComprasModalidade->getCodModalidade();
        $this->fkComprasModalidade = $fkComprasModalidade;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkComprasModalidade
     *
     * @return \Urbem\CoreBundle\Entity\Compras\Modalidade
     */
    public function getFkComprasModalidade()
    {
        return $this->fkComprasModalidade;
    }
}
