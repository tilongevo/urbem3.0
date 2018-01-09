<?php
 
namespace Urbem\CoreBundle\Entity\Tcemg;

/**
 * RegistroPrecosOrgaoItem
 */
class RegistroPrecosOrgaoItem
{
    /**
     * PK
     * @var integer
     */
    private $codEntidade;

    /**
     * PK
     * @var integer
     */
    private $numeroRegistroPrecos;

    /**
     * PK
     * @var string
     */
    private $exercicioRegistroPrecos;

    /**
     * PK
     * @var boolean
     */
    private $interno;

    /**
     * PK
     * @var integer
     */
    private $numcgmGerenciador;

    /**
     * PK
     * @var string
     */
    private $exercicioUnidade;

    /**
     * PK
     * @var integer
     */
    private $numUnidade;

    /**
     * PK
     * @var integer
     */
    private $numOrgao;

    /**
     * PK
     * @var integer
     */
    private $codLote;

    /**
     * PK
     * @var integer
     */
    private $codItem;

    /**
     * PK
     * @var integer
     */
    private $cgmFornecedor;

    /**
     * @var integer
     */
    private $quantidade;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Tcemg\ItemRegistroPrecos
     */
    private $fkTcemgItemRegistroPrecos;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Tcemg\RegistroPrecosOrgao
     */
    private $fkTcemgRegistroPrecosOrgao;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\SwCgm
     */
    private $fkSwCgm;

    /**
     * Set codEntidade
     *
     * @param integer $codEntidade
     * @return RegistroPrecosOrgaoItem
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
     * Set numeroRegistroPrecos
     *
     * @param integer $numeroRegistroPrecos
     * @return RegistroPrecosOrgaoItem
     */
    public function setNumeroRegistroPrecos($numeroRegistroPrecos)
    {
        $this->numeroRegistroPrecos = $numeroRegistroPrecos;
        return $this;
    }

    /**
     * Get numeroRegistroPrecos
     *
     * @return integer
     */
    public function getNumeroRegistroPrecos()
    {
        return $this->numeroRegistroPrecos;
    }

    /**
     * Set exercicioRegistroPrecos
     *
     * @param string $exercicioRegistroPrecos
     * @return RegistroPrecosOrgaoItem
     */
    public function setExercicioRegistroPrecos($exercicioRegistroPrecos)
    {
        $this->exercicioRegistroPrecos = $exercicioRegistroPrecos;
        return $this;
    }

    /**
     * Get exercicioRegistroPrecos
     *
     * @return string
     */
    public function getExercicioRegistroPrecos()
    {
        return $this->exercicioRegistroPrecos;
    }

    /**
     * Set interno
     *
     * @param boolean $interno
     * @return RegistroPrecosOrgaoItem
     */
    public function setInterno($interno)
    {
        $this->interno = $interno;
        return $this;
    }

    /**
     * Get interno
     *
     * @return boolean
     */
    public function getInterno()
    {
        return $this->interno;
    }

    /**
     * Set numcgmGerenciador
     *
     * @param integer $numcgmGerenciador
     * @return RegistroPrecosOrgaoItem
     */
    public function setNumcgmGerenciador($numcgmGerenciador)
    {
        $this->numcgmGerenciador = $numcgmGerenciador;
        return $this;
    }

    /**
     * Get numcgmGerenciador
     *
     * @return integer
     */
    public function getNumcgmGerenciador()
    {
        return $this->numcgmGerenciador;
    }

    /**
     * Set exercicioUnidade
     *
     * @param string $exercicioUnidade
     * @return RegistroPrecosOrgaoItem
     */
    public function setExercicioUnidade($exercicioUnidade)
    {
        $this->exercicioUnidade = $exercicioUnidade;
        return $this;
    }

    /**
     * Get exercicioUnidade
     *
     * @return string
     */
    public function getExercicioUnidade()
    {
        return $this->exercicioUnidade;
    }

    /**
     * Set numUnidade
     *
     * @param integer $numUnidade
     * @return RegistroPrecosOrgaoItem
     */
    public function setNumUnidade($numUnidade)
    {
        $this->numUnidade = $numUnidade;
        return $this;
    }

    /**
     * Get numUnidade
     *
     * @return integer
     */
    public function getNumUnidade()
    {
        return $this->numUnidade;
    }

    /**
     * Set numOrgao
     *
     * @param integer $numOrgao
     * @return RegistroPrecosOrgaoItem
     */
    public function setNumOrgao($numOrgao)
    {
        $this->numOrgao = $numOrgao;
        return $this;
    }

    /**
     * Get numOrgao
     *
     * @return integer
     */
    public function getNumOrgao()
    {
        return $this->numOrgao;
    }

    /**
     * Set codLote
     *
     * @param integer $codLote
     * @return RegistroPrecosOrgaoItem
     */
    public function setCodLote($codLote)
    {
        $this->codLote = $codLote;
        return $this;
    }

    /**
     * Get codLote
     *
     * @return integer
     */
    public function getCodLote()
    {
        return $this->codLote;
    }

