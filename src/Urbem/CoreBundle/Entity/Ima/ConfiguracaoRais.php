<?php
 
namespace Urbem\CoreBundle\Entity\Ima;

/**
 * ConfiguracaoRais
 */
class ConfiguracaoRais
{
    /**
     * PK
     * @var string
     */
    private $exercicio;

    /**
     * @var integer
     */
    private $numcgm;

    /**
     * @var string
     */
    private $tipoInscricao;

    /**
     * @var string
     */
    private $telefone;

    /**
     * @var string
     */
    private $email;

    /**
     * @var string
     */
    private $naturezaJuridica;

    /**
     * @var integer
     */
    private $codMunicipio;

    /**
     * @var integer
     */
    private $dtBaseCategoria;

    /**
     * @var boolean
     */
    private $ceiVinculado;

    /**
     * @var integer
     */
    private $prefixo = 0;

    /**
     * @var integer
     */
    private $numeroCei = '0';

    /**
     * @var integer
     */
    private $codTipoControlePonto = 1;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ima\EventoHorasExtras
     */
    private $fkImaEventoHorasExtras;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ima\EventoComposicaoRemuneracao
     */
    private $fkImaEventoComposicaoRemuneracoes;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\SwCgm
     */
    private $fkSwCgm;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Ima\TipoControlePonto
     */
    private $fkImaTipoControlePonto;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkImaEventoHorasExtras = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkImaEventoComposicaoRemuneracoes = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return ConfiguracaoRais
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
     * Set numcgm
     *
     * @param integer $numcgm
     * @return ConfiguracaoRais
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
     * Set tipoInscricao
     *
     * @param string $tipoInscricao
     * @return ConfiguracaoRais
     */
    public function setTipoInscricao($tipoInscricao)
    {
        $this->tipoInscricao = $tipoInscricao;
        return $this;
    }

    /**
     * Get tipoInscricao
     *
     * @return string
     */
    public function getTipoInscricao()
    {
        return $this->tipoInscricao;
    }

    /**
     * Set telefone
     *
     * @param string $telefone
     * @return ConfiguracaoRais
     */
    public function setTelefone($telefone)
    {
        $this->telefone = $telefone;
        return $this;
    }

