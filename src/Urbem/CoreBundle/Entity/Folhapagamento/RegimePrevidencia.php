<?php
 
namespace Urbem\CoreBundle\Entity\Folhapagamento;

/**
 * RegimePrevidencia
 */
class RegimePrevidencia
{
    /**
     * PK
     * @var integer
     */
    private $codRegimePrevidencia;

    /**
     * @var string
     */
    private $descricao;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\SalarioFamilia
     */
    private $fkFolhapagamentoSalarioFamilias;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\AssentamentoAssentamento
     */
    private $fkPessoalAssentamentoAssentamentos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\Ocorrencia
     */
    private $fkPessoalOcorrencias;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\Previdencia
     */
    private $fkFolhapagamentoPrevidencias;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkFolhapagamentoSalarioFamilias = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkPessoalAssentamentoAssentamentos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkPessoalOcorrencias = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkFolhapagamentoPrevidencias = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codRegimePrevidencia
     *
     * @param integer $codRegimePrevidencia
     * @return RegimePrevidencia
     */
    public function setCodRegimePrevidencia($codRegimePrevidencia)
    {
        $this->codRegimePrevidencia = $codRegimePrevidencia;
        return $this;
    }

    /**
     * Get codRegimePrevidencia
     *
     * @return integer
     */
    public function getCodRegimePrevidencia()
    {
        return $this->codRegimePrevidencia;
    }

    /**
     * Set descricao
     *
     * @param string $descricao
     * @return RegimePrevidencia
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
     * Add FolhapagamentoSalarioFamilia
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\SalarioFamilia $fkFolhapagamentoSalarioFamilia
     * @return RegimePrevidencia
     */
    public function addFkFolhapagamentoSalarioFamilias(\Urbem\CoreBundle\Entity\Folhapagamento\SalarioFamilia $fkFolhapagamentoSalarioFamilia)
    {
        if (false === $this->fkFolhapagamentoSalarioFamilias->contains($fkFolhapagamentoSalarioFamilia)) {
            $fkFolhapagamentoSalarioFamilia->setFkFolhapagamentoRegimePrevidencia($this);
            $this->fkFolhapagamentoSalarioFamilias->add($fkFolhapagamentoSalarioFamilia);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FolhapagamentoSalarioFamilia
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\SalarioFamilia $fkFolhapagamentoSalarioFamilia
     */
    public function removeFkFolhapagamentoSalarioFamilias(\Urbem\CoreBundle\Entity\Folhapagamento\SalarioFamilia $fkFolhapagamentoSalarioFamilia)
    {
        $this->fkFolhapagamentoSalarioFamilias->removeElement($fkFolhapagamentoSalarioFamilia);
    }

    /**
     * OneToMany (owning side)
     * Get fkFolhapagamentoSalarioFamilias
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\SalarioFamilia
     */
    public function getFkFolhapagamentoSalarioFamilias()
    {
        return $this->fkFolhapagamentoSalarioFamilias;
    }

    /**
     * OneToMany (owning side)
     * Add PessoalAssentamentoAssentamento
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\AssentamentoAssentamento $fkPessoalAssentamentoAssentamento
     * @return RegimePrevidencia
     */
    public function addFkPessoalAssentamentoAssentamentos(\Urbem\CoreBundle\Entity\Pessoal\AssentamentoAssentamento $fkPessoalAssentamentoAssentamento)
    {
        if (false === $this->fkPessoalAssentamentoAssentamentos->contains($fkPessoalAssentamentoAssentamento)) {
            $fkPessoalAssentamentoAssentamento->setFkFolhapagamentoRegimePrevidencia($this);
            $this->fkPessoalAssentamentoAssentamentos->add($fkPessoalAssentamentoAssentamento);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PessoalAssentamentoAssentamento
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\AssentamentoAssentamento $fkPessoalAssentamentoAssentamento
     */
    public function removeFkPessoalAssentamentoAssentamentos(\Urbem\CoreBundle\Entity\Pessoal\AssentamentoAssentamento $fkPessoalAssentamentoAssentamento)
    {
        $this->fkPessoalAssentamentoAssentamentos->removeElement($fkPessoalAssentamentoAssentamento);
    }

    /**
     * OneToMany (owning side)
     * Get fkPessoalAssentamentoAssentamentos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\AssentamentoAssentamento
     */
    public function getFkPessoalAssentamentoAssentamentos()
    {
        return $this->fkPessoalAssentamentoAssentamentos;
    }

    /**
     * OneToMany (owning side)
     * Add PessoalOcorrencia
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\Ocorrencia $fkPessoalOcorrencia
     * @return RegimePrevidencia
     */
    public function addFkPessoalOcorrencias(\Urbem\CoreBundle\Entity\Pessoal\Ocorrencia $fkPessoalOcorrencia)
    {
        if (false === $this->fkPessoalOcorrencias->contains($fkPessoalOcorrencia)) {
            $fkPessoalOcorrencia->setFkFolhapagamentoRegimePrevidencia($this);
            $this->fkPessoalOcorrencias->add($fkPessoalOcorrencia);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PessoalOcorrencia
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\Ocorrencia $fkPessoalOcorrencia
     */
    public function removeFkPessoalOcorrencias(\Urbem\CoreBundle\Entity\Pessoal\Ocorrencia $fkPessoalOcorrencia)
    {
        $this->fkPessoalOcorrencias->removeElement($fkPessoalOcorrencia);
    }

    /**
     * OneToMany (owning side)
     * Get fkPessoalOcorrencias
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\Ocorrencia
     */
    public function getFkPessoalOcorrencias()
    {
        return $this->fkPessoalOcorrencias;
    }

    /**
     * OneToMany (owning side)
     * Add FolhapagamentoPrevidencia
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\Previdencia $fkFolhapagamentoPrevidencia
     * @return RegimePrevidencia
     */
    public function addFkFolhapagamentoPrevidencias(\Urbem\CoreBundle\Entity\Folhapagamento\Previdencia $fkFolhapagamentoPrevidencia)
    {
        if (false === $this->fkFolhapagamentoPrevidencias->contains($fkFolhapagamentoPrevidencia)) {
            $fkFolhapagamentoPrevidencia->setFkFolhapagamentoRegimePrevidencia($this);
            $this->fkFolhapagamentoPrevidencias->add($fkFolhapagamentoPrevidencia);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FolhapagamentoPrevidencia
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\Previdencia $fkFolhapagamentoPrevidencia
     */
    public function removeFkFolhapagamentoPrevidencias(\Urbem\CoreBundle\Entity\Folhapagamento\Previdencia $fkFolhapagamentoPrevidencia)
    {
        $this->fkFolhapagamentoPrevidencias->removeElement($fkFolhapagamentoPrevidencia);
    }

    /**
     * OneToMany (owning side)
     * Get fkFolhapagamentoPrevidencias
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\Previdencia
     */
    public function getFkFolhapagamentoPrevidencias()
    {
        return $this->fkFolhapagamentoPrevidencias;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string) $this->descricao;
    }
}
