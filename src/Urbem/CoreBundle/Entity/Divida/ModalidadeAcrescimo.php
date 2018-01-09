<?php
 
namespace Urbem\CoreBundle\Entity\Divida;

/**
 * ModalidadeAcrescimo
 */
class ModalidadeAcrescimo
{
    /**
     * PK
     * @var integer
     */
    private $codModalidade;

    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    private $timestamp;

    /**
     * PK
     * @var integer
     */
    private $codTipo;

    /**
     * PK
     * @var integer
     */
    private $codAcrescimo;

    /**
     * PK
     * @var boolean
     */
    private $pagamento;

    /**
     * @var integer
     */
    private $codFuncao;

    /**
     * @var integer
     */
    private $codBiblioteca;

    /**
     * @var integer
     */
    private $codModulo;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Divida\ModalidadeReducaoAcrescimo
     */
    private $fkDividaModalidadeReducaoAcrescimos;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Divida\ModalidadeVigencia
     */
    private $fkDividaModalidadeVigencia;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Administracao\Funcao
     */
    private $fkAdministracaoFuncao;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkDividaModalidadeReducaoAcrescimos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
    }

    /**
     * Set codModalidade
     *
     * @param integer $codModalidade
     * @return ModalidadeAcrescimo
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
     * Set timestamp
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp
     * @return ModalidadeAcrescimo
     */
    public function setTimestamp(\Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp)
    {
        $this->timestamp = $timestamp;
        return $this;
    }

    /**
     * Get timestamp
     *
     * @return \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }

    /**
     * Set codTipo
     *
     * @param integer $codTipo
     * @return ModalidadeAcrescimo
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
     * Set codAcrescimo
     *
     * @param integer $codAcrescimo
     * @return ModalidadeAcrescimo
     */
    public function setCodAcrescimo($codAcrescimo)
    {
        $this->codAcrescimo = $codAcrescimo;
        return $this;
    }

    /**
     * Get codAcrescimo
     *
     * @return integer
     */
    public function getCodAcrescimo()
    {
        return $this->codAcrescimo;
    }

    /**
     * Set pagamento
     *
     * @param boolean $pagamento
     * @return ModalidadeAcrescimo
     */
    public function setPagamento($pagamento)
    {
        $this->pagamento = $pagamento;
        return $this;
    }

    /**
     * Get pagamento
     *
     * @return boolean
     */
    public function getPagamento()
    {
        return $this->pagamento;
    }

    /**
     * Set codFuncao
     *
     * @param integer $codFuncao
     * @return ModalidadeAcrescimo
     */
    public function setCodFuncao($codFuncao)
    {
        $this->codFuncao = $codFuncao;
        return $this;
    }

    /**
     * Get codFuncao
     *
     * @return integer
     */
    public function getCodFuncao()
    {
        return $this->codFuncao;
    }

    /**
     * Set codBiblioteca
     *
     * @param integer $codBiblioteca
     * @return ModalidadeAcrescimo
     */
    public function setCodBiblioteca($codBiblioteca)
    {
        $this->codBiblioteca = $codBiblioteca;
        return $this;
    }

    /**
     * Get codBiblioteca
     *
     * @return integer
     */
    public function getCodBiblioteca()
    {
        return $this->codBiblioteca;
    }

    /**
     * Set codModulo
     *
     * @param integer $codModulo
     * @return ModalidadeAcrescimo
     */
    public function setCodModulo($codModulo)
    {
        $this->codModulo = $codModulo;
        return $this;
    }

    /**
     * Get codModulo
     *
     * @return integer
     */
    public function getCodModulo()
    {
        return $this->codModulo;
    }

    /**
     * OneToMany (owning side)
     * Add DividaModalidadeReducaoAcrescimo
     *
     * @param \Urbem\CoreBundle\Entity\Divida\ModalidadeReducaoAcrescimo $fkDividaModalidadeReducaoAcrescimo
     * @return ModalidadeAcrescimo
     */
    public function addFkDividaModalidadeReducaoAcrescimos(\Urbem\CoreBundle\Entity\Divida\ModalidadeReducaoAcrescimo $fkDividaModalidadeReducaoAcrescimo)
    {
        if (false === $this->fkDividaModalidadeReducaoAcrescimos->contains($fkDividaModalidadeReducaoAcrescimo)) {
            $fkDividaModalidadeReducaoAcrescimo->setFkDividaModalidadeAcrescimo($this);
            $this->fkDividaModalidadeReducaoAcrescimos->add($fkDividaModalidadeReducaoAcrescimo);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove DividaModalidadeReducaoAcrescimo
     *
     * @param \Urbem\CoreBundle\Entity\Divida\ModalidadeReducaoAcrescimo $fkDividaModalidadeReducaoAcrescimo
     */
    public function removeFkDividaModalidadeReducaoAcrescimos(\Urbem\CoreBundle\Entity\Divida\ModalidadeReducaoAcrescimo $fkDividaModalidadeReducaoAcrescimo)
    {
        $this->fkDividaModalidadeReducaoAcrescimos->removeElement($fkDividaModalidadeReducaoAcrescimo);
    }

    /**
     * OneToMany (owning side)
     * Get fkDividaModalidadeReducaoAcrescimos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Divida\ModalidadeReducaoAcrescimo
     */
    public function getFkDividaModalidadeReducaoAcrescimos()
    {
        return $this->fkDividaModalidadeReducaoAcrescimos;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkDividaModalidadeVigencia
     *
     * @param \Urbem\CoreBundle\Entity\Divida\ModalidadeVigencia $fkDividaModalidadeVigencia
     * @return ModalidadeAcrescimo
     */
    public function setFkDividaModalidadeVigencia(\Urbem\CoreBundle\Entity\Divida\ModalidadeVigencia $fkDividaModalidadeVigencia)
    {
        $this->codModalidade = $fkDividaModalidadeVigencia->getCodModalidade();
        $this->timestamp = $fkDividaModalidadeVigencia->getTimestamp();
        $this->fkDividaModalidadeVigencia = $fkDividaModalidadeVigencia;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkDividaModalidadeVigencia
     *
     * @return \Urbem\CoreBundle\Entity\Divida\ModalidadeVigencia
     */
    public function getFkDividaModalidadeVigencia()
    {
        return $this->fkDividaModalidadeVigencia;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkAdministracaoFuncao
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\Funcao $fkAdministracaoFuncao
     * @return ModalidadeAcrescimo
     */
    public function setFkAdministracaoFuncao(\Urbem\CoreBundle\Entity\Administracao\Funcao $fkAdministracaoFuncao)
    {
        $this->codModulo = $fkAdministracaoFuncao->getCodModulo();
        $this->codBiblioteca = $fkAdministracaoFuncao->getCodBiblioteca();
        $this->codFuncao = $fkAdministracaoFuncao->getCodFuncao();
        $this->fkAdministracaoFuncao = $fkAdministracaoFuncao;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkAdministracaoFuncao
     *
     * @return \Urbem\CoreBundle\Entity\Administracao\Funcao
     */
    public function getFkAdministracaoFuncao()
    {
        return $this->fkAdministracaoFuncao;
    }
}
