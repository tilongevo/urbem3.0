<?php
 
namespace Urbem\CoreBundle\Entity\Arrecadacao;

/**
 * DocumentoCgm
 */
class DocumentoCgm
{
    /**
     * PK
     * @var integer
     */
    private $numcgm;

    /**
     * PK
     * @var integer
     */
    private $codDocumento;

    /**
     * PK
     * @var integer
     */
    private $numDocumento;

    /**
     * PK
     * @var string
     */
    private $exercicio;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\SwCgm
     */
    private $fkSwCgm;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Arrecadacao\DocumentoEmissao
     */
    private $fkArrecadacaoDocumentoEmissao;


    /**
     * Set numcgm
     *
     * @param integer $numcgm
     * @return DocumentoCgm
     */
    public function setNumcgm($numcgm)
    {
        $this->numcgm = $numcgm;
        return $this;
    }

    /**
     * Get numcgm
     *
     * @return integer
     */
    public function getNumcgm()
    {
        return $this->numcgm;
    }

    /**
     * Set codDocumento
     *
     * @param integer $codDocumento
     * @return DocumentoCgm
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
     * Set numDocumento
     *
     * @param integer $numDocumento
     * @return DocumentoCgm
     */
    public function setNumDocumento($numDocumento)
    {
        $this->numDocumento = $numDocumento;
        return $this;
    }

    /**
     * Get numDocumento
     *
     * @return integer
     */
    public function getNumDocumento()
    {
        return $this->numDocumento;
    }

    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return DocumentoCgm
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
     * ManyToOne (inverse side)
     * Set fkSwCgm
     *
     * @param \Urbem\CoreBundle\Entity\SwCgm $fkSwCgm
     * @return DocumentoCgm
     */
    public function setFkSwCgm(\Urbem\CoreBundle\Entity\SwCgm $fkSwCgm)
    {
        $this->numcgm = $fkSwCgm->getNumcgm();
        $this->fkSwCgm = $fkSwCgm;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkSwCgm
     *
     * @return \Urbem\CoreBundle\Entity\SwCgm
     */
    public function getFkSwCgm()
    {
        return $this->fkSwCgm;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkArrecadacaoDocumentoEmissao
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\DocumentoEmissao $fkArrecadacaoDocumentoEmissao
     * @return DocumentoCgm
     */
    public function setFkArrecadacaoDocumentoEmissao(\Urbem\CoreBundle\Entity\Arrecadacao\DocumentoEmissao $fkArrecadacaoDocumentoEmissao)
    {
        $this->codDocumento = $fkArrecadacaoDocumentoEmissao->getCodDocumento();
        $this->numDocumento = $fkArrecadacaoDocumentoEmissao->getNumDocumento();
        $this->exercicio = $fkArrecadacaoDocumentoEmissao->getExercicio();
        $this->fkArrecadacaoDocumentoEmissao = $fkArrecadacaoDocumentoEmissao;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkArrecadacaoDocumentoEmissao
     *
     * @return \Urbem\CoreBundle\Entity\Arrecadacao\DocumentoEmissao
     */
    public function getFkArrecadacaoDocumentoEmissao()
    {
        return $this->fkArrecadacaoDocumentoEmissao;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string) $this->getNumcgm().' - '.$this->getFkSwCgm()->getNomCgm();
    }
}
