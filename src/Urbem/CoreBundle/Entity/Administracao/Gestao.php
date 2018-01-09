<?php
 
namespace Urbem\CoreBundle\Entity\Administracao;

/**
 * Gestao
 */
class Gestao
{
    const GESTAO_ADMINISTRATIVA = 1;
    const GESTAO_FINANCEIRA = 2;
    const GESTAO_PATRIMONIAL = 3;
    const GESTAO_RECURSOS_HUMANOS = 4;
    const GESTAO_TRIBUTARIA = 5;

    /**
     * PK
     * @var integer
     */
    private $codGestao;

    /**
     * @var string
     */
    private $nomGestao;

    /**
     * @var string
     */
    private $nomDiretorio;

    /**
     * @var integer
     */
    private $ordem;

    /**
     * @var string
     */
    private $versao;

    /**
     * @var integer
     */
    private $versaoDb;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Administracao\HistoricoVersao
     */
    private $fkAdministracaoHistoricoVersoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Administracao\Modulo
     */
    private $fkAdministracaoModulos;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkAdministracaoHistoricoVersoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkAdministracaoModulos = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codGestao
     *
     * @param integer $codGestao
     * @return Gestao
     */
    public function setCodGestao($codGestao)
    {
        $this->codGestao = $codGestao;
        return $this;
    }

    /**
     * Get codGestao
     *
     * @return integer
     */
    public function getCodGestao()
    {
        return $this->codGestao;
    }

    /**
     * Set nomGestao
     *
     * @param string $nomGestao
     * @return Gestao
     */
    public function setNomGestao($nomGestao)
    {
        $this->nomGestao = $nomGestao;
        return $this;
    }

    /**
     * Get nomGestao
     *
     * @return string
     */
    public function getNomGestao()
    {
        return $this->nomGestao;
    }

    /**
     * Set nomDiretorio
     *
     * @param string $nomDiretorio
     * @return Gestao
     */
    public function setNomDiretorio($nomDiretorio)
    {
        $this->nomDiretorio = $nomDiretorio;
        return $this;
    }

    /**
     * Get nomDiretorio
     *
     * @return string
     */
    public function getNomDiretorio()
    {
        return $this->nomDiretorio;
    }

    /**
     * Set ordem
     *
     * @param integer $ordem
     * @return Gestao
     */
    public function setOrdem($ordem)
    {
        $this->ordem = $ordem;
        return $this;
    }

    /**
     * Get ordem
     *
     * @return integer
     */
    public function getOrdem()
    {
        return $this->ordem;
    }

    /**
     * Set versao
     *
     * @param string $versao
     * @return Gestao
     */
    public function setVersao($versao)
    {
        $this->versao = $versao;
        return $this;
    }

    /**
     * Get versao
     *
     * @return string
     */
    public function getVersao()
    {
        return $this->versao;
    }

    /**
     * Set versaoDb
     *
     * @param integer $versaoDb
     * @return Gestao
     */
    public function setVersaoDb($versaoDb)
    {
        $this->versaoDb = $versaoDb;
        return $this;
    }

    /**
     * Get versaoDb
     *
     * @return integer
     */
    public function getVersaoDb()
    {
        return $this->versaoDb;
    }

    /**
     * OneToMany (owning side)
     * Add AdministracaoHistoricoVersao
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\HistoricoVersao $fkAdministracaoHistoricoVersao
     * @return Gestao
     */
    public function addFkAdministracaoHistoricoVersoes(\Urbem\CoreBundle\Entity\Administracao\HistoricoVersao $fkAdministracaoHistoricoVersao)
    {
        if (false === $this->fkAdministracaoHistoricoVersoes->contains($fkAdministracaoHistoricoVersao)) {
            $fkAdministracaoHistoricoVersao->setFkAdministracaoGestao($this);
            $this->fkAdministracaoHistoricoVersoes->add($fkAdministracaoHistoricoVersao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove AdministracaoHistoricoVersao
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\HistoricoVersao $fkAdministracaoHistoricoVersao
     */
    public function removeFkAdministracaoHistoricoVersoes(\Urbem\CoreBundle\Entity\Administracao\HistoricoVersao $fkAdministracaoHistoricoVersao)
    {
        $this->fkAdministracaoHistoricoVersoes->removeElement($fkAdministracaoHistoricoVersao);
    }

    /**
     * OneToMany (owning side)
     * Get fkAdministracaoHistoricoVersoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Administracao\HistoricoVersao
     */
    public function getFkAdministracaoHistoricoVersoes()
    {
        return $this->fkAdministracaoHistoricoVersoes;
    }

    /**
     * OneToMany (owning side)
     * Add AdministracaoModulo
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\Modulo $fkAdministracaoModulo
     * @return Gestao
     */
    public function addFkAdministracaoModulos(\Urbem\CoreBundle\Entity\Administracao\Modulo $fkAdministracaoModulo)
    {
        if (false === $this->fkAdministracaoModulos->contains($fkAdministracaoModulo)) {
            $fkAdministracaoModulo->setFkAdministracaoGestao($this);
            $this->fkAdministracaoModulos->add($fkAdministracaoModulo);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove AdministracaoModulo
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\Modulo $fkAdministracaoModulo
     */
    public function removeFkAdministracaoModulos(\Urbem\CoreBundle\Entity\Administracao\Modulo $fkAdministracaoModulo)
    {
        $this->fkAdministracaoModulos->removeElement($fkAdministracaoModulo);
    }

    /**
     * OneToMany (owning side)
     * Get fkAdministracaoModulos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Administracao\Modulo
     */
    public function getFkAdministracaoModulos()
    {
        return $this->fkAdministracaoModulos;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return sprintf('%d - %s', $this->getCodGestao(), $this->getNomGestao());
    }
}
