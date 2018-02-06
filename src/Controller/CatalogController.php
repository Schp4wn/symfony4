<?php
/**
 * Created by PhpStorm.
 * User: Administrateur
 * Date: 30/01/2018
 * Time: 14:08
 */


namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Psr\Log\LoggerInterface;

class CatalogController extends Controller
{
    private function _getProducts(){
        $bdd = array(
            array("name"=>"skeggǫld"                    , "price"=>10),
            array("name"=>"skálmǫld"                    , "price"=>20),
            array("name"=>"skildir ro klofnir"          , "price"=>30),
        );

        foreach( $bdd as $key => &$product){
            $product['url'] = $this->generateUrl(
                "product_route", array("product_id" =>$key)
            );
        }

        return $bdd;
    }
    /**
     * @Route("/catalog", name="catalog_route")
     */
    public function displayCatalog(){
        return $this->render(
            "catalog.html.twig",
            array( "catalog" => $this->_getProducts() )
    );
}



    /**
     * @Route("/product/{product_id}", name="product_route", requirements={"product_id"="\d*"})
     */

     public function displayProduct(LoggerInterface $logger, $product_id = -1 ){
         $logger->info($product_id);

         if( $product_id == "" || $product_id == -1 ){
             return $this->redirectToRoute("catalog_route");
         }

         $catalog       = $this->_getProducts();
         $max           = count($catalog) - 1;
         $product_id    = ( $product_id > $max ? $product_id = $max : $product_id);
         $product       = $catalog[$product_id];
         return $this-> render ('product.html.twig', array('product'=>$product));
     }

}