<?php
 
namespace Urbem\CoreBundle\Entity\Licitacao;

/**
 * TipoConvenio
 */
class TipoConvenio
{
    /**
     * PK
     * @var integer
     */
    private $codTipoConvenio;

    /**
     * PK
     * @var integer
     */
    private $codUfTipoConvenio;

    /**
     * @var string
     */
    private $descricao;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Licitacao\Convenio
     */
    private $fkLicitacaoConvenios;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkLicitacaoConvenios = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codTipoConvenio
     *
     * @param integer $codTipoConvenio
     * @return TipoConvenio
     */
    public function setCodTipoConvenio($codTipoConvenio)
    {
        $this->codTipoConvenio = $codTipoConvenio;
        return $this;
    }

    /**
     * Get codTipoConvenio
     *
     * @return integer
     */
    public function getCodTipoConvenio()
    {
        return $this->codTipoConvenio;
    }

    /**
     * Set codUfTipoConvenio
     *
     * @param integer $codUfTipoConvenio
     * @return TipoConvenio
     */
    public function setCodUfTipoConvenio($codUfTipoConvenio)
    {
        $this->codUfTipoConvenio = $codUfTipoConvenio;
        return $this;
    }

    /**
     * Get codUfTipoConvenio
     *
     * @return integer
     */
    public function getCodUfTipoConvenio()
    {
        return $this->codUfTipoConvenio;
    }

    /**
     * Set descricao
     *
     * @param string $descricao
     * @return TipoConvenio
     */
    public function setDescricao($descricao = null)
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
     * Add LicitacaoConvenio
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\Convenio $fkLicitacaoConvenio
     * @return TipoConvenio
     */
    public function addFkLicitacaoConvenios(\Urbem\CoreBundle\Entity\Licitacao\Convenio $fkLicitacaoConvenio)
    {
        if (false === $this->fkLicitacaoConvenios->contains($fkLicitacaoConvenio)) {
            $fkLicitacaoConvenio->setFkLicitacaoTipoConvenio($this);
            $this->fkLicitacaoConvenios->add($fkLicitacaoConvenio);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove LicitacaoConvenio
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\Convenio $fkLicitacaoConvenio
     */
    public function removeFkLicitacaoConvenios(\Urbem\CoreBundle\Entity\Licitacao\Convenio $fkLicitacaoConvenio)
    {
        $this->fkLicitacaoConvenios->removeElement($fkLicitacaoConvenio);
    }

    /**
     * OneToMany (owning side)
     * Get fkLicitacaoConvenios
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Licitacao\Convenio
     */
    public function getFkLicitacaoConvenios()
    {
        return $this->fkLicitacaoConvenios;
    }
}
