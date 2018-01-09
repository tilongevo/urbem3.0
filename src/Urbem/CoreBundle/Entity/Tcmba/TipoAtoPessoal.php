<?php
 
namespace Urbem\CoreBundle\Entity\Tcmba;

/**
 * TipoAtoPessoal
 */
class TipoAtoPessoal
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
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\TcmbaAssentamentoAtoPessoal
     */
    private $fkPessoalTcmbaAssentamentoAtoPessoais;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkPessoalTcmbaAssentamentoAtoPessoais = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codTipo
     *
     * @param integer $codTipo
     * @return TipoAtoPessoal
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
     * @return TipoAtoPessoal
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
     * Add PessoalTcmbaAssentamentoAtoPessoal
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\TcmbaAssentamentoAtoPessoal $fkPessoalTcmbaAssentamentoAtoPessoal
     * @return TipoAtoPessoal
     */
    public function addFkPessoalTcmbaAssentamentoAtoPessoais(\Urbem\CoreBundle\Entity\Pessoal\TcmbaAssentamentoAtoPessoal $fkPessoalTcmbaAssentamentoAtoPessoal)
    {
        if (false === $this->fkPessoalTcmbaAssentamentoAtoPessoais->contains($fkPessoalTcmbaAssentamentoAtoPessoal)) {
            $fkPessoalTcmbaAssentamentoAtoPessoal->setFkTcmbaTipoAtoPessoal($this);
            $this->fkPessoalTcmbaAssentamentoAtoPessoais->add($fkPessoalTcmbaAssentamentoAtoPessoal);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PessoalTcmbaAssentamentoAtoPessoal
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\TcmbaAssentamentoAtoPessoal $fkPessoalTcmbaAssentamentoAtoPessoal
     */
    public function removeFkPessoalTcmbaAssentamentoAtoPessoais(\Urbem\CoreBundle\Entity\Pessoal\TcmbaAssentamentoAtoPessoal $fkPessoalTcmbaAssentamentoAtoPessoal)
    {
        $this->fkPessoalTcmbaAssentamentoAtoPessoais->removeElement($fkPessoalTcmbaAssentamentoAtoPessoal);
    }

    /**
     * OneToMany (owning side)
     * Get fkPessoalTcmbaAssentamentoAtoPessoais
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\TcmbaAssentamentoAtoPessoal
     */
    public function getFkPessoalTcmbaAssentamentoAtoPessoais()
    {
        return $this->fkPessoalTcmbaAssentamentoAtoPessoais;
    }
}
