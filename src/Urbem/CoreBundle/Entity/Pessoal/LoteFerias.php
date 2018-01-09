<?php
 
namespace Urbem\CoreBundle\Entity\Pessoal;

/**
 * LoteFerias
 */
class LoteFerias
{
    /**
     * PK
     * @var integer
     */
    private $codLote;

    /**
     * @var string
     */
    private $nome;

    /**
     * @var string
     */
    private $mesCompetencia;

    /**
     * @var string
     */
    private $anoCompetencia;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\LoteFeriasLocal
     */
    private $fkPessoalLoteFeriasLocais;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\LoteFeriasFuncao
     */
    private $fkPessoalLoteFeriasFuncoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\LoteFeriasLote
     */
    private $fkPessoalLoteFeriasLotes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\LoteFeriasOrgao
     */
    private $fkPessoalLoteFeriasOrgoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\LoteFeriasContrato
     */
    private $fkPessoalLoteFeriasContratos;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkPessoalLoteFeriasLocais = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkPessoalLoteFeriasFuncoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkPessoalLoteFeriasLotes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkPessoalLoteFeriasOrgoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkPessoalLoteFeriasContratos = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codLote
     *
     * @param integer $codLote
     * @return LoteFerias
     */
    public function setCodLote($codLote)
    {
        $this->codLote = $codLote;
        return $this;
    }

    /**
     * Get codLote
     *
     * @return integer
     */
    public function getCodLote()
    {
        return $this->codLote;
    }

    /**
     * Set nome
     *
     * @param string $nome
     * @return LoteFerias
     */
    public function setNome($nome)
    {
        $this->nome = $nome;
        return $this;
    }

    /**
     * Get nome
     *
     * @return string
     */
    public function getNome()
    {
        return $this->nome;
    }

    /**
     * Set mesCompetencia
     *
     * @param string $mesCompetencia
     * @return LoteFerias
     */
    public function setMesCompetencia($mesCompetencia)
    {
        $this->mesCompetencia = $mesCompetencia;
        return $this;
    }

    /**
     * Get mesCompetencia
     *
     * @return string
     */
    public function getMesCompetencia()
    {
        return $this->mesCompetencia;
    }

    /**
     * Set anoCompetencia
     *
     * @param string $anoCompetencia
     * @return LoteFerias
     */
    public function setAnoCompetencia($anoCompetencia)
    {
        $this->anoCompetencia = $anoCompetencia;
        return $this;
    }

    /**
     * Get anoCompetencia
     *
     * @return string
     */
    public function getAnoCompetencia()
    {
        return $this->anoCompetencia;
    }