    /**
     * Get telefone
     *
     * @return string
     */
    public function getTelefone()
    {
        return $this->telefone;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return ConfiguracaoRais
     */
    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set naturezaJuridica
     *
     * @param string $naturezaJuridica
     * @return ConfiguracaoRais
     */
    public function setNaturezaJuridica($naturezaJuridica)
    {
        $this->naturezaJuridica = $naturezaJuridica;
        return $this;
    }

    /**
     * Get naturezaJuridica
     *
     * @return string
     */
    public function getNaturezaJuridica()
    {
        return $this->naturezaJuridica;
    }

    /**
     * Set codMunicipio
     *
     * @param integer $codMunicipio
     * @return ConfiguracaoRais
     */
    public function setCodMunicipio($codMunicipio)
    {
        $this->codMunicipio = $codMunicipio;
        return $this;
    }

    /**
     * Get codMunicipio
     *
     * @return integer
     */
    public function getCodMunicipio()
    {
        return $this->codMunicipio;
    }

    /**
     * Set dtBaseCategoria
     *
     * @param integer $dtBaseCategoria
     * @return ConfiguracaoRais
     */
    public function setDtBaseCategoria($dtBaseCategoria)
    {
        $this->dtBaseCategoria = $dtBaseCategoria;
        return $this;
    }

    /**
     * Get dtBaseCategoria
     *
     * @return integer
     */
    public function getDtBaseCategoria()
    {
        return $this->dtBaseCategoria;
    }

    /**
     * Set ceiVinculado
     *
     * @param boolean $ceiVinculado
     * @return ConfiguracaoRais
     */
    public function setCeiVinculado($ceiVinculado)
    {
        $this->ceiVinculado = $ceiVinculado;
        return $this;
    }

    /**
     * Get ceiVinculado
     *
     * @return boolean
     */
    public function getCeiVinculado()
    {
        return $this->ceiVinculado;
    }

    /**
     * Set prefixo
     *
     * @param integer $prefixo
     * @return ConfiguracaoRais
     */
    public function setPrefixo($prefixo)
    {
        $this->prefixo = $prefixo;
        return $this;
    }

    /**
     * Get prefixo
     *
     * @return integer
     */
    public function getPrefixo()
    {
        return $this->prefixo;
    }

    /**
     * Set numeroCei
     *
     * @param integer $numeroCei
     * @return ConfiguracaoRais
     */
    public function setNumeroCei($numeroCei)
    {
        $this->numeroCei = $numeroCei;
        return $this;
    }

    /**
     * Get numeroCei
     *
     * @return integer
     */
    public function getNumeroCei()
    {
        return $this->numeroCei;
    }

    /**
     * Set codTipoControlePonto
     *
     * @param integer $codTipoControlePonto
     * @return ConfiguracaoRais
     */
    public function setCodTipoControlePonto($codTipoControlePonto)
    {
        $this->codTipoControlePonto = $codTipoControlePonto;
        return $this;
    }

    /**
     * Get codTipoControlePonto
     *
     * @return integer
     */
    public function getCodTipoControlePonto()
    {
        return $this->codTipoControlePonto;
    }

    /**
     * OneToMany (owning side)
     * Add ImaEventoHorasExtras
     *
     * @param \Urbem\CoreBundle\Entity\Ima\EventoHorasExtras $fkImaEventoHorasExtras
     * @return ConfiguracaoRais
     */
    public function addFkImaEventoHorasExtras(\Urbem\CoreBundle\Entity\Ima\EventoHorasExtras $fkImaEventoHorasExtras)
    {
        if (false === $this->fkImaEventoHorasExtras->contains($fkImaEventoHorasExtras)) {
            $fkImaEventoHorasExtras->setFkImaConfiguracaoRais($this);
            $this->fkImaEventoHorasExtras->add($fkImaEventoHorasExtras);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ImaEventoHorasExtras
     *
     * @param \Urbem\CoreBundle\Entity\Ima\EventoHorasExtras $fkImaEventoHorasExtras
     */
    public function removeFkImaEventoHorasExtras(\Urbem\CoreBundle\Entity\Ima\EventoHorasExtras $fkImaEventoHorasExtras)
    {
        $this->fkImaEventoHorasExtras->removeElement($fkImaEventoHorasExtras);
    }

    /**
     * OneToMany (owning side)
     * Get fkImaEventoHorasExtras
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ima\EventoHorasExtras
     */
    public function getFkImaEventoHorasExtras()
    {
        return $this->fkImaEventoHorasExtras;
    }

    /**
     * OneToMany (owning side)
     * Add ImaEventoComposicaoRemuneracao
     *
     * @param \Urbem\CoreBundle\Entity\Ima\EventoComposicaoRemuneracao $fkImaEventoComposicaoRemuneracao
     * @return ConfiguracaoRais
     */
    public function addFkImaEventoComposicaoRemuneracoes(\Urbem\CoreBundle\Entity\Ima\EventoComposicaoRemuneracao $fkImaEventoComposicaoRemuneracao)
    {
        if (false === $this->fkImaEventoComposicaoRemuneracoes->contains($fkImaEventoComposicaoRemuneracao)) {
            $fkImaEventoComposicaoRemuneracao->setFkImaConfiguracaoRais($this);
            $this->fkImaEventoComposicaoRemuneracoes->add($fkImaEventoComposicaoRemuneracao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ImaEventoComposicaoRemuneracao
     *
     * @param \Urbem\CoreBundle\Entity\Ima\EventoComposicaoRemuneracao $fkImaEventoComposicaoRemuneracao
     */
    public function removeFkImaEventoComposicaoRemuneracoes(\Urbem\CoreBundle\Entity\Ima\EventoComposicaoRemuneracao $fkImaEventoComposicaoRemuneracao)
    {
        $this->fkImaEventoComposicaoRemuneracoes->removeElement($fkImaEventoComposicaoRemuneracao);
    }

    /**
     * OneToMany (owning side)
     * Get fkImaEventoComposicaoRemuneracoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ima\EventoComposicaoRemuneracao
     */
    public function getFkImaEventoComposicaoRemuneracoes()
    {
        return $this->fkImaEventoComposicaoRemuneracoes;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkSwCgm
     *
     * @param \Urbem\CoreBundle\Entity\SwCgm $fkSwCgm
     * @return ConfiguracaoRais
     */
    public function setFkSwCgm(\Urbem\CoreBundle\Entity\SwCgm $fkSwCgm)
    {
        $this->numcgm = $fkSwCgm->getNumcgm();
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
     * Set fkImaTipoControlePonto
     *
     * @param \Urbem\CoreBundle\Entity\Ima\TipoControlePonto $fkImaTipoControlePonto
     * @return ConfiguracaoRais
     */
    public function setFkImaTipoControlePonto(\Urbem\CoreBundle\Entity\Ima\TipoControlePonto $fkImaTipoControlePonto)
    {
        $this->codTipoControlePonto = $fkImaTipoControlePonto->getCodTipoControlePonto();
        $this->fkImaTipoControlePonto = $fkImaTipoControlePonto;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkImaTipoControlePonto
     *
     * @return \Urbem\CoreBundle\Entity\Ima\TipoControlePonto
     */
    public function getFkImaTipoControlePonto()
    {
        return $this->fkImaTipoControlePonto;
    }
}
