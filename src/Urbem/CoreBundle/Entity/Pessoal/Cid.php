<?php

namespace Urbem\CoreBundle\Entity\Pessoal;

/**
 * Cid
 */
class Cid
{
    /**
     * PK
     * @var integer
     */
    private $codCid;

    /**
     * @var string
     */
    private $sigla;

    /**
     * @var string
     */
    private $descricao;

    /**
     * @var integer
     */
    private $codTipoDeficiencia;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\PensionistaCid
     */
    private $fkPessoalPensionistaCids;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\ServidorCid
     */
    private $fkPessoalServidorCids;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\TabelaIrrfCid
     */
    private $fkFolhapagamentoTabelaIrrfCids;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\DependenteCid
     */
    private $fkPessoalDependenteCids;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Pessoal\TipoDeficiencia
     */
    private $fkPessoalTipoDeficiencia;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkPessoalPensionistaCids = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkPessoalServidorCids = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkFolhapagamentoTabelaIrrfCids = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkPessoalDependenteCids = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codCid
     *
     * @param integer $codCid
     * @return Cid
     */
    public function setCodCid($codCid)
    {
        $this->codCid = $codCid;
        return $this;
    }

    /**
     * Get codCid
     *
     * @return integer
     */
    public function getCodCid()
    {
        return $this->codCid;
    }

    /**
     * Set sigla
     *
     * @param string $sigla
     * @return Cid
     */
    public function setSigla($sigla)
    {
        $this->sigla = $sigla;
        return $this;
    }

    /**
     * Get sigla
     *
     * @return string
     */
    public function getSigla()
    {
        return $this->sigla;
    }

    /**
     * Set descricao
     *
     * @param string $descricao
     * @return Cid
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
     * Set codTipoDeficiencia
     *
     * @param integer $codTipoDeficiencia
     * @return Cid
     */
    public function setCodTipoDeficiencia($codTipoDeficiencia)
    {
        $this->codTipoDeficiencia = $codTipoDeficiencia;
        return $this;
    }

    /**
     * Get codTipoDeficiencia
     *
     * @return integer
     */
    public function getCodTipoDeficiencia()
    {
        return $this->codTipoDeficiencia;
    }

