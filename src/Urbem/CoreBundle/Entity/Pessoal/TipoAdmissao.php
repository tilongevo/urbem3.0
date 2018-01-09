<?php
 
namespace Urbem\CoreBundle\Entity\Pessoal;

/**
 * TipoAdmissao
 */
class TipoAdmissao
{
    /**
     * PK
     * @var integer
     */
    private $codTipoAdmissao;

    /**
     * @var string
     */
    private $descricao;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\TipoAdmissaoCaged
     */
    private $fkPessoalTipoAdmissaoCageds;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\ContratoServidor
     */
    private $fkPessoalContratoServidores;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkPessoalTipoAdmissaoCageds = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkPessoalContratoServidores = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codTipoAdmissao
     *
     * @param integer $codTipoAdmissao
     * @return TipoAdmissao
     */
    public function setCodTipoAdmissao($codTipoAdmissao)
    {
        $this->codTipoAdmissao = $codTipoAdmissao;
        return $this;
    }

    /**
     * Get codTipoAdmissao
     *
     * @return integer
     */
    public function getCodTipoAdmissao()
    {
        return $this->codTipoAdmissao;
    }

    /**
     * Set descricao
     *
     * @param string $descricao
     * @return TipoAdmissao
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
     * Add PessoalTipoAdmissaoCaged
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\TipoAdmissaoCaged $fkPessoalTipoAdmissaoCaged
     * @return TipoAdmissao
     */
    public function addFkPessoalTipoAdmissaoCageds(\Urbem\CoreBundle\Entity\Pessoal\TipoAdmissaoCaged $fkPessoalTipoAdmissaoCaged)
    {
        if (false === $this->fkPessoalTipoAdmissaoCageds->contains($fkPessoalTipoAdmissaoCaged)) {
            $fkPessoalTipoAdmissaoCaged->setFkPessoalTipoAdmissao($this);
            $this->fkPessoalTipoAdmissaoCageds->add($fkPessoalTipoAdmissaoCaged);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PessoalTipoAdmissaoCaged
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\TipoAdmissaoCaged $fkPessoalTipoAdmissaoCaged
     */
    public function removeFkPessoalTipoAdmissaoCageds(\Urbem\CoreBundle\Entity\Pessoal\TipoAdmissaoCaged $fkPessoalTipoAdmissaoCaged)
    {
        $this->fkPessoalTipoAdmissaoCageds->removeElement($fkPessoalTipoAdmissaoCaged);
    }

    /**
     * OneToMany (owning side)
     * Get fkPessoalTipoAdmissaoCageds
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\TipoAdmissaoCaged
     */
    public function getFkPessoalTipoAdmissaoCageds()
    {
        return $this->fkPessoalTipoAdmissaoCageds;
    }

    /**
     * OneToMany (owning side)
     * Add PessoalContratoServidor
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\ContratoServidor $fkPessoalContratoServidor
     * @return TipoAdmissao
     */
    public function addFkPessoalContratoServidores(\Urbem\CoreBundle\Entity\Pessoal\ContratoServidor $fkPessoalContratoServidor)
    {
        if (false === $this->fkPessoalContratoServidores->contains($fkPessoalContratoServidor)) {
            $fkPessoalContratoServidor->setFkPessoalTipoAdmissao($this);
            $this->fkPessoalContratoServidores->add($fkPessoalContratoServidor);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PessoalContratoServidor
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\ContratoServidor $fkPessoalContratoServidor
     */
    public function removeFkPessoalContratoServidores(\Urbem\CoreBundle\Entity\Pessoal\ContratoServidor $fkPessoalContratoServidor)
    {
        $this->fkPessoalContratoServidores->removeElement($fkPessoalContratoServidor);
    }

    /**
     * OneToMany (owning side)
     * Get fkPessoalContratoServidores
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\ContratoServidor
     */
    public function getFkPessoalContratoServidores()
    {
        return $this->fkPessoalContratoServidores;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string) $this->getDescricao();
    }
}
