<?php
 
namespace Urbem\CoreBundle\Entity\Pessoal;

/**
 * Categoria
 */
class Categoria
{
    /**
     * PK
     * @var integer
     */
    private $codCategoria;

    /**
     * @var string
     */
    private $descricao;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\FgtsCategoria
     */
    private $fkFolhapagamentoFgtsCategorias;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ima\CategoriaSefip
     */
    private $fkImaCategoriaSefips;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\MovSefipSaidaCategoria
     */
    private $fkPessoalMovSefipSaidaCategorias;

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
        $this->fkFolhapagamentoFgtsCategorias = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkImaCategoriaSefips = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkPessoalMovSefipSaidaCategorias = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkPessoalContratoServidores = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codCategoria
     *
     * @param integer $codCategoria
     * @return Categoria
     */
    public function setCodCategoria($codCategoria)
    {
        $this->codCategoria = $codCategoria;
        return $this;
    }

    /**
     * Get codCategoria
     *
     * @return integer
     */
    public function getCodCategoria()
    {
        return $this->codCategoria;
    }

    /**
     * Set descricao
     *
     * @param string $descricao
     * @return Categoria
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
     * Add FolhapagamentoFgtsCategoria
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\FgtsCategoria $fkFolhapagamentoFgtsCategoria
     * @return Categoria
     */
    public function addFkFolhapagamentoFgtsCategorias(\Urbem\CoreBundle\Entity\Folhapagamento\FgtsCategoria $fkFolhapagamentoFgtsCategoria)
    {
        if (false === $this->fkFolhapagamentoFgtsCategorias->contains($fkFolhapagamentoFgtsCategoria)) {
            $fkFolhapagamentoFgtsCategoria->setFkPessoalCategoria($this);
            $this->fkFolhapagamentoFgtsCategorias->add($fkFolhapagamentoFgtsCategoria);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FolhapagamentoFgtsCategoria
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\FgtsCategoria $fkFolhapagamentoFgtsCategoria
     */
    public function removeFkFolhapagamentoFgtsCategorias(\Urbem\CoreBundle\Entity\Folhapagamento\FgtsCategoria $fkFolhapagamentoFgtsCategoria)
    {
        $this->fkFolhapagamentoFgtsCategorias->removeElement($fkFolhapagamentoFgtsCategoria);
    }

    /**
     * OneToMany (owning side)
     * Get fkFolhapagamentoFgtsCategorias
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\FgtsCategoria
     */
    public function getFkFolhapagamentoFgtsCategorias()
    {
        return $this->fkFolhapagamentoFgtsCategorias;
    }

    /**
     * OneToMany (owning side)
     * Add ImaCategoriaSefip
     *
     * @param \Urbem\CoreBundle\Entity\Ima\CategoriaSefip $fkImaCategoriaSefip
     * @return Categoria
     */
    public function addFkImaCategoriaSefips(\Urbem\CoreBundle\Entity\Ima\CategoriaSefip $fkImaCategoriaSefip)
    {
        if (false === $this->fkImaCategoriaSefips->contains($fkImaCategoriaSefip)) {
            $fkImaCategoriaSefip->setFkPessoalCategoria($this);
            $this->fkImaCategoriaSefips->add($fkImaCategoriaSefip);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ImaCategoriaSefip
     *
     * @param \Urbem\CoreBundle\Entity\Ima\CategoriaSefip $fkImaCategoriaSefip
     */
    public function removeFkImaCategoriaSefips(\Urbem\CoreBundle\Entity\Ima\CategoriaSefip $fkImaCategoriaSefip)
    {
        $this->fkImaCategoriaSefips->removeElement($fkImaCategoriaSefip);
    }

    /**
     * OneToMany (owning side)
     * Get fkImaCategoriaSefips
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ima\CategoriaSefip
     */
    public function getFkImaCategoriaSefips()
    {
        return $this->fkImaCategoriaSefips;
    }

    /**
     * OneToMany (owning side)
     * Add PessoalMovSefipSaidaCategoria
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\MovSefipSaidaCategoria $fkPessoalMovSefipSaidaCategoria
     * @return Categoria
     */
    public function addFkPessoalMovSefipSaidaCategorias(\Urbem\CoreBundle\Entity\Pessoal\MovSefipSaidaCategoria $fkPessoalMovSefipSaidaCategoria)
    {
        if (false === $this->fkPessoalMovSefipSaidaCategorias->contains($fkPessoalMovSefipSaidaCategoria)) {
            $fkPessoalMovSefipSaidaCategoria->setFkPessoalCategoria($this);
            $this->fkPessoalMovSefipSaidaCategorias->add($fkPessoalMovSefipSaidaCategoria);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PessoalMovSefipSaidaCategoria
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\MovSefipSaidaCategoria $fkPessoalMovSefipSaidaCategoria
     */
    public function removeFkPessoalMovSefipSaidaCategorias(\Urbem\CoreBundle\Entity\Pessoal\MovSefipSaidaCategoria $fkPessoalMovSefipSaidaCategoria)
    {
        $this->fkPessoalMovSefipSaidaCategorias->removeElement($fkPessoalMovSefipSaidaCategoria);
    }

    /**
     * OneToMany (owning side)
     * Get fkPessoalMovSefipSaidaCategorias
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\MovSefipSaidaCategoria
     */
    public function getFkPessoalMovSefipSaidaCategorias()
    {
        return $this->fkPessoalMovSefipSaidaCategorias;
    }

    /**
     * OneToMany (owning side)
     * Add PessoalContratoServidor
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\ContratoServidor $fkPessoalContratoServidor
     * @return Categoria
     */
    public function addFkPessoalContratoServidores(\Urbem\CoreBundle\Entity\Pessoal\ContratoServidor $fkPessoalContratoServidor)
    {
        if (false === $this->fkPessoalContratoServidores->contains($fkPessoalContratoServidor)) {
            $fkPessoalContratoServidor->setFkPessoalCategoria($this);
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
