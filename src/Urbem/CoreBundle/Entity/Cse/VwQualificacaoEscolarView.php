<?php
 
namespace Urbem\CoreBundle\Entity\Cse;

/**
 * VwQualificacaoEscolarView
 */
class VwQualificacaoEscolarView
{
    /**
     * PK
     * @var integer
     */
    private $codCidadao;

    /**
     * @var string
     */
    private $nomCidadao;

    /**
     * @var integer
     */
    private $codGrau;

    /**
     * @var string
     */
    private $nomGrau;

    /**
     * @var string
     */
    private $serie;

    /**
     * @var string
     */
    private $frequencia;

    /**
     * @var integer
     */
    private $codInstituicao;

    /**
     * @var string
     */
    private $nomInstituicao;


    /**
     * Set codCidadao
     *
     * @param integer $codCidadao
     * @return VwQualificacaoEscolar
     */
    public function setCodCidadao($codCidadao)
    {
        $this->codCidadao = $codCidadao;
        return $this;
    }

    /**
     * Get codCidadao
     *
     * @return integer
     */
    public function getCodCidadao()
    {
        return $this->codCidadao;
    }

    /**
     * Set nomCidadao
     *
     * @param string $nomCidadao
     * @return VwQualificacaoEscolar
     */
    public function setNomCidadao($nomCidadao = null)
    {
        $this->nomCidadao = $nomCidadao;
        return $this;
    }

    /**
     * Get nomCidadao
     *
     * @return string
     */
    public function getNomCidadao()
    {
        return $this->nomCidadao;
    }

    /**
     * Set codGrau
     *
     * @param integer $codGrau
     * @return VwQualificacaoEscolar
     */
    public function setCodGrau($codGrau = null)
    {
        $this->codGrau = $codGrau;
        return $this;
    }

    /**
     * Get codGrau
     *
     * @return integer
     */
    public function getCodGrau()
    {
        return $this->codGrau;
    }

    /**
     * Set nomGrau
     *
     * @param string $nomGrau
     * @return VwQualificacaoEscolar
     */
    public function setNomGrau($nomGrau = null)
    {
        $this->nomGrau = $nomGrau;
        return $this;
    }

    /**
     * Get nomGrau
     *
     * @return string
     */
    public function getNomGrau()
    {
        return $this->nomGrau;
    }

    /**
     * Set serie
     *
     * @param string $serie
     * @return VwQualificacaoEscolar
     */
    public function setSerie($serie = null)
    {
        $this->serie = $serie;
        return $this;
    }

    /**
     * Get serie
     *
     * @return string
     */
    public function getSerie()
    {
        return $this->serie;
    }

    /**
     * Set frequencia
     *
     * @param string $frequencia
     * @return VwQualificacaoEscolar
     */
    public function setFrequencia($frequencia = null)
    {
        $this->frequencia = $frequencia;
        return $this;
    }

    /**
     * Get frequencia
     *
     * @return string
     */
    public function getFrequencia()
    {
        return $this->frequencia;
    }

    /**
     * Set codInstituicao
     *
     * @param integer $codInstituicao
     * @return VwQualificacaoEscolar
     */
    public function setCodInstituicao($codInstituicao = null)
    {
        $this->codInstituicao = $codInstituicao;
        return $this;
    }

    /**
     * Get codInstituicao
     *
     * @return integer
     */
    public function getCodInstituicao()
    {
        return $this->codInstituicao;
    }

    /**
     * Set nomInstituicao
     *
     * @param string $nomInstituicao
     * @return VwQualificacaoEscolar
     */
    public function setNomInstituicao($nomInstituicao = null)
    {
        $this->nomInstituicao = $nomInstituicao;
        return $this;
    }

    /**
     * Get nomInstituicao
     *
     * @return string
     */
    public function getNomInstituicao()
    {
        return $this->nomInstituicao;
    }
}