    /**
     * Set codItem
     *
     * @param integer $codItem
     * @return RegistroPrecosOrgaoItem
     */
    public function setCodItem($codItem)
    {
        $this->codItem = $codItem;
        return $this;
    }

    /**
     * Get codItem
     *
     * @return integer
     */
    public function getCodItem()
    {
        return $this->codItem;
    }

    /**
     * Set cgmFornecedor
     *
     * @param integer $cgmFornecedor
     * @return RegistroPrecosOrgaoItem
     */
    public function setCgmFornecedor($cgmFornecedor)
    {
        $this->cgmFornecedor = $cgmFornecedor;
        return $this;
    }

    /**
     * Get cgmFornecedor
     *
     * @return integer
     */
    public function getCgmFornecedor()
    {
        return $this->cgmFornecedor;
    }

    /**
     * Set quantidade
     *
     * @param integer $quantidade
     * @return RegistroPrecosOrgaoItem
     */
    public function setQuantidade($quantidade)
    {
        $this->quantidade = $quantidade;
        return $this;
    }

    /**
     * Get quantidade
     *
     * @return integer
     */
    public function getQuantidade()
    {
        return $this->quantidade;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkTcemgItemRegistroPrecos
     *
     * @param \Urbem\CoreBundle\Entity\Tcemg\ItemRegistroPrecos $fkTcemgItemRegistroPrecos
     * @return RegistroPrecosOrgaoItem
     */
    public function setFkTcemgItemRegistroPrecos(\Urbem\CoreBundle\Entity\Tcemg\ItemRegistroPrecos $fkTcemgItemRegistroPrecos)
    {
        $this->codEntidade = $fkTcemgItemRegistroPrecos->getCodEntidade();
        $this->numeroRegistroPrecos = $fkTcemgItemRegistroPrecos->getNumeroRegistroPrecos();
        $this->exercicioRegistroPrecos = $fkTcemgItemRegistroPrecos->getExercicio();
        $this->codLote = $fkTcemgItemRegistroPrecos->getCodLote();
        $this->codItem = $fkTcemgItemRegistroPrecos->getCodItem();
        $this->cgmFornecedor = $fkTcemgItemRegistroPrecos->getCgmFornecedor();
        $this->interno = $fkTcemgItemRegistroPrecos->getInterno();
        $this->numcgmGerenciador = $fkTcemgItemRegistroPrecos->getNumcgmGerenciador();
        $this->fkTcemgItemRegistroPrecos = $fkTcemgItemRegistroPrecos;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkTcemgItemRegistroPrecos
     *
     * @return \Urbem\CoreBundle\Entity\Tcemg\ItemRegistroPrecos
     */
    public function getFkTcemgItemRegistroPrecos()
    {
        return $this->fkTcemgItemRegistroPrecos;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkTcemgRegistroPrecosOrgao
     *
     * @param \Urbem\CoreBundle\Entity\Tcemg\RegistroPrecosOrgao $fkTcemgRegistroPrecosOrgao
     * @return RegistroPrecosOrgaoItem
     */
    public function setFkTcemgRegistroPrecosOrgao(\Urbem\CoreBundle\Entity\Tcemg\RegistroPrecosOrgao $fkTcemgRegistroPrecosOrgao)
    {
        $this->codEntidade = $fkTcemgRegistroPrecosOrgao->getCodEntidade();
        $this->numeroRegistroPrecos = $fkTcemgRegistroPrecosOrgao->getNumeroRegistroPrecos();
        $this->exercicioRegistroPrecos = $fkTcemgRegistroPrecosOrgao->getExercicioRegistroPrecos();
        $this->interno = $fkTcemgRegistroPrecosOrgao->getInterno();
        $this->numcgmGerenciador = $fkTcemgRegistroPrecosOrgao->getNumcgmGerenciador();
        $this->exercicioUnidade = $fkTcemgRegistroPrecosOrgao->getExercicioUnidade();
        $this->numUnidade = $fkTcemgRegistroPrecosOrgao->getNumUnidade();
        $this->numOrgao = $fkTcemgRegistroPrecosOrgao->getNumOrgao();
        $this->fkTcemgRegistroPrecosOrgao = $fkTcemgRegistroPrecosOrgao;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkTcemgRegistroPrecosOrgao
     *
     * @return \Urbem\CoreBundle\Entity\Tcemg\RegistroPrecosOrgao
     */
    public function getFkTcemgRegistroPrecosOrgao()
    {
        return $this->fkTcemgRegistroPrecosOrgao;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkSwCgm
     *
     * @param \Urbem\CoreBundle\Entity\SwCgm $fkSwCgm
     * @return RegistroPrecosOrgaoItem
     */
    public function setFkSwCgm(\Urbem\CoreBundle\Entity\SwCgm $fkSwCgm)
    {
        $this->cgmFornecedor = $fkSwCgm->getNumcgm();
        $this->fkSwCgm = $fkSwCgm;

        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkSwCgm
     *
     * @return \Urbem\CoreBundle\Entity\SwCgm
     */
    public function getFkSwCgm()
    {
        return $this->fkSwCgm;
    }
}
