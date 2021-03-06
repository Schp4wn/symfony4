<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class HomeController extends Controller
{

    /**
     *@Route("/", name="home")
     */
    public function display()
    {
        return $this->render("home.html.twig", array());
    }


    /**
     * @Route("/gods", name="gods")
     */
    public function gods()
    {

        return $this->render(
            'gods.html.twig', array(
            "male" => array(
                "Odin",
                "Thor",
                "Heimdallr",
                "Týr",
                "Baldr",
                "Njörðr",
                "Loki",
                "Freyr",
                "Fenrir",
                "Niðhogg"
            ),

            "female" => array(
                "Sif",
                "Freya",
                "Frigg",
                "Eir",
                "Hella",
                "Nott",
                "Skadi",
                "Skuld",
                "Valkiries",
                "Voluspa"
            ),


        ));
    }

    /**
     * @Route("/presentation", name="presentation")
     */

    public function presentation()
    {

        $msg = "
            <html>
                <body>
                    <h1>Hello, my name is: </h1>
                        <p>Name: Poscher</p>
                         <p>Firstname: Steven</p>
                         <p>Age: 29y</p>                            
                         <img src='https://orig00.deviantart.net/d31e/f/2015/147/b/9/odin_by_design_by_humans-d8uyqd7.jpg'</img>
                </body>
            </html>
        ";
        return new Response($msg);
    }



    /**
     * @Route("/yggdrasil", name="yggdrasil")
     */
    public function yggdrasil()
    {

        return $this->render('yggdrasil.html.twig');
    }





    /**
     * @Route("/god/{person_id}", name="god")
     */

    public function specGod($person_id){
        $bdd = array(
            "Odin",
            "Thor",
            "Heimdallr",
            "Týr",
            "Baldr",
            "Njörðr",
            "Loki",
            "Freyr",
            "Fenrir",
            "Niðhogg"

        );

        $goodPerson = $bdd[$person_id];

        return $this->render('gods.html.twig', array("god"=>$goodPerson));

    }

    /**
     * @Route("/about", name="about")
     */

    public function about()
    {

        return $this->render('base.html.twig');


    }
}