    /**
     * OneToMany (owning side)
     * Add PessoalLoteFeriasLocal
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\LoteFeriasLocal $fkPessoalLoteFeriasLocal
     * @return LoteFerias
     */
    public function addFkPessoalLoteFeriasLocais(\Urbem\CoreBundle\Entity\Pessoal\LoteFeriasLocal $fkPessoalLoteFeriasLocal)
    {
        if (false === $this->fkPessoalLoteFeriasLocais->contains($fkPessoalLoteFeriasLocal)) {
            $fkPessoalLoteFeriasLocal->setFkPessoalLoteFerias($this);
            $this->fkPessoalLoteFeriasLocais->add($fkPessoalLoteFeriasLocal);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PessoalLoteFeriasLocal
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\LoteFeriasLocal $fkPessoalLoteFeriasLocal
     */
    public function removeFkPessoalLoteFeriasLocais(\Urbem\CoreBundle\Entity\Pessoal\LoteFeriasLocal $fkPessoalLoteFeriasLocal)
    {
        $this->fkPessoalLoteFeriasLocais->removeElement($fkPessoalLoteFeriasLocal);
    }

    /**
     * OneToMany (owning side)
     * Get fkPessoalLoteFeriasLocais
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\LoteFeriasLocal
     */
    public function getFkPessoalLoteFeriasLocais()
    {
        return $this->fkPessoalLoteFeriasLocais;
    }

    /**
     * OneToMany (owning side)
     * Add PessoalLoteFeriasFuncao
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\LoteFeriasFuncao $fkPessoalLoteFeriasFuncao
     * @return LoteFerias
     */
    public function addFkPessoalLoteFeriasFuncoes(\Urbem\CoreBundle\Entity\Pessoal\LoteFeriasFuncao $fkPessoalLoteFeriasFuncao)
    {
        if (false === $this->fkPessoalLoteFeriasFuncoes->contains($fkPessoalLoteFeriasFuncao)) {
            $fkPessoalLoteFeriasFuncao->setFkPessoalLoteFerias($this);
            $this->fkPessoalLoteFeriasFuncoes->add($fkPessoalLoteFeriasFuncao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PessoalLoteFeriasFuncao
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\LoteFeriasFuncao $fkPessoalLoteFeriasFuncao
     */
    public function removeFkPessoalLoteFeriasFuncoes(\Urbem\CoreBundle\Entity\Pessoal\LoteFeriasFuncao $fkPessoalLoteFeriasFuncao)
    {
        $this->fkPessoalLoteFeriasFuncoes->removeElement($fkPessoalLoteFeriasFuncao);
    }

    /**
     * OneToMany (owning side)
     * Get fkPessoalLoteFeriasFuncoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\LoteFeriasFuncao
     */
    public function getFkPessoalLoteFeriasFuncoes()
    {
        return $this->fkPessoalLoteFeriasFuncoes;
    }

    /**
     * OneToMany (owning side)
     * Add PessoalLoteFeriasLote
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\LoteFeriasLote $fkPessoalLoteFeriasLote
     * @return LoteFerias
     */
    public function addFkPessoalLoteFeriasLotes(\Urbem\CoreBundle\Entity\Pessoal\LoteFeriasLote $fkPessoalLoteFeriasLote)
    {
        if (false === $this->fkPessoalLoteFeriasLotes->contains($fkPessoalLoteFeriasLote)) {
            $fkPessoalLoteFeriasLote->setFkPessoalLoteFerias($this);
            $this->fkPessoalLoteFeriasLotes->add($fkPessoalLoteFeriasLote);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PessoalLoteFeriasLote
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\LoteFeriasLote $fkPessoalLoteFeriasLote
     */
    public function removeFkPessoalLoteFeriasLotes(\Urbem\CoreBundle\Entity\Pessoal\LoteFeriasLote $fkPessoalLoteFeriasLote)
    {
        $this->fkPessoalLoteFeriasLotes->removeElement($fkPessoalLoteFeriasLote);
    }

    /**
     * OneToMany (owning side)
     * Get fkPessoalLoteFeriasLotes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\LoteFeriasLote
     */
    public function getFkPessoalLoteFeriasLotes()
    {
        return $this->fkPessoalLoteFeriasLotes;
    }

    /**
     * OneToMany (owning side)
     * Add PessoalLoteFeriasOrgao
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\LoteFeriasOrgao $fkPessoalLoteFeriasOrgao
     * @return LoteFerias
     */
    public function addFkPessoalLoteFeriasOrgoes(\Urbem\CoreBundle\Entity\Pessoal\LoteFeriasOrgao $fkPessoalLoteFeriasOrgao)
    {
        if (false === $this->fkPessoalLoteFeriasOrgoes->contains($fkPessoalLoteFeriasOrgao)) {
            $fkPessoalLoteFeriasOrgao->setFkPessoalLoteFerias($this);
            $this->fkPessoalLoteFeriasOrgoes->add($fkPessoalLoteFeriasOrgao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PessoalLoteFeriasOrgao
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\LoteFeriasOrgao $fkPessoalLoteFeriasOrgao
     */
    public function removeFkPessoalLoteFeriasOrgoes(\Urbem\CoreBundle\Entity\Pessoal\LoteFeriasOrgao $fkPessoalLoteFeriasOrgao)
    {
        $this->fkPessoalLoteFeriasOrgoes->removeElement($fkPessoalLoteFeriasOrgao);
    }

    /**
     * OneToMany (owning side)
     * Get fkPessoalLoteFeriasOrgoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\LoteFeriasOrgao
     */
    public function getFkPessoalLoteFeriasOrgoes()
    {
        return $this->fkPessoalLoteFeriasOrgoes;
    }

    /**
     * OneToMany (owning side)
     * Add PessoalLoteFeriasContrato
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\LoteFeriasContrato $fkPessoalLoteFeriasContrato
     * @return LoteFerias
     */
    public function addFkPessoalLoteFeriasContratos(\Urbem\CoreBundle\Entity\Pessoal\LoteFeriasContrato $fkPessoalLoteFeriasContrato)
    {
        if (false === $this->fkPessoalLoteFeriasContratos->contains($fkPessoalLoteFeriasContrato)) {
            $fkPessoalLoteFeriasContrato->setFkPessoalLoteFerias($this);
            $this->fkPessoalLoteFeriasContratos->add($fkPessoalLoteFeriasContrato);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PessoalLoteFeriasContrato
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\LoteFeriasContrato $fkPessoalLoteFeriasContrato
     */
    public function removeFkPessoalLoteFeriasContratos(\Urbem\CoreBundle\Entity\Pessoal\LoteFeriasContrato $fkPessoalLoteFeriasContrato)
    {
        $this->fkPessoalLoteFeriasContratos->removeElement($fkPessoalLoteFeriasContrato);
    }

    /**
     * OneToMany (owning side)
     * Get fkPessoalLoteFeriasContratos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\LoteFeriasContrato
     */
    public function getFkPessoalLoteFeriasContratos()
    {
        return $this->fkPessoalLoteFeriasContratos;
    }
}
