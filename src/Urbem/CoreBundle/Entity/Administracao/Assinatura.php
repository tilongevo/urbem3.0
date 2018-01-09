<?php
 
namespace Urbem\CoreBundle\Entity\Administracao;

/**
 * Assinatura
 */
class Assinatura
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
    private $numcgm;

    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    private $timestamp;

    /**
     * @var string
     */
    private $cargo;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Administracao\AssinaturaCrc
     */
    private $fkAdministracaoAssinaturaCrc;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Administracao\AssinaturaModulo
     */
    private $fkAdministracaoAssinaturaModulos;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Orcamento\Entidade
     */
    private $fkOrcamentoEntidade;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\SwCgmPessoaFisica
     */
    private $fkSwCgmPessoaFisica;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkAdministracaoAssinaturaModulos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
    }

    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return Assinatura
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
     * @return Assinatura
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
     * Set numcgm
     *
     * @param integer $numcgm
     * @return Assinatura
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
     * Set timestamp
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp
     * @return Assinatura
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
     * Set cargo
     *
     * @param string $cargo
     * @return Assinatura
     */
    public function setCargo($cargo)
    {
        $this->cargo = $cargo;
        return $this;
    }

    /**
     * Get cargo
     *
     * @return string
     */
    public function getCargo()
    {
        return $this->cargo;
    }

    /**
     * OneToMany (owning side)
     * Add AdministracaoAssinaturaModulo
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\AssinaturaModulo $fkAdministracaoAssinaturaModulo
     * @return Assinatura
     */
    public function addFkAdministracaoAssinaturaModulos(\Urbem\CoreBundle\Entity\Administracao\AssinaturaModulo $fkAdministracaoAssinaturaModulo)
    {
        if (false === $this->fkAdministracaoAssinaturaModulos->contains($fkAdministracaoAssinaturaModulo)) {
            $fkAdministracaoAssinaturaModulo->setFkAdministracaoAssinatura($this);
            $this->fkAdministracaoAssinaturaModulos->add($fkAdministracaoAssinaturaModulo);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove AdministracaoAssinaturaModulo
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\AssinaturaModulo $fkAdministracaoAssinaturaModulo
     */
    public function removeFkAdministracaoAssinaturaModulos(\Urbem\CoreBundle\Entity\Administracao\AssinaturaModulo $fkAdministracaoAssinaturaModulo)
    {
        $this->fkAdministracaoAssinaturaModulos->removeElement($fkAdministracaoAssinaturaModulo);
    }

    /**
     * OneToMany (owning side)
     * Get fkAdministracaoAssinaturaModulos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Administracao\AssinaturaModulo
     */
    public function getFkAdministracaoAssinaturaModulos()
    {
        return $this->fkAdministracaoAssinaturaModulos;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkOrcamentoEntidade
     *
     * @param \Urbem\CoreBundle\Entity\Orcamento\Entidade $fkOrcamentoEntidade
     * @return Assinatura
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
     * Set fkSwCgmPessoaFisica
     *
     * @param \Urbem\CoreBundle\Entity\SwCgmPessoaFisica $fkSwCgmPessoaFisica
     * @return Assinatura
     */
    public function setFkSwCgmPessoaFisica(\Urbem\CoreBundle\Entity\SwCgmPessoaFisica $fkSwCgmPessoaFisica)
    {
        $this->numcgm = $fkSwCgmPessoaFisica->getNumcgm();
        $this->fkSwCgmPessoaFisica = $fkSwCgmPessoaFisica;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkSwCgmPessoaFisica
     *
     * @return \Urbem\CoreBundle\Entity\SwCgmPessoaFisica
     */
    public function getFkSwCgmPessoaFisica()
    {
        return $this->fkSwCgmPessoaFisica;
    }

    /**
     * OneToOne (inverse side)
     * Set AdministracaoAssinaturaCrc
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\AssinaturaCrc $fkAdministracaoAssinaturaCrc
     * @return Assinatura
     */
    public function setFkAdministracaoAssinaturaCrc(\Urbem\CoreBundle\Entity\Administracao\AssinaturaCrc $fkAdministracaoAssinaturaCrc)
    {
        $fkAdministracaoAssinaturaCrc->setFkAdministracaoAssinatura($this);
        $this->fkAdministracaoAssinaturaCrc = $fkAdministracaoAssinaturaCrc;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkAdministracaoAssinaturaCrc
     *
     * @return \Urbem\CoreBundle\Entity\Administracao\AssinaturaCrc
     */
    public function getFkAdministracaoAssinaturaCrc()
    {
        return $this->fkAdministracaoAssinaturaCrc;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return sprintf('%s|%s', (string) $this->fkSwCgmPessoaFisica, $this->cargo);
    }

    /**
     * @return string
     */
    public function getCustomAssinaturaToString()
    {
        return sprintf('%s (%s)', $this->__toString(), $this->fkOrcamentoEntidade->getCustomEntidadeNomeToString());
    }
}
