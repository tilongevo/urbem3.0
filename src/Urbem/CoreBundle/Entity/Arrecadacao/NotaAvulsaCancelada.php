<?php
 
namespace Urbem\CoreBundle\Entity\Arrecadacao;

/**
 * NotaAvulsaCancelada
 */
class NotaAvulsaCancelada
{
    /**
     * PK
     * @var integer
     */
    private $codNota;

    /**
     * @var integer
     */
    private $numcgmUsuario;

    /**
     * @var \DateTime
     */
    private $dtCancelamento;

    /**
     * @var string
     */
    private $observacao;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Arrecadacao\NotaAvulsa
     */
    private $fkArrecadacaoNotaAvulsa;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Administracao\Usuario
     */
    private $fkAdministracaoUsuario;


    /**
     * Set codNota
     *
     * @param integer $codNota
     * @return NotaAvulsaCancelada
     */
    public function setCodNota($codNota)
    {
        $this->codNota = $codNota;
        return $this;
    }

    /**
     * Get codNota
     *
     * @return integer
     */
    public function getCodNota()
    {
        return $this->codNota;
    }

    /**
     * Set numcgmUsuario
     *
     * @param integer $numcgmUsuario
     * @return NotaAvulsaCancelada
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
     * Set dtCancelamento
     *
     * @param \DateTime $dtCancelamento
     * @return NotaAvulsaCancelada
     */
    public function setDtCancelamento(\DateTime $dtCancelamento)
    {
        $this->dtCancelamento = $dtCancelamento;
        return $this;
    }

    /**
     * Get dtCancelamento
     *
     * @return \DateTime
     */
    public function getDtCancelamento()
    {
        return $this->dtCancelamento;
    }

    /**
     * Set observacao
     *
     * @param string $observacao
     * @return NotaAvulsaCancelada
     */
    public function setObservacao($observacao)
    {
        $this->observacao = $observacao;
        return $this;
    }

    /**
     * Get observacao
     *
     * @return string
     */
    public function getObservacao()
    {
        return $this->observacao;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkAdministracaoUsuario
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\Usuario $fkAdministracaoUsuario
     * @return NotaAvulsaCancelada
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
     * OneToOne (owning side)
     * Set ArrecadacaoNotaAvulsa
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\NotaAvulsa $fkArrecadacaoNotaAvulsa
     * @return NotaAvulsaCancelada
     */
    public function setFkArrecadacaoNotaAvulsa(\Urbem\CoreBundle\Entity\Arrecadacao\NotaAvulsa $fkArrecadacaoNotaAvulsa)
    {
        $this->codNota = $fkArrecadacaoNotaAvulsa->getCodNota();
        $this->fkArrecadacaoNotaAvulsa = $fkArrecadacaoNotaAvulsa;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkArrecadacaoNotaAvulsa
     *
     * @return \Urbem\CoreBundle\Entity\Arrecadacao\NotaAvulsa
     */
    public function getFkArrecadacaoNotaAvulsa()
    {
        return $this->fkArrecadacaoNotaAvulsa;
    }
}
