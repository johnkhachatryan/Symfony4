<?php

namespace App\Controller;

use App\Entity\Product;
use App\Entity\Receipt;
use App\Entity\Register;
use App\Entity\User;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\JsonEncoder;

/**
 * Class ApiController
 * @package App\Controller
 */
class ApiController extends AbstractController
{
    private $encoders;
    private $normalizers;
    private $serializer;

    public function __construct()
    {
        $this->encoders = [new JsonEncoder()];
        $this->normalizers = [new ObjectNormalizer()];
        $this->serializer = new Serializer($this->normalizers, $this->encoders);
    }

    /**
     * @Route("/api/product/all")
     *
     * @return Response
     */
    public function getAll()
    {
        $products = $this->getDoctrine()->getRepository(Product::class)
            ->findAll();

        $jsonContent = $this->serializer->serialize($products, 'json');

        return new Response($jsonContent);
    }

    /**
     * @Route("/api/product/get/{barcode}")
     *
     * @param string $barcode
     * @return Product
     */
    public function getProduct($barcode) : Product
    {
        $product = $this->getDoctrine()->getRepository(Product::class)
            ->findOneBy(['barcode' => $barcode]);

        $jsonContent = $this->serializer->serialize($product, 'json');

        return new Response($jsonContent);
    }

    /**
     * @Route("/api/receipt/new")
     *
     * @param ObjectManager $manager
     * @return Response
     */
    public function newReceipt(ObjectManager $manager)
    {
        $receipt = new Receipt();
        $receipt->setDiscount(0);

        $manager->persist($receipt);
        $manager->flush();

        $jsonContent = $this->serializer->serialize($receipt, 'json');
        return new Response($jsonContent);

    }

    /**
     * @Route("/api/receipt/addproduct")
     *
     * @param ObjectManager $manager
     * @param Request $request
     * @return Response
     *
     * example input json: {"receipt_id": 1, "barcode": "2222", "count": 1}
     */
    public function addProduct(ObjectManager $manager, Request $request)
    {
        if($request->isMethod('POST'))
        {
            $inputData = file_get_contents('php://input');
            $data = json_decode($inputData, true);

            $product = $this->getDoctrine()->getRepository(Product::class)
                ->findOneBy(['barcode' => $data['barcode']]);

            $receipt = $this->getDoctrine()->getRepository(Receipt::class)
                ->find($data['receipt_id']);

            $register = new Register();
            $register->setProduct($product);
            $register->setReceipt($receipt);
            $register->setCount($data['count']);

            $manager->persist($register);
            $manager->flush();

            return new Response("product added");
        }
    }

    /**
     * @Route("/api/receipt/finish")
     *
     * @param ObjectManager $manager
     * @param Request $request
     *
     * example input json: {"receipt_id": 1}
     */
//    public function finishReceipt(ObjectManager $manager, Request $request)
//    {
//        $inputData = file_get_contents('php://input');
//        $data = json_decode($inputData, true);
//
//        $receipt = $this->getDoctrine()->getRepository(Receipt::class)
//            ->findOneBy($data['id']);
//
//        $products = $receipt->
//    }


}
