<?php

namespace Urbem\CoreBundle\Entity\Pessoal;

/**
 * ClassificacaoAssentamento
 */
class ClassificacaoAssentamento
{
    /**
     * PK
     * @var integer
     */
    private $codClassificacao;

    /**
     * @var string
     */
    private $descricao;

    /**
     * @var integer
     */
    private $codTipo;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\AssentamentoAssentamento
     */
    private $fkPessoalAssentamentoAssentamentos;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Pessoal\TipoClassificacao
     */
    private $fkPessoalTipoClassificacao;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkPessoalAssentamentoAssentamentos = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codClassificacao
     *
     * @param integer $codClassificacao
     * @return ClassificacaoAssentamento
     */
    public function setCodClassificacao($codClassificacao)
    {
        $this->codClassificacao = $codClassificacao;
        return $this;
    }

    /**
     * Get codClassificacao
     *
     * @return integer
     */
    public function getCodClassificacao()
    {
        return $this->codClassificacao;
    }

    /**
     * Set descricao
     *
     * @param string $descricao
     * @return ClassificacaoAssentamento
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
     * Set codTipo
     *
     * @param integer $codTipo
     * @return ClassificacaoAssentamento
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
     * OneToMany (owning side)
     * Add PessoalAssentamentoAssentamento
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\AssentamentoAssentamento $fkPessoalAssentamentoAssentamento
     * @return ClassificacaoAssentamento
     */
    public function addFkPessoalAssentamentoAssentamentos(\Urbem\CoreBundle\Entity\Pessoal\AssentamentoAssentamento $fkPessoalAssentamentoAssentamento)
    {
        if (false === $this->fkPessoalAssentamentoAssentamentos->contains($fkPessoalAssentamentoAssentamento)) {
            $fkPessoalAssentamentoAssentamento->setFkPessoalClassificacaoAssentamento($this);
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
     * ManyToOne (inverse side)
     * Set fkPessoalTipoClassificacao
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\TipoClassificacao $fkPessoalTipoClassificacao
     * @return ClassificacaoAssentamento
     */
    public function setFkPessoalTipoClassificacao(\Urbem\CoreBundle\Entity\Pessoal\TipoClassificacao $fkPessoalTipoClassificacao)
    {
        $this->codTipo = $fkPessoalTipoClassificacao->getCodTipo();
        $this->fkPessoalTipoClassificacao = $fkPessoalTipoClassificacao;

        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkPessoalTipoClassificacao
     *
     * @return \Urbem\CoreBundle\Entity\Pessoal\TipoClassificacao
     */
    public function getFkPessoalTipoClassificacao()
    {
        return $this->fkPessoalTipoClassificacao;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return sprintf('%s - %s', $this->codClassificacao, $this->descricao);
    }
}
