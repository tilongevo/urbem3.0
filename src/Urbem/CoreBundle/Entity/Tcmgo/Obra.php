<?php
 
namespace Urbem\CoreBundle\Entity\Tcmgo;

/**
 * Obra
 */
class Obra
{
    /**
     * PK
     * @var integer
     */
    private $codObra;

    /**
     * PK
     * @var integer
     */
    private $anoObra;

    /**
     * @var string
     */
    private $especificacao;

    /**
     * @var string
     */
    private $bairro;

    /**
     * @var integer
     */
    private $grauLatitude;

    /**
     * @var integer
     */
    private $minutoLatitude;

    /**
     * @var integer
     */
    private $segundoLatitude;

    /**
     * @var integer
     */
    private $grauLongitude;

    /**
     * @var integer
     */
    private $minutoLongitude;

    /**
     * @var integer
     */
    private $segundoLongitude;

    /**
     * @var integer
     */
    private $codUnidade;

    /**
     * @var integer
     */
    private $codGrandeza;

    /**
     * @var integer
     */
    private $quantidade;

    /**
     * @var string
     */
    private $endereco;

    /**
     * @var string
     */
    private $fiscal;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcmgo\PatrimonioBemObra
     */
    private $fkTcmgoPatrimonioBemObras;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcmgo\ObraEmpenho
     */
    private $fkTcmgoObraEmpenhos;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Administracao\UnidadeMedida
     */
    private $fkAdministracaoUnidadeMedida;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkTcmgoPatrimonioBemObras = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTcmgoObraEmpenhos = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codObra
     *
     * @param integer $codObra
     * @return Obra
     */
    public function setCodObra($codObra)
    {
        $this->codObra = $codObra;
        return $this;
    }

    /**
     * Get codObra
     *
     * @return integer
     */
    public function getCodObra()
    {
        return $this->codObra;
    }

    /**
     * Set anoObra
     *
     * @param integer $anoObra
     * @return Obra
     */
    public function setAnoObra($anoObra)
    {
        $this->anoObra = $anoObra;
        return $this;
    }

    /**
     * Get anoObra
     *
     * @return integer
     */
    public function getAnoObra()
    {
        return $this->anoObra;
    }

    /**
     * Set especificacao
     *
     * @param string $especificacao
     * @return Obra
     */
    public function setEspecificacao($especificacao)
    {
        $this->especificacao = $especificacao;
        return $this;
    }

    /**
     * Get especificacao
     *
     * @return string
     */
    public function getEspecificacao()
    {
        return $this->especificacao;
    }

    /**
     * Set bairro
     *
     * @param string $bairro
     * @return Obra
     */
    public function setBairro($bairro = null)
    {
        $this->bairro = $bairro;
        return $this;
    }

    /**
     * Get bairro
     *
     * @return string
     */
    public function getBairro()
    {
        return $this->bairro;
    }

    /**
     * Set grauLatitude
     *
     * @param integer $grauLatitude
     * @return Obra
     */
    public function setGrauLatitude($grauLatitude = null)
    {
        $this->grauLatitude = $grauLatitude;
        return $this;
    }

    /**
     * Get grauLatitude
     *
     * @return integer
     */
    public function getGrauLatitude()
    {
        return $this->grauLatitude;
    }

    /**
     * Set minutoLatitude
     *
     * @param integer $minutoLatitude
     * @return Obra
     */
    public function setMinutoLatitude($minutoLatitude = null)
    {
        $this->minutoLatitude = $minutoLatitude;
        return $this;
    }

    /**
     * Get minutoLatitude
     *
     * @return integer
     */
    public function getMinutoLatitude()
    {
        return $this->minutoLatitude;
    }

    /**
     * Set segundoLatitude
     *
     * @param integer $segundoLatitude
     * @return Obra
     */
    public function setSegundoLatitude($segundoLatitude = null)
    {
        $this->segundoLatitude = $segundoLatitude;
        return $this;
    }

    /**
     * Get segundoLatitude
     *
     * @return integer
     */
    public function getSegundoLatitude()
    {
        return $this->segundoLatitude;
    }

    /**
     * Set grauLongitude
     *
     * @param integer $grauLongitude
     * @return Obra
     */
    public function setGrauLongitude($grauLongitude = null)
    {
        $this->grauLongitude = $grauLongitude;
        return $this;
    }

    /**
     * Get grauLongitude
     *
     * @return integer
     */
    public function getGrauLongitude()
    {
        return $this->grauLongitude;
    }

    /**
     * Set minutoLongitude
     *
     * @param integer $minutoLongitude
     * @return Obra
     */
    public function setMinutoLongitude($minutoLongitude = null)
    {
        $this->minutoLongitude = $minutoLongitude;
        return $this;
    }

    /**
     * Get minutoLongitude
     *
     * @return integer
     */
    public function getMinutoLongitude()
    {
        return $this->minutoLongitude;
    }

    /**
     * Set segundoLongitude
     *
     * @param integer $segundoLongitude
     * @return Obra
     */
    public function setSegundoLongitude($segundoLongitude = null)
    {
        $this->segundoLongitude = $segundoLongitude;
        return $this;
    }

    /**
     * Get segundoLongitude
     *
     * @return integer
     */
    public function getSegundoLongitude()
    {
        return $this->segundoLongitude;
    }

