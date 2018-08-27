<?php

namespace Pondo\Domain\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Customer
 * @ORM\Entity()
 * @ORM\Table(name="product_url")
 */
class ProductUrl
{
    /**
     * @var integer|null
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(name="url_id", type="integer")
     */
    protected $urlId;

    /**
     * @var string
     * @ORM\Column(name="url", type="string")
     */
    protected $url;

    /**
     * @var boolean
     * @ORM\Column(name="size_xs", type="string")
     */
    protected $size_xs;

    /**
     * @var boolean
     * @ORM\Column(name="size_s", type="string")
     */
    protected $size_s;

    /**
     * @var boolean
     * @ORM\Column(name="size_m", type="string")
     */
    protected $size_m;

    /**
     * @var boolean
     * @ORM\Column(name="size_l", type="string")
     */
    protected $size_l;

    /**
     * @var boolean
     * @ORM\Column(name="size_xl", type="string")
     */
    protected $size_xl;

    /**
     * @var boolean
     * @ORM\Column(name="size_xxl", type="string")
     */
    protected $size_xxl;

    /**
     * @var boolean
     * @ORM\Column(name="changed_price", type="string")
     */
    protected $changedPrice;

    /**
     * The price for the a product
     * @var float
     * @ORM\Column(name="price", type="decimal", precision=13, scale=4)
     */
    protected $price;

}
