<?php
 
namespace Urbem\CoreBundle\Entity\Divida;

/**
 * DividaAtiva
 */
class DividaAtiva
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
    private $codInscricao;

    /**
     * @var integer
     */
    private $codAutoridade;

    /**
     * @var integer
     */
    private $numcgmUsuario;

    /**
     * @var \DateTime
     */
    private $dtInscricao;

    /**
     * @var integer
     */
    private $numLivro;

    /**
     * @var integer
     */
    private $numFolha;

    /**
     * @var \DateTime
     */
    private $dtVencimentoOrigem;

    /**
     * @var string
     */
    private $exercicioOriginal;

    /**
     * @var string
     */
    private $exercicioLivro;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Divida\DividaEstorno
     */
    private $fkDividaDividaEstorno;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Divida\CobrancaJudicial
     */
    private $fkDividaCobrancaJudicial;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Divida\DividaRemissao
     */
    private $fkDividaDividaRemissao;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Divida\DividaCancelada
     */
    private $fkDividaDividaCancelada;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Divida\DividaImovel
     */
    private $fkDividaDividaImoveis;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Divida\DividaAcrescimo
     */
    private $fkDividaDividaAcrescimos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Divida\DividaEmpresa
     */
    private $fkDividaDividaEmpresas;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Divida\DividaCgm
     */
    private $fkDividaDividaCgns;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Divida\DividaParcelamento
     */
    private $fkDividaDividaParcelamentos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Divida\DividaProcesso
     */
    private $fkDividaDividaProcessos;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Divida\Autoridade
     */
    private $fkDividaAutoridade;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Administracao\Usuario
     */
    private $fkAdministracaoUsuario;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkDividaDividaImoveis = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkDividaDividaAcrescimos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkDividaDividaEmpresas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkDividaDividaCgns = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkDividaDividaParcelamentos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkDividaDividaProcessos = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return DividaAtiva
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
     * Set codInscricao
     *
     * @param integer $codInscricao
     * @return DividaAtiva
     */
    public function setCodInscricao($codInscricao)
    {
        $this->codInscricao = $codInscricao;
        return $this;
    }

    /**
     * Get codInscricao
     *
     * @return integer
     */
    public function getCodInscricao()
    {
        return $this->codInscricao;
    }

    /**
     * Set codAutoridade
     *
     * @param integer $codAutoridade
     * @return DividaAtiva
     */
    public function setCodAutoridade($codAutoridade)
    {
        $this->codAutoridade = $codAutoridade;
        return $this;
    }

    /**
     * Get codAutoridade
     *
     * @return integer
     */
    public function getCodAutoridade()
    {
        return $this->codAutoridade;
    }

    /**
     * Set numcgmUsuario
     *
     * @param integer $numcgmUsuario
     * @return DividaAtiva
     */
    public function setNumcgmUsuario($numcgmUsuario)
    {
        $this->numcgmUsuario = $numcgmUsuario;
        return $this;
    }

    /**
     * Get numcgmUsuario
     *
     * @return integer
     */
    public function getNumcgmUsuario()
    {
        return $this->numcgmUsuario;
    }

    /**
     * Set dtInscricao
     *
     * @param \DateTime $dtInscricao
     * @return DividaAtiva
     */
    public function setDtInscricao(\DateTime $dtInscricao)
    {
        $this->dtInscricao = $dtInscricao;
        return $this;
    }

    /**
     * Get dtInscricao
     *
     * @return \DateTime
     */
    public function getDtInscricao()
    {
        return $this->dtInscricao;
    }

    /**
     * Set numLivro
     *
     * @param integer $numLivro
     * @return DividaAtiva
     */
    public function setNumLivro($numLivro)
    {
        $this->numLivro = $numLivro;
        return $this;
    }

    /**
     * Get numLivro
     *
     * @return integer
     */
    public function getNumLivro()
    {
        return $this->numLivro;
    }

    /**
     * Set numFolha
     *
     * @param integer $numFolha
     * @return DividaAtiva
     */
    public function setNumFolha($numFolha)
    {
        $this->numFolha = $numFolha;
        return $this;
    }

    /**
     * Get numFolha
     *
     * @return integer
     */
    public function getNumFolha()
    {
        return $this->numFolha;
    }

    /**
     * Set dtVencimentoOrigem
     *
     * @param \DateTime $dtVencimentoOrigem
     * @return DividaAtiva
     */
    public function setDtVencimentoOrigem(\DateTime $dtVencimentoOrigem)
    {
        $this->dtVencimentoOrigem = $dtVencimentoOrigem;
        return $this;
    }

    /**
     * Get dtVencimentoOrigem
     *
     * @return \DateTime
     */
    public function getDtVencimentoOrigem()
    {
        return $this->dtVencimentoOrigem;
    }

    /**
     * Set exercicioOriginal
     *
     * @param string $exercicioOriginal
     * @return DividaAtiva
     */
    public function setExercicioOriginal($exercicioOriginal)
    {
        $this->exercicioOriginal = $exercicioOriginal;
        return $this;
    }

    /**
     * Get exercicioOriginal
     *
     * @return string
     */
    public function getExercicioOriginal()
    {
        return $this->exercicioOriginal;
    }

    /**
     * Set exercicioLivro
     *
     * @param string $exercicioLivro
     * @return DividaAtiva
     */
    public function setExercicioLivro($exercicioLivro)
    {
        $this->exercicioLivro = $exercicioLivro;
        return $this;
    }

    /**
     * Get exercicioLivro
     *
     * @return string
     */
    public function getExercicioLivro()
    {
        return $this->exercicioLivro;
    }

    /**
     * OneToMany (owning side)
     * Add DividaDividaImovel
     *
     * @param \Urbem\CoreBundle\Entity\Divida\DividaImovel $fkDividaDividaImovel
     * @return DividaAtiva
     */
    public function addFkDividaDividaImoveis(\Urbem\CoreBundle\Entity\Divida\DividaImovel $fkDividaDividaImovel)
    {
        if (false === $this->fkDividaDividaImoveis->contains($fkDividaDividaImovel)) {
            $fkDividaDividaImovel->setFkDividaDividaAtiva($this);
            $this->fkDividaDividaImoveis->add($fkDividaDividaImovel);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove DividaDividaImovel
     *
     * @param \Urbem\CoreBundle\Entity\Divida\DividaImovel $fkDividaDividaImovel
     */
    public function removeFkDividaDividaImoveis(\Urbem\CoreBundle\Entity\Divida\DividaImovel $fkDividaDividaImovel)
    {
        $this->fkDividaDividaImoveis->removeElement($fkDividaDividaImovel);
    }

    /**
     * OneToMany (owning side)
     * Get fkDividaDividaImoveis
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Divida\DividaImovel
     */
    public function getFkDividaDividaImoveis()
    {
        return $this->fkDividaDividaImoveis;
    }

    /**
     * OneToMany (owning side)
     * Add DividaDividaAcrescimo
     *
     * @param \Urbem\CoreBundle\Entity\Divida\DividaAcrescimo $fkDividaDividaAcrescimo
     * @return DividaAtiva
     */
    public function addFkDividaDividaAcrescimos(\Urbem\CoreBundle\Entity\Divida\DividaAcrescimo $fkDividaDividaAcrescimo)
    {
        if (false === $this->fkDividaDividaAcrescimos->contains($fkDividaDividaAcrescimo)) {
            $fkDividaDividaAcrescimo->setFkDividaDividaAtiva($this);
            $this->fkDividaDividaAcrescimos->add($fkDividaDividaAcrescimo);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove DividaDividaAcrescimo
     *
     * @param \Urbem\CoreBundle\Entity\Divida\DividaAcrescimo $fkDividaDividaAcrescimo
     */
    public function removeFkDividaDividaAcrescimos(\Urbem\CoreBundle\Entity\Divida\DividaAcrescimo $fkDividaDividaAcrescimo)
    {
        $this->fkDividaDividaAcrescimos->removeElement($fkDividaDividaAcrescimo);
    }

    /**
     * OneToMany (owning side)
     * Get fkDividaDividaAcrescimos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Divida\DividaAcrescimo
     */
    public function getFkDividaDividaAcrescimos()
    {
        return $this->fkDividaDividaAcrescimos;
    }

    /**
     * OneToMany (owning side)
     * Add DividaDividaEmpresa
     *
     * @param \Urbem\CoreBundle\Entity\Divida\DividaEmpresa $fkDividaDividaEmpresa
     * @return DividaAtiva
     */
    public function addFkDividaDividaEmpresas(\Urbem\CoreBundle\Entity\Divida\DividaEmpresa $fkDividaDividaEmpresa)
    {
        if (false === $this->fkDividaDividaEmpresas->contains($fkDividaDividaEmpresa)) {
            $fkDividaDividaEmpresa->setFkDividaDividaAtiva($this);
            $this->fkDividaDividaEmpresas->add($fkDividaDividaEmpresa);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove DividaDividaEmpresa
     *
     * @param \Urbem\CoreBundle\Entity\Divida\DividaEmpresa $fkDividaDividaEmpresa
     */
    public function removeFkDividaDividaEmpresas(\Urbem\CoreBundle\Entity\Divida\DividaEmpresa $fkDividaDividaEmpresa)
    {
        $this->fkDividaDividaEmpresas->removeElement($fkDividaDividaEmpresa);
    }

    /**
     * OneToMany (owning side)
     * Get fkDividaDividaEmpresas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Divida\DividaEmpresa
     */
    public function getFkDividaDividaEmpresas()
    {
        return $this->fkDividaDividaEmpresas;
    }

    /**
     * OneToMany (owning side)
     * Add DividaDividaCgm
     *
     * @param \Urbem\CoreBundle\Entity\Divida\DividaCgm $fkDividaDividaCgm
     * @return DividaAtiva
     */
    public function addFkDividaDividaCgns(\Urbem\CoreBundle\Entity\Divida\DividaCgm $fkDividaDividaCgm)
    {
        if (false === $this->fkDividaDividaCgns->contains($fkDividaDividaCgm)) {
            $fkDividaDividaCgm->setFkDividaDividaAtiva($this);
            $this->fkDividaDividaCgns->add($fkDividaDividaCgm);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove DividaDividaCgm
     *
     * @param \Urbem\CoreBundle\Entity\Divida\DividaCgm $fkDividaDividaCgm
     */
    public function removeFkDividaDividaCgns(\Urbem\CoreBundle\Entity\Divida\DividaCgm $fkDividaDividaCgm)
    {
        $this->fkDividaDividaCgns->removeElement($fkDividaDividaCgm);
    }

    /**
     * OneToMany (owning side)
     * Get fkDividaDividaCgns
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Divida\DividaCgm
     */
    public function getFkDividaDividaCgns()
    {
        return $this->fkDividaDividaCgns;
    }

    /**
     * OneToMany (owning side)
     * Add DividaDividaParcelamento
     *
     * @param \Urbem\CoreBundle\Entity\Divida\DividaParcelamento $fkDividaDividaParcelamento
     * @return DividaAtiva
     */
    public function addFkDividaDividaParcelamentos(\Urbem\CoreBundle\Entity\Divida\DividaParcelamento $fkDividaDividaParcelamento)
    {
        if (false === $this->fkDividaDividaParcelamentos->contains($fkDividaDividaParcelamento)) {
            $fkDividaDividaParcelamento->setFkDividaDividaAtiva($this);
            $this->fkDividaDividaParcelamentos->add($fkDividaDividaParcelamento);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove DividaDividaParcelamento
     *
     * @param \Urbem\CoreBundle\Entity\Divida\DividaParcelamento $fkDividaDividaParcelamento
     */
    public function removeFkDividaDividaParcelamentos(\Urbem\CoreBundle\Entity\Divida\DividaParcelamento $fkDividaDividaParcelamento)
    {
        $this->fkDividaDividaParcelamentos->removeElement($fkDividaDividaParcelamento);
    }

    /**
     * OneToMany (owning side)
     * Get fkDividaDividaParcelamentos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Divida\DividaParcelamento
     */
    public function getFkDividaDividaParcelamentos()
    {
        return $this->fkDividaDividaParcelamentos;
    }

    /**
     * OneToMany (owning side)
     * Add DividaDividaProcesso
     *
     * @param \Urbem\CoreBundle\Entity\Divida\DividaProcesso $fkDividaDividaProcesso
     * @return DividaAtiva
     */
    public function addFkDividaDividaProcessos(\Urbem\CoreBundle\Entity\Divida\DividaProcesso $fkDividaDividaProcesso)
    {
        if (false === $this->fkDividaDividaProcessos->contains($fkDividaDividaProcesso)) {
            $fkDividaDividaProcesso->setFkDividaDividaAtiva($this);
            $this->fkDividaDividaProcessos->add($fkDividaDividaProcesso);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove DividaDividaProcesso
     *
     * @param \Urbem\CoreBundle\Entity\Divida\DividaProcesso $fkDividaDividaProcesso
     */
    public function removeFkDividaDividaProcessos(\Urbem\CoreBundle\Entity\Divida\DividaProcesso $fkDividaDividaProcesso)
    {
        $this->fkDividaDividaProcessos->removeElement($fkDividaDividaProcesso);
    }

    /**
     * OneToMany (owning side)
     * Get fkDividaDividaProcessos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Divida\DividaProcesso
     */
    public function getFkDividaDividaProcessos()
    {
        return $this->fkDividaDividaProcessos;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkDividaAutoridade
     *
     * @param \Urbem\CoreBundle\Entity\Divida\Autoridade $fkDividaAutoridade
     * @return DividaAtiva
     */
    public function setFkDividaAutoridade(\Urbem\CoreBundle\Entity\Divida\Autoridade $fkDividaAutoridade)
    {
        $this->codAutoridade = $fkDividaAutoridade->getCodAutoridade();
        $this->fkDividaAutoridade = $fkDividaAutoridade;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkDividaAutoridade
     *
     * @return \Urbem\CoreBundle\Entity\Divida\Autoridade
     */
    public function getFkDividaAutoridade()
    {
        return $this->fkDividaAutoridade;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkAdministracaoUsuario
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\Usuario $fkAdministracaoUsuario
     * @return DividaAtiva
     */
    public function setFkAdministracaoUsuario(\Urbem\CoreBundle\Entity\Administracao\Usuario $fkAdministracaoUsuario)
    {
        $this->numcgmUsuario = $fkAdministracaoUsuario->getNumcgm();
        $this->fkAdministracaoUsuario = $fkAdministracaoUsuario;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkAdministracaoUsuario
     *
     * @return \Urbem\CoreBundle\Entity\Administracao\Usuario
     */
    public function getFkAdministracaoUsuario()
    {
        return $this->fkAdministracaoUsuario;
    }

    /**
     * OneToOne (inverse side)
     * Set DividaDividaEstorno
     *
     * @param \Urbem\CoreBundle\Entity\Divida\DividaEstorno $fkDividaDividaEstorno
     * @return DividaAtiva
     */
    public function setFkDividaDividaEstorno(\Urbem\CoreBundle\Entity\Divida\DividaEstorno $fkDividaDividaEstorno)
    {
        $fkDividaDividaEstorno->setFkDividaDividaAtiva($this);
        $this->fkDividaDividaEstorno = $fkDividaDividaEstorno;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkDividaDividaEstorno
     *
     * @return \Urbem\CoreBundle\Entity\Divida\DividaEstorno
     */
    public function getFkDividaDividaEstorno()
    {
        return $this->fkDividaDividaEstorno;
    }

    /**
     * OneToOne (inverse side)
     * Set DividaCobrancaJudicial
     *
     * @param \Urbem\CoreBundle\Entity\Divida\CobrancaJudicial $fkDividaCobrancaJudicial
     * @return DividaAtiva
     */
    public function setFkDividaCobrancaJudicial(\Urbem\CoreBundle\Entity\Divida\CobrancaJudicial $fkDividaCobrancaJudicial)
    {
        $fkDividaCobrancaJudicial->setFkDividaDividaAtiva($this);
        $this->fkDividaCobrancaJudicial = $fkDividaCobrancaJudicial;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkDividaCobrancaJudicial
     *
     * @return \Urbem\CoreBundle\Entity\Divida\CobrancaJudicial
     */
    public function getFkDividaCobrancaJudicial()
    {
        return $this->fkDividaCobrancaJudicial;
    }

    /**
     * OneToOne (inverse side)
     * Set DividaDividaRemissao
     *
     * @param \Urbem\CoreBundle\Entity\Divida\DividaRemissao $fkDividaDividaRemissao
     * @return DividaAtiva
     */
    public function setFkDividaDividaRemissao(\Urbem\CoreBundle\Entity\Divida\DividaRemissao $fkDividaDividaRemissao)
    {
        $fkDividaDividaRemissao->setFkDividaDividaAtiva($this);
        $this->fkDividaDividaRemissao = $fkDividaDividaRemissao;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkDividaDividaRemissao
     *
     * @return \Urbem\CoreBundle\Entity\Divida\DividaRemissao
     */
    public function getFkDividaDividaRemissao()
    {
        return $this->fkDividaDividaRemissao;
    }

    /**
     * OneToOne (inverse side)
     * Set DividaDividaCancelada
     *
     * @param \Urbem\CoreBundle\Entity\Divida\DividaCancelada $fkDividaDividaCancelada
     * @return DividaAtiva
     */
    public function setFkDividaDividaCancelada(\Urbem\CoreBundle\Entity\Divida\DividaCancelada $fkDividaDividaCancelada)
    {
        $fkDividaDividaCancelada->setFkDividaDividaAtiva($this);
        $this->fkDividaDividaCancelada = $fkDividaDividaCancelada;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkDividaDividaCancelada
     *
     * @return \Urbem\CoreBundle\Entity\Divida\DividaCancelada
     */
    public function getFkDividaDividaCancelada()
    {
        return $this->fkDividaDividaCancelada;
    }
}
