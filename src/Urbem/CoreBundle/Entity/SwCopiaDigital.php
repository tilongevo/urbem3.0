<?php
 
namespace Urbem\CoreBundle\Entity;

/**
 * SwCopiaDigital
 */
class SwCopiaDigital
{
    /**
     * PK
     * @var integer
     */
    private $codCopia;

    /**
     * PK
     * @var integer
     */
    private $codDocumento;

    /**
     * PK
     * @var integer
     */
    private $codProcesso;

    /**
     * PK
     * @var string
     */
    private $exercicio;

    /**
     * @var boolean
     */
    private $imagem;

    /**
     * @var string
     */
    private $anexo;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\SwDocumentoProcesso
     */
    private $fkSwDocumentoProcesso;


    /**
     * Set codCopia
     *
     * @param integer $codCopia
     * @return SwCopiaDigital
     */
    public function setCodCopia($codCopia)
    {
        $this->codCopia = $codCopia;
        return $this;
    }

    /**
     * Get codCopia
     *
     * @return integer
     */
    public function getCodCopia()
    {
        return $this->codCopia;
    }

    /**
     * Set codDocumento
     *
     * @param integer $codDocumento
     * @return SwCopiaDigital
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
     * Set codProcesso
     *
     * @param integer $codProcesso
     * @return SwCopiaDigital
     */
    public function setCodProcesso($codProcesso)
    {
        $this->codProcesso = $codProcesso;
        return $this;
    }

    /**
     * Get codProcesso
     *
     * @return integer
     */
    public function getCodProcesso()
    {
        return $this->codProcesso;
    }

    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return SwCopiaDigital
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
     * Set imagem
     *
     * @param boolean $imagem
     * @return SwCopiaDigital
     */
    public function setImagem($imagem)
    {
        $this->imagem = $imagem;
        return $this;
    }

    /**
     * Get imagem
     *
     * @return boolean
     */
    public function getImagem()
    {
        return $this->imagem;
    }

    /**
     * Set anexo
     *
     * @param string $anexo
     * @return SwCopiaDigital
     */
    public function setAnexo($anexo)
    {
        $this->anexo = $anexo;
        return $this;
    }

    /**
     * Get anexo
     *
     * @return string
     */
    public function getAnexo()
    {
        return $this->anexo;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkSwDocumentoProcesso
     *
     * @param \Urbem\CoreBundle\Entity\SwDocumentoProcesso $fkSwDocumentoProcesso
     * @return SwCopiaDigital
     */
    public function setFkSwDocumentoProcesso(\Urbem\CoreBundle\Entity\SwDocumentoProcesso $fkSwDocumentoProcesso)
    {
        $this->codDocumento = $fkSwDocumentoProcesso->getCodDocumento();
        $this->codProcesso = $fkSwDocumentoProcesso->getCodProcesso();
        $this->exercicio = $fkSwDocumentoProcesso->getExercicio();
        $this->fkSwDocumentoProcesso = $fkSwDocumentoProcesso;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkSwDocumentoProcesso
     *
     * @return \Urbem\CoreBundle\Entity\SwDocumentoProcesso
     */
    public function getFkSwDocumentoProcesso()
    {
        return $this->fkSwDocumentoProcesso;
    }
}
