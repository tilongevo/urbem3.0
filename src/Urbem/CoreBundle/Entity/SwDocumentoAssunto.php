<?php
 
namespace Urbem\CoreBundle\Entity;

/**
 * SwDocumentoAssunto
 */
class SwDocumentoAssunto
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
    private $codClassificacao;

    /**
     * PK
     * @var integer
     */
    private $codAssunto;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\SwDocumento
     */
    private $fkSwDocumento;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\SwAssunto
     */
    private $fkSwAssunto;


    /**
     * Set codDocumento
     *
     * @param integer $codDocumento
     * @return SwDocumentoAssunto
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
     * Set codClassificacao
     *
     * @param integer $codClassificacao
     * @return SwDocumentoAssunto
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
     * Set codAssunto
     *
     * @param integer $codAssunto
     * @return SwDocumentoAssunto
     */
    public function setCodAssunto($codAssunto)
    {
        $this->codAssunto = $codAssunto;
        return $this;
    }

    /**
     * Get codAssunto
     *
     * @return integer
     */
    public function getCodAssunto()
    {
        return $this->codAssunto;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkSwDocumento
     *
     * @param \Urbem\CoreBundle\Entity\SwDocumento $fkSwDocumento
     * @return SwDocumentoAssunto
     */
    public function setFkSwDocumento(\Urbem\CoreBundle\Entity\SwDocumento $fkSwDocumento)
    {
        $this->codDocumento = $fkSwDocumento->getCodDocumento();
        $this->fkSwDocumento = $fkSwDocumento;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkSwDocumento
     *
     * @return \Urbem\CoreBundle\Entity\SwDocumento
     */
    public function getFkSwDocumento()
    {
        return $this->fkSwDocumento;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkSwAssunto
     *
     * @param \Urbem\CoreBundle\Entity\SwAssunto $fkSwAssunto
     * @return SwDocumentoAssunto
     */
    public function setFkSwAssunto(\Urbem\CoreBundle\Entity\SwAssunto $fkSwAssunto)
    {
        $this->codAssunto = $fkSwAssunto->getCodAssunto();
        $this->codClassificacao = $fkSwAssunto->getCodClassificacao();
        $this->fkSwAssunto = $fkSwAssunto;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkSwAssunto
     *
     * @return \Urbem\CoreBundle\Entity\SwAssunto
     */
    public function getFkSwAssunto()
    {
        return $this->fkSwAssunto;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string) $this->fkSwDocumento;
    }
}
