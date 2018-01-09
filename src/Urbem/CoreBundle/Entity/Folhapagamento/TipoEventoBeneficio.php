<?php
 
namespace Urbem\CoreBundle\Entity\Folhapagamento;

/**
 * TipoEventoBeneficio
 */
class TipoEventoBeneficio
{
    /**
     * PK
     * @var integer
     */
    private $codTipo;

    /**
     * @var integer
     */
    private $codBeneficio;

    /**
     * @var string
     */
    private $descricao;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\BeneficioEvento
     */
    private $fkFolhapagamentoBeneficioEventos;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Beneficio\BeneficioCadastro
     */
    private $fkBeneficioBeneficioCadastro;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkFolhapagamentoBeneficioEventos = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codTipo
     *
     * @param integer $codTipo
     * @return TipoEventoBeneficio
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
     * Set codBeneficio
     *
     * @param integer $codBeneficio
     * @return TipoEventoBeneficio
     */
    public function setCodBeneficio($codBeneficio)
    {
        $this->codBeneficio = $codBeneficio;
        return $this;
    }

    /**
     * Get codBeneficio
     *
     * @return integer
     */
    public function getCodBeneficio()
    {
        return $this->codBeneficio;
    }

    /**
     * Set descricao
     *
     * @param string $descricao
     * @return TipoEventoBeneficio
     */
    public function setDescricao($descricao)
    {
        $this->descricao = $descricao;
        return $this;
    }

    /**
     * Get descricao
     *
     * @return string
     */
    public function getDescricao()
    {
        return $this->descricao;
    }

    /**
     * OneToMany (owning side)
     * Add FolhapagamentoBeneficioEvento
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\BeneficioEvento $fkFolhapagamentoBeneficioEvento
     * @return TipoEventoBeneficio
     */
    public function addFkFolhapagamentoBeneficioEventos(\Urbem\CoreBundle\Entity\Folhapagamento\BeneficioEvento $fkFolhapagamentoBeneficioEvento)
    {
        if (false === $this->fkFolhapagamentoBeneficioEventos->contains($fkFolhapagamentoBeneficioEvento)) {
            $fkFolhapagamentoBeneficioEvento->setFkFolhapagamentoTipoEventoBeneficio($this);
            $this->fkFolhapagamentoBeneficioEventos->add($fkFolhapagamentoBeneficioEvento);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FolhapagamentoBeneficioEvento
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\BeneficioEvento $fkFolhapagamentoBeneficioEvento
     */
    public function removeFkFolhapagamentoBeneficioEventos(\Urbem\CoreBundle\Entity\Folhapagamento\BeneficioEvento $fkFolhapagamentoBeneficioEvento)
    {
        $this->fkFolhapagamentoBeneficioEventos->removeElement($fkFolhapagamentoBeneficioEvento);
    }

    /**
     * OneToMany (owning side)
     * Get fkFolhapagamentoBeneficioEventos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\BeneficioEvento
     */
    public function getFkFolhapagamentoBeneficioEventos()
    {
        return $this->fkFolhapagamentoBeneficioEventos;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkBeneficioBeneficioCadastro
     *
     * @param \Urbem\CoreBundle\Entity\Beneficio\BeneficioCadastro $fkBeneficioBeneficioCadastro
     * @return TipoEventoBeneficio
     */
    public function setFkBeneficioBeneficioCadastro(\Urbem\CoreBundle\Entity\Beneficio\BeneficioCadastro $fkBeneficioBeneficioCadastro)
    {
        $this->codBeneficio = $fkBeneficioBeneficioCadastro->getCodBeneficio();
        $this->fkBeneficioBeneficioCadastro = $fkBeneficioBeneficioCadastro;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkBeneficioBeneficioCadastro
     *
     * @return \Urbem\CoreBundle\Entity\Beneficio\BeneficioCadastro
     */
    public function getFkBeneficioBeneficioCadastro()
    {
        return $this->fkBeneficioBeneficioCadastro;
    }
}
