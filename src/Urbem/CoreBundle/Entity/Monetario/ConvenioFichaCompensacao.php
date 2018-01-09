<?php
 
namespace Urbem\CoreBundle\Entity\Monetario;

/**
 * ConvenioFichaCompensacao
 */
class ConvenioFichaCompensacao
{
    /**
     * PK
     * @var integer
     */
    private $codConvenio;

    /**
     * @var string
     */
    private $localPagamento;

    /**
     * @var string
     */
    private $especieDoc;

    /**
     * @var string
     */
    private $aceite;

    /**
     * @var string
     */
    private $especie;

    /**
     * @var string
     */
    private $quantidade;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Monetario\Convenio
     */
    private $fkMonetarioConvenio;


    /**
     * Set codConvenio
     *
     * @param integer $codConvenio
     * @return ConvenioFichaCompensacao
     */
    public function setCodConvenio($codConvenio)
    {
        $this->codConvenio = $codConvenio;
        return $this;
    }

    /**
     * Get codConvenio
     *
     * @return integer
     */
    public function getCodConvenio()
    {
        return $this->codConvenio;
    }

    /**
     * Set localPagamento
     *
     * @param string $localPagamento
     * @return ConvenioFichaCompensacao
     */
    public function setLocalPagamento($localPagamento = null)
    {
        $this->localPagamento = $localPagamento;
        return $this;
    }

    /**
     * Get localPagamento
     *
     * @return string
     */
    public function getLocalPagamento()
    {
        return $this->localPagamento;
    }

    /**
     * Set especieDoc
     *
     * @param string $especieDoc
     * @return ConvenioFichaCompensacao
     */
    public function setEspecieDoc($especieDoc = null)
    {
        $this->especieDoc = $especieDoc;
        return $this;
    }

    /**
     * Get especieDoc
     *
     * @return string
     */
    public function getEspecieDoc()
    {
        return $this->especieDoc;
    }

    /**
     * Set aceite
     *
     * @param string $aceite
     * @return ConvenioFichaCompensacao
     */
    public function setAceite($aceite = null)
    {
        $this->aceite = $aceite;
        return $this;
    }

    /**
     * Get aceite
     *
     * @return string
     */
    public function getAceite()
    {
        return $this->aceite;
    }

    /**
     * Set especie
     *
     * @param string $especie
     * @return ConvenioFichaCompensacao
     */
    public function setEspecie($especie = null)
    {
        $this->especie = $especie;
        return $this;
    }

    /**
     * Get especie
     *
     * @return string
     */
    public function getEspecie()
    {
        return $this->especie;
    }

    /**
     * Set quantidade
     *
     * @param string $quantidade
     * @return ConvenioFichaCompensacao
     */
    public function setQuantidade($quantidade = null)
    {
        $this->quantidade = $quantidade;
        return $this;
    }

    /**
     * Get quantidade
     *
     * @return string
     */
    public function getQuantidade()
    {
        return $this->quantidade;
    }

    /**
     * OneToOne (owning side)
     * Set MonetarioConvenio
     *
     * @param \Urbem\CoreBundle\Entity\Monetario\Convenio $fkMonetarioConvenio
     * @return ConvenioFichaCompensacao
     */
    public function setFkMonetarioConvenio(\Urbem\CoreBundle\Entity\Monetario\Convenio $fkMonetarioConvenio)
    {
        $this->codConvenio = $fkMonetarioConvenio->getCodConvenio();
        $this->fkMonetarioConvenio = $fkMonetarioConvenio;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkMonetarioConvenio
     *
     * @return \Urbem\CoreBundle\Entity\Monetario\Convenio
     */
    public function getFkMonetarioConvenio()
    {
        return $this->fkMonetarioConvenio;
    }
}
