<?php
 
namespace Urbem\CoreBundle\Entity\Divida;

/**
 * ModalidadeReducao
 */
class ModalidadeReducao
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
    private $codFuncao;

    /**
     * PK
     * @var integer
     */
    private $codBiblioteca;

    /**
     * PK
     * @var integer
     */
    private $codModulo;

    /**
     * PK
     * @var boolean
     */
    private $percentual = true;

    /**
     * PK
     * @var integer
     */
    private $valor = 0;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Divida\ModalidadeReducaoAcrescimo
     */
    private $fkDividaModalidadeReducaoAcrescimos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Divida\ModalidadeReducaoCredito
     */
    private $fkDividaModalidadeReducaoCreditos;

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
        $this->fkDividaModalidadeReducaoCreditos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
    }

    /**
     * Set codModalidade
     *
     * @param integer $codModalidade
     * @return ModalidadeReducao
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
     * @return ModalidadeReducao
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
     * Set codFuncao
     *
     * @param integer $codFuncao
     * @return ModalidadeReducao
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
     * @return ModalidadeReducao
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
     * @return ModalidadeReducao
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
     * Set percentual
     *
     * @param boolean $percentual
     * @return ModalidadeReducao
     */
    public function setPercentual($percentual)
    {
        $this->percentual = $percentual;
        return $this;
    }

    /**
     * Get percentual
     *
     * @return boolean
     */
    public function getPercentual()
    {
        return $this->percentual;
    }

    /**
     * Set valor
     *
     * @param integer $valor
     * @return ModalidadeReducao
     */
    public function setValor($valor)
    {
        $this->valor = $valor;
        return $this;
    }

    /**
     * Get valor
     *
     * @return integer
     */
    public function getValor()
    {
        return $this->valor;
    }

    /**
     * OneToMany (owning side)
     * Add DividaModalidadeReducaoAcrescimo
     *
     * @param \Urbem\CoreBundle\Entity\Divida\ModalidadeReducaoAcrescimo $fkDividaModalidadeReducaoAcrescimo
     * @return ModalidadeReducao
     */
    public function addFkDividaModalidadeReducaoAcrescimos(\Urbem\CoreBundle\Entity\Divida\ModalidadeReducaoAcrescimo $fkDividaModalidadeReducaoAcrescimo)
    {
        if (false === $this->fkDividaModalidadeReducaoAcrescimos->contains($fkDividaModalidadeReducaoAcrescimo)) {
            $fkDividaModalidadeReducaoAcrescimo->setFkDividaModalidadeReducao($this);
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
     * OneToMany (owning side)
     * Add DividaModalidadeReducaoCredito
     *
     * @param \Urbem\CoreBundle\Entity\Divida\ModalidadeReducaoCredito $fkDividaModalidadeReducaoCredito
     * @return ModalidadeReducao
     */
    public function addFkDividaModalidadeReducaoCreditos(\Urbem\CoreBundle\Entity\Divida\ModalidadeReducaoCredito $fkDividaModalidadeReducaoCredito)
    {
        if (false === $this->fkDividaModalidadeReducaoCreditos->contains($fkDividaModalidadeReducaoCredito)) {
            $fkDividaModalidadeReducaoCredito->setFkDividaModalidadeReducao($this);
            $this->fkDividaModalidadeReducaoCreditos->add($fkDividaModalidadeReducaoCredito);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove DividaModalidadeReducaoCredito
     *
     * @param \Urbem\CoreBundle\Entity\Divida\ModalidadeReducaoCredito $fkDividaModalidadeReducaoCredito
     */
    public function removeFkDividaModalidadeReducaoCreditos(\Urbem\CoreBundle\Entity\Divida\ModalidadeReducaoCredito $fkDividaModalidadeReducaoCredito)
    {
        $this->fkDividaModalidadeReducaoCreditos->removeElement($fkDividaModalidadeReducaoCredito);
    }

    /**
     * OneToMany (owning side)
     * Get fkDividaModalidadeReducaoCreditos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Divida\ModalidadeReducaoCredito
     */
    public function getFkDividaModalidadeReducaoCreditos()
    {
        return $this->fkDividaModalidadeReducaoCreditos;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkDividaModalidadeVigencia
     *
     * @param \Urbem\CoreBundle\Entity\Divida\ModalidadeVigencia $fkDividaModalidadeVigencia
     * @return ModalidadeReducao
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
     * @return ModalidadeReducao
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
