<?php
 
namespace Urbem\CoreBundle\Entity\Cse;

/**
 * VwQualificacaoProfissionalView
 */
class VwQualificacaoProfissionalView
{
    /**
     * PK
     * @var \DateTime
     */
    private $dtAdmissao;

    /**
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
    private $codProfissao;

    /**
     * @var string
     */
    private $nomProfissao;


    /**
     * Set dtAdmissao
     *
     * @param \DateTime $dtAdmissao
     * @return VwQualificacaoProfissional
     */
    public function setDtAdmissao(\DateTime $dtAdmissao)
    {
        $this->dtAdmissao = $dtAdmissao;
        return $this;
    }

    /**
     * Get dtAdmissao
     *
     * @return \DateTime
     */
    public function getDtAdmissao()
    {
        return $this->dtAdmissao;
    }

    /**
     * Set codCidadao
     *
     * @param integer $codCidadao
     * @return VwQualificacaoProfissional
     */
    public function setCodCidadao($codCidadao = null)
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
     * @return VwQualificacaoProfissional
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
     * Set codProfissao
     *
     * @param integer $codProfissao
     * @return VwQualificacaoProfissional
     */
    public function setCodProfissao($codProfissao = null)
    {
        $this->codProfissao = $codProfissao;
        return $this;
    }

    /**
     * Get codProfissao
     *
     * @return integer
     */
    public function getCodProfissao()
    {
        return $this->codProfissao;
    }

    /**
     * Set nomProfissao
     *
     * @param string $nomProfissao
     * @return VwQualificacaoProfissional
     */
    public function setNomProfissao($nomProfissao = null)
    {
        $this->nomProfissao = $nomProfissao;
        return $this;
    }

    /**
     * Get nomProfissao
     *
     * @return string
     */
    public function getNomProfissao()
    {
        return $this->nomProfissao;
    }
}
