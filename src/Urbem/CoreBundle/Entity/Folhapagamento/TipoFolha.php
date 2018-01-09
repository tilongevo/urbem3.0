<?php
 
namespace Urbem\CoreBundle\Entity\Folhapagamento;

/**
 * TipoFolha
 */
class TipoFolha
{
    const TIPO_FERIAS = 1;
    const TIPO_SALARIO = 2;
    const TIPO_COMPLEMENTAR = 3;
    const TIPO_13_SALARIO = 4;
    const TIPO_RESCISAO = 5;

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
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\DeducaoDependente
     */
    private $fkFolhapagamentoDeducaoDependentes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ima\Pagamento910
     */
    private $fkImaPagamento910s;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\LancamentoFerias
     */
    private $fkPessoalLancamentoFerias;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkFolhapagamentoDeducaoDependentes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkImaPagamento910s = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkPessoalLancamentoFerias = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codTipo
     *
     * @param integer $codTipo
     * @return TipoFolha
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
     * @return TipoFolha
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
     * Add FolhapagamentoDeducaoDependente
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\DeducaoDependente $fkFolhapagamentoDeducaoDependente
     * @return TipoFolha
     */
    public function addFkFolhapagamentoDeducaoDependentes(\Urbem\CoreBundle\Entity\Folhapagamento\DeducaoDependente $fkFolhapagamentoDeducaoDependente)
    {
        if (false === $this->fkFolhapagamentoDeducaoDependentes->contains($fkFolhapagamentoDeducaoDependente)) {
            $fkFolhapagamentoDeducaoDependente->setFkFolhapagamentoTipoFolha($this);
            $this->fkFolhapagamentoDeducaoDependentes->add($fkFolhapagamentoDeducaoDependente);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FolhapagamentoDeducaoDependente
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\DeducaoDependente $fkFolhapagamentoDeducaoDependente
     */
    public function removeFkFolhapagamentoDeducaoDependentes(\Urbem\CoreBundle\Entity\Folhapagamento\DeducaoDependente $fkFolhapagamentoDeducaoDependente)
    {
        $this->fkFolhapagamentoDeducaoDependentes->removeElement($fkFolhapagamentoDeducaoDependente);
    }

    /**
     * OneToMany (owning side)
     * Get fkFolhapagamentoDeducaoDependentes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\DeducaoDependente
     */
    public function getFkFolhapagamentoDeducaoDependentes()
    {
        return $this->fkFolhapagamentoDeducaoDependentes;
    }

    /**
     * OneToMany (owning side)
     * Add ImaPagamento910
     *
     * @param \Urbem\CoreBundle\Entity\Ima\Pagamento910 $fkImaPagamento910
     * @return TipoFolha
     */
    public function addFkImaPagamento910s(\Urbem\CoreBundle\Entity\Ima\Pagamento910 $fkImaPagamento910)
    {
        if (false === $this->fkImaPagamento910s->contains($fkImaPagamento910)) {
            $fkImaPagamento910->setFkFolhapagamentoTipoFolha($this);
            $this->fkImaPagamento910s->add($fkImaPagamento910);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ImaPagamento910
     *
     * @param \Urbem\CoreBundle\Entity\Ima\Pagamento910 $fkImaPagamento910
     */
    public function removeFkImaPagamento910s(\Urbem\CoreBundle\Entity\Ima\Pagamento910 $fkImaPagamento910)
    {
        $this->fkImaPagamento910s->removeElement($fkImaPagamento910);
    }

    /**
     * OneToMany (owning side)
     * Get fkImaPagamento910s
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ima\Pagamento910
     */
    public function getFkImaPagamento910s()
    {
        return $this->fkImaPagamento910s;
    }

    /**
     * OneToMany (owning side)
     * Add PessoalLancamentoFerias
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\LancamentoFerias $fkPessoalLancamentoFerias
     * @return TipoFolha
     */
    public function addFkPessoalLancamentoFerias(\Urbem\CoreBundle\Entity\Pessoal\LancamentoFerias $fkPessoalLancamentoFerias)
    {
        if (false === $this->fkPessoalLancamentoFerias->contains($fkPessoalLancamentoFerias)) {
            $fkPessoalLancamentoFerias->setFkFolhapagamentoTipoFolha($this);
            $this->fkPessoalLancamentoFerias->add($fkPessoalLancamentoFerias);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PessoalLancamentoFerias
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\LancamentoFerias $fkPessoalLancamentoFerias
     */
    public function removeFkPessoalLancamentoFerias(\Urbem\CoreBundle\Entity\Pessoal\LancamentoFerias $fkPessoalLancamentoFerias)
    {
        $this->fkPessoalLancamentoFerias->removeElement($fkPessoalLancamentoFerias);
    }

    /**
     * OneToMany (owning side)
     * Get fkPessoalLancamentoFerias
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\LancamentoFerias
     */
    public function getFkPessoalLancamentoFerias()
    {
        return $this->fkPessoalLancamentoFerias;
    }
}
