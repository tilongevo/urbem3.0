<?php
 
namespace Urbem\CoreBundle\Entity\Fiscalizacao;

/**
 * DocumentoAtividade
 */
class DocumentoAtividade
{
    /**
     * PK
     * @var integer
     */
    private $codAtividade;

    /**
     * PK
     * @var integer
     */
    private $codDocumento;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Economico\Atividade
     */
    private $fkEconomicoAtividade;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Fiscalizacao\Documento
     */
    private $fkFiscalizacaoDocumento;


    /**
     * Set codAtividade
     *
     * @param integer $codAtividade
     * @return DocumentoAtividade
     */
    public function setCodAtividade($codAtividade)
    {
        $this->codAtividade = $codAtividade;
        return $this;
    }

    /**
     * Get codAtividade
     *
     * @return integer
     */
    public function getCodAtividade()
    {
        return $this->codAtividade;
    }

    /**
     * Set codDocumento
     *
     * @param integer $codDocumento
     * @return DocumentoAtividade
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
     * ManyToOne (inverse side)
     * Set fkEconomicoAtividade
     *
     * @param \Urbem\CoreBundle\Entity\Economico\Atividade $fkEconomicoAtividade
     * @return DocumentoAtividade
     */
    public function setFkEconomicoAtividade(\Urbem\CoreBundle\Entity\Economico\Atividade $fkEconomicoAtividade)
    {
        $this->codAtividade = $fkEconomicoAtividade->getCodAtividade();
        $this->fkEconomicoAtividade = $fkEconomicoAtividade;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkEconomicoAtividade
     *
     * @return \Urbem\CoreBundle\Entity\Economico\Atividade
     */
    public function getFkEconomicoAtividade()
    {
        return $this->fkEconomicoAtividade;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkFiscalizacaoDocumento
     *
     * @param \Urbem\CoreBundle\Entity\Fiscalizacao\Documento $fkFiscalizacaoDocumento
     * @return DocumentoAtividade
     */
    public function setFkFiscalizacaoDocumento(\Urbem\CoreBundle\Entity\Fiscalizacao\Documento $fkFiscalizacaoDocumento)
    {
        $this->codDocumento = $fkFiscalizacaoDocumento->getCodDocumento();
        $this->fkFiscalizacaoDocumento = $fkFiscalizacaoDocumento;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkFiscalizacaoDocumento
     *
     * @return \Urbem\CoreBundle\Entity\Fiscalizacao\Documento
     */
    public function getFkFiscalizacaoDocumento()
    {
        return $this->fkFiscalizacaoDocumento;
    }
}
