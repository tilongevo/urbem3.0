<?php
 
namespace Urbem\CoreBundle\Entity\Tcmba;

/**
 * TermoParceria
 */
class TermoParceria
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
     * @var string
     */
    private $nroProcesso;

    /**
     * @var \DateTime
     */
    private $dtAssinatura;

    /**
     * @var \DateTime
     */
    private $dtPublicacao;

    /**
     * @var string
     */
    private $imprensaOficial;

    /**
     * @var \DateTime
     */
    private $dtInicio;

    /**
     * @var \DateTime
     */
    private $dtTermino;

    /**
     * @var integer
     */
    private $numcgm;

    /**
     * @var string
     */
    private $processoLicitatorio;

    /**
     * @var string
     */
    private $processoDispensa;

    /**
     * @var string
     */
    private $objeto;

    /**
     * @var string
     */
    private $nroProcessoMj;

    /**
     * @var \DateTime
     */
    private $dtProcessoMj;

    /**
     * @var \DateTime
     */
    private $dtPublicacaoMj;

    /**
     * @var integer
     */
    private $vlParceiroPublico;

    /**
     * @var integer
     */
    private $vlTermoParceria;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcmba\TermoParceriaProrrogacao
     */
    private $fkTcmbaTermoParceriaProrrogacoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcmba\TermoParceriaDotacao
     */
    private $fkTcmbaTermoParceriaDotacoes;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Orcamento\Entidade
     */
    private $fkOrcamentoEntidade;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\SwCgmPessoaJuridica
     */
    private $fkSwCgmPessoaJuridica;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkTcmbaTermoParceriaProrrogacoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTcmbaTermoParceriaDotacoes = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return TermoParceria
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
     * @return TermoParceria
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
     * Set nroProcesso
     *
     * @param string $nroProcesso
     * @return TermoParceria
     */
    public function setNroProcesso($nroProcesso)
    {
        $this->nroProcesso = $nroProcesso;
        return $this;
    }

    /**
     * Get nroProcesso
     *
     * @return string
     */
    public function getNroProcesso()
    {
        return $this->nroProcesso;
    }

    /**
     * Set dtAssinatura
     *
     * @param \DateTime $dtAssinatura
     * @return TermoParceria
     */
    public function setDtAssinatura(\DateTime $dtAssinatura)
    {
        $this->dtAssinatura = $dtAssinatura;
        return $this;
    }

    /**
     * Get dtAssinatura
     *
     * @return \DateTime
     */
    public function getDtAssinatura()
    {
        return $this->dtAssinatura;
    }

    /**
     * Set dtPublicacao
     *
     * @param \DateTime $dtPublicacao
     * @return TermoParceria
     */
    public function setDtPublicacao(\DateTime $dtPublicacao)
    {
        $this->dtPublicacao = $dtPublicacao;
        return $this;
    }

    /**
     * Get dtPublicacao
     *
     * @return \DateTime
     */
    public function getDtPublicacao()
    {
        return $this->dtPublicacao;
    }

    /**
     * Set imprensaOficial
     *
     * @param string $imprensaOficial
     * @return TermoParceria
     */
    public function setImprensaOficial($imprensaOficial)
    {
        $this->imprensaOficial = $imprensaOficial;
        return $this;
    }

    /**
     * Get imprensaOficial
     *
     * @return string
     */
    public function getImprensaOficial()
    {
        return $this->imprensaOficial;
    }

    /**
     * Set dtInicio
     *
     * @param \DateTime $dtInicio
     * @return TermoParceria
     */
    public function setDtInicio(\DateTime $dtInicio)
    {
        $this->dtInicio = $dtInicio;
        return $this;
    }

    /**
     * Get dtInicio
     *
     * @return \DateTime
     */
    public function getDtInicio()
    {
        return $this->dtInicio;
    }

    /**
     * Set dtTermino
     *
     * @param \DateTime $dtTermino
     * @return TermoParceria
     */
    public function setDtTermino(\DateTime $dtTermino)
    {
        $this->dtTermino = $dtTermino;
        return $this;
    }

    /**
     * Get dtTermino
     *
     * @return \DateTime
     */
    public function getDtTermino()
    {
        return $this->dtTermino;
    }

    /**
     * Set numcgm
     *
     * @param integer $numcgm
     * @return TermoParceria
     */
    public function setNumcgm($numcgm)
    {
        $this->numcgm = $numcgm;
        return $this;
    }

    /**
     * Get numcgm
     *
     * @return integer
     */
    public function getNumcgm()
    {
        return $this->numcgm;
    }

    /**
     * Set processoLicitatorio
     *
     * @param string $processoLicitatorio
     * @return TermoParceria
     */
    public function setProcessoLicitatorio($processoLicitatorio = null)
    {
        $this->processoLicitatorio = $processoLicitatorio;
        return $this;
    }

    /**
     * Get processoLicitatorio
     *
     * @return string
     */
    public function getProcessoLicitatorio()
    {
        return $this->processoLicitatorio;
    }

    /**
     * Set processoDispensa
     *
     * @param string $processoDispensa
     * @return TermoParceria
     */
    public function setProcessoDispensa($processoDispensa = null)
    {
        $this->processoDispensa = $processoDispensa;
        return $this;
    }

    /**
     * Get processoDispensa
     *
     * @return string
     */
    public function getProcessoDispensa()
    {
        return $this->processoDispensa;
    }

    /**
     * Set objeto
     *
     * @param string $objeto
     * @return TermoParceria
     */
    public function setObjeto($objeto)
    {
        $this->objeto = $objeto;
        return $this;
    }

    /**
     * Get objeto
     *
     * @return string
     */
    public function getObjeto()
    {
        return $this->objeto;
    }

    /**
     * Set nroProcessoMj
     *
     * @param string $nroProcessoMj
     * @return TermoParceria
     */
    public function setNroProcessoMj($nroProcessoMj = null)
    {
        $this->nroProcessoMj = $nroProcessoMj;
        return $this;
    }

    /**
     * Get nroProcessoMj
     *
     * @return string
     */
    public function getNroProcessoMj()
    {
        return $this->nroProcessoMj;
    }

    /**
     * Set dtProcessoMj
     *
     * @param \DateTime $dtProcessoMj
     * @return TermoParceria
     */
    public function setDtProcessoMj(\DateTime $dtProcessoMj = null)
    {
        $this->dtProcessoMj = $dtProcessoMj;
        return $this;
    }

    /**
     * Get dtProcessoMj
     *
     * @return \DateTime
     */
    public function getDtProcessoMj()
    {
        return $this->dtProcessoMj;
    }

    /**
     * Set dtPublicacaoMj
     *
     * @param \DateTime $dtPublicacaoMj
     * @return TermoParceria
     */
    public function setDtPublicacaoMj(\DateTime $dtPublicacaoMj = null)
    {
        $this->dtPublicacaoMj = $dtPublicacaoMj;
        return $this;
    }

    /**
     * Get dtPublicacaoMj
     *
     * @return \DateTime
     */
    public function getDtPublicacaoMj()
    {
        return $this->dtPublicacaoMj;
    }

    /**
     * Set vlParceiroPublico
     *
     * @param integer $vlParceiroPublico
     * @return TermoParceria
     */
    public function setVlParceiroPublico($vlParceiroPublico = null)
    {
        $this->vlParceiroPublico = $vlParceiroPublico;
        return $this;
    }

    /**
     * Get vlParceiroPublico
     *
     * @return integer
     */
    public function getVlParceiroPublico()
    {
        return $this->vlParceiroPublico;
    }

    /**
     * Set vlTermoParceria
     *
     * @param integer $vlTermoParceria
     * @return TermoParceria
     */
    public function setVlTermoParceria($vlTermoParceria = null)
    {
        $this->vlTermoParceria = $vlTermoParceria;
        return $this;
    }

    /**
     * Get vlTermoParceria
     *
     * @return integer
     */
    public function getVlTermoParceria()
    {
        return $this->vlTermoParceria;
    }

    /**
     * OneToMany (owning side)
     * Add TcmbaTermoParceriaProrrogacao
     *
     * @param \Urbem\CoreBundle\Entity\Tcmba\TermoParceriaProrrogacao $fkTcmbaTermoParceriaProrrogacao
     * @return TermoParceria
     */
    public function addFkTcmbaTermoParceriaProrrogacoes(\Urbem\CoreBundle\Entity\Tcmba\TermoParceriaProrrogacao $fkTcmbaTermoParceriaProrrogacao)
    {
        if (false === $this->fkTcmbaTermoParceriaProrrogacoes->contains($fkTcmbaTermoParceriaProrrogacao)) {
            $fkTcmbaTermoParceriaProrrogacao->setFkTcmbaTermoParceria($this);
            $this->fkTcmbaTermoParceriaProrrogacoes->add($fkTcmbaTermoParceriaProrrogacao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcmbaTermoParceriaProrrogacao
     *
     * @param \Urbem\CoreBundle\Entity\Tcmba\TermoParceriaProrrogacao $fkTcmbaTermoParceriaProrrogacao
     */
    public function removeFkTcmbaTermoParceriaProrrogacoes(\Urbem\CoreBundle\Entity\Tcmba\TermoParceriaProrrogacao $fkTcmbaTermoParceriaProrrogacao)
    {
        $this->fkTcmbaTermoParceriaProrrogacoes->removeElement($fkTcmbaTermoParceriaProrrogacao);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcmbaTermoParceriaProrrogacoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcmba\TermoParceriaProrrogacao
     */
    public function getFkTcmbaTermoParceriaProrrogacoes()
    {
        return $this->fkTcmbaTermoParceriaProrrogacoes;
    }

    /**
     * OneToMany (owning side)
     * Add TcmbaTermoParceriaDotacao
     *
     * @param \Urbem\CoreBundle\Entity\Tcmba\TermoParceriaDotacao $fkTcmbaTermoParceriaDotacao
     * @return TermoParceria
     */
    public function addFkTcmbaTermoParceriaDotacoes(\Urbem\CoreBundle\Entity\Tcmba\TermoParceriaDotacao $fkTcmbaTermoParceriaDotacao)
    {
        if (false === $this->fkTcmbaTermoParceriaDotacoes->contains($fkTcmbaTermoParceriaDotacao)) {
            $fkTcmbaTermoParceriaDotacao->setFkTcmbaTermoParceria($this);
            $this->fkTcmbaTermoParceriaDotacoes->add($fkTcmbaTermoParceriaDotacao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcmbaTermoParceriaDotacao
     *
     * @param \Urbem\CoreBundle\Entity\Tcmba\TermoParceriaDotacao $fkTcmbaTermoParceriaDotacao
     */
    public function removeFkTcmbaTermoParceriaDotacoes(\Urbem\CoreBundle\Entity\Tcmba\TermoParceriaDotacao $fkTcmbaTermoParceriaDotacao)
    {
        $this->fkTcmbaTermoParceriaDotacoes->removeElement($fkTcmbaTermoParceriaDotacao);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcmbaTermoParceriaDotacoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcmba\TermoParceriaDotacao
     */
    public function getFkTcmbaTermoParceriaDotacoes()
    {
        return $this->fkTcmbaTermoParceriaDotacoes;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkOrcamentoEntidade
     *
     * @param \Urbem\CoreBundle\Entity\Orcamento\Entidade $fkOrcamentoEntidade
     * @return TermoParceria
     */
    public function setFkOrcamentoEntidade(\Urbem\CoreBundle\Entity\Orcamento\Entidade $fkOrcamentoEntidade)
    {
        $this->exercicio = $fkOrcamentoEntidade->getExercicio();
        $this->codEntidade = $fkOrcamentoEntidade->getCodEntidade();
        $this->fkOrcamentoEntidade = $fkOrcamentoEntidade;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkOrcamentoEntidade
     *
     * @return \Urbem\CoreBundle\Entity\Orcamento\Entidade
     */
    public function getFkOrcamentoEntidade()
    {
        return $this->fkOrcamentoEntidade;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkSwCgmPessoaJuridica
     *
     * @param \Urbem\CoreBundle\Entity\SwCgmPessoaJuridica $fkSwCgmPessoaJuridica
     * @return TermoParceria
     */
    public function setFkSwCgmPessoaJuridica(\Urbem\CoreBundle\Entity\SwCgmPessoaJuridica $fkSwCgmPessoaJuridica)
    {
        $this->numcgm = $fkSwCgmPessoaJuridica->getNumcgm();
        $this->fkSwCgmPessoaJuridica = $fkSwCgmPessoaJuridica;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkSwCgmPessoaJuridica
     *
     * @return \Urbem\CoreBundle\Entity\SwCgmPessoaJuridica
     */
    public function getFkSwCgmPessoaJuridica()
    {
        return $this->fkSwCgmPessoaJuridica;
    }
}