    /**
     * Set codUnidade
     *
     * @param integer $codUnidade
     * @return Obra
     */
    public function setCodUnidade($codUnidade = null)
    {
        $this->codUnidade = $codUnidade;
        return $this;
    }

    /**
     * Get codUnidade
     *
     * @return integer
     */
    public function getCodUnidade()
    {
        return $this->codUnidade;
    }

    /**
     * Set codGrandeza
     *
     * @param integer $codGrandeza
     * @return Obra
     */
    public function setCodGrandeza($codGrandeza = null)
    {
        $this->codGrandeza = $codGrandeza;
        return $this;
    }

    /**
     * Get codGrandeza
     *
     * @return integer
     */
    public function getCodGrandeza()
    {
        return $this->codGrandeza;
    }

    /**
     * Set quantidade
     *
     * @param integer $quantidade
     * @return Obra
     */
    public function setQuantidade($quantidade = null)
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
     * Set endereco
     *
     * @param string $endereco
     * @return Obra
     */
    public function setEndereco($endereco = null)
    {
        $this->endereco = $endereco;
        return $this;
    }

    /**
     * Get endereco
     *
     * @return string
     */
    public function getEndereco()
    {
        return $this->endereco;
    }

    /**
     * Set fiscal
     *
     * @param string $fiscal
     * @return Obra
     */
    public function setFiscal($fiscal = null)
    {
        $this->fiscal = $fiscal;
        return $this;
    }

    /**
     * Get fiscal
     *
     * @return string
     */
    public function getFiscal()
    {
        return $this->fiscal;
    }

    /**
     * OneToMany (owning side)
     * Add TcmgoPatrimonioBemObra
     *
     * @param \Urbem\CoreBundle\Entity\Tcmgo\PatrimonioBemObra $fkTcmgoPatrimonioBemObra
     * @return Obra
     */
    public function addFkTcmgoPatrimonioBemObras(\Urbem\CoreBundle\Entity\Tcmgo\PatrimonioBemObra $fkTcmgoPatrimonioBemObra)
    {
        if (false === $this->fkTcmgoPatrimonioBemObras->contains($fkTcmgoPatrimonioBemObra)) {
            $fkTcmgoPatrimonioBemObra->setFkTcmgoObra($this);
            $this->fkTcmgoPatrimonioBemObras->add($fkTcmgoPatrimonioBemObra);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcmgoPatrimonioBemObra
     *
     * @param \Urbem\CoreBundle\Entity\Tcmgo\PatrimonioBemObra $fkTcmgoPatrimonioBemObra
     */
    public function removeFkTcmgoPatrimonioBemObras(\Urbem\CoreBundle\Entity\Tcmgo\PatrimonioBemObra $fkTcmgoPatrimonioBemObra)
    {
        $this->fkTcmgoPatrimonioBemObras->removeElement($fkTcmgoPatrimonioBemObra);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcmgoPatrimonioBemObras
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcmgo\PatrimonioBemObra
     */
    public function getFkTcmgoPatrimonioBemObras()
    {
        return $this->fkTcmgoPatrimonioBemObras;
    }

    /**
     * OneToMany (owning side)
     * Add TcmgoObraEmpenho
     *
     * @param \Urbem\CoreBundle\Entity\Tcmgo\ObraEmpenho $fkTcmgoObraEmpenho
     * @return Obra
     */
    public function addFkTcmgoObraEmpenhos(\Urbem\CoreBundle\Entity\Tcmgo\ObraEmpenho $fkTcmgoObraEmpenho)
    {
        if (false === $this->fkTcmgoObraEmpenhos->contains($fkTcmgoObraEmpenho)) {
            $fkTcmgoObraEmpenho->setFkTcmgoObra($this);
            $this->fkTcmgoObraEmpenhos->add($fkTcmgoObraEmpenho);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcmgoObraEmpenho
     *
     * @param \Urbem\CoreBundle\Entity\Tcmgo\ObraEmpenho $fkTcmgoObraEmpenho
     */
    public function removeFkTcmgoObraEmpenhos(\Urbem\CoreBundle\Entity\Tcmgo\ObraEmpenho $fkTcmgoObraEmpenho)
    {
        $this->fkTcmgoObraEmpenhos->removeElement($fkTcmgoObraEmpenho);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcmgoObraEmpenhos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcmgo\ObraEmpenho
     */
    public function getFkTcmgoObraEmpenhos()
    {
        return $this->fkTcmgoObraEmpenhos;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkAdministracaoUnidadeMedida
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\UnidadeMedida $fkAdministracaoUnidadeMedida
     * @return Obra
     */
    public function setFkAdministracaoUnidadeMedida(\Urbem\CoreBundle\Entity\Administracao\UnidadeMedida $fkAdministracaoUnidadeMedida)
    {
        $this->codUnidade = $fkAdministracaoUnidadeMedida->getCodUnidade();
        $this->codGrandeza = $fkAdministracaoUnidadeMedida->getCodGrandeza();
        $this->fkAdministracaoUnidadeMedida = $fkAdministracaoUnidadeMedida;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkAdministracaoUnidadeMedida
     *
     * @return \Urbem\CoreBundle\Entity\Administracao\UnidadeMedida
     */
    public function getFkAdministracaoUnidadeMedida()
    {
        return $this->fkAdministracaoUnidadeMedida;
    }
}
