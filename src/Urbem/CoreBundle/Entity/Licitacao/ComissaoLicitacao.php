<?php
 
namespace Urbem\CoreBundle\Entity\Licitacao;

/**
 * ComissaoLicitacao
 */
class ComissaoLicitacao
{
    /**
     * PK
     * @var string
     */
    private $exercicio;

    /**
     * PK
     * @var integer
     */
    private $codEntidade;

    /**
     * PK
     * @var integer
     */
    private $codModalidade;

    /**
     * PK
     * @var integer
     */
    private $codLicitacao;

    /**
     * PK
     * @var integer
     */
    private $codComissao;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Licitacao\ComissaoLicitacaoMembros
     */
    private $fkLicitacaoComissaoLicitacaoMembros;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Licitacao\Licitacao
     */
    private $fkLicitacaoLicitacao;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Licitacao\Comissao
     */
    private $fkLicitacaoComissao;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkLicitacaoComissaoLicitacaoMembros = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return ComissaoLicitacao
     */
    public function setExercicio($exercicio)
    {
        $this->exercicio = $exercicio;
        return $this;
    }

    /**
     * Get exercicio
     *
     * @return string
     */
    public function getExercicio()
    {
        return $this->exercicio;
    }

    /**
     * Set codEntidade
     *
     * @param integer $codEntidade
     * @return ComissaoLicitacao
     */
    public function setCodEntidade($codEntidade)
    {
        $this->codEntidade = $codEntidade;
        return $this;
    }

    /**
     * Get codEntidade
     *
     * @return integer
     */
    public function getCodEntidade()
    {
        return $this->codEntidade;
    }

    /**
     * Set codModalidade
     *
     * @param integer $codModalidade
     * @return ComissaoLicitacao
     */
    public function setCodModalidade($codModalidade)
    {
        $this->codModalidade = $codModalidade;
        return $this;
    }

    /**
     * Get codModalidade
     *
     * @return integer
     */
    public function getCodModalidade()
    {
        return $this->codModalidade;
    }

    /**
     * Set codLicitacao
     *
     * @param integer $codLicitacao
     * @return ComissaoLicitacao
     */
    public function setCodLicitacao($codLicitacao)
    {
        $this->codLicitacao = $codLicitacao;
        return $this;
    }

    /**
     * Get codLicitacao
     *
     * @return integer
     */
    public function getCodLicitacao()
    {
        return $this->codLicitacao;
    }

    /**
     * Set codComissao
     *
     * @param integer $codComissao
     * @return ComissaoLicitacao
     */
    public function setCodComissao($codComissao)
    {
        $this->codComissao = $codComissao;
        return $this;
    }

    /**
     * Get codComissao
     *
     * @return integer
     */
    public function getCodComissao()
    {
        return $this->codComissao;
    }

    /**
     * OneToMany (owning side)
     * Add LicitacaoComissaoLicitacaoMembros
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\ComissaoLicitacaoMembros $fkLicitacaoComissaoLicitacaoMembros
     * @return ComissaoLicitacao
     */
    public function addFkLicitacaoComissaoLicitacaoMembros(\Urbem\CoreBundle\Entity\Licitacao\ComissaoLicitacaoMembros $fkLicitacaoComissaoLicitacaoMembros)
    {
        if (false === $this->fkLicitacaoComissaoLicitacaoMembros->contains($fkLicitacaoComissaoLicitacaoMembros)) {
            $fkLicitacaoComissaoLicitacaoMembros->setFkLicitacaoComissaoLicitacao($this);
            $this->fkLicitacaoComissaoLicitacaoMembros->add($fkLicitacaoComissaoLicitacaoMembros);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove LicitacaoComissaoLicitacaoMembros
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\ComissaoLicitacaoMembros $fkLicitacaoComissaoLicitacaoMembros
     */
    public function removeFkLicitacaoComissaoLicitacaoMembros(\Urbem\CoreBundle\Entity\Licitacao\ComissaoLicitacaoMembros $fkLicitacaoComissaoLicitacaoMembros)
    {
        $this->fkLicitacaoComissaoLicitacaoMembros->removeElement($fkLicitacaoComissaoLicitacaoMembros);
    }

    /**
     * OneToMany (owning side)
     * Get fkLicitacaoComissaoLicitacaoMembros
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Licitacao\ComissaoLicitacaoMembros
     */
    public function getFkLicitacaoComissaoLicitacaoMembros()
    {
        return $this->fkLicitacaoComissaoLicitacaoMembros;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkLicitacaoLicitacao
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\Licitacao $fkLicitacaoLicitacao
     * @return ComissaoLicitacao
     */
    public function setFkLicitacaoLicitacao(\Urbem\CoreBundle\Entity\Licitacao\Licitacao $fkLicitacaoLicitacao)
    {
        $this->codLicitacao = $fkLicitacaoLicitacao->getCodLicitacao();
        $this->codModalidade = $fkLicitacaoLicitacao->getCodModalidade();
        $this->codEntidade = $fkLicitacaoLicitacao->getCodEntidade();
        $this->exercicio = $fkLicitacaoLicitacao->getExercicio();
        $this->fkLicitacaoLicitacao = $fkLicitacaoLicitacao;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkLicitacaoLicitacao
     *
     * @return \Urbem\CoreBundle\Entity\Licitacao\Licitacao
     */
    public function getFkLicitacaoLicitacao()
    {
        return $this->fkLicitacaoLicitacao;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkLicitacaoComissao
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\Comissao $fkLicitacaoComissao
     * @return ComissaoLicitacao
     */
    public function setFkLicitacaoComissao(\Urbem\CoreBundle\Entity\Licitacao\Comissao $fkLicitacaoComissao)
    {
        $this->codComissao = $fkLicitacaoComissao->getCodComissao();
        $this->fkLicitacaoComissao = $fkLicitacaoComissao;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkLicitacaoComissao
     *
     * @return \Urbem\CoreBundle\Entity\Licitacao\Comissao
     */
    public function getFkLicitacaoComissao()
    {
        return $this->fkLicitacaoComissao;
    }
}
