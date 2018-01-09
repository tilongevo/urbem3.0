<?php
 
namespace Urbem\CoreBundle\Entity\Licitacao;

/**
 * TipoTermoAditivo
 */
class TipoTermoAditivo
{
    /**
     * PK
     * @var integer
     */
    private $codTipo;

    /**
     * @var string
     */
    private $descricao;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Licitacao\ContratoAditivos
     */
    private $fkLicitacaoContratoAditivos;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkLicitacaoContratoAditivos = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codTipo
     *
     * @param integer $codTipo
     * @return TipoTermoAditivo
     */
    public function setCodTipo($codTipo)
    {
        $this->codTipo = $codTipo;
        return $this;
    }

    /**
     * Get codTipo
     *
     * @return integer
     */
    public function getCodTipo()
    {
        return $this->codTipo;
    }

    /**
     * Set descricao
     *
     * @param string $descricao
     * @return TipoTermoAditivo
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
     * Add LicitacaoContratoAditivos
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\ContratoAditivos $fkLicitacaoContratoAditivos
     * @return TipoTermoAditivo
     */
    public function addFkLicitacaoContratoAditivos(\Urbem\CoreBundle\Entity\Licitacao\ContratoAditivos $fkLicitacaoContratoAditivos)
    {
        if (false === $this->fkLicitacaoContratoAditivos->contains($fkLicitacaoContratoAditivos)) {
            $fkLicitacaoContratoAditivos->setFkLicitacaoTipoTermoAditivo($this);
            $this->fkLicitacaoContratoAditivos->add($fkLicitacaoContratoAditivos);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove LicitacaoContratoAditivos
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\ContratoAditivos $fkLicitacaoContratoAditivos
     */
    public function removeFkLicitacaoContratoAditivos(\Urbem\CoreBundle\Entity\Licitacao\ContratoAditivos $fkLicitacaoContratoAditivos)
    {
        $this->fkLicitacaoContratoAditivos->removeElement($fkLicitacaoContratoAditivos);
    }

    /**
     * OneToMany (owning side)
     * Get fkLicitacaoContratoAditivos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Licitacao\ContratoAditivos
     */
    public function getFkLicitacaoContratoAditivos()
    {
        return $this->fkLicitacaoContratoAditivos;
    }
}
