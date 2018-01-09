<?php
 
namespace Urbem\CoreBundle\Entity\Normas;

/**
 * CopiaDigital
 */
class CopiaDigital
{
    /**
     * PK
     * @var integer
     */
    private $codCopia;

    /**
     * @var string
     */
    private $arquivo;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Normas\NormaCopiaDigital
     */
    private $fkNormasNormaCopiaDigitais;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkNormasNormaCopiaDigitais = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codCopia
     *
     * @param integer $codCopia
     * @return CopiaDigital
     */
    public function setCodCopia($codCopia)
    {
        $this->codCopia = $codCopia;
        return $this;
    }

    /**
     * Get codCopia
     *
     * @return integer
     */
    public function getCodCopia()
    {
        return $this->codCopia;
    }

    /**
     * Set arquivo
     *
     * @param string $arquivo
     * @return CopiaDigital
     */
    public function setArquivo($arquivo = null)
    {
        $this->arquivo = $arquivo;
        return $this;
    }

    /**
     * Get arquivo
     *
     * @return string
     */
    public function getArquivo()
    {
        return $this->arquivo;
    }

    /**
     * OneToMany (owning side)
     * Add NormasNormaCopiaDigital
     *
     * @param \Urbem\CoreBundle\Entity\Normas\NormaCopiaDigital $fkNormasNormaCopiaDigital
     * @return CopiaDigital
     */
    public function addFkNormasNormaCopiaDigitais(\Urbem\CoreBundle\Entity\Normas\NormaCopiaDigital $fkNormasNormaCopiaDigital)
    {
        if (false === $this->fkNormasNormaCopiaDigitais->contains($fkNormasNormaCopiaDigital)) {
            $fkNormasNormaCopiaDigital->setFkNormasCopiaDigital($this);
            $this->fkNormasNormaCopiaDigitais->add($fkNormasNormaCopiaDigital);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove NormasNormaCopiaDigital
     *
     * @param \Urbem\CoreBundle\Entity\Normas\NormaCopiaDigital $fkNormasNormaCopiaDigital
     */
    public function removeFkNormasNormaCopiaDigitais(\Urbem\CoreBundle\Entity\Normas\NormaCopiaDigital $fkNormasNormaCopiaDigital)
    {
        $this->fkNormasNormaCopiaDigitais->removeElement($fkNormasNormaCopiaDigital);
    }

    /**
     * OneToMany (owning side)
     * Get fkNormasNormaCopiaDigitais
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Normas\NormaCopiaDigital
     */
    public function getFkNormasNormaCopiaDigitais()
    {
        return $this->fkNormasNormaCopiaDigitais;
    }
}
