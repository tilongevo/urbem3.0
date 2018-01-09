<?php
 
namespace Urbem\CoreBundle\Entity\Folhapagamento;

/**
 * PensaoFuncaoPadrao
 */
class PensaoFuncaoPadrao
{
    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    private $timestamp;

    /**
     * PK
     * @var integer
     */
    private $codConfiguracaoPensao;

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
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\PensaoEvento
     */
    private $fkFolhapagamentoPensaoEventos;

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
        $this->fkFolhapagamentoPensaoEventos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
    }

    /**
     * Set timestamp
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp
     * @return PensaoFuncaoPadrao
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
     * Set codConfiguracaoPensao
     *
     * @param integer $codConfiguracaoPensao
     * @return PensaoFuncaoPadrao
     */
    public function setCodConfiguracaoPensao($codConfiguracaoPensao)
    {
        $this->codConfiguracaoPensao = $codConfiguracaoPensao;
        return $this;
    }

    /**
     * Get codConfiguracaoPensao
     *
     * @return integer
     */
    public function getCodConfiguracaoPensao()
    {
        return $this->codConfiguracaoPensao;
    }

    /**
     * Set codFuncao
     *
     * @param integer $codFuncao
     * @return PensaoFuncaoPadrao
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
     * @return PensaoFuncaoPadrao
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
     * @return PensaoFuncaoPadrao
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
     * Add FolhapagamentoPensaoEvento
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\PensaoEvento $fkFolhapagamentoPensaoEvento
     * @return PensaoFuncaoPadrao
     */
    public function addFkFolhapagamentoPensaoEventos(\Urbem\CoreBundle\Entity\Folhapagamento\PensaoEvento $fkFolhapagamentoPensaoEvento)
    {
        if (false === $this->fkFolhapagamentoPensaoEventos->contains($fkFolhapagamentoPensaoEvento)) {
            $fkFolhapagamentoPensaoEvento->setFkFolhapagamentoPensaoFuncaoPadrao($this);
            $this->fkFolhapagamentoPensaoEventos->add($fkFolhapagamentoPensaoEvento);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FolhapagamentoPensaoEvento
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\PensaoEvento $fkFolhapagamentoPensaoEvento
     */
    public function removeFkFolhapagamentoPensaoEventos(\Urbem\CoreBundle\Entity\Folhapagamento\PensaoEvento $fkFolhapagamentoPensaoEvento)
    {
        $this->fkFolhapagamentoPensaoEventos->removeElement($fkFolhapagamentoPensaoEvento);
    }

    /**
     * OneToMany (owning side)
     * Get fkFolhapagamentoPensaoEventos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\PensaoEvento
     */
    public function getFkFolhapagamentoPensaoEventos()
    {
        return $this->fkFolhapagamentoPensaoEventos;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkAdministracaoFuncao
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\Funcao $fkAdministracaoFuncao
     * @return PensaoFuncaoPadrao
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
    
    /**
     * Returna a descrição da função
     * @return string
     */
    public function getDescricaoFuncao()
    {
        return $this->fkAdministracaoFuncao->getCodModulo()
        . "." . $this->fkAdministracaoFuncao->getCodBiblioteca()
        . "." . $this->fkAdministracaoFuncao->getCodFuncao()
        . " - " . $this->fkAdministracaoFuncao->getNomFuncao()
        ;
    }
}
