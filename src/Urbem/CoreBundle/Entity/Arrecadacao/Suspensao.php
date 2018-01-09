<?php

namespace Urbem\CoreBundle\Entity\Arrecadacao;

/**
 * Suspensao
 */
class Suspensao
{
    /**
     * PK
     * @var integer
     */
    private $codSuspensao;

    /**
     * PK
     * @var integer
     */
    private $codLancamento;

    /**
     * @var integer
     */
    private $codTipoSuspensao;

    /**
     * @var \DateTime
     */
    private $inicio;

    /**
     * @var string
     */
    private $observacoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Arrecadacao\ProcessoSuspensao
     */
    private $fkArrecadacaoProcessoSuspensoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Arrecadacao\SuspensaoTermino
     */
    private $fkArrecadacaoSuspensaoTerminos;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Arrecadacao\TipoSuspensao
     */
    private $fkArrecadacaoTipoSuspensao;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Arrecadacao\Lancamento
     */
    private $fkArrecadacaoLancamento;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkArrecadacaoProcessoSuspensoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkArrecadacaoSuspensaoTerminos = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codSuspensao
     *
     * @param integer $codSuspensao
     * @return Suspensao
     */
    public function setCodSuspensao($codSuspensao)
    {
        $this->codSuspensao = $codSuspensao;
        return $this;
    }

    /**
     * Get codSuspensao
     *
     * @return integer
     */
    public function getCodSuspensao()
    {
        return $this->codSuspensao;
    }

    /**
     * Set codLancamento
     *
     * @param integer $codLancamento
     * @return Suspensao
     */
    public function setCodLancamento($codLancamento)
    {
        $this->codLancamento = $codLancamento;
        return $this;
    }

    /**
     * Get codLancamento
     *
     * @return integer
     */
    public function getCodLancamento()
    {
        return $this->codLancamento;
    }

    /**
     * Set codTipoSuspensao
     *
     * @param integer $codTipoSuspensao
     * @return Suspensao
     */
    public function setCodTipoSuspensao($codTipoSuspensao)
    {
        $this->codTipoSuspensao = $codTipoSuspensao;
        return $this;
    }

    /**
     * Get codTipoSuspensao
     *
     * @return integer
     */
    public function getCodTipoSuspensao()
    {
        return $this->codTipoSuspensao;
    }

    /**
     * Set inicio
     *
     * @param \DateTime $inicio
     * @return Suspensao
     */
    public function setInicio(\DateTime $inicio)
    {
        $this->inicio = $inicio;
        return $this;
    }

    /**
     * Get inicio
     *
     * @return \DateTime
     */
    public function getInicio()
    {
        return $this->inicio;
    }

    /**
     * Set observacoes
     *
     * @param string $observacoes
     * @return Suspensao
     */
    public function setObservacoes($observacoes)
    {
        $this->observacoes = $observacoes;
        return $this;
    }

    /**
     * Get observacoes
     *
     * @return string
     */
    public function getObservacoes()
    {
        return $this->observacoes;
    }

    /**
     * OneToMany (owning side)
     * Add ArrecadacaoProcessoSuspensao
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\ProcessoSuspensao $fkArrecadacaoProcessoSuspensao
     * @return Suspensao
     */
    public function addFkArrecadacaoProcessoSuspensoes(\Urbem\CoreBundle\Entity\Arrecadacao\ProcessoSuspensao $fkArrecadacaoProcessoSuspensao)
    {
        if (false === $this->fkArrecadacaoProcessoSuspensoes->contains($fkArrecadacaoProcessoSuspensao)) {
            $fkArrecadacaoProcessoSuspensao->setFkArrecadacaoSuspensao($this);
            $this->fkArrecadacaoProcessoSuspensoes->add($fkArrecadacaoProcessoSuspensao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ArrecadacaoProcessoSuspensao
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\ProcessoSuspensao $fkArrecadacaoProcessoSuspensao
     */
    public function removeFkArrecadacaoProcessoSuspensoes(\Urbem\CoreBundle\Entity\Arrecadacao\ProcessoSuspensao $fkArrecadacaoProcessoSuspensao)
    {
        $this->fkArrecadacaoProcessoSuspensoes->removeElement($fkArrecadacaoProcessoSuspensao);
    }

    /**
     * OneToMany (owning side)
     * Get fkArrecadacaoProcessoSuspensoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Arrecadacao\ProcessoSuspensao
     */
    public function getFkArrecadacaoProcessoSuspensoes()
    {
        return $this->fkArrecadacaoProcessoSuspensoes;
    }

    /**
     * OneToMany (owning side)
     * Add ArrecadacaoSuspensaoTermino
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\SuspensaoTermino $fkArrecadacaoSuspensaoTermino
     * @return Suspensao
     */
    public function addFkArrecadacaoSuspensaoTerminos(\Urbem\CoreBundle\Entity\Arrecadacao\SuspensaoTermino $fkArrecadacaoSuspensaoTermino)
    {
        if (false === $this->fkArrecadacaoSuspensaoTerminos->contains($fkArrecadacaoSuspensaoTermino)) {
            $fkArrecadacaoSuspensaoTermino->setFkArrecadacaoSuspensao($this);
            $this->fkArrecadacaoSuspensaoTerminos->add($fkArrecadacaoSuspensaoTermino);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ArrecadacaoSuspensaoTermino
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\SuspensaoTermino $fkArrecadacaoSuspensaoTermino
     */
    public function removeFkArrecadacaoSuspensaoTerminos(\Urbem\CoreBundle\Entity\Arrecadacao\SuspensaoTermino $fkArrecadacaoSuspensaoTermino)
    {
        $this->fkArrecadacaoSuspensaoTerminos->removeElement($fkArrecadacaoSuspensaoTermino);
    }

    /**
     * OneToMany (owning side)
     * Get fkArrecadacaoSuspensaoTerminos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Arrecadacao\SuspensaoTermino
     */
    public function getFkArrecadacaoSuspensaoTerminos()
    {
        return $this->fkArrecadacaoSuspensaoTerminos;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkArrecadacaoTipoSuspensao
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\TipoSuspensao $fkArrecadacaoTipoSuspensao
     * @return Suspensao
     */
    public function setFkArrecadacaoTipoSuspensao(\Urbem\CoreBundle\Entity\Arrecadacao\TipoSuspensao $fkArrecadacaoTipoSuspensao)
    {
        $this->codTipoSuspensao = $fkArrecadacaoTipoSuspensao->getCodTipoSuspensao();
        $this->fkArrecadacaoTipoSuspensao = $fkArrecadacaoTipoSuspensao;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkArrecadacaoTipoSuspensao
     *
     * @return \Urbem\CoreBundle\Entity\Arrecadacao\TipoSuspensao
     */
    public function getFkArrecadacaoTipoSuspensao()
    {
        return $this->fkArrecadacaoTipoSuspensao;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkArrecadacaoLancamento
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\Lancamento $fkArrecadacaoLancamento
     * @return Suspensao
     */
    public function setFkArrecadacaoLancamento(\Urbem\CoreBundle\Entity\Arrecadacao\Lancamento $fkArrecadacaoLancamento)
    {
        $this->codLancamento = $fkArrecadacaoLancamento->getCodLancamento();
        $this->fkArrecadacaoLancamento = $fkArrecadacaoLancamento;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkArrecadacaoLancamento
     *
     * @return \Urbem\CoreBundle\Entity\Arrecadacao\Lancamento
     */
    public function getFkArrecadacaoLancamento()
    {
        return $this->fkArrecadacaoLancamento;
    }
}
