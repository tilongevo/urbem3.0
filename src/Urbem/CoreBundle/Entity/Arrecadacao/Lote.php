<?php
 
namespace Urbem\CoreBundle\Entity\Arrecadacao;

/**
 * Lote
 */
class Lote
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
    private $codLote;

    /**
     * @var integer
     */
    private $numcgm;

    /**
     * @var \DateTime
     */
    private $dataLote;

    /**
     * @var integer
     */
    private $codBanco;

    /**
     * @var integer
     */
    private $codAgencia;

    /**
     * @var boolean
     */
    private $automatico;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Arrecadacao\LoteArquivo
     */
    private $fkArrecadacaoLoteArquivo;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Arrecadacao\LoteInconsistencia
     */
    private $fkArrecadacaoLoteInconsistencias;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Arrecadacao\PagamentoLote
     */
    private $fkArrecadacaoPagamentoLotes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tesouraria\BoletimLoteArrecadacao
     */
    private $fkTesourariaBoletimLoteArrecadacoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tesouraria\BoletimLoteArrecadacaoInconsistencia
     */
    private $fkTesourariaBoletimLoteArrecadacaoInconsistencias;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tesouraria\BoletimLoteTransferenciaInconsistencia
     */
    private $fkTesourariaBoletimLoteTransferenciaInconsistencias;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tesouraria\BoletimLoteTransferencia
     */
    private $fkTesourariaBoletimLoteTransferencias;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Administracao\Usuario
     */
    private $fkAdministracaoUsuario;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Monetario\Agencia
     */
    private $fkMonetarioAgencia;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkArrecadacaoLoteInconsistencias = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkArrecadacaoPagamentoLotes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTesourariaBoletimLoteArrecadacoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTesourariaBoletimLoteArrecadacaoInconsistencias = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTesourariaBoletimLoteTransferenciaInconsistencias = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTesourariaBoletimLoteTransferencias = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return Lote
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
     * Set codLote
     *
     * @param integer $codLote
     * @return Lote
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
     * Set numcgm
     *
     * @param integer $numcgm
     * @return Lote
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
     * Set dataLote
     *
     * @param \DateTime $dataLote
     * @return Lote
     */
    public function setDataLote(\DateTime $dataLote)
    {
        $this->dataLote = $dataLote;
        return $this;
    }

    /**
     * Get dataLote
     *
     * @return \DateTime
     */
    public function getDataLote()
    {
        return $this->dataLote;
    }

    /**
     * Set codBanco
     *
     * @param integer $codBanco
     * @return Lote
     */
    public function setCodBanco($codBanco)
    {
        $this->codBanco = $codBanco;
        return $this;
    }

    /**
     * Get codBanco
     *
     * @return integer
     */
    public function getCodBanco()
    {
        return $this->codBanco;
    }

    /**
     * Set codAgencia
     *
     * @param integer $codAgencia
     * @return Lote
     */
    public function setCodAgencia($codAgencia)
    {
        $this->codAgencia = $codAgencia;
        return $this;
    }

    /**
     * Get codAgencia
     *
     * @return integer
     */
    public function getCodAgencia()
    {
        return $this->codAgencia;
    }

    /**
     * Set automatico
     *
     * @param boolean $automatico
     * @return Lote
     */
    public function setAutomatico($automatico)
    {
        $this->automatico = $automatico;
        return $this;
    }

    /**
     * Get automatico
     *
     * @return boolean
     */
    public function getAutomatico()
    {
        return $this->automatico;
    }

    /**
     * OneToMany (owning side)
     * Add ArrecadacaoLoteInconsistencia
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\LoteInconsistencia $fkArrecadacaoLoteInconsistencia
     * @return Lote
     */
    public function addFkArrecadacaoLoteInconsistencias(\Urbem\CoreBundle\Entity\Arrecadacao\LoteInconsistencia $fkArrecadacaoLoteInconsistencia)
    {
        if (false === $this->fkArrecadacaoLoteInconsistencias->contains($fkArrecadacaoLoteInconsistencia)) {
            $fkArrecadacaoLoteInconsistencia->setFkArrecadacaoLote($this);
            $this->fkArrecadacaoLoteInconsistencias->add($fkArrecadacaoLoteInconsistencia);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ArrecadacaoLoteInconsistencia
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\LoteInconsistencia $fkArrecadacaoLoteInconsistencia
     */
    public function removeFkArrecadacaoLoteInconsistencias(\Urbem\CoreBundle\Entity\Arrecadacao\LoteInconsistencia $fkArrecadacaoLoteInconsistencia)
    {
        $this->fkArrecadacaoLoteInconsistencias->removeElement($fkArrecadacaoLoteInconsistencia);
    }

    /**
     * OneToMany (owning side)
     * Get fkArrecadacaoLoteInconsistencias
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Arrecadacao\LoteInconsistencia
     */
    public function getFkArrecadacaoLoteInconsistencias()
    {
        return $this->fkArrecadacaoLoteInconsistencias;
    }

    /**
     * OneToMany (owning side)
     * Add ArrecadacaoPagamentoLote
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\PagamentoLote $fkArrecadacaoPagamentoLote
     * @return Lote
     */
    public function addFkArrecadacaoPagamentoLotes(\Urbem\CoreBundle\Entity\Arrecadacao\PagamentoLote $fkArrecadacaoPagamentoLote)
    {
        if (false === $this->fkArrecadacaoPagamentoLotes->contains($fkArrecadacaoPagamentoLote)) {
            $fkArrecadacaoPagamentoLote->setFkArrecadacaoLote($this);
            $this->fkArrecadacaoPagamentoLotes->add($fkArrecadacaoPagamentoLote);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ArrecadacaoPagamentoLote
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\PagamentoLote $fkArrecadacaoPagamentoLote
     */
    public function removeFkArrecadacaoPagamentoLotes(\Urbem\CoreBundle\Entity\Arrecadacao\PagamentoLote $fkArrecadacaoPagamentoLote)
    {
        $this->fkArrecadacaoPagamentoLotes->removeElement($fkArrecadacaoPagamentoLote);
    }

    /**
     * OneToMany (owning side)
     * Get fkArrecadacaoPagamentoLotes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Arrecadacao\PagamentoLote
     */
    public function getFkArrecadacaoPagamentoLotes()
    {
        return $this->fkArrecadacaoPagamentoLotes;
    }

    /**
     * OneToMany (owning side)
     * Add TesourariaBoletimLoteArrecadacao
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\BoletimLoteArrecadacao $fkTesourariaBoletimLoteArrecadacao
     * @return Lote
     */
    public function addFkTesourariaBoletimLoteArrecadacoes(\Urbem\CoreBundle\Entity\Tesouraria\BoletimLoteArrecadacao $fkTesourariaBoletimLoteArrecadacao)
    {
        if (false === $this->fkTesourariaBoletimLoteArrecadacoes->contains($fkTesourariaBoletimLoteArrecadacao)) {
            $fkTesourariaBoletimLoteArrecadacao->setFkArrecadacaoLote($this);
            $this->fkTesourariaBoletimLoteArrecadacoes->add($fkTesourariaBoletimLoteArrecadacao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TesourariaBoletimLoteArrecadacao
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\BoletimLoteArrecadacao $fkTesourariaBoletimLoteArrecadacao
     */
    public function removeFkTesourariaBoletimLoteArrecadacoes(\Urbem\CoreBundle\Entity\Tesouraria\BoletimLoteArrecadacao $fkTesourariaBoletimLoteArrecadacao)
    {
        $this->fkTesourariaBoletimLoteArrecadacoes->removeElement($fkTesourariaBoletimLoteArrecadacao);
    }

    /**
     * OneToMany (owning side)
     * Get fkTesourariaBoletimLoteArrecadacoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tesouraria\BoletimLoteArrecadacao
     */
    public function getFkTesourariaBoletimLoteArrecadacoes()
    {
        return $this->fkTesourariaBoletimLoteArrecadacoes;
    }

    /**
     * OneToMany (owning side)
     * Add TesourariaBoletimLoteArrecadacaoInconsistencia
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\BoletimLoteArrecadacaoInconsistencia $fkTesourariaBoletimLoteArrecadacaoInconsistencia
     * @return Lote
     */
    public function addFkTesourariaBoletimLoteArrecadacaoInconsistencias(\Urbem\CoreBundle\Entity\Tesouraria\BoletimLoteArrecadacaoInconsistencia $fkTesourariaBoletimLoteArrecadacaoInconsistencia)
    {
        if (false === $this->fkTesourariaBoletimLoteArrecadacaoInconsistencias->contains($fkTesourariaBoletimLoteArrecadacaoInconsistencia)) {
            $fkTesourariaBoletimLoteArrecadacaoInconsistencia->setFkArrecadacaoLote($this);
            $this->fkTesourariaBoletimLoteArrecadacaoInconsistencias->add($fkTesourariaBoletimLoteArrecadacaoInconsistencia);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TesourariaBoletimLoteArrecadacaoInconsistencia
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\BoletimLoteArrecadacaoInconsistencia $fkTesourariaBoletimLoteArrecadacaoInconsistencia
     */
    public function removeFkTesourariaBoletimLoteArrecadacaoInconsistencias(\Urbem\CoreBundle\Entity\Tesouraria\BoletimLoteArrecadacaoInconsistencia $fkTesourariaBoletimLoteArrecadacaoInconsistencia)
    {
        $this->fkTesourariaBoletimLoteArrecadacaoInconsistencias->removeElement($fkTesourariaBoletimLoteArrecadacaoInconsistencia);
    }

    /**
     * OneToMany (owning side)
     * Get fkTesourariaBoletimLoteArrecadacaoInconsistencias
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tesouraria\BoletimLoteArrecadacaoInconsistencia
     */
    public function getFkTesourariaBoletimLoteArrecadacaoInconsistencias()
    {
        return $this->fkTesourariaBoletimLoteArrecadacaoInconsistencias;
    }

    /**
     * OneToMany (owning side)
     * Add TesourariaBoletimLoteTransferenciaInconsistencia
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\BoletimLoteTransferenciaInconsistencia $fkTesourariaBoletimLoteTransferenciaInconsistencia
     * @return Lote
     */
    public function addFkTesourariaBoletimLoteTransferenciaInconsistencias(\Urbem\CoreBundle\Entity\Tesouraria\BoletimLoteTransferenciaInconsistencia $fkTesourariaBoletimLoteTransferenciaInconsistencia)
    {
        if (false === $this->fkTesourariaBoletimLoteTransferenciaInconsistencias->contains($fkTesourariaBoletimLoteTransferenciaInconsistencia)) {
            $fkTesourariaBoletimLoteTransferenciaInconsistencia->setFkArrecadacaoLote($this);
            $this->fkTesourariaBoletimLoteTransferenciaInconsistencias->add($fkTesourariaBoletimLoteTransferenciaInconsistencia);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TesourariaBoletimLoteTransferenciaInconsistencia
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\BoletimLoteTransferenciaInconsistencia $fkTesourariaBoletimLoteTransferenciaInconsistencia
     */
    public function removeFkTesourariaBoletimLoteTransferenciaInconsistencias(\Urbem\CoreBundle\Entity\Tesouraria\BoletimLoteTransferenciaInconsistencia $fkTesourariaBoletimLoteTransferenciaInconsistencia)
    {
        $this->fkTesourariaBoletimLoteTransferenciaInconsistencias->removeElement($fkTesourariaBoletimLoteTransferenciaInconsistencia);
    }

    /**
     * OneToMany (owning side)
     * Get fkTesourariaBoletimLoteTransferenciaInconsistencias
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tesouraria\BoletimLoteTransferenciaInconsistencia
     */
    public function getFkTesourariaBoletimLoteTransferenciaInconsistencias()
    {
        return $this->fkTesourariaBoletimLoteTransferenciaInconsistencias;
    }

    /**
     * OneToMany (owning side)
     * Add TesourariaBoletimLoteTransferencia
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\BoletimLoteTransferencia $fkTesourariaBoletimLoteTransferencia
     * @return Lote
     */
    public function addFkTesourariaBoletimLoteTransferencias(\Urbem\CoreBundle\Entity\Tesouraria\BoletimLoteTransferencia $fkTesourariaBoletimLoteTransferencia)
    {
        if (false === $this->fkTesourariaBoletimLoteTransferencias->contains($fkTesourariaBoletimLoteTransferencia)) {
            $fkTesourariaBoletimLoteTransferencia->setFkArrecadacaoLote($this);
            $this->fkTesourariaBoletimLoteTransferencias->add($fkTesourariaBoletimLoteTransferencia);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TesourariaBoletimLoteTransferencia
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\BoletimLoteTransferencia $fkTesourariaBoletimLoteTransferencia
     */
    public function removeFkTesourariaBoletimLoteTransferencias(\Urbem\CoreBundle\Entity\Tesouraria\BoletimLoteTransferencia $fkTesourariaBoletimLoteTransferencia)
    {
        $this->fkTesourariaBoletimLoteTransferencias->removeElement($fkTesourariaBoletimLoteTransferencia);
    }

    /**
     * OneToMany (owning side)
     * Get fkTesourariaBoletimLoteTransferencias
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tesouraria\BoletimLoteTransferencia
     */
    public function getFkTesourariaBoletimLoteTransferencias()
    {
        return $this->fkTesourariaBoletimLoteTransferencias;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkAdministracaoUsuario
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\Usuario $fkAdministracaoUsuario
     * @return Lote
     */
    public function setFkAdministracaoUsuario(\Urbem\CoreBundle\Entity\Administracao\Usuario $fkAdministracaoUsuario)
    {
        $this->numcgm = $fkAdministracaoUsuario->getNumcgm();
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
     * ManyToOne (inverse side)
     * Set fkMonetarioAgencia
     *
     * @param \Urbem\CoreBundle\Entity\Monetario\Agencia $fkMonetarioAgencia
     * @return Lote
     */
    public function setFkMonetarioAgencia(\Urbem\CoreBundle\Entity\Monetario\Agencia $fkMonetarioAgencia)
    {
        $this->codBanco = $fkMonetarioAgencia->getCodBanco();
        $this->codAgencia = $fkMonetarioAgencia->getCodAgencia();
        $this->fkMonetarioAgencia = $fkMonetarioAgencia;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkMonetarioAgencia
     *
     * @return \Urbem\CoreBundle\Entity\Monetario\Agencia
     */
    public function getFkMonetarioAgencia()
    {
        return $this->fkMonetarioAgencia;
    }

    /**
     * OneToOne (inverse side)
     * Set ArrecadacaoLoteArquivo
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\LoteArquivo $fkArrecadacaoLoteArquivo
     * @return Lote
     */
    public function setFkArrecadacaoLoteArquivo(\Urbem\CoreBundle\Entity\Arrecadacao\LoteArquivo $fkArrecadacaoLoteArquivo)
    {
        $fkArrecadacaoLoteArquivo->setFkArrecadacaoLote($this);
        $this->fkArrecadacaoLoteArquivo = $fkArrecadacaoLoteArquivo;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkArrecadacaoLoteArquivo
     *
     * @return \Urbem\CoreBundle\Entity\Arrecadacao\LoteArquivo
     */
    public function getFkArrecadacaoLoteArquivo()
    {
        return $this->fkArrecadacaoLoteArquivo;
    }
}