    /**
     * OneToMany (owning side)
     * Add PessoalPensionistaCid
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\PensionistaCid $fkPessoalPensionistaCid
     * @return Cid
     */
    public function addFkPessoalPensionistaCids(\Urbem\CoreBundle\Entity\Pessoal\PensionistaCid $fkPessoalPensionistaCid)
    {
        if (false === $this->fkPessoalPensionistaCids->contains($fkPessoalPensionistaCid)) {
            $fkPessoalPensionistaCid->setFkPessoalCid($this);
            $this->fkPessoalPensionistaCids->add($fkPessoalPensionistaCid);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PessoalPensionistaCid
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\PensionistaCid $fkPessoalPensionistaCid
     */
    public function removeFkPessoalPensionistaCids(\Urbem\CoreBundle\Entity\Pessoal\PensionistaCid $fkPessoalPensionistaCid)
    {
        $this->fkPessoalPensionistaCids->removeElement($fkPessoalPensionistaCid);
    }

    /**
     * OneToMany (owning side)
     * Get fkPessoalPensionistaCids
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\PensionistaCid
     */
    public function getFkPessoalPensionistaCids()
    {
        return $this->fkPessoalPensionistaCids;
    }

    /**
     * OneToMany (owning side)
     * Add PessoalServidorCid
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\ServidorCid $fkPessoalServidorCid
     * @return Cid
     */
    public function addFkPessoalServidorCids(\Urbem\CoreBundle\Entity\Pessoal\ServidorCid $fkPessoalServidorCid)
    {
        if (false === $this->fkPessoalServidorCids->contains($fkPessoalServidorCid)) {
            $fkPessoalServidorCid->setFkPessoalCid($this);
            $this->fkPessoalServidorCids->add($fkPessoalServidorCid);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PessoalServidorCid
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\ServidorCid $fkPessoalServidorCid
     */
    public function removeFkPessoalServidorCids(\Urbem\CoreBundle\Entity\Pessoal\ServidorCid $fkPessoalServidorCid)
    {
        $this->fkPessoalServidorCids->removeElement($fkPessoalServidorCid);
    }

    /**
     * OneToMany (owning side)
     * Get fkPessoalServidorCids
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\ServidorCid
     */
    public function getFkPessoalServidorCids()
    {
        return $this->fkPessoalServidorCids;
    }

    /**
     * OneToMany (owning side)
     * Add FolhapagamentoTabelaIrrfCid
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\TabelaIrrfCid $fkFolhapagamentoTabelaIrrfCid
     * @return Cid
     */
    public function addFkFolhapagamentoTabelaIrrfCids(\Urbem\CoreBundle\Entity\Folhapagamento\TabelaIrrfCid $fkFolhapagamentoTabelaIrrfCid)
    {
        if (false === $this->fkFolhapagamentoTabelaIrrfCids->contains($fkFolhapagamentoTabelaIrrfCid)) {
            $fkFolhapagamentoTabelaIrrfCid->setFkPessoalCid($this);
            $this->fkFolhapagamentoTabelaIrrfCids->add($fkFolhapagamentoTabelaIrrfCid);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FolhapagamentoTabelaIrrfCid
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\TabelaIrrfCid $fkFolhapagamentoTabelaIrrfCid
     */
    public function removeFkFolhapagamentoTabelaIrrfCids(\Urbem\CoreBundle\Entity\Folhapagamento\TabelaIrrfCid $fkFolhapagamentoTabelaIrrfCid)
    {
        $this->fkFolhapagamentoTabelaIrrfCids->removeElement($fkFolhapagamentoTabelaIrrfCid);
    }

    /**
     * OneToMany (owning side)
     * Get fkFolhapagamentoTabelaIrrfCids
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\TabelaIrrfCid
     */
    public function getFkFolhapagamentoTabelaIrrfCids()
    {
        return $this->fkFolhapagamentoTabelaIrrfCids;
    }

    /**
     * OneToMany (owning side)
     * Add PessoalDependenteCid
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\DependenteCid $fkPessoalDependenteCid
     * @return Cid
     */
    public function addFkPessoalDependenteCids(\Urbem\CoreBundle\Entity\Pessoal\DependenteCid $fkPessoalDependenteCid)
    {
        if (false === $this->fkPessoalDependenteCids->contains($fkPessoalDependenteCid)) {
            $fkPessoalDependenteCid->setFkPessoalCid($this);
            $this->fkPessoalDependenteCids->add($fkPessoalDependenteCid);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PessoalDependenteCid
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\DependenteCid $fkPessoalDependenteCid
     */
    public function removeFkPessoalDependenteCids(\Urbem\CoreBundle\Entity\Pessoal\DependenteCid $fkPessoalDependenteCid)
    {
        $this->fkPessoalDependenteCids->removeElement($fkPessoalDependenteCid);
    }

    /**
     * OneToMany (owning side)
     * Get fkPessoalDependenteCids
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\DependenteCid
     */
    public function getFkPessoalDependenteCids()
    {
        return $this->fkPessoalDependenteCids;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkPessoalTipoDeficiencia
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\TipoDeficiencia $fkPessoalTipoDeficiencia
     * @return Cid
     */
    public function setFkPessoalTipoDeficiencia(\Urbem\CoreBundle\Entity\Pessoal\TipoDeficiencia $fkPessoalTipoDeficiencia)
    {
        $this->codTipoDeficiencia = $fkPessoalTipoDeficiencia->getCodTipoDeficiencia();
        $this->fkPessoalTipoDeficiencia = $fkPessoalTipoDeficiencia;

        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkPessoalTipoDeficiencia
     *
     * @return \Urbem\CoreBundle\Entity\Pessoal\TipoDeficiencia
     */
    public function getFkPessoalTipoDeficiencia()
    {
        return $this->fkPessoalTipoDeficiencia;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string) $this->descricao;
    }
}
