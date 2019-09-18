<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

use Cocur\Slugify\Slugify;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProductRepository")
 */
class Product
{

    const COLOR = [
        'Blonde',
        'Ambrée',
        'Brune',
        'Blanche',
        'Noire',
        'Verte'
    ];

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $title;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\Column(type="float")
     */
    private $price;

    /**
     * @ORM\Column(type="integer")
     */
    private $quantity;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $style;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $color;

    /**
     * @ORM\Column(type="float")
     */
    private $degrees;

     /**
     * @ORM\Column(type="datetime")
     */
    private $updated_at;

    /**
     * @ORM\Column(type="boolean")
     */
    private $new;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $promo;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Picture", mappedBy="product", orphanRemoval=true, cascade={"persist"})
     */
    private $pictures;

    /**
     * @Assert\All(
     *     {@Assert\Image(mimeTypes="image/jpeg")})
     */
    private $picturesFiles;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Comment", mappedBy="product")
     */
    private $comments;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\OrderProduct", mappedBy="product", orphanRemoval=true)
     */
    private $orderProducts;

    /**
     * @ORM\Column(type="boolean")
     */
    private $soldOut;

    /**
     * @ORM\Column(type="integer")
     */
    private $IBU;


    public function __construct()
    {
        $this->pictures = new ArrayCollection();
        $this->comments = new ArrayCollection();
        $this->new = false;
        $this->orderProducts = new ArrayCollection();
        $this->updated_at = new \DateTime('now');
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    public function getSlug()
    {
        return (new Slugify())->slugify($this->getName());
    }

    /**
     * @param string $name
     * @return Product
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * @param string|null $title
     * @return Product
     */
    public function setTitle(?string $title): self
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param string $description
     * @return Product
     */
    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return float|null
     */
    public function getPrice(): ?float
    {
        return $this->price;
    }

    /**
     * @param float $price
     * @return Product
     */
    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    /**
     * @param int $quatity
     * @return Product
     */
    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getStyle(): ?string
    {
        return $this->style;
    }

    /**
     * @param string $style
     * @return Product
     */
    public function setStyle(string $style): self
    {
        $this->style = $style;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getColor(): ?string
    {
        return $this->color;
    }

    /**
     * @param string $color
     * @return Product
     */
    public function setColor(string $color): self
    {
        $this->color = $color;

        return $this;
    }

    /**
     * @return float|null
     */
    public function getDegrees(): ?float
    {
        return $this->degrees;
    }

    /**
     * @param float $degrees
     * @return Product
     */
    public function setDegrees(float $degrees): self
    {
        $this->degrees = $degrees;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(\DateTimeInterface $updated_at): self
    {
        $this->updated_at = $updated_at;

        return $this;
    }

    public function getNew(): ?bool
    {
        return $this->new;
    }

    public function setNew(bool $new): self
    {
        $this->new = $new;

        return $this;
    }

    /**
     * @return Collection|Picture[]
     */
    public function getPictures(): Collection
    {
        return $this->pictures;
    }

    public function addPicture(Picture $picture): self
    {
        if (!$this->pictures->contains($picture)) {
            $this->pictures[] = $picture;
            $picture->setProduct($this);
        }

        return $this;
    }

    public function removePicture(Picture $picture): self
    {
        if ($this->pictures->contains($picture)) {
            $this->pictures->removeElement($picture);
            // set the owning side to null (unless already changed)
            if ($picture->getProduct() === $this) {
                $picture->setProduct(null);
            }
        }

        return $this;
    }

    public function getPicture(): ?Picture
    {
        if($this->pictures->isEmpty())
        {
            return null;
        }

        return $this->pictures->first();
    }

    /**
     * @return mixed
     */
    public function getPicturesFiles()
    {
        return $this->picturesFiles;
    }

    /**
     * @param mixed $picturesFiles
     * @return Product
     */
    public function setPicturesFiles($picturesFiles)
    {
        foreach ($picturesFiles as $picturesFile)
        {
           $picture = new Picture();
           $picture->setImageFile($picturesFile);
           $this->addPicture($picture);
        }
        $this->picturesFiles = $picturesFiles;
        return $this;
    }

    /**
     * @return Collection|Comment[]
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comment $comment): self
    {
        if (!$this->comments->contains($comment)) {
            $this->comments[] = $comment;
            $comment->setProduct($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): self
    {
        if ($this->comments->contains($comment)) {
            $this->comments->removeElement($comment);
            // set the owning side to null (unless already changed)
            if ($comment->getProduct() === $this) {
                $comment->setProduct(null);
            }
        }

        return $this;
    }
    public function getComment(): ?Comment
    {
        if($this->comments->isEmpty())
        {
            return null;
        }

        return $this->comments->first();
    }

    public function getPromo(): ?int
    {
        return $this->promo;
    }

    public function setPromo(?int $promo): self
    {
        $this->promo = $promo;

        return $this;
    }

    /**
     * @return Collection|OrderProduct[]
     */
    public function getOrderProducts(): Collection
    {
        return $this->orderProducts;
    }

    public function addOrderProduct(OrderProduct $orderProduct): self
    {
        if (!$this->orderProducts->contains($orderProduct)) {
            $this->orderProducts[] = $orderProduct;
            $orderProduct->setProduct($this);
        }

        return $this;
    }

    public function removeOrderProduct(OrderProduct $orderProduct): self
    {
        if ($this->orderProducts->contains($orderProduct)) {
            $this->orderProducts->removeElement($orderProduct);
            // set the owning side to null (unless already changed)
            if ($orderProduct->getProduct() === $this) {
                $orderProduct->setProduct(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->getName();
    }

    public function getSoldOut(): ?bool
    {
        return $this->soldOut;
    }

    public function setSoldOut(bool $soldOut): self
    {
        $this->soldOut = $soldOut;

        return $this;
    }

    public function getIBU(): ?int
    {
        return $this->IBU;
    }

    public function setIBU(int $IBU): self
    {
        $this->IBU = $IBU;

        return $this;
    }
}
