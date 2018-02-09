<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use App\Entity\Rom;

class RomController extends Controller
{
    /**
     * @Route("/rom", name="rom")
     */
    public function index(){

        // you can fetch the EntityManager via $this->getDoctrine()
        // or you can add an argument to your action: index(EntityManagerInterface $em)
        $em = $this->getDoctrine()->getManager();

        $rom = new Rom();
        $rom->setName('Super Mario 3');
        $rom->setDescription('Top Notch Mario Adventure');
        $rom->setYear(1985);
        $rom->setRating('5');
        $rom->setIstested(true);
        $rom->setPublisher('Nintendo');
        $rom->setDeveloper('Konami');

        // tell Doctrine you want to (eventually) save the Product (no queries yet)
        $em->persist($rom);

        // actually executes the queries (i.e. the INSERT query)
        $em->flush();


        //return $this->render('@Maker/demoPage.html.twig', [ 'path' => str_replace($this->getParameter('kernel.project_dir').'/', '', __FILE__) ]);
        return new Response('Saved new product with id '.$rom->getId());
    }



    /**
     * @Route("/rom/{id}", name="rom_show")
     */
    public function showAction($id)
    {
        $rom = $this->getDoctrine()
            ->getRepository(Rom::class)
            ->find($id);

        if (!$rom) {
            throw $this->createNotFoundException(
                'No product found for id '.$id
            );
        }

        return new Response('Check out this great product: '.$rom->getName() .$rom->getDescription());

        // or render a template
        // in the template, print things with {{ rom.name }}
        // return $this->render('roms/show.html.twig', ['rom' => $rom]);



    }

    /**
     * @Route("/rom/edit/{id}")
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $rom = $em->getRepository(Rom::class)->find($id);

        if (!$rom) {
            throw $this->createNotFoundException(
                'No Rom found for id '.$id
            );
        }

        $rom->setName('Tetris');
        $em->flush();

        return $this->redirectToRoute('rom_show', [
            'id' => $rom->getId()
        ]);
    }


    /**
     * @Route("/rom/delete/{id}")
     */
    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $rom = $em->getRepository(Rom::class)->find($id);

        if (!$rom) {
            throw $this->createNotFoundException(
                'No Rom found for id '.$id
            );
        }

        $em->remove($rom);
        $em->flush();

        return new Response('Your Rom was succesfully deleted: '.$rom->getName());


    }

    /**
     * @Route("/roms/list", name="rom_list")
     */
        public function list()
        {
            $rom = $this->getDoctrine()
            ->getRepository(Rom::class)
            ->findAllAndOrderAsc();

            return $this->render(
                'roms.html.twig', array('romList'=>$rom));
//            return new Response('Check out all the great Roms: '.$rom->getName());
        }


    /**
     * @Route("/test", name="test")
     */

    public function test(Request $request)
    {
        // creates a task and gives it some dummy data for this example
        $rom = new Rom();

        $form = $this->createFormBuilder($rom)
            ->add('name', TextType::class)
            ->add('description', TextType::class)
            ->add('year', IntegerType::class)
            ->add('rating', IntegerType::class)
            ->add('istested', CheckboxType::class)
            ->add('publisher', TextType::class)
            ->add('developer', TextType::class)
            ->add('save', SubmitType::class, array('label' => 'Add'))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // $form->getData() holds the submitted values
            // but, the original `$task` variable has also been updated

            $rom = $form->getData();

            // ... perform some action, such as saving the task to the database
            // for example, if Task is a Doctrine entity, save it!
            $em = $this->getDoctrine()->getManager();
            $em->persist($rom);
            $em->flush();

            return $this->redirectToRoute('rom_list');
        }

        return $this->render('test.html.twig', array(
            'form' => $form->createView(),
        ));
    }




}
