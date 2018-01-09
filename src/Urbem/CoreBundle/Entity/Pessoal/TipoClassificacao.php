<?php
 
namespace Urbem\CoreBundle\Entity\Pessoal;

/**
 * TipoClassificacao
 */
class TipoClassificacao
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
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\ClassificacaoAssentamento
     */
    private $fkPessoalClassificacaoAssentamentos;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkPessoalClassificacaoAssentamentos = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codTipo
     *
     * @param integer $codTipo
     * @return TipoClassificacao
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
     * @return TipoClassificacao
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
     * Add PessoalClassificacaoAssentamento
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\ClassificacaoAssentamento $fkPessoalClassificacaoAssentamento
     * @return TipoClassificacao
     */
    public function addFkPessoalClassificacaoAssentamentos(\Urbem\CoreBundle\Entity\Pessoal\ClassificacaoAssentamento $fkPessoalClassificacaoAssentamento)
    {
        if (false === $this->fkPessoalClassificacaoAssentamentos->contains($fkPessoalClassificacaoAssentamento)) {
            $fkPessoalClassificacaoAssentamento->setFkPessoalTipoClassificacao($this);
            $this->fkPessoalClassificacaoAssentamentos->add($fkPessoalClassificacaoAssentamento);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PessoalClassificacaoAssentamento
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\ClassificacaoAssentamento $fkPessoalClassificacaoAssentamento
     */
    public function removeFkPessoalClassificacaoAssentamentos(\Urbem\CoreBundle\Entity\Pessoal\ClassificacaoAssentamento $fkPessoalClassificacaoAssentamento)
    {
        $this->fkPessoalClassificacaoAssentamentos->removeElement($fkPessoalClassificacaoAssentamento);
    }

    /**
     * OneToMany (owning side)
     * Get fkPessoalClassificacaoAssentamentos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\ClassificacaoAssentamento
     */
    public function getFkPessoalClassificacaoAssentamentos()
    {
        return $this->fkPessoalClassificacaoAssentamentos;
    }
}
