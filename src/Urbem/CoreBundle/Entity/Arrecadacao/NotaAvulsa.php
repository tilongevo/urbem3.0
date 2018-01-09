<?php
 
namespace Urbem\CoreBundle\Entity\Arrecadacao;

/**
 * NotaAvulsa
 */
class NotaAvulsa
{
    /**
     * PK
     * @var integer
     */
    private $codNota;

    /**
     * @var integer
     */
    private $numcgmTomador;

    /**
     * @var integer
     */
    private $numcgmUsuario;

    /**
     * @var string
     */
    private $nroSerie;

    /**
     * @var integer
     */
    private $nroNota;

    /**
     * @var string
     */
    private $exercicio;

    /**
     * @var string
     */
    private $observacao;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Arrecadacao\NotaAvulsaCancelada
     */
    private $fkArrecadacaoNotaAvulsaCancelada;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Arrecadacao\TomadorEmpresa
     */
    private $fkArrecadacaoTomadorEmpresa;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Arrecadacao\Nota
     */
    private $fkArrecadacaoNota;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\SwCgm
     */
    private $fkSwCgm;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Administracao\Usuario
     */
    private $fkAdministracaoUsuario;


    /**
     * Set codNota
     *
     * @param integer $codNota
     * @return NotaAvulsa
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
     * Set numcgmTomador
     *
     * @param integer $numcgmTomador
     * @return NotaAvulsa
     */
    public function setNumcgmTomador($numcgmTomador)
    {
        $this->numcgmTomador = $numcgmTomador;
        return $this;
    }

    /**
     * Get numcgmTomador
     *
     * @return integer
     */
    public function getNumcgmTomador()
    {
        return $this->numcgmTomador;
    }

    /**
     * Set numcgmUsuario
     *
     * @param integer $numcgmUsuario
     * @return NotaAvulsa
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
     * Set nroSerie
     *
     * @param string $nroSerie
     * @return NotaAvulsa
     */
    public function setNroSerie($nroSerie)
    {
        $this->nroSerie = $nroSerie;
        return $this;
    }

    /**
     * Get nroSerie
     *
     * @return string
     */
    public function getNroSerie()
    {
        return $this->nroSerie;
    }

    /**
     * Set nroNota
     *
     * @param integer $nroNota
     * @return NotaAvulsa
     */
    public function setNroNota($nroNota)
    {
        $this->nroNota = $nroNota;
        return $this;
    }

    /**
     * Get nroNota
     *
     * @return integer
     */
    public function getNroNota()
    {
        return $this->nroNota;
    }

    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return NotaAvulsa
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
     * Set observacao
     *
     * @param string $observacao
     * @return NotaAvulsa
     */
    public function setObservacao($observacao = null)
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
     * Set fkSwCgm
     *
     * @param \Urbem\CoreBundle\Entity\SwCgm $fkSwCgm
     * @return NotaAvulsa
     */
    public function setFkSwCgm(\Urbem\CoreBundle\Entity\SwCgm $fkSwCgm)
    {
        $this->numcgmTomador = $fkSwCgm->getNumcgm();
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

    /**
     * ManyToOne (inverse side)
     * Set fkAdministracaoUsuario
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\Usuario $fkAdministracaoUsuario
     * @return NotaAvulsa
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
     * Set ArrecadacaoNotaAvulsaCancelada
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\NotaAvulsaCancelada $fkArrecadacaoNotaAvulsaCancelada
     * @return NotaAvulsa
     */
    public function setFkArrecadacaoNotaAvulsaCancelada(\Urbem\CoreBundle\Entity\Arrecadacao\NotaAvulsaCancelada $fkArrecadacaoNotaAvulsaCancelada)
    {
        $fkArrecadacaoNotaAvulsaCancelada->setFkArrecadacaoNotaAvulsa($this);
        $this->fkArrecadacaoNotaAvulsaCancelada = $fkArrecadacaoNotaAvulsaCancelada;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkArrecadacaoNotaAvulsaCancelada
     *
     * @return \Urbem\CoreBundle\Entity\Arrecadacao\NotaAvulsaCancelada
     */
    public function getFkArrecadacaoNotaAvulsaCancelada()
    {
        return $this->fkArrecadacaoNotaAvulsaCancelada;
    }

    /**
     * OneToOne (inverse side)
     * Set ArrecadacaoTomadorEmpresa
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\TomadorEmpresa $fkArrecadacaoTomadorEmpresa
     * @return NotaAvulsa
     */
    public function setFkArrecadacaoTomadorEmpresa(\Urbem\CoreBundle\Entity\Arrecadacao\TomadorEmpresa $fkArrecadacaoTomadorEmpresa)
    {
        $fkArrecadacaoTomadorEmpresa->setFkArrecadacaoNotaAvulsa($this);
        $this->fkArrecadacaoTomadorEmpresa = $fkArrecadacaoTomadorEmpresa;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkArrecadacaoTomadorEmpresa
     *
     * @return \Urbem\CoreBundle\Entity\Arrecadacao\TomadorEmpresa
     */
    public function getFkArrecadacaoTomadorEmpresa()
    {
        return $this->fkArrecadacaoTomadorEmpresa;
    }

    /**
     * OneToOne (owning side)
     * Set ArrecadacaoNota
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\Nota $fkArrecadacaoNota
     * @return NotaAvulsa
     */
    public function setFkArrecadacaoNota(\Urbem\CoreBundle\Entity\Arrecadacao\Nota $fkArrecadacaoNota)
    {
        $this->codNota = $fkArrecadacaoNota->getCodNota();
        $this->fkArrecadacaoNota = $fkArrecadacaoNota;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkArrecadacaoNota
     *
     * @return \Urbem\CoreBundle\Entity\Arrecadacao\Nota
     */
    public function getFkArrecadacaoNota()
    {
        return $this->fkArrecadacaoNota;
    }
}
