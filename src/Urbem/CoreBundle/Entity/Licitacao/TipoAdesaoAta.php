<?php
 
namespace Urbem\CoreBundle\Entity\Licitacao;

/**
 * TipoAdesaoAta
 */
class TipoAdesaoAta
{
    /**
     * PK
     * @var integer
     */
    private $codigo;

    /**
     * @var string
     */
    private $descricao;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Licitacao\Ata
     */
    private $fkLicitacaoAtas;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkLicitacaoAtas = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codigo
     *
     * @param integer $codigo
     * @return TipoAdesaoAta
     */
    public function setCodigo($codigo)
    {
        $this->codigo = $codigo;
        return $this;
    }

    /**
     * Get codigo
     *
     * @return integer
     */
    public function getCodigo()
    {
        return $this->codigo;
    }

    /**
     * Set descricao
     *
     * @param string $descricao
     * @return TipoAdesaoAta
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
     * Add LicitacaoAta
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\Ata $fkLicitacaoAta
     * @return TipoAdesaoAta
     */
    public function addFkLicitacaoAtas(\Urbem\CoreBundle\Entity\Licitacao\Ata $fkLicitacaoAta)
    {
        if (false === $this->fkLicitacaoAtas->contains($fkLicitacaoAta)) {
            $fkLicitacaoAta->setFkLicitacaoTipoAdesaoAta($this);
            $this->fkLicitacaoAtas->add($fkLicitacaoAta);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove LicitacaoAta
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\Ata $fkLicitacaoAta
     */
    public function removeFkLicitacaoAtas(\Urbem\CoreBundle\Entity\Licitacao\Ata $fkLicitacaoAta)
    {
        $this->fkLicitacaoAtas->removeElement($fkLicitacaoAta);
    }

    /**
     * OneToMany (owning side)
     * Get fkLicitacaoAtas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Licitacao\Ata
     */
    public function getFkLicitacaoAtas()
    {
        return $this->fkLicitacaoAtas;
    }
}
